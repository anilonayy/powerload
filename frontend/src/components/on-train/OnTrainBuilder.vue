<template>
    <div>
        <div class="mx-3 relative">
            <div class="h-6  w-full flex justify-between items-center mt-10 relative">
                <div class="previous-exercise absolute left-0 cursor-pointer" v-if="pageIndex !== 0"  @click="handlePreviousStep()">
                    <LeftIcon />
                </div>

                <div class="next-exercise absolute right-0 cursor-pointer" @click="handleNextStep()" v-if="nextArrowVisibility">
                    <RightIcon />
                </div>
            </div>

            <h3 v-if="pageIndex === 1 || pageIndex === 0" class="font-bold text-center my-4"> {{ headerTitle }} </h3>

            <div v-if="pageIndex === 0">
                <OnTrainSelectTrainingSkeleton v-if="!loaded || training?.length" />

                <SelectTraining
                    :trainings="trainings"
                    @select-training="selectTraining($event)"
                    v-else
                />
            </div>

            <div v-else-if="pageIndex === 1" class="flex flex-col gap-3">
                <SelectTrainingDay :selectedTraining="selectedTraining"
                    @select-training-day="selectTrainingDay($event)"
                />
            </div>

            <div v-else class="pb-20">
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
            v-if="pageIndex === maxIndex && maxIndex >= 2"
            class="flat-btn green-btn w-full absolute bottom-0 h-12 "
            @click="completeTraining()"
        >
            {{ $t('ON_TRAIN.COMPLETE_TRAINING') }}
        </div>
        <div 
            v-else-if="pageIndex >= 2 && pageIndex !== maxIndex"
            @click="handleNextStep()"
            class="flex w-full items-center justify-center text-lg font-semibold absolute bottom-0 bg-green-500 text-white h-14 cursor-pointer"
            >
            {{ $t('ON_TRAIN.NEXT_EXERCISE') }}
        </div>

        <div v-if="!(pageIndex === maxIndex && maxIndex >= 2) && pageIndex !== 0"
            @click="giveUp()"
            class="flex justify-center items-center text-xs absolute bottom-1 left-4 p-4 rounded-full bg-gray-600 text-white h-12 w-12 cursor-pointer"
        >
            {{ $t('ON_TRAIN.GIVE_UP') }}
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref, inject, computed, watchEffect } from "vue";
import { useStore } from 'vuex';
import router from '@/router';
import trainingService from '@/services/trainingService';
import trainingLogService from '@/services/trainingLogService';
import { useI18n } from 'vue-i18n';

import SelectTraining from '@/components/on-train/SelectTraining.vue';
import SelectTrainingDay from '@/components/on-train/SelectTrainingDay.vue';
import SelectExercises from '@/components/on-train/SelectExercises.vue';    
import LeftIcon from '@/components/icons/LeftIcon.vue';
import RightIcon from '@/components/icons/RightIcon.vue';
import OnTrainSelectTrainingSkeleton from '@/components/skeletons/OnTrainSelectTrainingSkeleton.vue';

const store = useStore();
const toast = inject('toast');
const swal = inject('swal');
const { t } = useI18n();

const headerTitle = ref(t('ON_TRAIN.WHICH_TITLES.TRAINING'));
const trainings = ref(store.getters['_userTrainings']);
const isTrainingDaySelected = computed(() => store.getters['_isTrainingDaySelected']);
const isTrainingSelected =  computed(() => store.getters['_isTrainingSelected']);
const nextArrowVisibility = ref(false);
const maxIndex = ref(2);
const pageIndex = ref(0);
const loaded = ref(false);

const trainingLog = computed(() => store.getters['_trainingLogId']);
const selectedTraining = computed(() => store.getters['_selectedTraining']);
const selectedDay = computed(() => store.getters['_selectedDay']);
const currentExercise = computed(() => selectedDay.value.exercises[pageIndex.value - 2]);

const swalWithBootstrapButtons = swal.mixin({
    customClass: {
    confirmButton: "bg-red-500 text-white py-2 px-4 rounded-md ms-2",
    cancelButton: "bg-gray-400 text-white py-2 px-4 rounded-md"
    },
    buttonsStyling: false
});

const swalConfirmButtons = swal.mixin({
    customClass: {
    confirmButton: "bg-green-500 text-white py-2 px-4 rounded-md ms-2",
    cancelButton: "bg-gray-500 text-white py-2 px-4 rounded-md"
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
        const allTrainings = await trainingService.getAllTrainingsWithDetails();

        const trainingData = allTrainings.data.map((training) => {
            return {
                id: training.id ?? 0,
                name: training.name ?? '',
                isSelected: false,
                days: training.days.map((day) => {
                    return {
                        id: day.id ?? 0,
                        name: day.name ?? '',
                        isSelected: false,
                        exercises: day.exercises?.map((exercise) => {
                            return {
                                id: exercise.exercise.id ?? 0,
                                name: exercise.exercise.name ?? '',
                                category: exercise.exercise.category ?? {},
                                sets: exercise.sets ?? 0,
                                reps: exercise.reps ?? 0,
                                onTrain: [{
                                    id: 0,
                                    reps: 5,
                                    weight: 0,
                                    repsError: false,
                                    weightError: false,
                                    createTime: new Date().getTime(),
                                }]
                            }
                        })
                    }
                })
            }
        });

        // Eğer antrenman içeriği var ise güncelle
        const lastTraining = await trainingLogService.getForceLastLog();

        if(!lastTraining.data.training_id) {
            pageIndex.value = 0;
        } else {
            trainingData.find((training) => training.id === lastTraining.data.training_id).isSelected = true;
        }

        if(lastTraining?.data?.exercises?.length) {
            ((trainingData.find((training) => training.isSelected).days.find((day) => day.isSelected) || {}).exercises || []).map((exercise) => {
                const onTrainData = [];

                lastTraining.data.exercises.map((exerciseFromDb) => {
                    if(exercise.id === exerciseFromDb.exercise_id) {
                        onTrainData.push({
                            id: exerciseFromDb.id,
                            reps: exerciseFromDb.reps,
                            weight: exerciseFromDb.weight,
                            repsError: false,
                            weightError: false,
                            createTime: exerciseFromDb.started_at,
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
    loaded.value = true;
});

const updateState = async () => {
    try {
        const index = pageIndex.value;

        if(index === 0) {
            headerTitle.value = t('ON_TRAIN.WHICH_TITLES.TRAINING');
        } else if (index === 1) {
            headerTitle.value = t('ON_TRAIN.WHICH_TITLES.DAY');
        } else {
            maxIndex.value = selectedDay.value.exercises?.length + 1;
        }
    } catch (error) {
        console.error(error);
        toast.error(t('ERRORS.UNKNOWN'))
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
            await trainingLogService.selectTraining(trainingLog.value, training.id);
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
            if(selectedDay.value.id && selectedDay.value.id !== day.id) {
                swalWithBootstrapButtons.fire({
                    title: t('ON_TRAIN.SELECT_ANOTHER_DAY_CONFIRM.TITLE'),
                    text: t('ON_TRAIN.SELECT_ANOTHER_DAY_CONFIRM.TEXT'),
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: t('ON_TRAIN.SELECT_ANOTHER_DAY_CONFIRM.CONFIRM_BUTTON'),
                    cancelButtonText: t('ON_TRAIN.SELECT_ANOTHER_DAY_CONFIRM.CANCEL_BUTTON'),
                    reverseButtons: true,
                })
                .then(async (result) => {
                    if (result.isConfirmed) {
                        await trainingLogService.selectTrainingDay(trainingLog.value, day.id);

                        handleNextStep();
                    }
                });
            } else {
                await trainingLogService.selectTrainingDay(trainingLog.value, day.id);

                handleNextStep();
            }
        } else {
            handleNextStep();
        }
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
        if(!validateCurrentExercise() && !currentExercise.value.isPassed) {
            swalWithBootstrapButtons.fire({
                title: t('ON_TRAIN.PASS_EXERCISE_CONFIRM.TITLE'),
                text: t('ON_TRAIN.PASS_EXERCISE_CONFIRM.TEXT'),
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: t('ON_TRAIN.PASS_EXERCISE_CONFIRM.CONFIRM_BUTTON'),
                cancelButtonText: t('ON_TRAIN.PASS_EXERCISE_CONFIRM.CANCEL_BUTTON'),
                reverseButtons: true,
            })
            .then(async (result) => {
                if (result.isConfirmed) {
                    store.dispatch('setAsPassed', currentExercise.value.id);
                    await saveExercise();
                    setNextPageIndex();
                }
            });
        } else {
            await saveExercise();
            setNextPageIndex();
        }
    } else {
        setNextPageIndex();
    }
};

const setNextPageIndex = () => {
    pageIndex.value += 1;
    updateState();
}

const saveExercise = async () => {
    await trainingLogService.saveExercise(trainingLog.value, currentExercise.value);
}

const addSet = (exercise) => {
    const newData = exercise.onTrain[exercise.onTrain.length - 1] || {
        id: 0,
        reps: 5,
        weight: 0,
    };
    
    exercise.onTrain.push({
        id: 0,
        reps: newData.reps,
        weight: newData.weight,
        createTime: new Date().getTime(),
    });

    store.dispatch('setAsNotPassed', exercise.id);
};

const removeSet = (data, index) => {
    data.onTrain.splice(index, 1);
};

const validateCurrentExercise = (index = null) => {
    if(currentExercise.value.isPassed) return true;
    
    let hasError = false;
    
    if (index != null) {
        const specificSet =  currentExercise.value.onTrain[index];

        specificSet.weight = Number(specificSet.weight);
        specificSet.reps = Number(specificSet.reps);

        specificSet.repsError = specificSet.reps === 0 || specificSet.reps > 100;
        specificSet.weightError = specificSet.weight === 0 || specificSet.weight > 1000;

        if( !currentExercise.value.onTrain[index + 1] && index === 0 ) {
            specificSet.createTime = new Date().getTime();
        }
        
        currentExercise.value.onTrain[index] = specificSet;
    } else {
        const exercise = currentExercise.value;

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
            title: t('ON_TRAIN.PASS_EXERCISE_CONFIRM.TITLE'),
            text: t('ON_TRAIN.PASS_EXERCISE_CONFIRM.TEXT'),
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: t('ON_TRAIN.PASS_EXERCISE_CONFIRM.CONFIRM_BUTTON'),
            cancelButtonText: t('ON_TRAIN.PASS_EXERCISE_CONFIRM.CANCEL_BUTTON'),
            reverseButtons: true,
        })
        .then(async (result) => {
            if (result.isConfirmed) {
                await store.dispatch('setAsPassed', currentExercise.value.id);
                await saveExercise();
                await completeTrainingRequest();
            }
        });
    } else {
        await saveExercise();
        await completeTrainingRequest();
    }
};

const completeTrainingRequest = async () => {
    try {
        swalConfirmButtons.fire({
            title: t('ON_TRAIN.COMPLETE_TRAINING_CONFIRM.TITLE'),
            text: t('ON_TRAIN.COMPLETE_TRAINING_CONFIRM.TEXT'),
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: t('ON_TRAIN.COMPLETE_TRAINING_CONFIRM.CONFIRM_BUTTON'),
            cancelButtonText: t('ON_TRAIN.COMPLETE_TRAINING_CONFIRM.CANCEL_BUTTON'),
            reverseButtons: true,
        })
        .then(async (result) => {
            if (result.isConfirmed) {
                await trainingLogService.completeTraining(trainingLog.value);

                router.push({ name: 'train-completed', params: { trainingLogId: trainingLog.value  } });
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
        if(selectedDay.value.exercises?.length + 1 === pageIndex.value) {
            nextArrowVisibility.value = false;
        } else{
            nextArrowVisibility.value = true;
        }
    }
}

const giveUp = () => {
    swalWithBootstrapButtons.fire({
            title: t('ON_TRAIN.GIVE_UP_TRAINING_CONFIRM.TITLE'),
            text: t('ON_TRAIN.GIVE_UP_TRAINING_CONFIRM.TEXT'),
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: t('ON_TRAIN.GIVE_UP_TRAINING_CONFIRM.CONFIRM_BUTTON'),
            cancelButtonText: t('ON_TRAIN.GIVE_UP_TRAINING_CONFIRM.CANCEL_BUTTON'),
            reverseButtons: true,
        })
        .then(async (result) => {
            if (result.isConfirmed) {
                await trainingLogService.giveUp(trainingLog.value);

                router.push({ name: 'home' });
            }
        });
}
</script>