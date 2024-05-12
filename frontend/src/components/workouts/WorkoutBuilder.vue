<template>
  <div>
    <WorkoutBuilderSkeleton v-if="!loaded" />
    <form v-else method="POST" @submit="submitWorkout($event)">
      <div class="mb-8">
        <Label for="workout-name" :value="$t('WORKOUTS.WORKOUT_BUILDER.WORKOUT_NAME')" />

        <Input
          id="workout-name"
          type="text"
          class="mt-1 block w-full"
          :class="{ 'validation-error': data.hasError }"
          v-model="data.name"
          :placeholder="$t('WORKOUTS.WORKOUT_BUILDER.WORKOUT_NAME_PLACEHOLDER')"
        />

        <ErrorList error-key="name" :errors="errors" />
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div v-for="(day, index) in data.days" class="border-2 rounded-md" :key="index">
          <div class="p-2 inline-block w-full">
            <div class="flex justify-between">
              <Label :value="`${$t('WORKOUTS.WORKOUT_BUILDER.DAY')} ${index + 1} `" class="text-start ms-1 mb-2" />
              <div v-if="index > 0" class="cursor-pointer" @click="removeDay(day.id)">
                <div class="red-btn" style="padding: 8px !important">
                  <TrashIcon />
                </div>
              </div>
            </div>
            <Input
              type="text"
              v-model="day.name"
              class="w-full border-1 border-b-2 max-w-full"
              :placeholder="$t('WORKOUTS.WORKOUT_BUILDER.DAY_PLACEHOLDER')"
              :class="{ 'validation-error': day.hasError }"
            />

            <div v-if="day.errorMessage" class="bg-red-200 text-red-800 rounded-md mt-3 p-2 text-sm font-semibold">
              {{ $t(day.errorMessage) }}
            </div>
          </div>
          <div class="inner-side mx-6 flex flex-col gap-2 pb-6">
            <ExerciseList :day="day" @removeExercise="removeExercise" @addExercise="addExercise" @addDay="addDay" />
          </div>
        </div>
        <div class="btn border-dashed border border-1 border-gray-700 w-full h-full" @click="addDay($event)">
          {{ $t('WORKOUTS.WORKOUT_BUILDER.ADD_DAY') }}
        </div>
      </div>
      <button type="submit" class="green-btn w-full mt-4">
        {{ $t('WORKOUTS.WORKOUT_BUILDER.SUBMIT_FORM') }}
      </button>
    </form>
  </div>
</template>

<script setup>
import { inject, onMounted, ref, watch } from 'vue';
import { guid, validateWorkoutBuilderData } from '@/utils/helpers';
import { useStore } from 'vuex';
import { useRoute } from 'vue-router';
import { useI18n } from 'vue-i18n';
import router from '@/router';
import workoutService from '@/services/workoutService';
import exerciseService from '@/services/exerciseService';

import Input from '@/components/form/Input.vue';
import Label from '@/components/form/Label.vue';
import ExerciseList from '@/components/workouts/ExerciseList.vue';
import WorkoutBuilderSkeleton from '@/components/skeletons/WorkoutBuilderSkeleton.vue';
import TrashIcon from '@/components/icons/TrashIcon.vue';
import ErrorList from '@/components/errors/ErrorList.vue';

const store = useStore();
const route = useRoute();
const translator = useI18n();
const toast = inject('toast');

const loaded = ref(false);
const currentWorkoutId = ref(route.params.trainId);

onMounted(async () => {
  try {
    if (currentWorkoutId.value) {
      const response = await workoutService.getWorkout(currentWorkoutId.value);

      const days = response.data.days.map((day) => {
        const exercises = day.exercises.map((exercise) => {
          exercise.selected = {
            name: exercise.exercise.name,
            value: exercise.exercise.id
          };

          return exercise;
        });

        day.exercises = exercises;

        return day;
      });

      response.data.days = days.length
        ? days
        : [
            {
              id: guid(),
              name: '',
              exercises: [
                {
                  id: guid(),
                  selected: {
                    name: '',
                    value: 0
                  },
                  sets: 4,
                  reps: 10
                }
              ],
              errorMessage: ''
            }
          ];

      data.value = response.data;
    }

    const response = await exerciseService.getAllExercises();
    store.dispatch('setExercises', response.data);

    loaded.value = true;
  } catch (error) {
    toast.error(error.message);
  }
});

const data = ref({
  name: '',
  days: [
    {
      id: guid(),
      name: '',
      exercises: [
        {
          id: guid(),
          selected: {
            name: '',
            value: 0
          },
          sets: 4,
          reps: 10
        }
      ],
      errorMessage: ''
    }
  ]
});

const errors = ref({});

const addDay = () => {
  data.value.days.push({
    id: guid(),
    name: '',
    exercises: [
      {
        id: guid(),
        selected: {
          name: '',
          value: 0
        },
        sets: data.value.days[0].exercises[0].sets,
        reps: data.value.days[0].exercises[0].reps,
        disabled: false
      }
    ],
    errorMessage: ''
  });
};

const removeDay = (id) => {
  data.value.days = data.value.days.filter((day) => day.id !== id);
};

const addExercise = (day) => {
  data.value.days.map((item) => {
    if (item.id === day.id) {
      item.exercises.push({
        id: guid(),
        selected: {
          name: '',
          value: 0
        },
        sets: item.exercises[0].sets,
        reps: item.exercises[0].reps,
        disabled: false
      });
    }
  });
};

const removeExercise = (exerciseId) => {
  data.value.days = data.value.days.filter((item, index) => {
    data.value.days[index].exercises = data.value.days[index].exercises.filter(
      (exercise) => exercise.id !== exerciseId
    );
    return true;
  });
};

const submitWorkout = async (event) => {
  event.preventDefault();

  try {
    const validationResponse = validateWorkoutBuilderData(data.value);

    if (validationResponse.success) {
      currentWorkoutId.value
        ? await workoutService.updateWorkout(currentWorkoutId.value, data.value)
        : await workoutService.createWorkout(data.value);

      router.push({ name: 'workout-list' });
    } else {
      toast.error(translator.t('WORKOUTS.WORKOUT_BUILDER.VALIDATION_ERROR'));
    }
  } catch (error) {
    console.log(error);
    toast.error(error.message);
  }
};

watch(data.value, () => {
  data.value = validateWorkoutBuilderData(data.value).data;
});
</script>
