import { computed } from 'vue';
import store from '@/store'
import axios from '@/utils/appAxios';
import CryptoJs from 'crypto-js';

const login = async ({ email, password }) => {
    const saltKey = computed(() => store.getters['_saltKey']);
    const hashPassword = CryptoJs.HmacSHA1(password, saltKey.value).toString();

    const response = await axios.post('auth/login', {
        email,
        password: hashPassword
    });

    await store.dispatch('login', response.data);
}

const register = async ({ name, email, password, password_confirm }) => {
    const saltKey = computed(() => store.getters['_saltKey']);
    const cryptPassword = CryptoJs.HmacSHA1(password, saltKey.value).toString();
    const cryptPasswordConfirm = CryptoJs.HmacSHA1(password_confirm, saltKey.value).toString();
    
    const response = await axios.post('/auth/register', {
        name,
        email,
        password: cryptPassword,
        password_confirm: cryptPasswordConfirm
    });

    await store.dispatch('register', response.data);
}

const logout = async () => {
    await axios.post('auth/logout');

    await store.dispatch('logout');
}

const forgotPassword = (email) => {
    return axios.post('auth/forgot-password', { email });
};

const resetPassword = async ({ password, email, password_confirm, token }) => {
    const saltKey = computed(() => store.getters['_saltKey']);
    const cryptPassword = CryptoJs.HmacSHA1(password, saltKey.value).toString();
    const cryptPasswordConfirm = CryptoJs.HmacSHA1(password_confirm, saltKey.value).toString();

    const response = await axios.post('/auth/reset-password', {
        token,
        email,
        password: cryptPassword,
        password_confirm: cryptPasswordConfirm
    });

    return response;
};

export default {
    login,
    register,
    logout,
    forgotPassword,
    resetPassword
}