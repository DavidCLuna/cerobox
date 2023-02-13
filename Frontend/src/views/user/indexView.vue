<template>
<v-app>
    <v-app-bar app color="primary">
        <v-toolbar-title>Cerobox</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn color="white" @click="() => {this.$router.push('/admin')}">Admin</v-btn>
    </v-app-bar>
    <v-content>
        <v-container fluid>
            <router-view></router-view>
        </v-container>
    </v-content>
    <v-content class="mt-15 p-5">
        <h2 class="text-center">Listado de Clientes</h2>
    </v-content>

    <v-container v-if="isLoading===true" align="center">
        <v-progress-circular color="blue-lighten-3" indeterminate :size="50" :width="6"></v-progress-circular>
    </v-container>

    <v-container v-if="isLoading!==true">
        <v-content style="margin: 4em;" class="mt-5">
            <DataTable :paginator="true" :rows="25" :paginatorTemplate="{
                    '640px': 'PrevPageLink CurrentPageReport NextPageLink',
                    '960px': 'FirstPageLink PrevPageLink CurrentPageReport NextPageLink LastPageLink',
                    '1300px': 'FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink',
                    default: 'FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink JumpToPageDropdown'
                }" currentPageReportTemplate="Showing {first} to {last} of {totalRecords}" :value="data.servicesClients" class="p-datatable-sm" responsiveLayout="scroll" showGridlines stripedRows>
                <ColumnP v-for="col of headers.servicesClients" :key="col" :field="col.value" :header="col.text" headerStyle="background-color: #005da6; color:white; text-align:center" />
                <ColumnP field="actions" header="Detalle" headerStyle="background-color: #005da6; color:white; text-align:center;  align-items:center; justify-content:center;">
                    <template #body="slotProps">
                        <v-btn style="color: black;" @click="() => {itemSelected = {...slotProps.data}; detailServiceClientModal = true}">
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

        <ComponentModalDetailServiceVue :showModal="detailServiceClientModal" @close="closeModalDetailService" :data="itemSelected" @reloadData="loadInit" />
    </v-container>
</v-app>
</template>

    
<script>
import vueAxios from '../../vueAxios'
import tableDataColumns from '../columns'
import ComponentModalDetailServiceVue from './components/ComponentModalDetailService.vue'

export default {
    name: 'dashboardView',
    components: {
        ComponentModalDetailServiceVue
    },
    data() {
        return {
            //data for datatable
            itemSelected: null,
            detailServiceClientModal: false,
            isLoading: true,
            headers: {
                servicesClients: []
            },
            data: {
                servicesClients: [],
            },
        }
    },
    mounted() {
        this.loadInit();
    },
    methods: {
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
            ]).then(([servicesClientsResponse]) => {
                this.data.servicesClients = servicesClientsResponse.data.data;
                this.isLoading = false;
            }).catch(error => {
                console.error(error);
            });
        },
        cancel() {
            this.$router.push({
                name: 'indexView'
            })
        },
    }
}
</script>
