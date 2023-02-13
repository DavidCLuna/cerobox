<template>
<v-dialog v-model="stateModal" max-width="800">
    <v-container v-if="isLoading===true" align="center">
        <v-progress-circular color="blue-lighten-3" indeterminate :size="50" :width="6"></v-progress-circular>
    </v-container>
    <v-card v-if="isLoading === false">
        <v-card-title>
            <h2 class="text-center mt-2">Servicios</h2>
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
                <ColumnP v-for="col of headers.services" :key="col" :field="col.value" :header="col.text" headerStyle="background-color: #005da6; color:white; text-align:center" />
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
                    Total de Servicios: {{ data.services ? data.services.length : 0 }}
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
            <h2 class="text-center mt-2">Registro de Servicio</h2>
        </v-card-title>
        <v-card-text>
            <v-form @submit.prevent="save" ref="form_register">
                <v-container>
                    <!--INITIAL INFORMATION-->
                    <v-row>
                        <v-col cols="12">
                            <v-text-field v-model="form.name" :rules="rules.name" label="Nombre" required outlined></v-text-field>
                            <v-select v-model="form.type" :items="['Basico', 'Avanzado']" :rules="rules.type" label="Tipo de Servicio" required outlined></v-select>
                            <v-text-field v-model="form.start_date" :rules="rules.start_date" label="Fecha de Inicio" required outlined></v-text-field>
                            <v-text-field v-model="form.end_date" :rules="rules.end_date" label="Fecha de Finalización" required outlined></v-text-field>
                            <v-text-field v-model="form.observations" :rules="rules.observations" label="Observaciones" required outlined></v-text-field>
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
            <h2 class="text-center mt-2">Editar Servicio</h2>
        </v-card-title>
        <v-card-text>
            <v-form @submit.prevent="update" ref="form_register">
                <v-container>
                    <!--INITIAL INFORMATION-->
                    <v-row>
                        <v-col cols="12">
                            <v-text-field v-model="formEdit.name" :rules="rules.name" label="Nombre" required outlined></v-text-field>
                            <v-select v-model="formEdit.type" :items="['Basico', 'Avanzado']" :rules="rules.type" label="Tipo de Servicio" required outlined></v-select>
                            <v-text-field v-model="formEdit.start_date" :rules="rules.start_date" type="date" label="Fecha de Inicio" required outlined></v-text-field>
                            <v-text-field v-model="formEdit.end_date" :rules="rules.end_date" type="date" label="Fecha de Finalización" required outlined></v-text-field>
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
    name: 'CRUDModalservices',
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
                type: '',
                start_date: null,
                end_date: null,
                image: 'imagen.png',
                observations: ''
            },
            formEdit: {
                name: '',
                type: '',
                start_date: null,
                end_date: null,
                image: 'imagen.png',
                observations: ''
            },
            rules: {
                name: [(v) => !!v || "Nombre del servicio es requerido"],
                type: [(v) => !!v || "Tipo de servicio es requerido"],
                start_date: [(v) => !!v || "Fecha de inicio es requerido"],
                end_date: [(v) => !!v || "Fecha de finalización es requerido"],
                observations: [(v) => !!v || "Observaciones del servicio es requerido"],
            },
            stateModalRegister: false,
            stateModalEdit: false,
            isLoading: false,
            isLoadingRegister: false,
            isLoadingEdit: false,
            itemEdit: {},
            headers: {
                services: [],
            },
        }
    },
    mounted() {
        this.headers.services = tableDataColumns.services
    },
    methods: {
        async save() {
            let validationResult = await this.$refs.form_register.validate();

            if (validationResult.valid) {
                this.isLoadingRegister = true
                await vueAxios.post('/api/services', this.form)
                    .then(() => {
                        Swal.fire(
                            '¡Agregado!',
                            'El servicio ha sido registrado exitosamente.',
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
            vueAxios.put('/api/services/' + this.itemEdit.id, this.formEdit)
                .then(() => {
                    Swal.fire(
                        'Actualizado!',
                        'El servicio ha sido actualizado exitosamente.',
                        'success',
                        //button ok
                        true
                    ).then(() => {
                        this.isLoadingEdit = false
                        this.stateModalEdit = false
                        this.$emit('reloadData');
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
                title: '¿Estás seguro de que deseas eliminar el servicio?',
                text: "Una vez eliminado, no podrá recuperarse!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Si, ¡Eliminar!',
                cancelButtonText: 'No, ¡Cancelar!',
            }).then((result) => {
                if (result.value) {
                    // Aquí debes colocar el código que realiza la eliminación
                    this.isLoading = true
                    vueAxios.delete('/api/services/' + id)
                        .then(() => {
                            Swal.fire('Eliminado!', 'El servicio ha sido eliminado.', 'success');
                            this.$emit('reloadData');
                        })
                        .catch(error => {
                            this.isLoading = false
                            console.log(error)
                        })

                } else {
                    Swal.fire('Cancelado', 'El servicio no se ha eliminado.', 'error');
                }
            });

        },
        edit(client) {
            this.itemEdit = client
            this.stateModalEdit = true
            this.formEdit.name = client.name
            this.formEdit.type = client.type
            this.formEdit.start_date = client.start_date
            this.formEdit.end_date = client.end_date
            this.formEdit.observations = client.observations
        },
        resetForm() {
            this.name = ''
            this.type = ''
            this.start_date = null
            this.end_date = null
            this.image = 'imagen.png'
            this.observations = ''
        },
        closeModal() {
            console.log('close component')
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
