// src/store/index.js

import Vuex from 'vuex';
import { setCookie, removeCookie, getCookie } from '@/Utils/helpers.js'
import createPersistedState from 'vuex-persistedstate'
import SecureLS from "secure-ls";
var ls = new SecureLS({ isCompression: true });


const state = {
  user: null,
  formErrors: null,
  token: null,
  saltKey: '~~C.QSuperSecretPasswordSaltKey!?Ç!ŞÇQÜŞÇCAQ',
  exercises: [],
  asideOpen: false,
  training: {
    currentTraining: 0,
    trainingStep: 0,
  }
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

  setExercises(state,exercisesList) {
    state.exercises = exercisesList;
  },

  setAsideOpen(state, data) {
    state.asideOpen = data;
  },
  setTrainingStep (state, data) {
    state.training.trainingStep = data;
  },
  setTraining (state, data) {
    state.training.currentTraining = data;
  }
};

const actions = {
  async register({ commit }, data) {
    commit('setUser', {
      name: data.user.name,
      email: data.user.email
    });

    commit('setToken',data.token);
  },
  async updateUser({commit}, data) {
    commit('setUser', {
      name: data.name,
      email: data.email
    });
  },
  async login({ commit }, data) {
    commit('setUser', data.user);
    commit('setToken',data.token);
  },

  async logout({ commit }) {
    commit('logoutUser');
    commit('removeToken');
  },

  async setExercises({commit},exercisesList) {
    commit('setExercises',exercisesList);
  },

  updateAsideOpen({ commit }, data) {
    commit('setAsideOpen', data);
  },

  setTraining({ commit }, data) {
    commit('setTraining', data);
  },

  updateStep({ commit }, data) {
    commit('setTrainingStep', data);
  }
};

const getters = {
  _isAuthenticated: (state) =>  state.user !== null  && getCookie('_token') !== null,
  _saltKey: state => state.saltKey,
  _getCurrentUser: state => state.user,
  _getToken: state => state.token,
  _getExercises: state => {
    return state.exercises.map((exercise) => {
      return {
        category: exercise.category,
        value : exercise.id,
        name: exercise.name
      }
    })
  },
  _getAsideOpen: state => state.asideOpen,
  _getTraining: state => state.training,
  _getTrainingStep: state => state.training.trainingStep,
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

