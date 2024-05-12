import store from '@/store';
import axios from '@/plugins/appAxios';

const login = async ({ email, password }) => {
  const response = await axios.post('auth/login', {
    email,
    password,
    device_type: 'web'
  });

  await store.dispatch('login', response.data);
};

const register = async ({ name, email, password, birthday }) => {
  const response = await axios.post('/auth/register', {
    name,
    email,
    password,
    birthday,
    device_type: 'web'
  });

  await store.dispatch('register', response.data);
};

const logout = async () => {
  await axios.post('auth/logout');

  await store.dispatch('logout');
};

const forgotPassword = (email) => {
  return axios.post('auth/forgot-password', { email });
};

const resetPassword = async ({ password, email, password_confirm, token }) => {
  return await axios.post('/auth/reset-password', {
    token,
    email,
    password,
    password_confirm
  });
};

export default {
  login,
  register,
  logout,
  forgotPassword,
  resetPassword
};
