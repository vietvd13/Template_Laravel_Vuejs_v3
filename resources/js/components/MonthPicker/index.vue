<template>
  <div v-click-outside="hide" class="month-picker">
    <i class="fad fa-calendar-day" />
    <input
      :id="inputId"
      ref="input"
      class="month-picker__input"
      :class="inputClassName"
      type="text"
      readonly
      :value="showDate"
      @click="pickerVisible = !pickerVisible"
      @input="updateValue()"
    >

    <div v-if="pickerVisible" class="month-picker__container" :style="{top: ($refs.input.offsetHeight + 5) + 'px'}">
      <div class="month-picker__year">
        <button class="month-picker__year-btn" :disabled="year <= 1" @click="prevYear">
          <i class="fas fa-angle-left" />
        </button>
        <span class="month-picker__show-year">{{ year }}</span>
        <button class="month-picker__year-btn" @click="nextYear">
          <i class="fas fa-angle-right" />
        </button>
      </div>

      <div class="month-picker__monthes">
        <a
          v-for="(m, index) in months"
          :key="'month'+index"
          href=""
          class="month-picker__month"
          :class="{'month-picker__month_selected': index + 1 === month}"
          @click.prevent="pickMonth(index)"
        >{{ $t(m) }}</a>
      </div>
    </div>
  </div>
</template>

<script>

import constMonthPicker from '../../const/monthPicker';

export default {
  name: 'MonthPicker',
  directives: {
    'click-outside': {
      bind: function(el, binding, vNode) {
        const bubble = binding.modifiers.bubble;
        const handler = (e) => {
          if (bubble || (!el.contains(e.target) && el !== e.target)) {
            binding.value(e);
          }
        };

        el.__vueClickOutside__ = handler;
        document.addEventListener('click', handler);
      },

      unbind: function(el, binding) {
        document.removeEventListener('click', el.__vueClickOutside__);
        el.__vueClickOutside__ = null;
      },
    },
  },
  props: {
    inputClassName: {
      type: String,
      default: '',
    },
    inputId: {
      type: String,
      default: '',
    },
    defaultYear: {
      type: Number,
      default: new Date().getFullYear(),
    },
    defaultMonth: {
      type: Number,
      default: new Date().getMonth() + 1,
    },
    months: {
      type: Array,
      default: () => constMonthPicker.LIST_MONTHS,
    },
  },
  data() {
    return {
      pickerVisible: false,
      year: this.defaultYear,
      month: this.defaultMonth,
    };
  },
  computed: {
    showDate() {
      this.$emit('input', { month: this.month, year: this.year });
      return `${this.$t(this.months[this.month - 1])}, ${this.year}`;
    },
  },
  watch: {
    defaultMonth(val) {
      this.month = val;
    },
    defaultYear(val) {
      this.year = val;
    },
  },
  methods: {
    hide() {
      this.pickerVisible = false;
    },
    pickMonth(month) {
      this.month = month + 1;
      this.$emit('input', { month: this.month, year: this.year });
      this.hide();
    },
    prevYear() {
      if (this.year > 1) {
        this.year = this.year - 1;
        this.$emit('input', { month: this.month, year: this.year });
      }
    },
    nextYear() {
      this.year = this.year + 1;
      this.$emit('input', { month: this.month, year: this.year });
    },
  },
};
</script>

<style scoped lang="scss">
    @import '../../scss/_variables.scss';

    .month-picker {
        position: relative;

        &__container {
            width: 310px;
            border: 1px solid $silver;
            border-radius: 4px;
            background-color: $white;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.06) 0px 2px 4px -1px;
            z-index: 10;
            overflow: hidden;
            position: absolute;
            left: 0;
        }

        &__input {
            background-color: $white;
            width: 100%;
            min-width: 310px;
            border: 1px solid $silver;
            border-radius: .25rem;
            padding: 6px 12px;
            cursor: pointer;
        }

        &__monthes {
            display: flex;
            flex-wrap: wrap;

            a {
                &:hover {
                    text-decoration: none;
                }
            }
        }

        &__year {
            display: flex;
            padding: 10px;
            background-color: $pale-sky;
        }

        &__year-btn {
            flex: 0 0 40px;
            height: 33px;
            line-height: 33px;
            background-color: transparent;
            border: 1px solid $silver;
            border-radius: .25rem;
            background-color: $sorbus;

            i {
                font-size: 20px;
                color: $white;
            }

            &:hover {
                opacity: .8;
            }

            &:disabled {
                opacity: .8;
            }
        }

        &__show-year {
            flex: 0 0 calc(100% - 80px);
            text-align: center;
            padding-top: 7px;
            font-size: 1.1rem;
            font-weight: bold;
            color: $white;
        }

        &__month {
            box-sizing: border-box;
            flex: 0 0 calc(100% / 3);
            text-align: center;
            padding: 10px;
            border: 1px solid $silver;
            border-bottom: 0;
            border-left: 0;
            color: $shark;

            &_selected {
                background-color: $sorbus !important;
                color: $white;
            }

            &:nth-child(3n+3) {
                border-right: 0;
            }

            &:hover {
                background-color: #f3f3f3;
            }
        }
    }

    .month-picker > i {
        position: absolute;
        right: 0;
        padding: 10px;
        pointer-events: none;
        font-size: 20px;
        color: $sorbus;
    }
</style>
