<template>
    <div class="mx-3">
        <h3 v-if="!(training.trainingId !== 0 && training.trainingDayId !== 0)" class="font-bold text-center mb-6"> {{ headerTitle }} </h3>


        <div v-if="training.trainingId === 0">
            <div v-for="(train, index) in trainings" :key="index" @click="selectTraining(train.id)">   
                <ButtonCmp class="w-full py-4 cursor-pointer">
                    {{ train.name }}
                </ButtonCmp>
                    
                
            </div>
        </div>

        <div v-else-if="training.trainingDayId === 0" class="flex flex-col gap-3">
            <div v-for="(day, index) in days" :key="index" @click="selectTrainingDay(day.id)">
                <div>
                    <ButtonCmp class="w-full py-4 cursor-pointer">
                        {{ day.name }}
                    </ButtonCmp>
                </div>
            </div>
        </div>

        <div v-else>
            <div v-for="(data, index) in training.exercises" :key="index">
                <div v-if="index === exerciseStep" class="flex justify-between items-center gap-5">

                    <div class="previous-exercise" @click="handlePreviousStep()">
                        --
                    </div>

                    <div class="exercise-info flex items-center justify-center">
                        <img :src="getIconName(data.exercise.category.name)" class=" w-12 h-12 object-contain">
                        <h1 class="font-bold text-center text-4xl"> {{ data.exercise.name }} </h1>
                    </div>

                    <div class="next-exercise" @click="handleNextStep()">
                        ++
                    </div>
                   
                </div>
            </div>
        </div>
        
        
    </div>
</template>

<script setup>
import { onMounted, ref, inject, watch } from "vue";
import { useStore } from 'vuex';
import { useRoute } from 'vue-router';
import { getIconName } from '@/Utils/helpers.js';
import router from '@/Router';

import ButtonCmp from '@/Components/buttons/ButtonCmp.vue';

const store = useStore();
const route = useRoute();
const axios = inject('axios');


const headerTitle = ref('Bugün hangi antrenmanı yapacaksın?');
const trainings = ref([]);
const days = ref([]);
const training = ref(store.getters['_getTraining'] );
const exerciseStep = ref(0);


onMounted(() => {
    updateState();
});

const updateState = async () => {
    try {
       if(training.value.trainingId === 0) {
            const response = await axios.get(`trainings`);

            trainings.value = response.data;
       } else if (training.value.trainingDayId === 0) {
            const response = await axios.get(`trainings/${training.value.trainingId}`);

            headerTitle.value = 'Hangi gündesin?';
            days.value = response.data.days;
       } else {
            const response = await axios.get(`trainings/${ training.value.trainingId }/days/${ training.value.trainingDayId }/exercises`);

            training.value.exercises = response.data;
       }
    } catch (error) {
        toast.error('Bir hata oluştu. Lütfen tekrar deneyiniz.')
    }
    
}


 watch(
      () => training.value, () => {
        training.value = store.getters['_getTraining'];
    }
)


const selectTraining = (trainingId) => {
    store.dispatch('setTrainingId', trainingId);

    updateState();
}

const selectTrainingDay = (dayId) => {
    store.dispatch('setTrainingDayId', dayId);

    updateState();
}

</script>