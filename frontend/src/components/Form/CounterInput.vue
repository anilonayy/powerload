<template>
  <div class="custom-number-input h-full">
    <div class="flex flex-row w-full rounded-lg relative bg-transparent mt-1">
      <button
        type="button"
        @click="DecrementValue(data)"
        class="bg-gray-300 text-gray-600 hover:text-gray-700 hover:bg-gray-400 h-full w-2/5 rounded-l cursor-pointer outline-none"
      >
        <span class="m-auto text-2xl font-thin">−</span>
      </button>
      <input
        v-model="data[valueKey]"
        type="number"
        @input="validateCurrentExercise(index)"
        :class="{ 'border-red-600': data[errorKey] }"
        class="focus:outline-none text-center bg-gray-300 font-semibold text-md hover:text-black focus:text-black md:text-basecursor-default flex items-center text-gray-700 outline-none w-1/5"
      />
      <button
        type="button"
        @click="IncrementValue(data)"
        class="bg-gray-300 text-gray-600 hover:text-gray-700 hover:bg-gray-400 h-full w-2/5 rounded-r cursor-pointer"
      >
        <span class="m-auto text-2xl font-thin">+</span>
      </button>
    </div>
  </div>
</template>


<script setup>

import { defineProps, defineEmits } from 'vue'

const emit = defineEmits(['increment, decrement'])

defineProps({
  data: {
    type: Object,
    required: true
  },
  valueKey: {
    type: String,
    required: true
  },
  errorKey: {
    type : String,
    required: false
  },
  index: {
    type: Number,
    required: false
  },
  validateCurrentExercise: {
    type: Function,
    required: false
  },
});

const IncrementValue = (data) => emit('increment', data);
const DecrementValue = (data) => emit('decrement', data)
</script>