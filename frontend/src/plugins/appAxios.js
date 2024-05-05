import store from '@/store';
import dayjs from "dayjs";
import {getCookie, getLocale} from '@/utils/helpers';
import axios from 'axios';
import router from '@/router';

const createAxiosInstance = () => {
	const instance = axios.create({
		baseURL: 'http://api.powerload.com',
		withCredentials: false,
		timeout: 30000,
	});

	instance.interceptors.request.use(
		config => {
			if (getCookie('_token')) {
				config.headers.Authorization = `Bearer ${ getCookie('_token') }`;
			}

			config.headers.Accept = 'application/json';
			config.headers.ContentType = 'application/json';
			config.headers.Locale = getLocale();
			config.headers['X-Production'] = true;

			return config;
		},
		error => {
			return Promise.reject(error);
		});

	instance.interceptors.response.use(
		({ data }) => data,
		async error => {
			const statusCode = error?.response?.status;
			const url = window.location.href;

			if (statusCode === 401) {
				if(!(url.includes('login') || url.includes('register'))) {
					await store.dispatch('logout');
					await router.push('/');
				}
			} else if(statusCode === 429) {
				const locale = getLocale();
				const nextRequestTime = dayjs(error.response
					.headers['x-ratelimit-reset'] * 1000).format('HH:mm');

				// @TODO : Fetch this message from language files.
				if(locale === 'en_US') {
					error.response.data.message = `You have exceeded the rate limit for this action. Please try again after ${nextRequestTime}`;
				} else if(locale === 'tr_TR') {
					error.response.data.message = `Bu işlem için istek limitini aştınız. Lütfen ${nextRequestTime} sonrasında tekrar deneyin.`;
				}
			}

			return Promise.reject(error.response.data);
		}
	);

	return instance;
};

export default createAxiosInstance();