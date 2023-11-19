// src/store/index.js

import Vuex from 'vuex';
import appAxios from '@/Utils/appAxios'
import createPersistedState from 'vuex-persistedstate'
import SecureLS from "secure-ls";
var ls = new SecureLS({ isCompression: true });


const state = {
  user: null,
  formErrors: null,
  saltKey: '~~C.QSuperSecretPasswordSaltKey!?Ç!ŞÇQÜŞÇCAQ'
};

const mutations = {
  setUser(state, user) {

      state.user = user || {};
  },

  logoutUser(state) {
      state.user = null;
  },

  setFormErrors(state,errors) {
      state.formErrors = errors || {};
  },

  clearFormErrors(state) {
      state.formErrors = null;
  }

};

const actions = {
  async register({ commit }, userData) {
      try {
          await appAxios.post('/register', userData);

          commit('setUser', {
              name: userData.name,
              email: userData.email
          });

          commit('clearFormErrors');
      } catch (error) {
        console.log(error);
          commit('setFormErrors',error.response.data.errors);
      }
  } ,
  async logout({commit}) {
    try {
        await appAxios.post('/logout');

        commit('logoutUser');
    } catch (error) {
      console.log('Error Occured Logout Action =>', error);
    }
  }
};

const getters = {
  _isAuthenticated: state =>  state.user !== null,
  _saltKey: state => state.saltKey,
  _getCurrentUser: state => state.user
};

const plugins = [createPersistedState({
  storage: {
      getItem: (key) => ls.get(key),
      setItem: (key, value) => ls.set(key, value),
      removeItem: (key) => ls.remove(key),
    }
})];

export default new Vuex.Store({
  state,
  mutations,
  actions,
  getters,
  plugins
});

