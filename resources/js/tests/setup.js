import Vue from 'vue';
import { config } from '@vue/test-utils';
require('dotenv').config();

import BootstrapVue from 'bootstrap-vue';
Vue.use(BootstrapVue);

config.mocks.$t = key => key;

Vue.config.productionTip = false;
config.showDeprecationWarnings = false;

jest.setTimeout(30000);
