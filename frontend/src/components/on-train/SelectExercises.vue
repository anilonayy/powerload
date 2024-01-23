<template>
    <div>
        <div v-for="(data, index) in selectedDay?.exercises" :key="index">
                <div v-if="index === pageIndex - 2" class="flex flex-col justify-center items-center gap-5">
                    <span class="font-bold "> {{ index + 1 }} / {{ selectedDay.exercises.length }} </span>
                    <div class="exercise-info flex items-center justify-center">
                        <img :src="getIconName(data.category?.name ?? '')" class=" w-10 h-10 object-contain">
                        <h1 class="font-bold text-center text-4xl"> {{ data?.name ?? '' }} </h1>
                    </div>
                    <div class="sets">
                        <div class="flex flex-col">
                            <div v-if="data?.isPassed">
                                <div class="w-full p-4 rounded-xl bg-yellow-200 text-yellow-700 text-sm border border-1 border-yellow-500">
                                    {{ $t('ON_TRAIN.EXERCISE.PASSED') }}
                                </div>
                            </div>
                            <div v-if="data.onTrain?.length">
                                <div v-for="(trainSet, index) in data.onTrain" :key="index" class="py-10" :class="{ 'border-b border-gray-300': data?.onTrain?.length - 1 !== index }">
                                    <div class="flex gap-3 items-end font-bold">
                                        <div class="whitespace-nowrap text-7xl" style="line-height: 0.8">
                                            {{ index + 1 }}.
                                        </div>
                                        <div>
                                            <Label for="weight" :value="$t('ON_TRAIN.EXERCISE.WEIGHT')" />

                                            <Input
                                                id="weight"
                                                type="number"
                                                @input="validateCurrentExercise(index)"
                                                :class="{'border-red-600': trainSet.weightError}"
                                                class="focus:outline-none text-center w-full bg-gray-300 font-semibold text-md hover:text-black focus:text-black md:text-basecursor-default flex items-center text-gray-700 outline-none"
                                                v-model="trainSet.weight"
                                            />
                                        </div>
                                        <div class="flex flex-col">
                                            <Label for="reps" :value="$t('ON_TRAIN.EXERCISE.REP')" />
                                            <CounterInput 
                                                valueKey="reps" 
                                                errorKey="repsError"
                                                :data="trainSet" 
                                                :index="index"  
                                                :validateCurrentExercise="validateCurrentExercise"
                                                @increment="(data) => { data.reps ++ }"
                                                @decrement="(data) => { data.reps !== 0 ? data.reps -- : '' }"
                                            />
                                        </div>

                                        <div v-if="index !== 0">
                                            <div class="red-btn" @click="removeSet(data,index)">
                                                <TrashIcon class="h-3 p-0" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="indigo-btn" @click="addSet(data)">
                                {{ $t('ON_TRAIN.EXERCISE.ADD_SET') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue';
import { getIconName } from '@/utils/helpers.js';

import Label from '@/components/form/Label.vue';
import Input from '@/components/form/Input.vue';
import CounterInput from '@/components/form/CounterInput.vue';
import TrashIcon from '@/components/icons/TrashIcon.vue';

defineProps({
    selectedDay: {
        type: Object,
        required: true
    },
    pageIndex: {
        type: Number,
        required: true
    },
    validateCurrentExercise: {
        type: Function,
        required: false
    },
    addSet: {
        type: Function,
        required: true
    },
    removeSet: {
        type: Function,
        required: true
    }
});

const emits = defineEmits(['addSet', 'removeSet']);

const addSet = (data) => emits('addSet', data);
const removeSet = (data) => emits('removeSet', data);
</script>