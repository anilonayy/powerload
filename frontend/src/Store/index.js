import Vuex from 'vuex';
import { setCookie, removeCookie, getCookie } from '@/Utils/helpers.js'
import createPersistedState from 'vuex-persistedstate'
import SecureLS from "secure-ls";

var ls = new SecureLS({ isCompression: true });

const state = {
  user: null,
  saltKey: '~~C.QSuperSecretPasswordSaltKey!?Ç!ŞÇQÜŞÇCAQ',
  exercises: [],
  asideOpen: false,
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
    state.token = null;
  },

  logoutUser(state) {
    state.user = null;
  },

  setExercises(state,exercisesList) {
    state.exercises = exercisesList || [];
  },

  setAsideOpen(state, data) {
    state.asideOpen = Boolean(data);
  },

  setTrainings (state, data) {
    state.trainings = data || [];
  },

  setTrainingLogId (state, data) {
    state.trainLogId = data || 0;
  },

  setOnTrainData (state, data) {
    state.trainings.find((training) => training.isSelected).days.find((day) => day.isSelected).exercises.find(
      (exercise) => exercise.id === data.exercise_id).onTrain = data.value;
  },

  // data.training_id
  selectTraining (state, data) {
    (state.trainings.find((training) => training.isSelected) || {}).isSelected = false;
    state.trainings.find((training) => training.id === data.training_id).isSelected = true;
  },

  // data.day_id
  selectTrainingDay (state, data) {
    ((state.trainings.find((training) => training.isSelected) || []).days.find((day) => day.isSelected === true) || {}).isSelected = false;
    ((state.trainings.find((training) => training.isSelected) || []).days.find((day) => day.id === data.day_id) || {}).isSelected = true;
  }
};

const actions = {
  register({ commit }, data) {
    commit('setUser', {
      name: data.user.name,
      email: data.user.email
    });

    commit('setToken', data.token);
  },

  updateUser({commit}, data) {
    commit('setUser', {
      name: data.name,
      email: data.email
    });
  },

  login({ commit }, data) {
    commit('setUser', data.user);
    commit('setToken', data.token);
  },

  logout({ commit }) {
    commit('logoutUser');
    commit('removeToken');
  },

  setExercises({commit},exercisesList) {
    commit('setExercises', exercisesList);
  },

  updateAsideOpen({ commit }, data) {
    commit('setAsideOpen', data);
  },

  setTrainings({ commit }, data) {
    commit('setTrainings', data);
  },
  setTrainingLogId({ commit }, data) {
    commit('setTrainingLogId', data);
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
  _currentUser: state => state.user,
  _exerciseList: state => {
    return state.exercises.map((exercise) => {
      return {
        category: exercise.category,
        value : exercise.id,
        name: exercise.name
      }
    })
  },
  _isAsideOpen: state => state.asideOpen,
  _userTrainings: state => state.trainings,
  _trainingLogId: state => state.trainLogId,
  _selectedTraining: state => state.trainings.find((training) => Boolean(training.isSelected)),
  _selectedDay: state => state.trainings.find((training) => Boolean(training.isSelected)).days.find((day) => day.isSelected === true),
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

