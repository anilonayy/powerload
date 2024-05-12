<template>
  <span>
    {{ $d(new Date(value), type, locale.replace('_', '-')) }}
  </span>
</template>

<script setup>
import { computed, defineProps } from 'vue';
import store from '@/store';

const props = defineProps({
  value: {
    type: String,
    required: true
  },
  type: {
    type: String,
    default: 'long'
  }
});

const locale = computed(() => store.getters['_getLocale']);
</script>
