import { createApp } from 'vue'
import App from './App.vue'

import { loadFonts } from './plugins/webfontloader'

import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import router from './router'

const vuetify = createVuetify({
    components,
    directives,
  })

loadFonts()

createApp(App)
  .use(vuetify)
  .use(router)
  .mount('#app')
