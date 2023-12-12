<template>
    <div v-if="isAuthenticated && componentWillShow"
        class="fixed bottom-0 left-0 w-full flex justify-center items-end h-8 lg:hidden"
    >

    <div class="w-full" @click="handleTraining()">
        <ButtonCmp class="w-full h-full bg-indigo-600 text-white border-indigo-600 rounded-none">
            <div v-if="training.id === 0">
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
import ButtonCmp from '@/Components/buttons/ButtonCmp.vue';
import router from '@/Router';

const store = useStore();
const route = useRoute();
const axios = inject('axios');
const toast = inject('toast');

const isAuthenticated = computed(() => store.getters['_isAuthenticated']);
const training = computed(() => store.getters['_getTraining']);
const componentWillShow = ref(route.name  !== "on-train");


onMounted(async () => {
    if(training.value.id === 0) {
        const response = await axios.get(`training-logs/last`);
        
        store.dispatch('setTraining', response.data);
    } else {
        console.log('Yenisi oluşmadı dbden çekildi');
    }
    
})

const handleTraining = async () => {
    try {
        if(training.value.id !== 0) {
            router.push({ name: 'on-train', params: { trainingLogId: training.value.id} });
            return;
        }

        const response = await axios.post(`training-logs`);

        store.dispatch('setTrainingLogId', response.data.id);
        
        router.push({ name: 'on-train', params: { trainingLogId: response.data.id} });
    } catch (error) {
        toast.error('Bir hata oluştu. Lütfen tekrar deneyiniz.')
    }
}


watch(
      () => route.fullPath,
      (newUrl, oldUrl) => {
        componentWillShow.value = !newUrl.includes('on-train');

      }
    )
</script>