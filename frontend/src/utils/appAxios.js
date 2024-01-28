import store from '@/store';
import { getCookie } from '@/utils/helpers';
import axios from 'axios';
import router from '@/router'

const createAxiosInstance = () => {
	const instance = axios.create({
		baseURL: 'http://127.0.0.1:8000/api',
		withCredentials: false,
		timeout: 4000
	});

	instance.interceptors.request.use(
		config => {
			config.headers.Authorization = `Bearer ${ getCookie('_token') }`;
			return config;
		},
		error => {
			return Promise.reject(error);
		});

	instance.interceptors.response.use(
		response => {
			return response.data;
		},
		error => {
		if (error?.response?.status === 401) {
			if(!(window.location.href.includes('login') || window.location.href.includes('register'))) {
				store.dispatch('logout');
				router.push('/');
			}
		}

		return Promise.reject(error.response.data);
		}
	);

	return instance;
};

export default createAxiosInstance();