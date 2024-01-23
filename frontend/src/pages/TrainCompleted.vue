<template>
    <main>
        <div v-if="!loaded">
            <h3 class="h-4 bg-gray-200 rounded-full dark:bg-gray-700 mx-auto mt-12" style="width: 40%;"></h3>

            <ul class="space-y-3 mt-4 p-4">
                <li class="w-full h-3 bg-gray-200 rounded-full dark:bg-gray-700"></li>
                <li class="w-full h-3 bg-gray-200 rounded-full dark:bg-gray-700"></li>
            </ul>

            <ul class="space-y-3 mt-4 p-4">
                <li class="w-full h-4 bg-gray-200 rounded-full dark:bg-gray-700"></li>
            </ul>
            <ul class="space-y-3 mt-4 p-6">
                <li class="w-4/5 h-2 bg-gray-200 rounded-full dark:bg-gray-700"></li>
                <li class="w-5/5 h-2 bg-gray-200 rounded-full dark:bg-gray-700"></li>
                <li class="w-4/5 h-2 bg-gray-200 rounded-full dark:bg-gray-700"></li>
                <li class="w-3/5 h-2 bg-gray-200 rounded-full dark:bg-gray-700"></li>
                <li class="w-5/5 h-2 bg-gray-200 rounded-full dark:bg-gray-700"></li>
            </ul>
        </div>
        <div v-else>
            <ConfettiExplosion  :particleCount="200" :force="0.4"/>

            <HeaderText class="text-[2rem] font-extrabold leading-9 tracking-tight text-slate-900 md:text-4xl mt-12 text-center ">
                {{ $t('TRAINING_COMPLETED.CONGURALITATIONS') }}
            </HeaderText>

            <div class="text-sm mt-4 p-4">
                <div class="italic text-justify">
                    {{ $t('TRAINING_COMPLETED.MOTIVATON_TEXT') }}
                </div>
                <br>
                <div class="font-semibold text-center" v-html="$t('TRAINING_COMPLETED.LETS_LOOK')" />

                <TrainResults :data="data" />
            </div>
        </div>
        
    </main>
</template>

<script setup>
import { ref, inject, onMounted, onBeforeMount } from 'vue';
import { useRoute } from 'vue-router'
import ConfettiExplosion from "vue-confetti-explosion";
import trainingLogService from '@/services/trainingLogService';

import HeaderText from '@/components/shared/HeaderText.vue';
import TrainResults from '@/components/pages/TrainCompleted/TrainResults.vue';
import router from '@/router';

const axios = inject('axios');
const toast = inject('toast');

const trainingLogId = useRoute().params.trainingLogId;
const loaded = ref(false);
const data = ref({});

onBeforeMount(() => {
    if (isNaN(Number(trainingLogId))) {
        toast.error('Lütfen geçerli bir antrenman seçin!');
        router.push({ name: 'home' });
    }
    
})

onMounted(async () => {
    try {
        const response = await trainingLogService.getTrainingResult(trainingLogId);

        data.value = response.data;
        loaded.value = true;        
    } catch (error) {
        console.log('error :>> ', error);
    }
})

</script>