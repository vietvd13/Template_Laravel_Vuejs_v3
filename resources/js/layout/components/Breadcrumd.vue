<template>
  <div class="display-breadcrumb">
    <b-col>
      <div class="body-breadcrumb">
        <span v-for="(router, indexRouter) in currentRoute" :key="router.path">
          <i v-if="indexRouter > 0" class="fad fa-angle-double-right" />
          {{ $t(router.meta.breadcrumb) }}
        </span>
      </div>
    </b-col>
  </div>
</template>

<script>
export default {
  name: 'Breadcrumd',
  data() {
    return {
      currentRoute: this.$router.currentRoute.matched,
    };
  },
  watch: {
    $route(to, from){
      this.currentRoute = to.matched;
    },
  },
};
</script>

<style lang="scss" scoped>
    @import '../../scss/_variables.scss';

    .display-breadcrumb {
        margin-top: 15px;
        margin-bottom: 10px;
        cursor: context-menu;

        .body-breadcrumb {
            span {
                font-size: 15px;
                font-weight: 700;

                i {
                    margin-left: 5px;
                    margin-right: 5px;
                    color: $sorbus;
                }
            }
        }
    }
</style>
