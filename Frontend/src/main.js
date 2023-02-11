import { createApp } from 'vue'
import App from './App.vue'

import { loadFonts } from './plugins/webfontloader'

import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import router from './router'
import PrimeVue from "primevue/config";
import 'primevue/resources/primevue.min.css'
import "primevue/resources/themes/saga-blue/theme.css"
import "primeicons/primeicons.css"
import ToastService from "primevue/toastservice"
import Button from "primevue/button"
import DataTable from 'primevue/datatable'
import Column from 'primevue/column'
import ColumnGroup from 'primevue/columngroup';     
import Row from 'primevue/row';                     
import InputText from 'primevue/inputtext'

const vuetify = createVuetify({
    components,
    directives,
  })

loadFonts()

createApp(App)
  .use(vuetify)
  .use(router)
  .use(PrimeVue)
  .use(ToastService)
  .component('ButtonP', Button)
  .component("DataTable", DataTable)
  .component("ColumnP", Column)
  .component("ColumnGroup", ColumnGroup)
  .component("RowP", Row)
  .component('InputText', InputText)
  .mount('#app')
