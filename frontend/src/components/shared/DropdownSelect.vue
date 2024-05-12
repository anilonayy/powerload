<template>
  <div class="relative w-full">
    <div
      @click="handleToggleDropdown()"
      id="main-dropdown"
      class="p-2 text-sm border border-1 rounded-md flex justify-between items-center cursor-pointer"
    >
      <div class="flex gap-2 items-center justify-center">
        <img v-if="model[imageField]?.length" :src="model[imageField]" class="w-6 h-6" />
        {{ model.name || props.placeholder }}
      </div>

      <AngleDownIcon />
    </div>

    <div id="options" v-if="isOpen" class="absolute bottom-full mb-2 w-full flex flex-col gap-2">
      <div
        v-for="(option, index) in props.options"
        :key="index"
        class="w-full p-2 rounded-md bg-gray-100 hover:bg-gray-200 transition-all cursor-pointer"
        @click="onSelect(option)"
      >
        <slot name="option" v-bind="option">{{ option[readText] }}</slot>
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineEmits, defineModel, defineProps, ref } from 'vue';

import AngleDownIcon from '@/components/icons/AngleDownIcon.vue';

const model = defineModel();

const selectedOption = ref({
  name: '',
  value: ''
});
const isOpen = ref(false);

const props = defineProps({
  placeholder: {
    type: String,
    default: 'Select an option',
    required: false
  },
  options: {
    type: Array,
    default: () => [],
    required: false
  },
  readValue: {
    type: String,
    required: true
  },
  readText: {
    type: String,
    required: true
  },
  imageField: {
    type: String,
    required: false
  }
});

const emits = defineEmits(['onSelect']);

const handleToggleDropdown = () => {
  isOpen.value = !isOpen.value;
};

const onSelect = (option) => {
  selectedOption.value = option;
  isOpen.value = false;
  model.value = option;

  emits('onSelect', option);
};
</script>
