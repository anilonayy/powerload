import './assets/main.css';

import { createApp } from 'vue';
import App from '@/App.vue';
import router from '@/Router';
import store from '@/Store';
import Select2 from 'vue3-select2-component'

const app = createApp(App);

app.use(router);
app.use(store);
app.component(Select2);

app.mount('#app');
