<template>
  <div class="container-fluid login">
    <div class="container">
      <div class="col-xl-6 col-lg-6 mx-auto login-container">
        <div class="row">
          <b-form-input
            id="input-email"
            v-model="account.email"
            type="email"
            name="username"
            :placeholder="$t('EMAIL')"
            spellcheck="false"
            :disabled="isProcess"
            @keyup.enter="handleLogin()"
          />
          <b-form-input
            id="input-password"
            v-model="account.password"
            type="password"
            name="password"
            :placeholder="$t('PASSWORD')"
            spellcheck="false"
            :disabled="isProcess"
            @keyup.enter="handleLogin()"
          />

          <div class="btn-login">
            <b-overlay
              :show="isProcess"
              rounded
              opacity="0.6"
              spinner-small
              spinner-variant="primary"
            >
              <b-button
                id="btn-login"
                class="btn_submit"
                :disabled="isProcess"
                @click="handleLogin()"
              >
                {{ $t('BUTTON_LOGIN') }}
              </b-button>
            </b-overlay>
          </div>
        </div>

        <div class="row">
          <div class="login-message">
            <span v-if="message.isShowMessage">
              {{ message.isMessage }}
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
// Import API
import { postLogin } from '../../api/modules/login';
import { MakeToast } from '../../utils/toastMessage';

// Import Validate
import { validEmail, validPassword } from '../../utils/validate';
import { parseToken } from '../../utils/handleToken';

const urlAPI = {
  urlLogin: `/auth/login`,
};

export default {
  name: 'Login',
  data() {
    return {
      // Account Login
      account: {
        email: '',
        password: '',
      },

      // Status process login
      isProcess: false,

      // Status validate account user login
      message: {
        isShowMessage: false,
        isMessage: '',
      },
    };
  },

  methods: {
    async handleLogin() {
      this.isProcess = true;

      // Check validate
      if (validEmail(this.account.email) && validPassword(this.account.password)) {
        this.message.isShowMessage = false;
        this.message.isMessage = '';

        const URL = urlAPI.urlLogin;

        const DATA = {
          user_name: this.account.email,
          password: this.account.password,
        };

        await postLogin(URL, DATA)
          .then((response) => {
            if (response.code === 200) {
              const TOKEN = response.data.access_token;
              const PROFILE = response.data.profile;
              const EXP_TOKEN = parseToken(TOKEN);

              const USER = {
                address: PROFILE.address || '',
                avatar: PROFILE.avatar || '',
                email: PROFILE.email || '',
                fax: PROFILE.fax || '',
                gender: PROFILE.gender || '',
                id: PROFILE.id || '',
                name: PROFILE.name || '',
                phone: PROFILE.phone || '',
                status: PROFILE.status || '',
                expToken: EXP_TOKEN.exp || '',
              };

              // Store data user login
              this.$store.dispatch('user/saveLogin', { USER, TOKEN })
                .then(() => {
                  MakeToast({
                    variant: 'success',
                    title: this.$t('SUCCESS'),
                    content: this.$t('LOGIN_SUCCESS'),
                  });

                  this.$router.push('/');
                })
                .catch(() => {
                  MakeToast({
                    variant: 'danger',
                    title: this.$t('DANGER'),
                    content: this.$t('TOAST_HAVE_ERROR'),
                  });
                });
            } else if ([401, 422].includes(response.code)) {
              this.message.isShowMessage = true;
              this.message.isMessage = response.message;
            }
          })
          .catch((error) => {
            this.message.isShowMessage = true;
            this.message.isMessage = error.message;
          });
      } else {
        this.message.isShowMessage = true;
        this.message.isMessage = this.$t('ERROR_VALIDATE_EMAIL_PASSWORD');
      }

      this.isProcess = false;
    },
  },
};
</script>

<style lang="scss" scoped>
    @import '../../scss/_variables.scss';

    .login {
        margin-top: 150px;

        .row {
            justify-content: center;

            input {
                margin: 10px;
                text-align: center;
                font-weight: 600;

                &::placeholder {
                    text-align: center;
                    font-weight: 600;
                    text-transform: uppercase;
                }
            }

            .btn-login {
                display: flex;
                text-align: center;
                justify-content: center;
                margin: 50px auto;

                button {
                    width: 30%;
                    min-width: 150px;
                    border: none;
                    background: $sorbus;
                    font-weight: 600;
                    text-transform: uppercase;

                    &:hover {
                        opacity: 0.8;
                    }
                }
            }

            .login-message {
                display: flex;
                text-align: center;
                justify-content: center;

                span {
                    margin-top: 30px;
                    font-weight: 600;
                    color: $red;
                }
            }
        }
    }
</style>
