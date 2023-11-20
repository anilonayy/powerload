// src/store/index.js

import Vuex from 'vuex';
import axios from '@/Utils/axios.js'
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
    state.token = token || '';
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
  async register({ commit }, userData) {
    commit('setUser', {
      name: userData.name,
      email: userData.email
    });
  },
  async login({ commit }, userData) {
    commit('setUser', userData);
  },

  async logout({ commit }) {
    commit('logoutUser');
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

