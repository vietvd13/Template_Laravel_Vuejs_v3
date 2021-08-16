import Cookies from 'js-cookie';

import { getToken } from '../../utils/handleToken';
import { getProfile } from '../../utils/getProfile';

import constAuth from '../../const/auth';

const state = {
  access_token: getToken(),
  profile: getProfile(),
};

const mutations = {
  SET_ACCESS_TOKEN: (state, access_token) => {
    Cookies.set('token', access_token);
    state.access_token = access_token;
  },
  SET_PROFILE: (state, profile) => {
    Cookies.set('exp_token', profile.expToken);
    Cookies.set('profile', profile);
    state.profile = profile;
  },
  DO_LOGOUT: (state, profile) => {
    state.access_token = '';
    state.profile = profile;
  },
};

const actions = {
  saveLogin({ commit }, userInfo) {
    commit('SET_ACCESS_TOKEN', userInfo.TOKEN);
    commit('SET_PROFILE', userInfo.USER);
  },
  doLogout({ commit }) {
    const PROFILE = constAuth.PROFILE;

    Cookies.set('token', '');
    Cookies.set('exp_token', '');
    Cookies.set('profile', PROFILE);

    commit('SET_ACCESS_TOKEN', '');
    commit('DO_LOGOUT', PROFILE);
  },
};

export default {
  namespaced: true,
  state,
  mutations,
  actions,
};
