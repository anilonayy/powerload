import appAxios from '@/plugins/appAxios';

export default {
  install: (app) => {
    app.provide('axios', appAxios);
  }
};
