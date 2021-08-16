<template>
  <div class="display-app-main">
    <b-col>
      <router-view :key="key" />
    </b-col>
  </div>
</template>

<script>
export default {
  name: 'AppMain',
  computed: {
    key() {
      return this.$route.fullPath;
    },
  },
};
</script>

<style lang="scss" scoped>
    .display-app-main {
        margin-bottom: 10px;
    }
</style>
