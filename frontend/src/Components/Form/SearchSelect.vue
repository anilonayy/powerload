
<template>
  <div>
    <Select2 v-model="myValue" :options="options" class="w-full"/>
    <h4>Value: {{ myValue }}</h4>
  </div>
</template>
<script setup>
import { ref } from 'vue';
import Select2 from 'vue3-select2-component';

const myValue = ref('4');

defineProps([
    'options'
])

     
</script>