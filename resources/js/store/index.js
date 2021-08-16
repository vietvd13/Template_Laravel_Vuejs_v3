import Vue from 'vue';
import Vuex from 'vuex';

// Import Modules
import app from './modules/app';
import user from './modules/user';
import permission from './modules/permission';

// Import Getters
import getters from './getters';

Vue.use(Vuex);

const modules = {
  app,
  user,
  permission,
};

const store = new Vuex.Store({
  modules,
  getters,
});

export default store;
