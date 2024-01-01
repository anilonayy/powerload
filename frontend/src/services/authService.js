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

export const register async (asd) => {
    
}