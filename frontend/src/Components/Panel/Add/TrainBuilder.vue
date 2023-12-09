<template>
    <form method="POST" @submit="submitTrain($event)">
        <div class="mb-8">
          <Label for="name" value="Antrenman Adı" />

          <Input
            id="name"
            type="text"
            class="mt-1 block w-full"
            :class="{ 'validation-error' : data.hasError }"
            v-model="data.name"
            autofocus
            placeholder="Full Body, Split, PPL..."
          />
          

          <div v-if="errors?.name && errors?.name.length > 0">
            <InputError class="mt-2" :message="errors?.name[0]" />
          </div>
        </div>
            

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <div v-for="(day, index) in data.days" class="border-2" :key="index">
            <div class="p-2 inline-block w-full">
              <div class="flex justify-between">
                <Label :value="'Gün ' + (index + 1)" class="text-start ms-1 mb-2" />

                <div v-if="index > 0" class="cursor-pointer" @click="removeDay(day.id)">
                  <ButtonCmp class="bg-red-500 border-white text-white h-9 px-2 lg:px-2" style="padding: 8px !important"
                      ><svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class=""
                      >
                        <path d="M3 6h18" />
                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                        <line x1="10" x2="10" y1="11" y2="17" />
                        <line x1="14" x2="14" y1="11" y2="17" /></svg
                    ></ButtonCmp>
                </div>
              </div>
              <Input
                type="text"
                v-model="day.name"
                class="w-full border-0 border-b-2 max-w-full"
                placeholder="Göğüs Günü, Sırt Günü, İtiş Günü..."
                :class="{ 'validation-error' : day.hasError }"
              />
              
              <div v-if="day.errorMessage" class="bg-red-200 text-red-800 rounded-md mt-3 p-2 text-sm font-semibold">
                  {{ day.errorMessage }}
              </div>

            </div>
            <div class="inner-side mx-6 flex flex-col gap-2 pb-6">
                <ExerciseList :day="day" @removeExercise="removeExercise" @addExercise="addExercise" @addDay="addDay"  />
            </div>
          </div>
          <ButtonCmp
            class="text-gray-700  w-full h-full border-gray-700 border-1 border-dashed"
            @click="addDay($event)"
            >Antrenman Günü Ekle</ButtonCmp
          >
        </div>
        <ButtonCmp type="submit" class="text-center mt-6 w-full bg-green-500  text-white" >ANTRENMANI KAYDET!</ButtonCmp
        >
      </form>
</template>


<script setup>
import { onMounted, ref, watch, inject } from 'vue'
import { guid, validateTrainBuilderData } from '@/Utils/helpers'
import { useStore } from 'vuex';
import { useRoute } from 'vue-router'

import ButtonCmp from '@/Components/buttons/ButtonCmp.vue'
import Input from '@/Components/Form/Input.vue'
import Label from '@/Components/Form/Label.vue'
import ExerciseList from '@/Components/Panel/Add/ExerciseList.vue';

const store =  useStore();
const route = useRoute();
import router from '@/Router'

const toast = inject('toast');
const axios = inject('axios');

const isUpdatePage = ref(route.params.trainId);

onMounted(async () => {
    try {
      if (isUpdatePage.value) {
        const response = await axios.get(`trainings/${ route.params.trainId }`);

        const days = response.data.days.map((day) => {
          const exercises =  day.exercises.map((exercise) => {
            exercise.selected = {
              name: exercise.exercise.name,
              value: exercise.exercise.id
            }

            return exercise;
          })

          day.exercises = exercises;

          return day;
        });


        response.data.days = days.length ? days : [{
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
          errorMessage :''
        }];
        
        data.value = response.data;
      }

      const response = await axios.get('/exercises');
      await store.dispatch('setExercises',response.data);
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
      errorMessage :''
    }
  ]
})

const errors = ref({});

const addDay = () => {
  data.value.days.push({
    id: guid(),
    name: '',
    exercises: [
      {
        id: guid(),
        selected: {
          name: 'Name',
          value: 0
        },
        sets: data.value.days[0].exercises[0].sets,
        reps: data.value.days[0].exercises[0].reps,
        disabled: false
      }
    ],
    errorMessage: ''
  })
}

const removeDay = (id) => {
  data.value.days = data.value.days.filter((day) => day.id !== id)
}

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
      })
    }
  })
}

const removeExercise = (exerciseId) => {
  data.value.days = data.value.days.filter((item, index) => {
    data.value.days[index].exercises = data.value.days[index].exercises.filter(
      (exercise) => exercise.id !== exerciseId
    )
    return true
  })
}

const submitTrain = async (event) => {
  event.preventDefault()

  try {
    const validationResponse = validateTrainBuilderData(data.value);

    if(validationResponse.success) {
      const response = isUpdatePage.value 
        ? await axios.put(`/trainings/${ isUpdatePage.value }`, {train: data.value}) 
        : await axios.post('/trainings', { train: data.value })

      toast.success(response.message);
      router.push({ name: 'trainings' });      
    }
  } catch (error) {
    console.log(error);
    toast.error(error.message);
  }
}


watch(data.value,() => {
    data.value = validateTrainBuilderData(data.value).data;
})


</script>