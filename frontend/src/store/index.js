import Vuex from 'vuex';
import { setCookie, removeCookie, getCookie } from '@/utils/helpers.js'
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
  }],
  nextLastLogRequestTime: null
};

const mutations = {
  setUser(state, user) {
    state.user = user ?? {};
  },

  setToken(state, token) {
    setCookie('_token',token,7);
    state.token = token ?? '';
  },

  removeToken(state) {
    removeCookie('_token');
    state.token = null;
  },

  logoutUser(state) {
    localStorage.removeItem('vuex');
    localStorage.removeItem('_secure__ls__metadata');
    state.user = null;
  },

  setExercises(state,exercisesList) {
    state.exercises = exercisesList ?? [];
  },

  setAsideOpen(state, data) {
    state.asideOpen = Boolean(data);
  },

  setTrainings (state, data) {
    state.trainings = data ?? [];
  },

  setTrainingLogId (state, data) {
    state.trainLogId = data ?? 0;
  },

  setOnTrainData (state, data) {
    state.trainings.find((training) => training?.isSelected).days.find((day) => day?.isSelected).exercises.find(
      (exercise) => exercise.id === data.exercise_id).onTrain = data.value;
  },

  selectTraining (state, training_id) {
    (state.trainings.find((training) => training.isSelected) ?? {}).isSelected = false;
    (state.trainings.find((training) => training.id === training_id) ?? {}).isSelected = true;
  },

  // data.day_id
  selectTrainingDay (state, day_id) {
    ((state.trainings.find((training) => training.isSelected) ?? []).days?.find((day) => day.isSelected === true) ?? {}).isSelected = false;
    ((state.trainings.find((training) => training.isSelected) ?? []).days?.find((day) => day.id == day_id) ?? {}).isSelected = true;
  },
  setExercisesOfDay(state, exercises) {
    ((state.trainings.find((training) => training.isSelected) ?? []).days.find((day) => day.isSelected) ?? {})
      .exercises = exercises.map((exercise) => {
        return {
          id: exercise.exercise.id ?? 0,
          name: exercise.exercise.name ?? '',
          category: exercise.exercise.category ?? {},
          sets: exercise.sets ?? 0,
          reps: exercise.reps ?? 0,
          isPassed: false,
          onTrain: [{
            id: 0,
            reps: 5,
            weight: 0,
            repsError: false,
            weightError: false,
            createTime: new Date().getTime()
          }]
        }
    });
  },
  setAsNotPassed (state, exerciseId) {
    ((state.trainings.find((training) => training.isSelected) ?? []).days.find((day) => day.isSelected) ?? {})
      .exercises.find((exercise) => exercise.id === exerciseId).isPassed = false;
  },
  setAsPassed (state, exerciseId) {
    ((state.trainings.find((training) => training.isSelected) ?? []).days.find((day) => day.isSelected) ?? {})
      .exercises.find((exercise) => exercise.id === exerciseId).isPassed = true;
  },
  setNextLastLogRequestTime (state, time) {
    state.nextLastLogRequestTime = time;
  }
};

const actions = {
  async register({ commit }, data) {
    commit('setUser', {
      name: data.user.name,
      email: data.user.email
    });

    commit('setToken', data.token);
  },

  async  updateUser({commit}, data) {
    commit('setUser', {
      name: data.name,
      email: data.email
    });
  },

  async  login({ commit }, data) {
    commit('setUser', data.user);
    commit('setToken', data.token);
  },

  async logout({ commit }) {
    commit('logoutUser');
    commit('removeToken');
    commit('setTrainings', []);
    commit('setTrainingLogId', 0);
  },

  async setExercises({commit},exercisesList) {
    commit('setExercises', exercisesList);
  },

  async  updateAsideOpen({ commit }, data) {
    commit('setAsideOpen', data);
  },

  async  setTrainings({ commit }, data) {
    commit('setTrainings', data);
  },
  async  setTrainingLogId({ commit }, data) {
    commit('setTrainingLogId', data);
  },
  async  setOnTrainData({ commit }, data) {
    commit('setOnTrainData', data);
  },
  async selectTraining({ commit }, training_id) {
    commit('selectTraining', training_id);
  },
  async  selectTrainingDay({ commit }, dayId) {
    commit('selectTrainingDay', dayId);
  },
  async  setExercisesOfDay({ commit }, exercises) {
    commit('setExercisesOfDay', exercises);
  },
  async  setAsNotPassed({ commit }, exerciseId) {
    commit('setAsNotPassed', exerciseId);
  },
  async setAsPassed({ commit }, exerciseId) {
    commit('setAsPassed', exerciseId);
  },
  async setNextLastLogRequestTime({ commit }, time) {
    commit('setNextLastLogRequestTime', time);
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
  _selectedDay: state => ((state.trainings.find((training) => Boolean(training.isSelected)) ?? {}).days ?? []).find((day) => day.isSelected === true) ?? {},
  _isTrainingSelected: state => state.trainings.some((training) => Boolean(training.isSelected)),
  _isTrainingDaySelected: state => state.trainings.some((training) => training.days.some((day) => day.isSelected === true)),
  _getNextLastLogRequestTime: state => state.nextLastLogRequestTime,
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

