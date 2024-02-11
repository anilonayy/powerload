<template>
    <div id="daily-content" class="pb-20">
                    <table class="mt-6">
                        <tr>
                            <td>{{ $t('WORKOUT_RESULT.WORKOUT') }}: </td>
                            <td class="font-semibold ps-2"> 
                                {{ data?.workout?.name }} <RightIcon class="h-3 w-3 inline" /> {{ data?.workout?.workout_day_name }} 
                            </td>
                        </tr>
                        <tr>
                            <td> {{ $t('WORKOUT_RESULT.DURATION') }}:  </td>
                            <td class="font-semibold ps-2">
                              <DynamicDuration :value="data?.duration" />
                            </td>
                        </tr>
                        <slot name="info" />
                    </table>

                    <div class="my-2">{{ $t('WORKOUT_RESULT.EXERCISES') }} ({{ data?.exercises?.length }})</div>
                        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-3">
                            <div v-for="(data, index) in data?.exercises" :key="index"> 
                                <div class="border border-1 p-3">
                                    <div class="card-header flex items-center gap-2">
										{{ index + 1  }}.
                                        <img :src="getIconName(data.exercise?.category?.name)" class="w-8 h-8" />
                                        <span class="font-semibold">{{ data?.exercise?.name  }}</span>
                                    </div>

                                    <hr class="my-1" />

                                    <table>
                                        <tbody>
                                            <tr v-for="(log, logIndex) in data.exercise_logs" :key="logIndex">
                                                <td class=""> {{ logIndex + 1 }}. {{ $t('WORKOUT_RESULT.SET') }}</td>
                                                <td class="ps-2">|</td>
                                                <td class="ps-4"> {{ log?.reps }}  </td>
                                                <td class="ps-4"> x </td>
                                                <td class="ps-4"> {{ log?.weight }} {{ $t('WORKOUT_RESULT.KG') }} </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    
                                </div>
                            </div>

                        </div>
                    <div>

                    </div>

                </div>
</template>

<script setup>
import {defineProps} from 'vue';
import RightIcon from '@/components/icons/RightIcon.vue';
import {getIconName} from '@/utils/helpers';
import DynamicDuration from "@/components/date/DynamicDuration.vue";

defineProps({
    data: {
        type: Object,
        required: true,
    }
})
</script>