<template>
<v-app>
    <v-app-bar app color="primary">
        <v-toolbar-title>Cerobox</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn color="white" @click="logout">Logout</v-btn>
    </v-app-bar>
    <v-content>
        <v-container fluid>
            <router-view></router-view>
        </v-container>
    </v-content>
    <v-content class="mt-15 p-5">
        <h2 class="text-center">Administración de Servicios y Clientes</h2>
    </v-content>

    <v-container v-if="isLoading===true" align="center">
        <v-progress-circular color="blue-lighten-3" indeterminate :size="50" :width="6"></v-progress-circular>
    </v-container>

    <v-container v-if="isLoading!==true">
        <v-content style="margin-left: 4em; margin-right: 4em;" class="mt-15 p-5">
            <div class="d-flex text-left">
                <v-btn style="background-color: #005da6; color:white;" @click="serviceModal = true">Servicios</v-btn>
                <v-btn style="background-color: #005da6; color:white;" class="ml-5" @click="clientModal = true">Clientes</v-btn>
            </div>
        </v-content>

        <v-content style="margin: 4em;" class="mt-5">
            <div class="text-right">
                <v-btn style="background-color: #005da6; color:white; margin-right: auto;" @click="addChaplainWO">
                    <v-icon size="25" class="mr-2">mdi-plus</v-icon> Agregar
                </v-btn>
            </div>

            <DataTable :paginator="true" :rows="25" :paginatorTemplate="{
                '640px': 'PrevPageLink CurrentPageReport NextPageLink',
                '960px': 'FirstPageLink PrevPageLink CurrentPageReport NextPageLink LastPageLink',
                '1300px': 'FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink',
                default: 'FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink JumpToPageDropdown'
            }" currentPageReportTemplate="Showing {first} to {last} of {totalRecords}" :value="data.servicesClients" class="p-datatable-sm" responsiveLayout="scroll" showGridlines stripedRows>
                <ColumnP v-for="col of headers.servicesClients" :key="col" :field="col.value" :header="col.text" headerStyle="background-color: #005da6; color:white; text-align:center" />
                <ColumnP field="actions" header="Actions" headerStyle="background-color: #005da6; color:white; text-align:center;  align-items:center; justify-content:center;">
                    <template #body="slotProps">
                        <v-btn style="color: black;" @click="editChaplainWO(slotProps.data)">
                            <v-icon small @click="deleteItem(item)">
                                mdi-pencil
                            </v-icon>
                        </v-btn>
                        <v-btn style="color: black;" @click="editChaplainWO(slotProps.data)">
                            <v-icon small @click="deleteItem(item)">
                                mdi-delete
                            </v-icon>
                        </v-btn>
                    </template>
                </ColumnP>

                <template #footer>
                    Total de Servicios de Clientes: {{ data.servicesClients ? data.servicesClients.length : 0 }}
                </template>
            </DataTable>
        </v-content>

        <!-- modal de CRUD de servicios -->
        <v-dialog v-model="serviceModal" max-width="800">
            <v-card>
                <v-card-title>
                    <h2 class="text-center mt-2">Servicios</h2>
                </v-card-title>
                <v-card-text>
                    <div class="text-right">
                        <v-btn style="background-color: #005da6; color:white; margin-right: auto;" @click="addChaplainWO">
                            <v-icon size="25" class="mr-2">mdi-plus</v-icon> Agregar
                        </v-btn>
                    </div>
                    <DataTable :paginator="true" :rows="6" :paginatorTemplate="{
                '640px': 'PrevPageLink CurrentPageReport NextPageLink',
                '960px': 'FirstPageLink PrevPageLink CurrentPageReport NextPageLink LastPageLink',
                '1300px': 'FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink',
                default: 'FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink JumpToPageDropdown'
            }" currentPageReportTemplate="Showing {first} to {last} of {totalRecords}" :value="data.services" class="p-datatable-sm" responsiveLayout="scroll" showGridlines stripedRows>
                        <ColumnP v-for="col of headers.services" :key="col" :field="col.value" :header="col.text" headerStyle="background-color: #005da6; color:white; text-align:center" />
                        <ColumnP field="actions" header="Actions" headerStyle="background-color: #005da6; color:white; text-align:center;  align-items:center; justify-content:center;">
                            <template #body="slotProps">
                                <v-btn style="color: black;" @click="editChaplainWO(slotProps.data)">
                                    <v-icon small @click="deleteItem(item)">
                                        mdi-pencil
                                    </v-icon>
                                </v-btn>
                                <v-btn style="color: black;" @click="editChaplainWO(slotProps.data)">
                                    <v-icon small @click="deleteItem(item)">
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
                    <v-btn color="error" @click="serviceModal = false">Cerrar</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!-- modal de CRUD de clientes -->
        <v-dialog v-model="clientModal" max-width="800">
            <v-card>
                <v-card-title>
                    <h2 class="text-center mt-2">Clientes</h2>
                </v-card-title>
                <v-card-text>
                    <div class="text-right">
                        <v-btn style="background-color: #005da6; color:white; margin-right: auto;" @click="addChaplainWO">
                            <v-icon size="25" class="mr-2">mdi-plus</v-icon> Agregar
                        </v-btn>
                    </div>
                    <DataTable :paginator="true" :rows="6" :paginatorTemplate="{
                '640px': 'PrevPageLink CurrentPageReport NextPageLink',
                '960px': 'FirstPageLink PrevPageLink CurrentPageReport NextPageLink LastPageLink',
                '1300px': 'FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink',
                default: 'FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink JumpToPageDropdown'
            }" currentPageReportTemplate="Showing {first} to {last} of {totalRecords}" :value="data.clients" class="p-datatable-sm" responsiveLayout="scroll" showGridlines stripedRows>
                        <ColumnP v-for="col of headers.clients" :key="col" :field="col.value" :header="col.text" headerStyle="background-color: #005da6; color:white; text-align:center" />
                        <ColumnP field="actions" header="Actions" headerStyle="background-color: #005da6; color:white; text-align:center;  align-items:center; justify-content:center;">
                            <template #body="slotProps">
                                <v-btn style="color: black;" @click="editChaplainWO(slotProps.data)">
                                    <v-icon small @click="deleteItem(item)">
                                        mdi-pencil
                                    </v-icon>
                                </v-btn>
                                <v-btn style="color: black;" @click="editChaplainWO(slotProps.data)">
                                    <v-icon small @click="deleteItem(item)">
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
                    <v-btn color="error" @click="clientModal = false">Cerrar</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-container>
</v-app>
//modal dialog vuetify
</template>

<script>
import vueAxios from '../../vueAxios'
import tableDataColumns from './columns'

export default {
    name: 'dashboardView',
    data() {
        return {
            //data for datatable
            serviceModal: false,
            clientModal: true,
            isLoading: true,
            tab: null,
            headers: {
                clients: [],
                services: [],
                servicesClients: []
            },
            data: {
                clients: [],
                services: [],
                servicesClients: [],
            },
        }
    },
    mounted() {
        this.loadInit();
    },
    methods: {
        async loadInit() {

            this.headers.clients = tableDataColumns.clients;
            this.headers.services = tableDataColumns.services;
            this.headers.servicesClients = tableDataColumns.service_clients;

            // load clients
            Promise.all([
                vueAxios.get('/api/clients'),
                vueAxios.get('/api/services'),
                vueAxios.get('/api/service-clients')
            ]).then(([clientsResponse, servicesResponse, servicesClientsResponse]) => {
                this.data.clients = clientsResponse.data.data;
                this.data.services = servicesResponse.data.data;
                this.data.servicesClients = servicesClientsResponse.data.data;
                this.isLoading = false;
            }).catch(error => {
                console.error(error);
            });
        },
        editClient() {

        },
        cancel() {
            this.$router.push({
                name: 'indexView'
            })
        },
        logout() {
            localStorage.setItem('token', null);
            alert('Logout successfull')
            this.$router.push('/admin')
        }
    }
}
</script>
