<template>
  <div>
    <ul class="display-menu">
      <router-link
        v-for="(itemRouter, indexRouter) in router"
        :key="indexRouter"
        :to="itemRouter.path"
      >
        <li>
          <span>{{ $t(itemRouter.meta.title) }}</span>
        </li>
      </router-link>
    </ul>
  </div>
</template>

<script>
export default {
  name: 'Menu',
  computed: {
    router() {
      return this.$router.options.routes.filter(item => item.hidden !== true);
    },
  },
};
</script>

<style lang="scss" scoped>
    @import '../../scss/_variables.scss';

    .display-menu {
        display: flex;

        a {
            color: $shark;
            text-align: center;
            font-weight: 700;
            line-height: 40px;
            font-size: 15px;
            margin: 0 5px 0 5px;

            &:not(.router-link-active):hover {
                text-decoration: none;
                border-bottom: 3px solid $sorbus;
            }

            li {
                text-decoration: none;
                list-style-type: none;
                min-width: 100px;
            }
        }

        a.router-link-active {
            border-bottom: 3px solid $sorbus;
            text-decoration: none;
        }
    }

    @media only screen and (max-width: 991px) {
        .display-menu {
            display: inline;
            padding: 0;

            a {
                color: $shark;
                text-align: left;
                margin: 0;

                &:hover {
                    text-decoration: none;
                    color: $sorbus;
                }

                li {
                    text-decoration: none;
                    list-style-type: none;
                    min-width: 100px;
                }
            }

            a.router-link-active {
                color: $sorbus;
            }
        }
    }
</style>
