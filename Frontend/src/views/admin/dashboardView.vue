<template>
<v-app>
    <v-app-bar app color="#0072AE"  style="color:#ffffff;">
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
                <v-btn style="background-color: #0072AE; color:white;" @click="serviceModal = true">Administrar Servicios</v-btn>
                <v-btn style="background-color: #0072AE; color:white;" class="ml-5" @click="clientModal = true">Administrar Clientes</v-btn>
            </div>
        </v-content>

        <v-content style="margin: 4em;" class="mt-5">
            <DataTable :paginator="true" :rows="25" :paginatorTemplate="{
                '640px': 'PrevPageLink CurrentPageReport NextPageLink',
                '960px': 'FirstPageLink PrevPageLink CurrentPageReport NextPageLink LastPageLink',
                '1300px': 'FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink',
                default: 'FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink JumpToPageDropdown'
            }" currentPageReportTemplate="Showing {first} to {last} of {totalRecords}" :value="data.servicesClients" class="p-datatable-sm" responsiveLayout="scroll" showGridlines stripedRows>
                <ColumnP v-for="col of headers.servicesClients" :key="col" :field="col.value" :header="col.text" headerStyle="background-color: #0072AE; color:white; text-align:center" />
                <ColumnP field="actions" header="Actions" headerStyle="background-color: #0072AE; color:white; text-align:center;  align-items:center; justify-content:center;">
                    <template #body="slotProps">
                        <v-btn style="color: black;" @click="showDetailServiceClientModal(slotProps.data.id)">
                            <v-icon small>
                                mdi-eye
                            </v-icon>
                        </v-btn>
                    </template>
                </ColumnP>

                <template #footer>
                    Total de Servicios de Clientes: {{ data.servicesClients ? data.servicesClients.length : 0 }}
                </template>
            </DataTable>
        </v-content>
        
        <!-- modal de CRUD de clientes -->
        <ComponentModalClientsVue :showModal="clientModal" @reloadData="loadInit" @close="closeModalClients" :data="data.clients" />
        <ComponentModalServicesVue :showModal="serviceModal" @close="closeModalServices" :data="data.services" @reloadData="loadInit"/>
        <ComponentModalDetailServiceVue ref="modalDetailServiceClient" :showModal="detailServiceClientModal" @close="closeModalDetailService" @reloadData="loadInit"/>
    </v-container>
</v-app>
</template>

<script>
import vueAxios from '../../vueAxios'
import tableDataColumns from '../columns'
import ComponentModalClientsVue from './components/ComponentModalClients.vue'
import ComponentModalServicesVue from './components/ComponentModalServices.vue'
import ComponentModalDetailServiceVue from './components/ComponentModalDetailService.vue'

export default {
    name: 'dashboardView',
    components: {
        ComponentModalClientsVue,
        ComponentModalServicesVue,
        ComponentModalDetailServiceVue
    },
    data() {
        return {
            //data for datatable
            serviceModal: false,
            idClientSelected: null,
            clientModal: false,
            detailServiceClientModal: false,
            isLoading: true,
            tab: null,
            headers: {
                servicesClients: []
            },
            data: {
                services: [],
                clients: [],
                servicesClients: [],
            },
        }
    },
    mounted() {
        this.loadInit();
    },
    methods: {
        showDetailServiceClientModal(id_client) {
            this.detailServiceClientModal = true;
            this.$refs.modalDetailServiceClient.loadInitialData(id_client);
        },
        closeModalClients() {
            console.log('closeModalClients')
            this.clientModal = false
        },
        closeModalServices() {
            console.log('closeModalClients')
            this.serviceModal = false
        },
        closeModalDetailService() {
            console.log('closeModalDetailService')
            this.detailServiceClientModal = false
        },
        loadInit() {

            this.isLoading = true;

            this.headers.servicesClients = tableDataColumns.service_clients;

            // load clients
            Promise.all([
                vueAxios.get('/api/service-clients'),
                vueAxios.get('/api/clients'),
                vueAxios.get('/api/services'),
            ]).then(([servicesClientsResponse, clientsResponse ,servicesResponse]) => {
                this.data.servicesClients = servicesClientsResponse.data.data;
                this.data.clients = clientsResponse.data.data;
                this.data.services = servicesResponse.data.data;
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
