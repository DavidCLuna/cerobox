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
                            <DataTable :paginator="true" :rows="6" :paginatorTemplate="{
                                    '640px': 'PrevPageLink CurrentPageReport NextPageLink',
                                    '960px': 'FirstPageLink PrevPageLink CurrentPageReport NextPageLink LastPageLink',
                                    '1300px': 'FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink',
                                    default: 'FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink JumpToPageDropdown'
                                }" currentPageReportTemplate="Showing {first} to {last} of {totalRecords}" :value="data.services" class="p-datatable-sm" responsiveLayout="scroll" showGridlines stripedRows>
                                <ColumnP v-for="col of headers.services" :key="col" :field="col.value" :header="col.text" headerStyle="background-color: #0072AE; color:white; text-align:center" />    
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

    </template>
    
    <script>
    import tableDataColumns from '../../columns'
    
    export default {
        name: "ComponentModalDetailService",
        props: ["showModal","data"],
        computed: {
            stateModal() {
                return this.showModal
            }
        },
        data() {
            return {
                isLoading: false,
                headers: {
                    services: []
                }
            };
        },
        mounted() {
            this.headers.services = tableDataColumns.services
        },
        methods: {
            closeModal() {
                this.$emit('close')
            }
        },
    };
    </script>
    