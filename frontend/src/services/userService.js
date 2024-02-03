import axios from '@/utils/appAxios';
import store from '@/store';


const updatePassword = async ({ currentPassword, newPassword }) => {
    await axios.patch('/v1/users/update-password', {
        currentPassword,
        newPassword,
        newPasswordConfirm: newPassword
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