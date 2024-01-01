import appAxios from '@/utils/appAxios';

export default {
	install: (app) => {
			app.provide('axios', appAxios);
	}
};