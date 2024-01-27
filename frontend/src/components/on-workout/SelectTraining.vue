<template>
    <div>
        <div v-if="workouts.length && workouts[0].id !== 0" class="flex flex-col gap-3">
            <div v-for="(train, index) in workouts" :key="index" @click="selectWorkout(train)">
                <div class="btn w-full border border-1" :class="{ 'bg-blue-600 text-white': train.isSelected }">
                    {{ train.name }}
                </div>
            </div>
        </div>
        <div v-else>
            <div class="p-4 text-center">
                {{ $t('SELECT_TRAINING.NO_TRAINING') }}
                <router-link :to="{ name: 'add-train' }" class="underline text-blue-700"> {{ $t('SELECT_TRAINING.LETS_CREATE') }} </router-link>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineEmits, computed } from 'vue';
import { useStore } from 'vuex';

const workouts = computed(() => useStore().getters['_userWorkouts']);

const emits = defineEmits(['selectWorkout']);

const selectWorkout = (train) => emits('selectWorkout',train);
</script>