<template>
    <div>
        <div v-if="trainings.length && trainings[0].id !== 0" class="flex flex-col gap-3">
            <div v-for="(train, index) in trainings" :key="index" @click="selectTraining(train)">
                <div class="btn w-full border border-1" :class="{ 'bg-blue-600 text-white': train.isSelected }">
                    {{ train.name }}
                </div>
            </div>
        </div>
        <div v-else>
            <div class="p-4 text-center">
                Henüz bir antrenman oluşturmadın. 
                <router-link :to="{ name: 'add-train' }" class="underline text-blue-700">Hemen Oluştur</router-link>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineEmits, computed } from 'vue';
import { useStore } from 'vuex';

const trainings = computed(() => useStore().getters['_userTrainings']);

const emits = defineEmits(['selectTraining']);

const selectTraining = (train) => emits('selectTraining',train);
</script>