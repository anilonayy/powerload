<template>
    <div v-if="isAuthenticated && componentWillShow"
        class="fixed bottom-0 left-0 w-full flex justify-center items-end h-10 md:hidden"
    >
    <div class="w-full h-full" @click="handleTraining()">
        <div class="w-full h-full flat-btn bg-indigo-800 hover:bg-indigo-600 active:bg-indigo-700  text-white">
            <div v-if="!isTrainingSelected">
                Antrenmana Başla!
            </div>
            <div v-else>
                Antrenmana Devam Et!  
            </div>
        </div>
    </div>
    </div>
</template>


<script setup>
import { computed, inject, watch, ref } from 'vue';
import { useRoute } from 'vue-router';
import { useStore } from 'vuex';
import router from '@/router';
import trainingLogService from '@/services/trainingLogService';

const store = useStore();
const route = useRoute();
const toast = inject('toast');

const isAuthenticated = computed(() => store.getters['_isAuthenticated']);
const trainingLogId = computed(() => store.getters['_trainingLogId']);
const isTrainingSelected = computed(() => store.getters['_isTrainingSelected']);
const componentWillShow = ref(route.name  !== "on-train");


const handleTraining = async () => {
    try {
        if (isTrainingSelected.value) {
            router.push({ name: 'on-train', params: { trainingLogId: trainingLogId.value} });
            return;
        }

        const response = await trainingLogService.createEmptyLog();

        router.push({ name: 'on-train', params: { trainingLogId: response.data.id} });
    } catch (error) {
        console.error(error);
        toast.error('Bir hata oluştu. Lütfen tekrar deneyiniz.')
    }
}


watch(
    () => route.fullPath,
    async (newUrl, oldUrl) => {
        const hiddenUrls = ['antrenmanlar/', 'on-train', 'antrenman-tamamlandi'];
        componentWillShow.value = !hiddenUrls.some(url => newUrl.includes(url));

        if(isAuthenticated.value) {
            if(!isTrainingSelected.value) {
                await trainingLogService.getLastLog();
            }
        }
    })
</script>