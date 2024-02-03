<template>
  <div
    v-for="(exercise, exerciseIndex) in day.exercises"
    :key="exercise.id"
    class="grid grid-cols-1 md:grid-cols-2 gap-3 items-center mb-4 border-2 p-3 rounded-md"
  >
    <div class="exercise w-full col-span-1">
      <Label
        :value="`${exerciseIndex + 1}. ${$t('WORKOUTS.WORKOUT_BUILDER.EXERCISE')}`"
        class="text-start w-full text-sm mb-1"
      />
      <ag-select
        :options="options"
        read-text="name"
        read-value="value"
        :placeholder="$t('WORKOUTS.WORKOUT_BUILDER.SELECT_EXERCISE')"
        search
        v-model="exercise.selected"
        :class="{ 'validation-error': exercise.hasError }"
        @updateModel="updateModel(exercise, $event)"
      >
        <template #option="option">
          <div class="flex gap-3">
            <img :src="getIconName(option.category)" width="25" class="object-contain" />
            <div>
              {{ option.text }}
            </div>
          </div>
        </template>
      </ag-select>
    </div>
    <div class="max-w-full grid grid-cols-12 gap-3">
      <div class="col-span-5" :class="{ 'col-span-6': exerciseIndex === 0 }">
        <Label :value="$t('WORKOUTS.WORKOUT_BUILDER.SET')" class="text-start w-full text-sm" />

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
              class="focus:outline-none text-center w-full bg-gray-300 font-semibold text-md hover:text-black focus:text-black md:text-basecursor-default flex items-center text-gray-700 outline-none"
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
      <div class="col-span-5" :class="{ 'col-span-6': exerciseIndex === 0 }">
        <Label :value="$t('WORKOUTS.WORKOUT_BUILDER.REP')" class="text-start w-full text-sm" />
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
              class="focus:outline-none text-center w-full bg-gray-300 font-semibold text-md hover:text-black focus:text-black md:text-basecursor-default flex items-center text-gray-700 outline-none"
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
      </div>
      <div
        v-if="exerciseIndex > 0"
        @click="$emit('removeExercise', exercise.id)"
        class="self-end col-span-2"
      >
        <div class="red-btn h-9 aspect-square px-2 lg:px-2" style="padding: 8px !important">
          <TrashIcon />
        </div>
      </div>
    </div>
  </div>

  <div class="indigo-btn col-span-1" @click="$emit('add-exercise', day)">
    {{ $t('WORKOUTS.WORKOUT_BUILDER.ADD_EXERCISE') }}
  </div>
</template>



<script setup>
import {computed, defineEmits} from 'vue'
import {useStore} from 'vuex'
import {getIconName} from '@/utils/helpers'

import TrashIcon from '@/components/icons/TrashIcon.vue'
import Label from '@/components/form/Label.vue'
import AgSelect from '@/components/shared/AgSelect.vue'

const props = defineProps(['day'])

const store = useStore()
const options = computed(() => store.getters['_exerciseList'])

const emit = defineEmits(['add-exercise', 'removeExercise', 'addDay'])

const updateModel = (exercise, $event) => {
  exercise.selected = $event
}
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