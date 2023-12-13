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
    id: 0,
    trainingId: 0,
    trainingDayId: 0,
    exercises: [{
      id: 0,
      name: '',
      category: {
        name : ''
      },
      onTrain: [{
        id: 0,
        weight: 0,
        reps: 0,
        weightError: false,
        repsError: false,
      }]
    }]
  },
  trainLogId: 0,
  trainings: [{
    id: 0,
    isSelected: false,
    days: [{
      id: 0,
      name: '',
      isSelected: false,
      exercises: [{
        id: 0,
        name: '',
        category: {
          name : ''
        },
        onTrain: [{
          id: 0,
          weight: 0,
          reps: 0,
          weightError: false,
          repsError: false,
        }]
      }]
    }]
  }]
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
  setTrainings (state, data) {
    state.trainings = data;
  },
  setTrainingId (state, data) {
    state.training.trainingId = data;
  },
  setTrainingLogId (state, data) {
    state.trainLogId = data;
  },
  setTrainingDayId (state, data) {
    state.training.trainingDayId = data;
  },
  
  setOnTrainData (state, data) {
    state.trainings.find((training) => training.isSelected).days.find((day) => day.isSelected).exercises.find((exercise) => exercise.id === data.exercise_id).onTrain = data.value;
  },
  // data.trainingId
  selectTraining (state, data) {
    (state.trainings.find((training) => training.isSelected) || {}).isSelected = false;
    state.trainings.find((training) => training.id === data.trainingId).isSelected = true;
  },
  // data.dayId
  selectTrainingDay (state, data) {
    ((state.trainings.find((training) => training.isSelected) || []).days.find((day) => day.isSelected === true) || {}).isSelected = false;
    state.trainings.find((training) => training.isSelected).days.find((day) => day.id === data.dayId).isSelected = true;
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

  setTrainings({ commit }, data) {
    commit('setTrainings', data);
  },

  setTrainingId({ commit }, data) {
    commit('setTrainingId', data);
  },
  setTrainingLogId({ commit }, data) {
    commit('setTrainingLogId', data);
  },
  setTrainingDayId({ commit }, data) {
    commit('setTrainingDayId', data);
  },
  setOnTrainData({ commit }, data) {
    commit('setOnTrainData', data);
  },
  selectTraining({ commit }, data) {
    commit('selectTraining', data);
  },
  selectTrainingDay({ commit }, data) {
    commit('selectTrainingDay', data);
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
  _getTrainings: state => state.trainings,
  _getTrainingLogId: state => state.trainLogId,
  _getSelectedTraining: state => state.trainings.find((training) => Boolean(training.isSelected)),
  _getSelectedDay: state => state.trainings.find((training) => Boolean(training.isSelected)).days.find((day) => day.isSelected === true),
  _isTrainingSelected: state => state.trainings.some((training) => Boolean(training.isSelected)),
  _isTrainingDaySelected: state => state.trainings.some((training) => training.days.some((day) => day.isSelected === true)),
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

