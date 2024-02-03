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
                <OnWorkoutSelectWorkoutSkeleton v-if="!loaded || workout?.length" />

                <SelectWorkout
                    :workouts="workouts"
                    @select-workout="selectWorkout($event)"
                    v-else
                />
            </div>

            <div v-else-if="pageIndex === 1" class="flex flex-col gap-3">
                <SelectWorkoutDay :selectedWorkout="selectedWorkout"
                    @select-workout-day="selectWorkoutDay($event)"
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
            @click="completeWorkout()"
        >
            {{ $t('ON_WORKOUT.COMPLETE_WORKOUT') }}
        </div>
        <div 
            v-else-if="pageIndex >= 2 && pageIndex !== maxIndex"
            @click="handleNextStep()"
            class="flex w-full items-center justify-center text-lg font-semibold absolute bottom-0 bg-green-500 text-white h-14 cursor-pointer"
            >
            {{ $t('ON_WORKOUT.NEXT_EXERCISE') }}
        </div>

        <div v-if="!(pageIndex === maxIndex && maxIndex >= 2) && pageIndex !== 0"
            @click="giveUp()"
            class="flex justify-center items-center text-xs absolute bottom-1 left-4 p-4 rounded-full bg-gray-600 text-white h-12 w-12 cursor-pointer"
        >
            {{ $t('ON_WORKOUT.GIVE_UP') }}
        </div>
    </div>
</template>

<script setup>
import {computed, inject, onMounted, ref, watchEffect} from "vue";
import {useStore} from 'vuex';
import router from '@/router';
import workoutService from '@/services/workoutService';
import workoutLogService from '@/services/workoutLogService';
import {useI18n} from 'vue-i18n';

import SelectWorkout from '@/components/on-workout/SelectWorkout.vue';
import SelectWorkoutDay from '@/components/on-workout/SelectWorkoutDay.vue';
import SelectExercises from '@/components/on-workout/SelectExercises.vue';
import LeftIcon from '@/components/icons/LeftIcon.vue';
import RightIcon from '@/components/icons/RightIcon.vue';
import OnWorkoutSelectWorkoutSkeleton from '@/components/skeletons/OnWorkoutSelectWorkoutSkeleton.vue';

const store = useStore();
const toast = inject('toast');
const swal = inject('swal');
const { t } = useI18n();

const headerTitle = ref(t('ON_WORKOUT.WHICH_TITLES.WORKOUT'));
const workouts = ref(store.getters['_userWorkouts']);
const isWorkoutDaySelected = computed(() => store.getters['_isWorkoutDaySelected']);
const isWorkoutSelected =  computed(() => store.getters['_isWorkoutSelected']);
const nextArrowVisibility = ref(false);
const maxIndex = ref(2);
const pageIndex = ref(0);
const loaded = ref(false);

const workoutLog = computed(() => store.getters['_workoutLogId']);
const selectedWorkout = computed(() => store.getters['_selectedWorkout']);
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
    if (!isWorkoutSelected.value) {
        pageIndex.value = 0;
        maxIndex.value = 0;
    } else if(!isWorkoutDaySelected.value)  {
        pageIndex.value = 1;
        maxIndex.value = 1;
    } else {
        pageIndex.value = 2;
        maxIndex.value = 2;
    }

    if((workouts.value[0] || {}).id === 0 || workouts.value.length === 0) {
        const allWorkouts = await workoutService.getAllWorkoutsWithDetails();

        const workoutData = allWorkouts.data.map((workout) => {
            return {
                id: workout.id ?? 0,
                name: workout.name ?? '',
                isSelected: false,
                days: workout.days.map((day) => {
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
                                onWorkout: [{
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
        const lastWorkout = await workoutLogService.getForceLastLog();

        if(!lastWorkout.data.workout_id) {
            pageIndex.value = 0;
        } else {
            workoutData.find((workout) => workout.id === lastWorkout.data.workout_id).isSelected = true;
        }

        if(lastWorkout?.data?.exercises?.length) {
            ((workoutData.find((workout) => workout.isSelected).days.find((day) => day.isSelected) || {}).exercises || []).map((exercise) => {
                const onWorkoutData = [];

                lastWorkout.data.exercises.map((exerciseFromDb) => {
                    if(exercise.id === exerciseFromDb.exercise_id) {
                        onWorkoutData.push({
                            id: exerciseFromDb.id,
                            reps: exerciseFromDb.reps,
                            weight: exerciseFromDb.weight,
                            repsError: false,
                            weightError: false,
                            createTime: exerciseFromDb.started_at,
                        });
                    }
                });

                if(onWorkoutData.length) {
                    exercise.onWorkout = onWorkoutData;
                }
            })
        }

        store.dispatch('setWorkouts', workoutData);
    }

    updateState();
    loaded.value = true;
});

const updateState = async () => {
    try {
        const index = pageIndex.value;

        if(index === 0) {
            headerTitle.value = t('ON_WORKOUT.WHICH_TITLES.WORKOUT');
        } else if (index === 1) {
            headerTitle.value = t('ON_WORKOUT.WHICH_TITLES.DAY');
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
    () => workouts, () => {
        workouts.value = store.getters['_userWorkouts'];
    }
)

const selectWorkout = async (workout) => {
    try {
        if(!workout.isSelected)  {
            await workoutLogService.selectWorkout(workoutLog.value, workout.id);
        }

        handleNextStep();
    } catch (error) {
        console.error(error);
        toast.error(error.message);
    }
}

const selectWorkoutDay = async (day) => {
    try {
        if(!day.isSelected) {
            if(selectedDay.value.id && selectedDay.value.id !== day.id) {
                swalWithBootstrapButtons.fire({
                    title: t('ON_WORKOUT.SELECT_ANOTHER_DAY_CONFIRM.TITLE'),
                    text: t('ON_WORKOUT.SELECT_ANOTHER_DAY_CONFIRM.TEXT'),
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: t('ON_WORKOUT.SELECT_ANOTHER_DAY_CONFIRM.CONFIRM_BUTTON'),
                    cancelButtonText: t('ON_WORKOUT.SELECT_ANOTHER_DAY_CONFIRM.CANCEL_BUTTON'),
                    reverseButtons: true,
                })
                .then(async (result) => {
                    if (result.isConfirmed) {
                        await workoutLogService.selectWorkoutDay(workoutLog.value, day.id);

                        handleNextStep();
                    }
                });
            } else {
                await workoutLogService.selectWorkoutDay(workoutLog.value, day.id);

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
                title: t('ON_WORKOUT.PASS_EXERCISE_CONFIRM.TITLE'),
                text: t('ON_WORKOUT.PASS_EXERCISE_CONFIRM.TEXT'),
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: t('ON_WORKOUT.PASS_EXERCISE_CONFIRM.CONFIRM_BUTTON'),
                cancelButtonText: t('ON_WORKOUT.PASS_EXERCISE_CONFIRM.CANCEL_BUTTON'),
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
    await workoutLogService.saveExercise(workoutLog.value, currentExercise.value);
}

const addSet = (exercise) => {
    const newData = exercise.onWorkout[exercise.onWorkout.length - 1] || {
        id: 0,
        reps: 5,
        weight: 0,
    };
    
    exercise.onWorkout.push({
        id: 0,
        reps: newData.reps,
        weight: newData.weight,
        createTime: new Date().getTime(),
    });

    store.dispatch('setAsNotPassed', exercise.id);
};

const removeSet = (data, index) => {
    data.onWorkout.splice(index, 1);
};

const validateCurrentExercise = (index = null) => {
    if(currentExercise.value.isPassed) return true;
    
    let hasError = false;
    
    if (index != null) {
        const specificSet =  currentExercise.value.onWorkout[index];

        specificSet.weight = Number(specificSet.weight);
        specificSet.reps = Number(specificSet.reps);

        specificSet.repsError = specificSet.reps === 0 || specificSet.reps > 100;
        specificSet.weightError = specificSet.weight === 0 || specificSet.weight > 1000;

        if( !currentExercise.value.onWorkout[index + 1] && index === 0 ) {
            specificSet.createTime = new Date().getTime();
        }
        
        currentExercise.value.onWorkout[index] = specificSet;
    } else {
        const exercise = currentExercise.value;

        exercise.onWorkout.map((item) => {
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

const completeWorkout = async () => {
    if(!validateCurrentExercise()) {
        swalWithBootstrapButtons.fire({
            title: t('ON_WORKOUT.PASS_EXERCISE_CONFIRM.TITLE'),
            text: t('ON_WORKOUT.PASS_EXERCISE_CONFIRM.TEXT'),
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: t('ON_WORKOUT.PASS_EXERCISE_CONFIRM.CONFIRM_BUTTON'),
            cancelButtonText: t('ON_WORKOUT.PASS_EXERCISE_CONFIRM.CANCEL_BUTTON'),
            reverseButtons: true,
        })
        .then(async (result) => {
            if (result.isConfirmed) {
                await store.dispatch('setAsPassed', currentExercise.value.id);
                await saveExercise();
                await completeWorkoutRequest();
            }
        });
    } else {
        await saveExercise();
        await completeWorkoutRequest();
    }
};

const completeWorkoutRequest = async () => {
    try {
        swalConfirmButtons.fire({
            title: t('ON_WORKOUT.COMPLETE_WORKOUT_CONFIRM.TITLE'),
            text: t('ON_WORKOUT.COMPLETE_WORKOUT_CONFIRM.TEXT'),
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: t('ON_WORKOUT.COMPLETE_WORKOUT_CONFIRM.CONFIRM_BUTTON'),
            cancelButtonText: t('ON_WORKOUT.COMPLETE_WORKOUT_CONFIRM.CANCEL_BUTTON'),
            reverseButtons: true,
        })
        .then(async (result) => {
            if (result.isConfirmed) {
                await workoutLogService.completeWorkout(workoutLog.value);

                router.push({ name: 'train-completed', params: { workoutLogId: workoutLog.value  } });
            }
        });
    } catch (error) {
        toast.error(error.message);
    }
}

const updateArrowsVisibility = () => {
    if(pageIndex.value === 0) {
        nextArrowVisibility.value = isWorkoutSelected.value;
    } else if (pageIndex.value === 1) {
        nextArrowVisibility.value = isWorkoutDaySelected.value;
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
            title: t('ON_WORKOUT.GIVE_UP_WORKOUT_CONFIRM.TITLE'),
            text: t('ON_WORKOUT.GIVE_UP_WORKOUT_CONFIRM.TEXT'),
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: t('ON_WORKOUT.GIVE_UP_WORKOUT_CONFIRM.CONFIRM_BUTTON'),
            cancelButtonText: t('ON_WORKOUT.GIVE_UP_WORKOUT_CONFIRM.CANCEL_BUTTON'),
            reverseButtons: true,
        })
        .then(async (result) => {
            if (result.isConfirmed) {
                await workoutLogService.giveUp(workoutLog.value);

                router.push({ name: 'home' });
            }
        });
}
</script>