<template>
    <div class="mx-3">
        <div v-if="route.params.trainId">
            <ButtonCmp @click="goBack()" class="h-9 mb-4"> Geri Dön </ButtonCmp>
        </div>

        <h3 class="font-bold text-center mb-6"> {{ headerTitle }} </h3>

        {{ route.params }}

        <div v-if="route.params.trainId === '' ">
            <div v-for="(train, index) in trainings" :key="index">
                    <router-link :to="{ name: 'on-train' , params: { trainId: train.id } }">
                        <ButtonCmp class="w-full py-4 cursor-pointer">
                        {{ train.name }}
                        </ButtonCmp>
                    </router-link>
                
            </div>
        </div>
        <div v-else-if="route.params.trainId" class="flex flex-col gap-3">
            <div v-for="(day, index) in trainings.days" :key="index">
                    <router-link :to="{ name: 'on-train' , params: { trainId: route.params.trainId, dayId: day.id } }">
                        <ButtonCmp class="w-full py-4 cursor-pointer">
                        {{ day.name }}
                        </ButtonCmp>
                    </router-link>
            </div>
        </div>
        
        
    </div>
</template>

<script setup>
import { onMounted, ref, inject, watchEffect, reactive } from "vue";
import { useStore } from 'vuex';
import { useRoute } from 'vue-router';
import ButtonCmp from '@/Components/buttons/ButtonCmp.vue';
import router from '@/Router';

const store = useStore();
const route = useRoute();
const axios = inject('axios');


const headerTitle = ref('Bugün hangi antrenmanı yapacaksın?');
const trainings = ref([]);

onMounted(async () => {
    try {
        const params = route.params;

        if(!params.trainId) {
            const train = await axios.get('trainings');
            trainings.value = train.data;
            headerTitle.value = 'Bu gün hangi antrenmanı yapacaksın?'
            console.log('fetched');
        } else if (params.trainId) {
            const train = await axios.get(`trainings/${ params.trainId }`);
            trainings.value = train.data;
            headerTitle.value = 'Hangi gündesin?'
            console.log('here');
        } else {
            console.log('else');
        }
    } catch (error) {
        console.log('here');
    }
    

    const train = await axios.get('trainings');
});

const goBack = () => {
    store.dispatch('setTraining', {});
    router.go(-1);
}

watchEffect(() => {
    console.log('hi');
})
</script>