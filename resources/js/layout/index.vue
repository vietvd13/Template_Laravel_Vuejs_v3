<template>
  <div>
    <Navbar />
    <div class="display-app">
      <Breadcrumd />
      <AppMain />
    </div>
  </div>
</template>

<script>

import Navbar from './components/Navbar.vue';
import Breadcrumd from './components/Breadcrumd.vue';
import AppMain from './components/AppMain.vue';

import { MakeToast } from '../utils/toastMessage';

export default {
  name: 'Layout',
  components: {
    Navbar,
    Breadcrumd,
    AppMain,
  },
  data() {
    return {
      timeNow: '',
    };
  },
  watch: {
    timeNow() {
      const EXP = (parseInt(this.$store.getters.expToken) * 1000);

      if (this.timeNow >= EXP) {
        this.$store.dispatch('user/doLogout')
          .then(() => {
            this.$router.push('/login');
          })
          .catch(() => {
            MakeToast({
              variant: 'danger',
              title: this.$t('DANGER'),
              content: this.$t('TOAST_HAVE_ERROR'),
            });
          });
      }
    },
  },
  mounted() {
    window.setTimeout(this.getTimeNow, 1000);
  },
  methods: {
    getTimeNow() {
      this.timeNow = Date.now();
      window.setTimeout(this.getTimeNow, 1000);
    },

  },
};
</script>

<style lang="scss" scoped>
    .display-app {
        margin-top: 78px;
    }
</style>
