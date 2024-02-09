import './assets/main.css';
import './assets/components/buttons.css';
import './assets/components/badges.css';
import 'sweetalert2/dist/sweetalert2.min.css';

import {createApp} from 'vue';
import App from '@/App.vue';
import router from '@/router';
import store from '@/store';
import SweetAlert from '@/plugins/SweetAlert';
import Toast from '@/plugins/Toast';
import axios from '@/plugins/axios';
import i18n from '@/plugins/I18n';

const app = createApp(App);

app.use(store);
app.use(router);
app.use(SweetAlert)
app.use(Toast)
app.use(axios);
app.use(i18n);

app.mount('#app');
