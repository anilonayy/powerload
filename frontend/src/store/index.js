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
  workouts: [{
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
        onWorkout: [{
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

  setWorkouts (state, data) {
    state.workouts = data ?? [];
  },

  setWorkoutLogId (state, data) {
    state.trainLogId = data ?? 0;
  },

  setOnWorkoutData (state, data) {
    state.workouts.find((workout) => workout?.isSelected).days.find((day) => day?.isSelected).exercises.find(
      (exercise) => exercise.id === data.exercise_id).onWorkout = data.value;
  },

  selectWorkout (state, workout_id) {
    (state.workouts.find((workout) => workout.isSelected) ?? {}).isSelected = false;
    (state.workouts.find((workout) => workout.id === workout_id) ?? {}).isSelected = true;
  },

  // data.day_id
  selectWorkoutDay (state, day_id) {
    ((state.workouts.find((workout) => workout.isSelected) ?? []).days?.find((day) => day.isSelected === true) ?? {}).isSelected = false;
    ((state.workouts.find((workout) => workout.isSelected) ?? []).days?.find((day) => day.id == day_id) ?? {}).isSelected = true;
  },
  setExercisesOfDay(state, exercises) {
    ((state.workouts.find((workout) => workout.isSelected) ?? []).days.find((day) => day.isSelected) ?? {})
      .exercises = exercises.map((exercise) => {
        return {
          id: exercise.exercise.id ?? 0,
          name: exercise.exercise.name ?? '',
          category: exercise.exercise.category ?? {},
          sets: exercise.sets ?? 0,
          reps: exercise.reps ?? 0,
          isPassed: false,
          onWorkout: [{
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
    ((state.workouts.find((workout) => workout.isSelected) ?? []).days.find((day) => day.isSelected) ?? {})
      .exercises.find((exercise) => exercise.id === exerciseId).isPassed = false;
  },
  setAsPassed (state, exerciseId) {
    ((state.workouts.find((workout) => workout.isSelected) ?? []).days.find((day) => day.isSelected) ?? {})
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
    commit('setWorkouts', []);
    commit('setWorkoutLogId', 0);
  },

  async setExercises({commit},exercisesList) {
    commit('setExercises', exercisesList);
  },

  async  updateAsideOpen({ commit }, data) {
    commit('setAsideOpen', data);
  },

  async  setWorkouts({ commit }, data) {
    commit('setWorkouts', data);
  },
  async  setWorkoutLogId({ commit }, data) {
    commit('setWorkoutLogId', data);
  },
  async  setOnWorkoutData({ commit }, data) {
    commit('setOnWorkoutData', data);
  },
  async selectWorkout({ commit }, workout_id) {
    commit('selectWorkout', workout_id);
  },
  async  selectWorkoutDay({ commit }, dayId) {
    commit('selectWorkoutDay', dayId);
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
  _userWorkouts: state => state.workouts,
  _workoutLogId: state => state.trainLogId,
  _selectedWorkout: state => state.workouts.find((workout) => Boolean(workout.isSelected)),
  _selectedDay: state => ((state.workouts.find((workout) => Boolean(workout.isSelected)) ?? {}).days ?? []).find((day) => day.isSelected === true) ?? {},
  _isWorkoutSelected: state => state.workouts.some((workout) => Boolean(workout.isSelected)),
  _isWorkoutDaySelected: state => state.workouts.some((workout) => workout.days.some((day) => day.isSelected === true)),
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

