// src/store/index.js

import Vuex from 'vuex';
import { setCookie, removeCookie } from '@/Utils/helpers.js'
import createPersistedState from 'vuex-persistedstate'
import SecureLS from "secure-ls";
var ls = new SecureLS({ isCompression: true });


const state = {
  user: null,
  formErrors: null,
  token: null,
  saltKey: '~~C.QSuperSecretPasswordSaltKey!?Ç!ŞÇQÜŞÇCAQ'
};

const mutations = {
  setUser(state, user) {
    state.user = user || {};
  },

  setToken(state, token) {
    setCookie('_token',token,7);
    state.token = token || '';
  },
  removeToken(state) {
    removeCookie('_token');
    state.token = '';
  },

  logoutUser(state) {
    state.user = null;
  },

  setFormErrors(state, errors) {
    state.formErrors = errors || {};
  },

  clearFormErrors(state) {
    state.formErrors = null;
  },


};

const actions = {
  async register({ commit }, data) {
    commit('setUser', {
      name: data.user.name,
      email: data.user.email
    });

    commit('setToken',data.token);
  },
  async login({ commit }, data) {
    commit('setUser', data.user);
    commit('setToken',data.token);
  },

  async logout({ commit }) {
    commit('logoutUser');
    commit('removeToken');
  }
};

const getters = {
  _isAuthenticated: state => state.user !== null,
  _saltKey: state => state.saltKey,
  _getCurrentUser: state => state.user,
  _getToken: state => state.token
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

