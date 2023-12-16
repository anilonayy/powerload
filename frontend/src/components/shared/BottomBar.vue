<template>
    <div v-if="isAuthenticated && componentWillShow"
        class="fixed bottom-0 left-0 w-full flex justify-center items-end h-8 lg:hidden"
    >

    <div class="w-full" @click="handleTraining()">
        <ButtonCmp class="w-full h-full bg-indigo-600 text-white border-indigo-600 rounded-none">
            <div v-if="!isTrainingSelected">
                Antrenmana Başla!
            </div>
            <div v-else>
                Antrenmana Devam Et!  
            </div>
        </ButtonCmp>
    </div>
    </div>
</template>


<script setup>
import { computed, inject, watch, ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import { useStore } from 'vuex';
import ButtonCmp from '@/components/buttons/ButtonCmp.vue';
import router from '@/router';

const store = useStore();
const route = useRoute();
const axios = inject('axios');
const toast = inject('toast');

const isAuthenticated = computed(() => store.getters['_isAuthenticated']);
const trainingLogId = computed(() => store.getters['_trainingLogId']);
const isTrainingSelected = computed(() => store.getters['_isTrainingSelected']);
const componentWillShow = ref(route.name  !== "on-train");


const handleTraining = async () => {
    try {
        if(isTrainingSelected.value) {
            router.push({ name: 'on-train', params: { trainingLogId: trainingLogId.value} });
            return;
        }

        const response = await axios.post(`training-logs`);

        store.dispatch('setTrainingLogId', response.data.id);
        
        router.push({ name: 'on-train', params: { trainingLogId: response.data.id} });
    } catch (error) {
        console.error(error);
        toast.error('Bir hata oluştu. Lütfen tekrar deneyiniz.')
    }
}


watch(
      () => route.fullPath,
      async (newUrl, oldUrl) => {
        componentWillShow.value = !newUrl.includes('on-train');

        if(isAuthenticated.value) {
            if(! isTrainingSelected.value) {
                const response = await axios.get(`training-logs/last`);

                store.dispatch('setTrainingLogId', response.data.id);
            }
        }

      }
    )
</script>