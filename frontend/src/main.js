import './assets/main.css';
import './assets/components/buttons.css';
import './assets/components/badges.css';
import 'sweetalert2/dist/sweetalert2.min.css';

import { createApp } from 'vue';
import App from '@/App.vue';
import router from '@/router';
import store from '@/store';
import SweetAlertPlugin from '@/plugins/SweetAlert';
import Toast from '@/plugins/Toast';
import axios from '@/utils/axios';

const app = createApp(App);

app.use(store);
app.use(router);
app.use(SweetAlertPlugin)
app.use(Toast)
app.use(axios);

app.mount('#app');
