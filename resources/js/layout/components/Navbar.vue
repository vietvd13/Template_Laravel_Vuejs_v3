<template>
  <div>
    <b-navbar toggleable="lg" type="light" class="navbar-app" fixed="top">
      <b-navbar-brand href="#">
        <div class="logo-navbar" />
      </b-navbar-brand>

      <b-navbar-toggle target="nav-collapse" />

      <b-collapse id="nav-collapse" is-nav>
        <b-navbar-nav>
          <Menu />
        </b-navbar-nav>

        <!-- Right aligned nav items -->
        <b-navbar-nav class="ml-auto">
          <MenuRight />
        </b-navbar-nav>
      </b-collapse>
    </b-navbar>
  </div>
</template>

<script>

import Menu from './Menu.vue';
import MenuRight from './MenuRight.vue';

export default {
  name: 'Navbar',
  components: {
    Menu,
    MenuRight,
  },
  data() {
    return {

    };
  },
};
</script>

<style lang="scss" scoped>
    @import "../../scss/_variables.scss";

    .navbar-app {
        background-color: $white;
        box-shadow: 0px 4px 2px rgba(0, 0, 0, 0.25);

        .logo-navbar {
            width: 40px;
            height: 30px;
            background-color: #727272;
        }
    }
</style>
