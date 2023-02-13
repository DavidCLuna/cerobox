<template>
<v-dialog v-model="stateModal" max-width="800">
    <v-container v-if="isLoading===true" align="center">
        <v-progress-circular color="blue-lighten-3" indeterminate :size="50" :width="6"></v-progress-circular>
    </v-container>
    <v-card v-if="isLoading === false">
        <v-card-title>
            <h2 class="text-center mt-2">Clientes</h2>
        </v-card-title>
        <v-card-text>
            <div class="text-right">
                <v-btn style="background-color: #005da6; color:white; margin-right: auto;" @click="stateModalRegister = true">
                    <v-icon size="25" class="mr-2">mdi-plus</v-icon> Agregar
                </v-btn>
            </div>
            <DataTable :paginator="true" :rows="6" :paginatorTemplate="{
        '640px': 'PrevPageLink CurrentPageReport NextPageLink',
        '960px': 'FirstPageLink PrevPageLink CurrentPageReport NextPageLink LastPageLink',
        '1300px': 'FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink',
        default: 'FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink JumpToPageDropdown'
    }" currentPageReportTemplate="Showing {first} to {last} of {totalRecords}" :value="data" class="p-datatable-sm" responsiveLayout="scroll" showGridlines stripedRows>
                <ColumnP v-for="col of headers.clients" :key="col" :field="col.value" :header="col.text" headerStyle="background-color: #005da6; color:white; text-align:center" />
                <ColumnP field="actions" header="Actions" headerStyle="background-color: #005da6; color:white; text-align:center;  align-items:center; justify-content:center;">
                    <template #body="slotProps">
                        <v-btn style="color: black;" @click="edit(slotProps.data)">
                            <v-icon small>
                                mdi-pencil
                            </v-icon>
                        </v-btn>
                        <v-btn style="color: black;" @click="destroy(slotProps.data.id)">
                            <v-icon small>
                                mdi-delete
                            </v-icon>
                        </v-btn>
                    </template>
                </ColumnP>

                <template #footer>
                    Total de Clientes: {{ data.clients ? data.clients.length : 0 }}
                </template>
            </DataTable>
        </v-card-text>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="error" @click="closeModal">Cerrar</v-btn>
        </v-card-actions>
    </v-card>
</v-dialog>

<!-- modal register -->
<v-dialog v-model="stateModalRegister" max-width="600">
    <v-container v-if="isLoadingRegister===true" align="center">
        <v-progress-circular color="blue-lighten-3" indeterminate :size="50" :width="6"></v-progress-circular>
    </v-container>
    <v-card v-if="isLoadingRegister === false">
        <v-card-title>
            <h2 class="text-center mt-2">Registro de Cliente</h2>
        </v-card-title>
        <v-card-text>
            <v-form @submit.prevent="save" ref="form_register">
                <v-container>
                    <!--INITIAL INFORMATION-->
                    <v-row>
                        <v-col cols="12">
                            <v-text-field v-model="form.name" :rules="rules.registerName" label="Nombre" required outlined></v-text-field>
                            <v-text-field v-model="form.email" :rules="rules.registerEmail" type="email" label="Correo" required outlined></v-text-field>
                            <v-text-field v-model="form.phone" :rules="rules.registerPhone" maxlength="10" type="number" label="Teléfono" required outlined></v-text-field>
                            <v-text-field v-model="form.document" :rules="rules.registerDocument" maxlength="10" type="number" label="Documento" required outlined></v-text-field>
                            <v-text-field v-model="form.observations" :rules="rules.registerObservations" label="Observaciones" required outlined></v-text-field>
                        </v-col>
                        <v-col cols="6">
                            <v-btn color="success" type="submit" block>Guardar</v-btn>
                        </v-col>
                        <v-col cols="6">
                            <v-btn color="error" @click="stateModalRegister = false" block>Cancelar</v-btn>
                        </v-col>
                    </v-row>
                </v-container>

            </v-form>
        </v-card-text>
    </v-card>
</v-dialog>

<!-- modal edit -->
<v-dialog v-model="stateModalEdit" max-width="600">
    <v-container v-if="isLoadingEdit===true" align="center">
        <v-progress-circular color="blue-lighten-3" indeterminate :size="50" :width="6"></v-progress-circular>
    </v-container>
    <v-card v-if="isLoadingEdit === false">
        <v-card-title>
            <h2 class="text-center mt-2">Editar Cliente</h2>
        </v-card-title>
        <v-card-text>
            <v-form @submit.prevent="update" ref="form_register">
                <v-container>
                    <!--INITIAL INFORMATION-->
                    <v-row>
                        <v-col cols="12">
                            <v-text-field v-model="formEdit.name" :rules="rules.name" label="Nombre" required outlined></v-text-field>
                            <v-text-field v-model="formEdit.email" :rules="rules.email" type="email" label="Correo" required outlined></v-text-field>
                            <v-text-field v-model="formEdit.phone" :rules="rules.phone" maxlength="10" type="number" label="Teléfono" required outlined></v-text-field>
                            <v-text-field v-model="formEdit.document" :rules="rules.document" maxlength="10" type="number" label="Documento" required outlined></v-text-field>
                            <v-text-field v-model="formEdit.observations" :rules="rules.observations" label="Observaciones" required outlined></v-text-field>
                        </v-col>
                        <v-col cols="6">
                            <v-btn color="success" type="submit" block>Guardar</v-btn>
                        </v-col>
                        <v-col cols="6">
                            <v-btn color="error" @click="stateModalEdit = false" block>Cancelar</v-btn>
                        </v-col>
                    </v-row>
                </v-container>

            </v-form>
        </v-card-text>
    </v-card>
</v-dialog>
</template>

<script>
import vueAxios from '../../../vueAxios'
import tableDataColumns from '../../columns'
import Swal from 'sweetalert2'

export default {
    name: 'CRUDModalClients',
    props: ['showModal', 'data'],
    computed: {
        stateModal() {
            return this.showModal
        }
    },
    data() {
        return {
            form: {
                name: '',
                email: '',
                phone: '',
                image: 'imagen.png',
                document: '',
                observations: ''
            },
            formEdit: {
                name: '',
                email: '',
                phone: '',
                image: 'imagen.png',
                document: '',
                observations: ''
            },
            rules: {
                name: [(v) => !!v || "Nombre del cliente es requerido"],
                email: [(v) => !!v || "Correo del cliente es requerido",
                    (v) => /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || "Por favor ingrese un correo electrónico válido"
                ],
                phone: [(v) => !!v || "Teléfono del cliente es requerido", (v) => !v || v.toString().length <= 10 || 'El número de teléfono no puede tener más de 10 dígitos'],
                document: [(v) => !!v || "Documento del cliente es requerido", (v) => !v || v.toString().length <= 10 || 'El número de documento no puede tener más de 10 dígitos'],
                observations: [(v) => !!v || "Observaciones del cliente es requerido"],
            },
            stateModalRegister: false,
            stateModalEdit: false,
            isLoading: false,
            isLoadingRegister: false,
            isLoadingEdit: false,
            itemEdit: {},
            headers: {
                clients: [],
            },
        }
    },
    mounted() {
        this.headers.clients = tableDataColumns.clients
    },
    methods: {
        async save() {
            let validationResult = await this.$refs.form_register.validate();

            if (validationResult.valid) {
                this.isLoadingRegister = true
                await vueAxios.post('/api/clients', this.form)
                    .then(() => {
                        Swal.fire(
                            '¡Agregado!',
                            'El cliente ha sido registrado exitosamente.',
                            'success',
                            //button ok
                            true
                        ).then(() => {
                            this.isLoadingRegister = false
                            this.stateModalRegister = false
                            this.$emit('reloadData');
                            this.resetForm()
                        })

                    })
                    .catch(error => {
                        this.isLoadingRegister = false
                        this.resetForm()
                        console.log(error)
                    })
            } else {
                document.querySelector(`#${validationResult.errors[0].id}`).focus();
            }
        },
        update() {
            this.isLoadingEdit = true
            vueAxios.put('/api/clients/' + this.itemEdit.id, this.formEdit)
                .then(() => {
                    Swal.fire(
                        'Actualizado!',
                        'El cliente ha sido actualizado exitosamente.',
                        'success',
                        //button ok
                        true
                    ).then(() => {
                        this.$emit('reloadData');
                        this.isLoadingEdit = false
                        this.stateModalEdit = false
                        this.loadInit()
                        this.resetForm()
                    })

                })
                .catch(error => {
                    this.isLoadingEdit = false
                    this.resetForm()
                    console.log(error)
                })
        },
        destroy(id) {
            // sweet alert, mensaje de confirmacion y eliminar
            Swal.fire({
                title: '¿Estás seguro de que deseas eliminar el cliente?',
                text: "Una vez eliminado, no podrá recuperarse!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Si, ¡Eliminar!',
                cancelButtonText: 'No, ¡Cancelar!',
            }).then((result) => {
                if (result.value) {
                    // Aquí debes colocar el código que realiza la eliminación
                    this.isLoading = true
                    vueAxios.delete('/api/clients/' + id)
                        .then(() => {
                            this.$emit('reloadData');
                            Swal.fire('Eliminado!', 'El cliente ha sido eliminado.', 'success');
                            this.loadInit()
                        })
                        .catch(error => {
                            this.isLoading = false
                            console.log(error)
                        })

                } else {
                    Swal.fire('Cancelado', 'El cliente no se ha eliminado.', 'error');
                }
            });

        },
        edit(client) {
            this.itemEdit = client
            this.stateModalEdit = true
            this.formEdit.name = client.name
            this.formEdit.email = client.email
            this.formEdit.phone = client.phone
            this.formEdit.document = client.document
            this.formEdit.observations = client.observations
        },
        resetForm() {
            this.form.name = ''
            this.form.email = ''
            this.form.phone = ''
            this.form.document = ''
            this.form.observations = ''
        },
        closeModal() {
            this.resetForm()
            this.$emit('close');
        },
    }
}
</script>

<style>
.swal2-container {
    z-index: 99999 !important;
}
</style>
