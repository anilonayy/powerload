<template>
  <PanelLayout class="p-5">
    <Panel class="lg:px-8">
      <PanelHeader
        class="p-2"
        title="Antrenman Ekle"
        description="Antrenmanına günler ekleyebilir ,günlere isim verebilir, antrenman anında bu günlere direkt tıklayarak erişebilirsin!"
      />

<form method="POST" @submit="submitTrain($event)">
      <div class="mb-8">
          <Label for="trainName" value="Antrenman Adı" />

          <Input
            id="trainName"
            type="text"
            class="mt-1 block w-full"
            v-model="data.trainName"
            autofocus
            required
            placeholder="Full Body, Split, PPL..."
          />

          <div v-if="errors?.trainName && errors?.trainName.length > 0">
            <InputError class="mt-2" :message="errors.trainName[0]" />
          </div>
        </div>


      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div v-for="(day, index) in data.days" class="border-2" :key="day.id">
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
          </div>
          <div class="inner-side mx-6 flex flex-col gap-2 py-6">
            <div
              v-for="(exercise, exerciseIndex) in day.exercises"
              :key="exercise.id"
              class="flex flex-col md:flex-row gap-3 items-center mb-4 border-2 p-3 rounded-md"
            >
              <div class="exercise w-full lg:w-3/5">
                <Label :value=" (exerciseIndex + 1) + '. Egzersiz'" class="text-start w-full text-sm mb-1" />
                <Input 
                type="text" 
                v-model="exercise.name" 
                class="w-full text-sm" 
                placeholder="Bench Press, Deadlift, Squat vb.."
                required
                />
              </div>
              <div class="flex gap-3 lg:grid  lg:grid-flow-col lg:w-3/5 max-w-full" :class="{ 'grid-cols-2': exerciseIndex === 0, 'set-repeats-grid' : exerciseIndex > 0 }">
                <div class="sets w-2/5 lg:w-full" :class="{ 'w-full' : exerciseIndex === 0 }">
                  <Label value="Set" class="text-start w-full text-sm" />

                  <div class="custom-number-input">
                    <div class="flex flex-row w-full rounded-lg relative bg-transparent mt-1">
                      <button
                        @click="exercise.sets > 1 ? exercise.sets-- : ''"
                        class="bg-gray-300 text-gray-600 hover:text-gray-700 hover:bg-gray-400 h-full w-20 rounded-l cursor-pointer outline-none"
                      >
                        <span class="m-auto text-2xl font-thin">−</span>
                      </button>
                      <input
                        v-model="exercise.sets"
                        type="number"
                        class="outline-none focus:outline-none text-center w-full bg-gray-300 font-semibold text-md hover:text-black focus:text-black md:text-basecursor-default flex items-center text-gray-700 outline-none"
                      />
                      <button
                        @click="exercise.sets++"
                        class="bg-gray-300 text-gray-600 hover:text-gray-700 hover:bg-gray-400 h-full w-20 rounded-r cursor-pointer"
                      >
                        <span class="m-auto text-2xl font-thin">+</span>
                      </button>
                    </div>
                  </div>
                </div>
                <div class="repeats w-2/5 lg:w-full" :class="{ 'w-full' : exerciseIndex === 0 }">
                  <Label value="Tekrar" class="text-start w-full text-sm" />
                  <div class="custom-number-input h-full">
                    <div class="flex flex-row w-full rounded-lg relative bg-transparent mt-1">
                      <button
                        @click="exercise.reps > 1 ? exercise.reps-- : ''"
                        class="bg-gray-300 text-gray-600 hover:text-gray-700 hover:bg-gray-400 h-full w-20 rounded-l cursor-pointer outline-none"
                      >
                        <span class="m-auto text-2xl font-thin">−</span>
                      </button>
                      <input
                        v-model="exercise.reps"
                        type="number"
                        class="outline-none focus:outline-none text-center w-full bg-gray-300 font-semibold text-md hover:text-black focus:text-black md:text-basecursor-default flex items-center text-gray-700 outline-none"
                      />
                      <button
                        @click="exercise.reps++"
                        class="bg-gray-300 text-gray-600 hover:text-gray-700 hover:bg-gray-400 h-full w-20 rounded-r cursor-pointer"
                      >
                        <span class="m-auto text-2xl font-thin">+</span>
                      </button>
                    </div>
                  </div>
                  <!-- <Input type="number" v-model="exercise.reps" class="w-full text-sm" /> -->
                </div>
                <div v-if="exerciseIndex > 0" @click="removeExercise(exercise.id)" class="self-end w-1/5 px-0">
                  <ButtonCmp class="bg-red-500 border-white text-white h-9 px-2 lg:px-2"
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
              
            </div>
            <ButtonCmp class="bg-indigo-900 text-white w-full" @click="addExercise(day)">+</ButtonCmp>
          </div>
        </div>
        <ButtonCmp class="bg-indigo-400 hover:bg-indigo-300 text-white w-full h-full border-white border-1 border-dashed" @click="addDay($event)">+</ButtonCmp>
      </div>
      <ButtonCmp type="submit" class="text-center mt-6 w-full bg-green-500 hover:bg-green-400 text-white">ANTRENMANI KAYDET!</ButtonCmp>
    </form>
    </Panel>
  </PanelLayout>
</template>

<script setup>
import { ref } from 'vue'
import { guid } from '@/Utils/helpers'
import axios from '@/Utils/axios';
import toastr from 'toastr'


import PanelLayout from '@/Layouts/PanelLayout.vue'
import Panel from '@/Components/Form/Panel.vue'
import PanelHeader from '@/Components/Panel/PanelHeader.vue'
import ButtonCmp from '@/Components/buttons/ButtonCmp.vue'
import Input from '@/Components/Form/Input.vue'
import Label from '@/Components/Form/Label.vue'


const data = ref({
  trainName: '',
  days: [
    {
      id: guid(),
      name: '',
      exercises: [
        {
          id: guid(),
          name: '',
          sets: 4,
          reps: 10
        }
      ]
    }
  ]
})

const addDay = () => {
  console.log('data :>> ', data.value)
  data.value.days.push({
    id: guid(),
    name: '',
    exercises: [
      {
        id: guid(),
        name: 'Yeni Egzersiz',
        sets: 4,
        reps: 10
      }
    ]
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
        name: '',
        sets: item.exercises[0].sets,
        reps: item.exercises[0].reps
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
  event.preventDefault();
  

  try {
    const response = await axios.post('/trainings',data.value);

    console.log('response :>> ', response);
  } catch (error) {
    toastr.error(error.message);
  }
}
</script>



<style scoped>
.set-repeats-grid {
  max-width: 100% !important;
  grid-template-columns: minmax(0, 2fr) minmax(0, 2fr) minmax(0, 1fr) !important;
}
</style>