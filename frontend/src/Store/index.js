// src/store/index.js

import Vuex from 'vuex';
import auth from '@/Store/Modules/Auth';

export default new Vuex.Store({
  modules: {
    auth,
  },
});
