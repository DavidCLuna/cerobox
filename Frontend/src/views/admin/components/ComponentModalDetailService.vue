<template>
<v-dialog v-model="stateModal" max-width="800">
    <v-container v-if="isLoading === true" align="center">
        <v-progress-circular color="blue-lighten-3" indeterminate :size="50" :width="6"></v-progress-circular>
    </v-container>
    <v-card v-if="isLoading === false">
        <v-card-title>
            <h2 class="text-center mt-2">Servicios del Cliente</h2>
        </v-card-title>
        <v-card-text>
            <v-container>
                <v-row>
                    <v-col cols="12" class="d-block">
                        <div class="d-flex">
                            <label><strong>Nombre del Cliente:</strong> {{ data.name }}</label>
                        </div>
                        <div class="d-flex">
                            <label><strong>Correo Electrónico:</strong> {{ data.email }}</label>
                        </div>
                        <div class="d-flex">
                            <label><strong>Teléfono:</strong> {{ data.phone }}</label>
                        </div>
                        <div class="d-flex">
                            <label><strong>Documento:</strong> {{ data.document }}</label>
                        </div>
                        <div class="d-flex">
                            <label><strong>Observaciones:</strong> {{ data.observations }}</label>
                        </div>
                    </v-col>
                </v-row>
                <v-row>

                    <v-col cols="12">
                        <div class="text-right">
                            <v-btn style="background-color: #0072AE; color:white; margin-right: auto;" @click="createServices()">
                                <v-icon size="25" class="mr-2">mdi-plus</v-icon> Agregar Servicios
                            </v-btn>
                        </div>
                        <DataTable :paginator="true" :rows="6" :paginatorTemplate="{
                                '640px': 'PrevPageLink CurrentPageReport NextPageLink',
                                '960px': 'FirstPageLink PrevPageLink CurrentPageReport NextPageLink LastPageLink',
                                '1300px': 'FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink',
                                default: 'FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink JumpToPageDropdown'
                            }" currentPageReportTemplate="Showing {first} to {last} of {totalRecords}" :value="data.services" class="p-datatable-sm" responsiveLayout="scroll" showGridlines stripedRows>
                            <ColumnP v-for="col of headers.services" :key="col" :field="col.value" :header="col.text" headerStyle="background-color: #0072AE; color:white; text-align:center" />
                            <ColumnP field="actions" header="Actions" headerStyle="background-color: #0072AE; color:white; text-align:center;  align-items:center; justify-content:center;">
                                <template #body="slotProps">
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
                    </v-col>
                </v-row>
            </v-container>
        </v-card-text>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="error" @click="closeModal">Cerrar</v-btn>
        </v-card-actions>
    </v-card>
</v-dialog>

<!-- modal services -->
<v-dialog v-model="showModalAddServices" max-width="600">
    <v-container v-if="isLoadingAddService === true" align="center">
        <v-progress-circular color="blue-lighten-3" indeterminate :size="50" :width="6"></v-progress-circular>
    </v-container>
    <v-card v-if="isLoadingAddService === false">
        <v-card-title>
            <h2 class="text-center mt-2">Agregar Servicios</h2>
        </v-card-title>
        <v-card-text>
            <v-form @submit.prevent="saveAddServices" ref="form_register">
                <v-container>
                    <!--INITIAL INFORMATION-->
                    <v-row>
                        <v-col cols="12">
                            <label class="mb-2"><strong>Seleccione los servicios que desea agregar al
                                    cliente:</strong></label>
                            <v-select v-model="selectedServicesAddClient" :items="servicesNotClient" :search-input="search" item-title="name" item-value="id" label="Searchable Select" multiple></v-select>
                        </v-col>
                        <v-col cols="6">
                            <v-btn color="success" type="submit" block>Guardar</v-btn>
                        </v-col>
                        <v-col cols="6">
                            <v-btn color="error" @click="showModalAddServices = false" block>Cancelar</v-btn>
                        </v-col>
                    </v-row>
                </v-container>

            </v-form>
        </v-card-text>
    </v-card>
</v-dialog>
</template>

<script>
import tableDataColumns from '../../columns'
import vueAxios from '../../../vueAxios'
import Swal from 'sweetalert2'

export default {
    name: "ComponentModalDetailService",
    props: ["showModal"],
    computed: {
        stateModal() {
            return this.showModal
        }
    },
    data() {
        return {
            data: {},
            clientId: null,
            servicesNotClient: [],
            selectedServicesAddClient: [],
            showModalAddServices: false,
            isLoadingAddService: false,
            stateModalRegister: false,
            isLoading: false,
            headers: {
                services: []
            }
        };
    },
    mounted() {
        console.log(this.data);
        this.headers.services = tableDataColumns.services
    },

    methods: {
        loadInitialData(clientId) {
            this.clientId = clientId
            this.isLoading = true

            vueAxios.get('/api/service-clients/' + this.clientId)
                .then(res => {
                    console.log('data detail client service')
                    console.log(res)
                    this.data = res.data.data
                    this.isLoading = false
                })
                .catch(err => {
                    console.log(err)
                })
        },
        createServices() {
            this.showModalAddServices = true
            this.isLoadingAddService = true
            vueAxios.get('/api/service-clients/get-services-not-client/' + this.data.id, this.formEdit)
                .then(res => {
                    this.servicesNotClient = res.data.data
                    this.isLoadingAddService = false
                })
                .catch(err => {
                    console.log(err)
                })
        },
        saveAddServices() {
            this.isLoadingAddService = true
            const data = {
                client_id: this.data.id,
                services: this.selectedServicesAddClient
            }
            vueAxios.post('/api/service-clients', data)
                .then(() => {
                    Swal.fire(
                        '¡Agregados!',
                        'Los servicios han sido agregados exitosamente.',
                        'success',
                        //button ok
                        true
                    ).then(() => {
                        this.isLoadingAddService = false
                        this.showModalAddServices = false
                        this.$emit('reloadData')
                        this.closeModal()
                    })

                })
                .catch(err => {
                    console.log(err)
                })
        },
        destroy(id) {
            Swal.fire({
                title: '¿Está seguro de eliminar el servicio?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    vueAxios.delete('/api/service-clients/' + id + '/' + this.clientId)
                        .then(() => {
                            Swal.fire(
                                '¡Eliminado!',
                                'El servicio ha sido eliminado.',
                                'success',
                                //button ok
                                true
                            ).then(() => {
                                this.$emit('reloadData')
                                this.closeModal()
                            })
                        })
                        .catch(err => {
                            console.log(err)
                        })
                }
            })
        },
        closeModal() {
            this.$emit('close')
        }
    },
};
</script>
