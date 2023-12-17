<template>
    <div class="flex flex-col gap-3">
        <div v-for="(day, index) in selectedTraining?.days" :key="index" @click="selectTrainingDay(day)">
            <ButtonCmp class="w-full py-4 cursor-pointer" :class="{ 'bg-blue-600 text-white': day.isSelected }">
                {{ day.name }}
            </ButtonCmp>
        </div>
    </div>
</template>

<script setup>
import { defineEmits, defineProps } from 'vue';
import ButtonCmp from '@/components/buttons/ButtonCmp.vue';

defineProps({
    selectedTraining: {
        type: Object,
        required: true
    }
});

const emits = defineEmits(['selectTrainingDay']);

const selectTrainingDay = (day) => emits('selectTrainingDay', day);
</script>