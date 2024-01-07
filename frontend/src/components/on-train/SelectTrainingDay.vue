<template>
    <div class="flex flex-col gap-3">
        <div v-for="(day, index) in selectedTraining?.days" :key="index" @click="selectTrainingDay(day)">
            <div class="btn w-full" :class="{ 'bg-blue-600 text-white': day.isSelected }">
                {{ day.name }}
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineEmits, defineProps } from 'vue';

defineProps({
    selectedTraining: {
        type: Object,
        required: true
    }
});

const emits = defineEmits(['selectTrainingDay']);

const selectTrainingDay = (day) => emits('selectTrainingDay', day);
</script>