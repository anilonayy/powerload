// src/store/modules/auth.js

import appAxios from '@/Utils/appAxios'

const state = {
    user: null,
};

const mutations = {
    setUser(state, user) {
        state.user = user || {};
    },
    logoutUser(state) {
        state.user = null;
    },

};

const actions = {
    async register({ commit }, userData) {

        delete userData.errors;        

        const result = await appAxios.post('/register', userData);
        console.log(result);
        commit('setUser', result);
    }
};

const getters = {
    isAuthenticated: (state) =>  state.user !== '',

};

export default {
    state,
    mutations,
    actions,
    getters,
};
