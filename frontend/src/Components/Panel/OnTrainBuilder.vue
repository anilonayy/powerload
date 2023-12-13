<template>
    <div class="mx-3 relative">
        <div class="h-6  w-full flex justify-between items-center mt-10 relative">
            <div class="previous-exercise absolute left-0 cursor-pointer" v-if="pageIndex !== 0"  @click="handlePreviousStep()">
                <LeftIcon />
            </div>

            <div class="next-exercise absolute right-0 cursor-pointer" @click="handleNextStep()" v-if="maxIndex > pageIndex">
                <RightIcon />
            </div>
        </div>

        <h3 v-if="pageIndex === 1 || pageIndex === 0" class="font-bold text-center my-4"> {{ headerTitle }} </h3>


        <div v-if="pageIndex === 0">
            <div v-if="trainings.length">
                <div v-for="(train, index) in trainings" :key="index" @click="selectTraining(train.id, index)">   
                    <ButtonCmp class="w-full py-4 cursor-pointer" :class="{ 'bg-blue-600 text-white': train.isSelected }">
                        {{ train.name }}
                    </ButtonCmp>
                        
                    
                </div>
            </div>
            <div v-else>
                <div class="p-4 text-center">
                    Henüz bir antrenman oluşturmadın. 
                    <router-link :to="{ name: 'add-train' }" class="underline text-blue-700">Hemen Oluştur</router-link>
                </div>
            </div>
            
        </div>

        <div v-else-if="pageIndex === 1" class="flex flex-col gap-3">
            <div v-for="(day, index) in selectedTraining.days" :key="index" @click="selectTrainingDay(day.id, index)">
                <div>
                    <ButtonCmp class="w-full py-4 cursor-pointer" :class="{ 'bg-blue-600 text-white': day.isSelected }">
                        {{ day.name }}
                    </ButtonCmp>
                </div>
            </div>
        </div>

        <div v-else>
            <div v-for="(data, index) in selectedDay.exercises" :key="index">
                <div v-if="index === pageIndex - 2" class="flex flex-col justify-center items-center gap-5">
                    <div class="exercise-info flex items-center justify-center">
                        <img :src="getIconName(data.category.name || '')" class=" w-16 h-16 object-contain">
                        <h1 class="font-bold text-center text-6xl"> {{ data.name }} </h1>
                    </div>

                    <div class="sets">
                        <div class="flex flex-col">
                            <div v-for="(trainSet, index) in data.onTrain" :key="index" class="py-10" :class="{ 'border-b border-gray-300': data.onTrain.length -1 !== index }">
                                <div class="flex gap-3 items-end font-bold">
                                    <div class="whitespace-nowrap text-7xl" style="line-height: 0.8">
                                        {{ index + 1 }}.
                                    </div>
                                    <div>
                                        <Label for="weight" value="Kilo" />

                                        <Input
                                            id="weight"
                                            type="weight"
                                            @input="validateCurrentExercise(index)"
                                            :class="{'border-red-600': trainSet.weightError}"
                                            class="focus:outline-none text-center w-full bg-gray-300 font-semibold text-md hover:text-black focus:text-black md:text-basecursor-default flex items-center text-gray-700 outline-none"
                                            v-model="trainSet.weight"
                                        />
                                    </div>
                                    <div class="flex flex-col">
                                        <Label for="weight" value="Tekrar" />
                                        <div class="custom-number-input h-full">
                                            <div class="flex flex-row w-full rounded-lg relative bg-transparent mt-1">
                                                <button type="button" @click="trainSet.reps > 1 ? trainSet.reps-- : ''" class="bg-gray-300 text-gray-600 hover:text-gray-700 hover:bg-gray-400 h-full w-2/5 rounded-l cursor-pointer outline-none">
                                                    <span class="m-auto text-2xl font-thin">−</span>
                                                </button>
                                                <input
                                                    v-model="trainSet.reps"
                                                    type="number"
                                                    @input="validateCurrentExercise(index)"
                                                    :class="{'border-red-600': trainSet.repsError}"
                                                    class="focus:outline-none text-center bg-gray-300 font-semibold text-md hover:text-black focus:text-black md:text-basecursor-default flex items-center text-gray-700 outline-none w-1/5"/>
                                                <button
                                                type="button"
                                                @click="trainSet.reps++"
                                                class="bg-gray-300 text-gray-600 hover:text-gray-700 hover:bg-gray-400 h-full w-2/5 rounded-r cursor-pointer"
                                                >
                                                <span class="m-auto text-2xl font-thin">+</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div v-if="index !== 0">
                                        <ButtonCmp class="bg-red-600 text-white" @click="removeSet(data,index)">
                                            <TrashIcon class="h-3 p-0" />
                                        </ButtonCmp>
                                    </div>
                                </div>
                                
                            </div>
                            <ButtonCmp class="bg-indigo-900 text-white w-full mt-4" @click="addSet(data)">
                                Set Ekle
                            </ButtonCmp>
                        </div>

                        
                    </div>
                </div>
            </div>
        </div>
        
        
    </div>
</template>

<script setup>
import { onMounted, ref, inject, watch, computed } from "vue";
import { useStore } from 'vuex';
import { useRoute } from 'vue-router';
import { getIconName } from '@/Utils/helpers.js';
import router from '@/Router';

import ButtonCmp from '@/Components/buttons/ButtonCmp.vue';
import LeftIcon from '@/Components/Icons/LeftIcon.vue';
import RightIcon from '@/Components/Icons/RightIcon.vue';
import TrashIcon from '@/Components/Icons/TrashIcon.vue';
import Input from '@/Components/Form/Input.vue';
import Label from '@/Components/Form/Label.vue';

const store = useStore();
const route = useRoute();
const axios = inject('axios');
const toast = inject('toast');


const headerTitle = ref('Bugün hangi antrenmanı yapacaksın?');
const trainings = ref(store.getters['_getTrainings'] );
const trainingLog = computed(() => store.getters['_getTrainingLogId']);
const selectedTraining = computed(() => store.getters['_getSelectedTraining']);
const selectedDay = computed(() => store.getters['_getSelectedDay']);
const isTrainingDaySelected = ref(store.getters['_isTrainingDaySelected']);
const maxIndex = ref(2);
const pageIndex = ref(0);
// 0 -> Select Train, 1 -> Select Day, 2 -> 1. exercie ...


onMounted(async () => {
    if (! isTrainingDaySelected.value) {
        pageIndex.value = 0;
    } else if(!isTrainingDaySelected.value)  {
        pageIndex.value = 1;
    } else {
        pageIndex.value = 2;
    }

    const allTrainings = await axios.get('trainings/details');

    const trainingData = allTrainings.data.map((training) => {
        return {
            id: training.id,
            name: training.name,
            isSelected: false,
            days: training.days.map((day) => {
                return {
                    id: day.id,
                    name: day.name,
                    isSelected: false,
                    exercises: day.exercises.map((exercise) => {
                        return {
                            id: exercise.exercise.id,
                            name: exercise.exercise.name,
                            category: exercise.exercise.category || {},
                            sets: exercise.sets,
                            reps: exercise.reps,
                            onTrain: [{
                                id: 0,
                                reps: 5,
                                weight: 0,
                                repsError: false,
                                weightError: false
                            }]
                        }
                    })
                }
            })
        }
    });

    // Eğer antrenman içeriği var ise güncelle
    const lastTraining = await axios.get(`training-logs/last`);

    if(!lastTraining.data.training_id) {
        pageIndex.value = 0;
    } else {
        trainingData.find((training) => training.id === lastTraining.data.training_id).isSelected = true;

        handleNextStep();
    }

    if(!lastTraining.data.training_day_id) {
        pageIndex.value = 1;
    } else {
        trainingData.find((training) => training.isSelected).days.find((day) => day.id === lastTraining.data.training_day_id).isSelected = true;

        handleNextStep();
    }

    if(lastTraining.data.exercises.length) {
        trainingData.find((training) => training.isSelected).days.find((day) => day.isSelected).exercises.map((exercise) => {
            
            const onTrainData = [];

            lastTraining.data.exercises.map((exerciseFromDb) => {
                if(exercise.id === exerciseFromDb.exercise_id) {
                    onTrainData.push({
                        id: exerciseFromDb.id,
                        reps: exerciseFromDb.reps,
                        weight: exerciseFromDb.weight,
                        repsError: false,
                        weightError: false
                    });
                }
            });

            if(onTrainData.length) {
                exercise.onTrain = onTrainData;
            }
        })
    }

    console.log('trainingData :>> ', trainingData);

    store.dispatch('setTrainings', trainingData);

    updateState();
});

const updateState = async () => {
    try {
        const index = pageIndex.value;

       if(index === 0) {
            headerTitle.value = 'Bugün hangi antrenmanı yapacaksın?';
       } else if (index === 1) {
            headerTitle.value = 'Hangi gündesin?';
       } else {
            maxIndex.value = selectedDay.value.exercises.length + 2;
       }
    } catch (error) {
        console.error(error);
        toast.error('Bir hata oluştu. Lütfen tekrar deneyiniz.')
    }

    console.log('pageIndex.value :>> ', pageIndex.value);
}


watch(
    () => trainings.value, () => {
        trainings.value = store.getters['_getTrainings'];
        console.log('TRAINING UPDATED');
    }
)


const selectTraining = async (trainingId) => {
    try {
        const response = await axios.put(`training-logs/${ trainingLog.value }/`, {
            training_id: trainingId
        });
        
        store.dispatch('selectTraining', { trainingId });

        handleNextStep();
    } catch (error) {
        toast.error(error.message);
    }

    
}

const selectTrainingDay = async (dayId) => {
    try {
        const response = await axios.put(`training-logs/${ trainingLog.value }/`, {
            training_day_id: dayId
        });

        store.dispatch('selectTrainingDay', { dayId });

        handleNextStep();
    } catch (error) {
        console.error(error);
        toast.error(error.message);
    }

   
}


const handlePreviousStep = () => {
    if(pageIndex.value === 0) return;
    

    pageIndex.value -= 1;

    updateState();
}


const handleNextStep = async () => {
    if (maxIndex.value === pageIndex.value)  return;

    if(pageIndex.value >= 2) {
        const validateResult = validateCurrentExercise();

        if(validateResult) {
            toast.error('Lütfen boş alanları doldurunuz.');
            return;
        }

        const addSetsResponse = await axios.post(`/training-logs/${ trainingLog.value }/exercises`, {
            sets: selectedDay.value.exercises[pageIndex.value - 2].onTrain,
            exercise_id: selectedDay.value.exercises[pageIndex.value - 2].id,
        })

        // update exercises id
        store.dispatch('setOnTrainData',{
            exercise_id: selectedDay.value.exercises[pageIndex.value - 2].id,
            value: addSetsResponse.data.map((exercise_log) => {
                return {
                    id: exercise_log.id,
                    reps: exercise_log.reps,
                    weight: exercise_log.weight,
                    repsError: false,
                    weightError: false
                }
            })
        });
    }

    pageIndex.value += 1;
    updateState();
};

const addSet = (data) => {
    const newData = data.onTrain[data.onTrain.length - 1] || {
        id: 0,
        reps: 5,
        weight: 0
    };
    
    data.onTrain.push({
        id: 0,
        reps: newData.reps,
        weight: newData.weight
    })
};

const removeSet = (data,index) => {
    data.onTrain.splice(index,1);
};

const validateCurrentExercise = (index = null) => {
    let hasError = false;


    if (index != null) {
        const specificSet =  selectedDay.value.exercises[pageIndex.value - 2].onTrain[index];

        specificSet.weight = Number(specificSet.weight);
        specificSet.reps = Number(specificSet.reps);

        specificSet.repsError = specificSet.reps === 0 || specificSet.reps > 100;
        specificSet.weightError = specificSet.weight === 0 || specificSet.weight > 1000;

        selectedDay.value.exercises[pageIndex.value - 2].onTrain[index] = specificSet;
    } else {
        const exercise = selectedDay.value.exercises[pageIndex.value - 2];

        exercise.onTrain.map((item) => {
            item.repsError = item.reps === 0 || item.reps > 100;
            item.weightError = item.weight === 0 || item.weight > 1000;

            if(item.repsError || item.weightError) {
                hasError = true;
            }

            return item;
        })
    }

    return hasError;
}


</script>