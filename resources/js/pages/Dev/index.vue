<template>
  <div>
    <div class="dev">
      <h1 class="title">Dev</h1>

      <div class="container-fluid">

        <div class="item">
          <h4>Multi language</h4>

          <div class="container change-lang">
            <b-row>
              <b-col>
                <b-button :class="{ 'active-lang': language === constLang.ENGLISH }" @click="handleChangeLang(constLang.ENGLISH)">English</b-button>
              </b-col>

              <b-col>
                <b-button :class="{ 'active-lang': language === constLang.JAPANESE }" @click="handleChangeLang(constLang.JAPANESE)">Japanese</b-button>
              </b-col>
            </b-row>
          </div>
        </div>

        <div class="item">
          <h4>Month Picker</h4>

          <div class="container display-month">
            <span> <strong>Month: </strong>{{ month.month }} | <strong>Year: </strong> {{ month.year }} </span>

            <MonthPicker v-model="month" />
          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<script>
import { MakeToast } from '../../utils/toastMessage';
import MonthPicker from '../../components/MonthPicker/index.vue';
import constLang from '../../const/language';

export default {
  name: 'Dev',
  components: {
    MonthPicker,
  },
  data() {
    return {
      month: '',
      constLang: constLang,
    };
  },
  computed: {
    language() {
      return this.$store.getters.language;
    },
  },
  methods: {
    handleChangeLang(lang) {
      this.$store.dispatch('app/setLanguage', lang)
        .then(() => {
          this.$i18n.locale = lang;
          MakeToast({
            variant: 'success',
            title: 'Success',
            content: 'Change language successfully',
          });
        })
        .catch(() => {
          MakeToast({
            variant: 'danger',
            title: 'Danger',
            content: 'Language change failed',
          });
        });
    },
  },
};
</script>

<style lang="scss" scoped>
    @import '../../scss/_variables.scss';

    .dev {
        .title {
            text-align: center;
        }

        .item {
            text-align: left;
            margin-bottom: 10px;

            h4 {
                margin-top: 20px;
                margin-bottom: 20px;
            }

            .change-lang {
                text-align: center;
                button {
                    min-width: 200px;
                    margin-top: 5px;
                    margin-bottom: 5px;
                    border: none;
                }

                .active-lang {
                    background-color: $sorbus;
                }
            }

            .display-month {
                strong {
                    margin-top: 20px;
                    margin-bottom: 20px;
                }
            }

        }
    }
</style>
