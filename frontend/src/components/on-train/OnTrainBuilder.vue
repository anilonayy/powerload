<template>
    <div>
        <div class="mx-3 relative">
            <div class="h-6  w-full flex justify-between items-center mt-10 relative">
                <div class="previous-exercise absolute left-0 cursor-pointer" v-if="pageIndex !== 0"  @click="handlePreviousStep()">
                    <LeftIcon />
                </div>

                <div class="next-exercise absolute right-0 cursor-pointer" @click="handleNextStep()" v-if="maxIndex != pageIndex && nextArrowVisibility">
                    <RightIcon />
                </div>
            </div>

            <h3 v-if="pageIndex === 1 || pageIndex === 0" class="font-bold text-center my-4"> {{ headerTitle }} </h3>

            <div v-if="pageIndex === 0">
                <SelectTraining
                    :trainings="trainings"
                    @select-training="selectTraining($event)"
                />
            </div>

            <div v-else-if="pageIndex === 1" class="flex flex-col gap-3">
                <SelectTrainingDay :selectedTraining="selectedTraining"
                    @select-training-day="selectTrainingDay($event)"
                />
            </div>

            <div v-else>
                <SelectExercises 
                    :selectedDay="selectedDay"
                    :pageIndex="pageIndex"
                    :validateCurrentExercise="validateCurrentExercise"
                    @add-set="addSet($event)"
                    @remove-set="removeSet($event)"
                />
            </div>
        </div>
        <div 
            v-if="pageIndex === maxIndex && maxIndex > 2"
            class="flex items-center justify-center text-lg font-semibold absolute bottom-0 w-full bg-green-500 text-white h-14 cursor-pointer"
            @click="completeTraining()"
        >
            Antrenmanı Tamamla
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref, inject, computed, watchEffect } from "vue";
import { useStore } from 'vuex';
import { useRoute } from 'vue-router';
import router from '@/router';

import SelectTraining from '@/components/on-train/SelectTraining.vue';
import SelectTrainingDay from '@/components/on-train/SelectTrainingDay.vue';
import SelectExercises from '@/components/on-train/SelectExercises.vue';    
import LeftIcon from '@/components/icons/LeftIcon.vue';
import RightIcon from '@/components/icons/RightIcon.vue';

const store = useStore();
const axios = inject('axios');
const toast = inject('toast');
const swal = inject('swal');


const headerTitle = ref('Bugün hangi antrenmanı yapacaksın?');
const trainings = ref(store.getters['_userTrainings']);
const isTrainingDaySelected = ref(store.getters['_isTrainingDaySelected']);
const isTrainingSelected = ref(store.getters['_isTrainingSelected']);
const nextArrowVisibility = ref(false);
const maxIndex = ref(2);
const pageIndex = ref(0);

const trainingLog = computed(() => store.getters['_trainingLogId']);
const selectedTraining = computed(() => store.getters['_selectedTraining']);
const selectedDay = computed(() => store.getters['_selectedDay']);

const swalWithBootstrapButtons = swal.mixin({
    customClass: {
    confirmButton: "bg-red-500 text-white py-2 px-4 rounded-md ms-2",
    cancelButton: "bg-gray-400 text-white py-2 px-4 rounded-md"
    },
    buttonsStyling: false
});

onMounted(async () => {
    if (!isTrainingSelected.value) {
        pageIndex.value = 0;
        maxIndex.value = 0;
    } else if(!isTrainingDaySelected.value)  {
        pageIndex.value = 1;
        maxIndex.value = 1;
    } else {
        pageIndex.value = 2;
        maxIndex.value = 2;
    }

    if((trainings.value[0] || {}).id === 0 || trainings.value.length === 0) {
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
        }

        if(lastTraining.data.exercises.length) {
            ((trainingData.find((training) => training.isSelected).days.find((day) => day.isSelected) || {}).exercises || []).map((exercise) => {
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

        store.dispatch('setTrainings', trainingData);
    }

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
            maxIndex.value = selectedDay.value.exercises.length + 1;
        }
    } catch (error) {
        console.error(error);
        toast.error('Bir hata oluştu. Lütfen tekrar deneyiniz.')
    }

    updateArrowsVisibility();
}

watchEffect(
    () => trainings, () => {
        trainings.value = store.getters['_userTrainings'];
    }
)

const selectTraining = async (training) => {
    try {
        if(!training.isSelected)  {
            await axios.put(`training-logs/${ trainingLog.value }/`, {
                training_id: training.id
            });
            
            store.dispatch('selectTraining', { training_id: training.id });
        }

        handleNextStep();
    } catch (error) {
        console.error(error);
        toast.error(error.message);
    }
}

const selectTrainingDay = async (day) => {
    try {
        if(!day.isSelected) {
            await axios.put(`training-logs/${ trainingLog.value }/`, {
                training_day_id: day.id
            });

            store.dispatch('selectTrainingDay', day.id);
        }

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
    if (maxIndex.value === pageIndex.value && pageIndex.value >= 2)  return;

    if(pageIndex.value >= 2) {
        if(!validateCurrentExercise()) {
            swalWithBootstrapButtons.fire({
                title: 'Emin misin?',
                text: 'Eğer hareketi pas geçersen, istatistiği tutulmaz.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Pas Geç',
                cancelButtonText: 'Vazgeçtim',
                reverseButtons: true,
            })
            .then(async (result) => {
                if (result.isConfirmed) {
                    setNewExercise();
                    setNextPage();
                }
            });
        } else {
            setNewExercise();
            setNextPage();
        }
    } else {
        setNextPage();
    }
};

const setNextPage = () => {
    pageIndex.value += 1;
    updateState();
}

const setNewExercise = async () => {
    const addSetsResponse = await axios.post(`/training-logs/${ trainingLog.value }/exercises`, {
            sets: selectedDay.value.exercises[pageIndex.value - 2].onTrain,
            exercise_id: selectedDay.value.exercises[pageIndex.value - 2].id,
    });

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
    });
};

const removeSet = (data,index) => {
    data.onTrain.splice(index, 1);
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
        });
    }

    return !hasError;
}

const completeTraining = async () => {
    if(!validateCurrentExercise()) {
        swalWithBootstrapButtons.fire({
            title: 'Emin misin?',
            text: 'Eğer hareketi pas geçersen, bu hareketin istatistiği tutulmaz.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Pas Geç',
            cancelButtonText: 'Vazgeçtim',
            reverseButtons: true,
        })
        .then(async (result) => {
            if (result.isConfirmed) {
                setNewExercise();
                completeTrainingRequest();
            }
        });
    } else {
        setNewExercise();
        completeTrainingRequest();
    }
};

const completeTrainingRequest = async () => {
    try {
        swalWithBootstrapButtons.fire({
            title: 'Emin misin?',
            text: 'Antrenmanı tamamlıyorsun, eğer tamamlarsan tekrardan düzenleyemezsin. Tüm setleri doğru girdiğine emin misin?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Antrenmanı Bitir',
            cancelButtonText: 'Vazgeçtim',
            reverseButtons: true,
        })
        .then(async (result) => {
            if (result.isConfirmed) {
                await axios.post(`/training-logs/${ trainingLog.value }/exercises`, {
                    sets: selectedDay.value.exercises[pageIndex.value - 2].onTrain,
                    exercise_id: selectedDay.value.exercises[pageIndex.value - 2].id,
                });

                await axios.patch(`training-logs/${ trainingLog.value }/complete`);

                store.dispatch('setTrainings', []);
                router.push({ name: 'home' });
            }
        });
    } catch (error) {
        toast.error(error.message);
    }
}

const updateArrowsVisibility = () => {
    if(pageIndex.value === 0) {
        nextArrowVisibility.value = isTrainingSelected.value;
    } else if (pageIndex.value === 1) {
        nextArrowVisibility.value = isTrainingDaySelected.value;
    } else {
        if(selectedDay.value.exercises.length + 1 === pageIndex.value) {
            nextArrowVisibility.value = false;
        } else{
            nextArrowVisibility.value = true;
        }
    }
}
</script>