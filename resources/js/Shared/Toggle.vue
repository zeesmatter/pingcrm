<template>
  <div :class="$attrs.class">

    <div class="">
      <label v-if="label" class="form-label" :for="id">{{ label }}:</label>
      <div class="relative inline-block w-10 mr-2 my-2 align-middle select-none transition duration-200 ease-in">
        <div class="flex justify-center">
          <div class="form-check form-switch">
            <input :id="id"
                   ref="toggle"
                   class="form-check-input
                   appearance-none w-9
                   -ml-10 rounded-full
                   float-left h-5
                   align-top bg-white
                   bg-no-repeat bg-contain
                   bg-gray-300
                   focus:outline-none
                   cursor-pointer
                   shadow-sm" type="checkbox" role="switch" id="flexSwitchCheckDefault"
                   v-model="modelValue"
                   @change="$emit('update:modelValue', modelValue)"
            >
          </div>
        </div>
      </div>
    </div>
    <div v-if="error" class="form-error">{{ error }}</div>

  </div>
</template>


<style>
/* CHECKBOX TOGGLE SWITCH */
/* @apply rules for documentation, these do not work as inline style */
.toggle-checkbox:checked {
  @apply: right-0 border-green-400;
  right: 0;
  border-color: #68D391;
}
.toggle-checkbox:checked + .toggle-label {
  @apply: bg-green-400;
  background-color: #68D391;
}
</style>

<script>
import { v4 as uuid } from 'uuid'

export default {
  inheritAttrs: false,
  props: {
    id: {
      type: String,
      default() {
        return `text-input-${uuid()}`
      },
    },
    type: {
      type: Boolean,
      default: false,
    },
    error: String,
    label: String,
    modelValue: Boolean,
  },
  emits: ['update:modelValue'],
  methods: {
    focus() {
      this.$refs.input.focus()
    },
    select() {
      this.$refs.input.select()
    },
    setSelectionRange(start, end) {
      this.$refs.input.setSelectionRange(start, end)
    },
  },
  watch: {


  }
}
</script>
