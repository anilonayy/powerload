import './assets/main.css';
import 'sweetalert2/dist/sweetalert2.min.css';

import { createApp } from 'vue';
import App from '@/App.vue';
import router from '@/Router';
import store from '@/Store';
import SweetAlertPlugin from '@/Plugins/SweetAlert';
import Toast from '@/Plugins/Toast';


const app = createApp(App);

app.use(router);
app.use(store);
app.use(SweetAlertPlugin)
app.use(Toast)

app.mount('#app');
