import store from '@/store'
import axios from '@/utils/appAxios';
import CryptoJs from 'crypto-js';
import { computed } from 'vue';

export const login = async ({ email, password }) => {
    const saltKey = computed(() => store.getters['_saltKey']);
    const hashPassword = CryptoJs.HmacSHA1(password, saltKey.value).toString();

    const response = await axios.post('auth/login', {
        email,
        password: hashPassword
    });

    store.dispatch('login', response.data);
}

export const register = async ({ name, email, password, password_confirm }) => {
    const saltKey = computed(() => store.getters['_saltKey']);

    const cryptPassword = CryptoJs.HmacSHA1(password, saltKey.value).toString();
    const cryptPasswordConfirm = CryptoJs.HmacSHA1(password_confirm, saltKey.value).toString();
    
    const response = await axios.post('/auth/register', {
        name,
        email,
        password: cryptPassword,
        password_confirm: cryptPasswordConfirm
    });

    store.dispatch('register', response.data);
}