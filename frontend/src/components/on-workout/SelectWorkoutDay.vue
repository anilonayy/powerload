<template>
  <div class="flex flex-col gap-3">
    <div v-for="(day, index) in selectedWorkout?.days" :key="index" @click="selectWorkoutDay(day)">
      <div class="btn w-full border border-1" :class="{ 'bg-blue-600 text-white': day.isSelected }">
        {{ day.name }}
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineEmits, defineProps } from 'vue';

defineProps({
  selectedWorkout: {
    type: Object,
    required: true
  }
});

const emits = defineEmits(['selectWorkoutDay']);

const selectWorkoutDay = (day) => emits('selectWorkoutDay', day);
</script>
