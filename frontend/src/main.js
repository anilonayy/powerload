import './assets/main.css'

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import appAxios from './utils/appAxios'
import axios from 'axios'

const app = createApp(App)

app.config.globalProperties.$axios = axios; // global axios defining
app.config.globalProperties.$appAxios = appAxios; // global axios defining

/* import font awesome icon component */


app.use(router)
app.mount('#app')
