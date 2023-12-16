<template>
     <div
                v-for="(exercise, exerciseIndex) in day.exercises"
                :key="exercise.id"
                class="flex flex-col md:flex-row gap-3 items-center mb-4 border-2 p-3 rounded-md"
              >
                <div class="exercise w-full lg:w-3/5">
                  <Label
                    :value="exerciseIndex + 1 + '. Egzersiz'"
                    class="text-start w-full text-sm mb-1"
                  />   
                  <ag-select
                    :options="options"
                    read-text="name"
                    read-value="value"
                    placeholder="Select Exercise"
                    search
                    v-model="exercise.selected"
                    :class="{ 'validation-error': exercise.hasError }"
                  >
                    <template #option="option">
                          <div class="flex gap-3">
                            <img :src="getIconName(option.category)"  width="25" class="object-contain">
                            <div>
                              {{ option.text }}
                            </div>
                          </div>
                    </template>
                  </ag-select>
                </div>
                <div
                  class="flex gap-3 lg:grid lg:grid-flow-col lg:w-3/5 max-w-full"
                  :class="{
                    'grid-cols-2': exerciseIndex === 0,
                    'set-repeats-grid': exerciseIndex > 0
                  }"
                >
                  <div class="sets w-2/5 lg:w-full" :class="{ 'flex-1': exerciseIndex === 0 }">
                    <Label value="Set" class="text-start w-full text-sm" />

                    <div class="custom-number-input">
                      <div class="flex flex-row w-full rounded-lg relative bg-transparent mt-1">
                        <button
                        type="button"
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
                        type="button"
                          @click="exercise.sets++"
                          class="bg-gray-300 text-gray-600 hover:text-gray-700 hover:bg-gray-400 h-full w-20 rounded-r cursor-pointer"
                        >
                          <span class="m-auto text-2xl font-thin">+</span>
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="repeats w-2/5 lg:w-full" :class="{ 'flex-1': exerciseIndex === 0 }">
                    <Label value="Tekrar" class="text-start w-full text-sm" />
                    <div class="custom-number-input h-full">
                      <div class="flex flex-row w-full rounded-lg relative bg-transparent mt-1">
                        <button
                        type="button"
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
                        type="button"
                          @click="exercise.reps++"
                          class="bg-gray-300 text-gray-600 hover:text-gray-700 hover:bg-gray-400 h-full w-20 rounded-r cursor-pointer"
                        >
                          <span class="m-auto text-2xl font-thin">+</span>
                        </button>
                      </div>
                    </div>
                    <!-- <Input type="number" v-model="exercise.reps" class="w-full text-sm" /> -->
                  </div>
                  <div
                    v-if="exerciseIndex > 0"
                    @click="$emit('removeExercise',exercise.id)"
                    class="self-end w-1/5 px-0"
                  >
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
              </div>
              <ButtonCmp class="bg-indigo-900 text-white w-full" @click="$emit('add-exercise',day)"
                > Egzersiz Ekle </ButtonCmp
              >
</template>



<script setup>

import {  computed, defineEmits } from 'vue';
import { useStore } from 'vuex';
import { getIconName } from '@/utils/helpers'

import ButtonCmp from '@/components/buttons/ButtonCmp.vue'
import Label from '@/components/form/Label.vue'
import AgSelect from '@/components/shared/AgSelect.vue';

const props = defineProps(['day']);

const store =  useStore();
const options = computed(() => store.getters['_exerciseList']);

const emit = defineEmits(['add-exercise','removeExercise','addDay'])
</script>


<style scoped>
.set-repeats-grid {
  max-width: 100% !important;
  grid-template-columns: minmax(0, 2fr) minmax(0, 2fr) minmax(0, 1fr) !important;
}

.default {
  background-color: none;
}
</style>