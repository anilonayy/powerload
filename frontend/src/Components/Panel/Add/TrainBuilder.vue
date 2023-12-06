<template>
    <form method="POST" @submit="submitTrain($event)">
        <div class="mb-8">
          <Label for="name" value="Antrenman Adı" />

          <Input
            id="name"
            type="text"
            class="mt-1 block w-full"
            v-model="data.name"
            autofocus
            required
            placeholder="Full Body, Split, PPL..."
          />
          

          <div v-if="errors?.name && errors?.name.length > 0">
            <InputError class="mt-2" :message="errors?.name[0]" />
          </div>
        </div>

            

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
          <div v-for="(day, index) in data.days" class="border-2" :key="index">
            <div class="p-2 inline-block w-full text-center">
              <div class="flex justify-between">
                <Label :value="'Gün ' + (index + 1)" class="text-start ms-1 mb-2" />

                <div v-if="index > 0" class="cursor-pointer" @click="removeDay(day.id)">
                  <ButtonCmp class="bg-red-500 border-white text-white h-8"
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
                class="w-full border-0 border-b-2"
                placeholder="Göğüs Günü, Sırt Günü, İtiş Günü..."
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
            class="bg-indigo-600 hover:bg-indigo-500 text-white w-full h-full border-white border-1"
            @click="addDay($event)"
            >Antrenman Günü Ekle</ButtonCmp
          >
        </div>
        <ButtonCmp type="submit" class="text-center mt-6 w-full bg-black  text-white" >ANTRENMANI KAYDET!</ButtonCmp
        >
      </form>
</template>


<script setup>
import { onMounted, ref, computed, watch } from 'vue'
import { guid } from '@/Utils/helpers'
import axios from '@/Utils/axios'
import toastr from 'toastr'
import { useStore } from 'vuex';
import { useRoute } from 'vue-router'


import ButtonCmp from '@/Components/buttons/ButtonCmp.vue'
import Input from '@/Components/Form/Input.vue'
import Label from '@/Components/Form/Label.vue'
import ExerciseList from '@/Components/Panel/Add/ExerciseList.vue';

const store =  useStore();
const router = useRoute();

const exerciselist = computed(() => store.getters['__getExercises']);


onMounted(async () => {
    try {
      if (router.params.trainId) {
        const response = await axios.get(`training/${ router.params.trainId }`);

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

        response.data.days = days;


        data.value = response.data;
      }

      const response = await axios.get('/exercises');
      await store.dispatch('setExercises',response.data);
    } catch (error) {
      toastr.error(error.message);
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


  console.log('Submit Data :>> ', data.value);

  try {
    const response = await axios.post('/trainings', { train: data.value })

    toastr.success(response.message, response.title)
  } catch (error) {
    toastr.error(error.message, error.title)
  }
}


watch(data.value,() => {
  
    data.value.days.map((day) => {
      const exerciseIds = [];
      let hasError = false;

      day.exercises.map((exercise) => {
        if(!hasError && (exercise.selected?.value || 0) !== 0) {
          if(exerciseIds.includes(exercise.selected.value)) {
            day.errorMessage = 'Her egzersiz gün içinde 1 kez seçilebilir!';
            hasError = true;
          } else {
            day.errorMessage = '';
            exerciseIds.push(exercise.selected.value);
          }
        }
       
      })
    })
})


</script>