<template>
    <Panel class="md:p-4">
        <div id="card-header" class="border-b border-1 mb-2 pb-2 relative">
            <h2 class="text-2xl font-bold">{{ $t('DASHBOARD.LAST_WORKOUTS.TITLE') }}</h2>
            
            <div class="text-xs underline">
                <router-link :to="{ name: 'workout-history' }">{{ $t('DASHBOARD.LAST_WORKOUTS.SEE_ALL') }}</router-link>
            </div>
        </div>

        <div v-if="loaded">
            <div v-if="workoutHistories?.length" class="space-y-4">
                <div v-for="(data, index) in workoutHistories" :key="index">
                    <div class="p-2  md:p-4 pb-1 bg-white border rounded-xl text-gray-800  text-xs relative">
                        <div class="flex justify-between">
                            <div class="text-gray-400 text-xs">{{ $t('DASHBOARD.LAST_WORKOUTS.TIME') }}:
                            <DynamicDuration :value="data?.duration" />
                            </div>
                            <div class="text-gray-400 text-xs flex gap-1 items-start">
                              <PassedTimeIcon class="w-3 relative -top-1"/>
                              {{ shortDateForHumans(data?.completed_date) }}
                            </div>
                        </div>
                        <div class="absolute bottom-2 right-2">
                            <div v-if="data.status.code === 0" class="inline-flex self-center bg-yellow-400 text-white text-[.6rem] rounded-md px-1">
                                {{ $t('DASHBOARD.LAST_WORKOUTS.STATUS.CONTINUE') }}
                            </div>
                            <div v-else-if="data.status.code === 1" class="inline-flex self-center bg-green-400 text-white text-[.6rem] rounded-md px-1">
                                {{ $t('DASHBOARD.LAST_WORKOUTS.STATUS.COMPLETED') }}
                            </div>
                            <div v-else class="inline-flex self-center bg-red-400 text-white text-[.6rem] rounded-md px-1">
                                {{ $t('DASHBOARD.LAST_WORKOUTS.STATUS.CANCELED') }}
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <router-link :to="{ name: 'show-workout-history', params: { workoutLogId: data.id } }" class="font-semibold hover:text-yellow-800 hover:underline cursor-pointer flex gap-1 items-center">
                                {{ data?.workout?.name }}
                                <RightIcon class="w-2.5 mx-0.5" />
                                {{ data?.workout_day?.name }}
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else class="text-sm text-gray-600 italic mt-4">
                Henüz antrenman geçmişiniz bulunmamaktadır.
            </div>
        </div>
        <LastWorkoutsSkeleton v-else />
    </Panel>
</template>


<script setup>
import { onMounted } from "vue";
import useWorkoutHistory from "@/composables/workoutHistory";
import { shortDateForHumans } from '@/utils/dateHelper'

import Panel from '@/components/shared/Panel.vue';
import LastWorkoutsSkeleton from '@/components/skeletons/UserDashboard/LastWorkoutsSkeleton.vue';
import RightIcon from '@/components/icons/RightIcon.vue';
import PassedTimeIcon from '@/components/icons/PassedTimeIcon.vue';
import DynamicDuration from "@/components/date/DynamicDuration.vue";

const { workoutHistories,loaded, getWorkoutHistories } = useWorkoutHistory();

const config = {
  page: 1,
  take: 5,
  paginate: 0
};

onMounted(async () => {
    await getWorkoutHistories(config);
})
</script>