import axios from '@/utils/appAxios';
import { computed } from 'vue';
import store from '@/store';
import CryptoJs from 'crypto-js';


const updatePassword = async ({ currentPassword, newPassword }) => {
    const saltKey = computed(() => store.getters['_saltKey']);
    const cryptCurrentPassword = CryptoJs.HmacSHA1(currentPassword, saltKey.value).toString();
    const cryptNewPassword = CryptoJs.HmacSHA1(newPassword, saltKey.value).toString();

    await axios.patch('/v1/users/update-password', {
        currentPassword: cryptCurrentPassword,
        newPassword: cryptNewPassword,
        newPasswordConfirm: cryptNewPassword
    });
};

const updateUser = async (user) => {
    await axios.put('/v1/users/update', user);
    await store.dispatch('updateUser', user);
}


export default {
    updatePassword,
    updateUser
}