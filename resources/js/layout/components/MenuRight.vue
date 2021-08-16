<template>
  <div>
    <b-nav-item-dropdown right class="display-menu-right">
      <template #button-content>
        <em>
          <span>{{ username }}</span>
          <br>
          <span>({{ email }})</span>
        </em>
      </template>

      <b-dropdown-item @click="handleLogout()">{{ $t('MENU_RIGHT_LOGOUT') }}</b-dropdown-item>
    </b-nav-item-dropdown>
  </div>
</template>

<script>

import { MakeToast } from '../../utils/toastMessage';

export default {
  name: 'MenuRight',
  computed: {
    username() {
      return this.$store.getters.name;
    },
    email() {
      return this.$store.getters.email;
    },
  },
  methods: {
    handleLogout() {
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
    },
  },
};
</script>

<style lang="scss" scoped>
    @import "../../scss/_variables.scss";

    .display-menu-right {
        span {
            font-size: 15px;
            color: $shark;
            font-weight: 700;
        }
    }
</style>
