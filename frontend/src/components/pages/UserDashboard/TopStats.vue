<template>
    <div class="">
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4 mt-4">
            <div class="flex items-center justify-start text-center gap-4 p-2 rounded-md bg-purple-200  ">
                <div class="stats-badge-icon bg-purple-50 ">
                    <DumbellIcon />
                </div>

                <div class="text-start" v-if="loaded" >
                    <h6 class="stats-text  font-semibold text-deep-purple-accent-400"> {{ data?.workout_count ?? '' }} </h6>
                    <p> {{ $t('DASHBOARD.TOP_STATS.WORKOUT') }} </p>
                </div>

                <TopStatsSkeleton v-else />
            </div>

            <div class="flex items-center justify-start text-center gap-4 p-2 rounded-md bg-indigo-200">
                <div class="stats-badge-icon bg-indigo-50">
                    <PassedTimeIcon />
                </div>

                <div class="text-start" v-if="loaded">
                    <h6 class="stats-text font-semibold text-deep-purple-accent-400"> {{ data?.average_workout_time ?? '' }} </h6>
                    <p> {{ $t('DASHBOARD.TOP_STATS.AVG_TIME') }} </p>
                </div>
                <TopStatsSkeleton v-else />
            </div>
            
            <div class="flex items-center justify-start text-center gap-4 p-2 rounded-md bg-blue-200">
                <div class="stats-badge-icon bg-blue-50">
                    <CountSticksIcon />
                </div>

                <div class="text-start" v-if="loaded">
                    <h6 class="stats-text font-semibold text-deep-purple-accent-400"> {{ data?.average_exercise_count ?? '' }} </h6>
                    <p> {{ $t('DASHBOARD.TOP_STATS.AVG_EXERCISE') }} </p>
                </div>
                <TopStatsSkeleton v-else />
            </div>

            <div class="flex items-center justify-start text-center gap-4 p-2 rounded-md bg-red-200">
                <div class="stats-badge-icon bg-blue-50">
                    <CountSticksIcon />
                </div>

                <div class="text-start" v-if="loaded">
                    <h6 class="stats-text font-semibold text-deep-purple-accent-400">?</h6>
                    <p> {{ $t('DASHBOARD.TOP_STATS.X') }} </p>
                </div>
                <TopStatsSkeleton v-else />
            </div>
        </div>
        <div class="text-xs  italic pt-2 leading-2 text-gray-600" v-html="$t('DASHBOARD.TOP_STATS.SUBTITLE')" />
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import dashboardService from '@/services/dashboardService';

import DumbellIcon from '@/components/icons/DumbellIcon.vue';
import PassedTimeIcon from '@/components/icons/PassedTimeIcon.vue';
import CountSticksIcon from '@/components/icons/CountSticksIcon.vue';
import TopStatsSkeleton from '@/components/skeletons/UserDashboard/TopStatsSkeleton.vue';



const loaded = ref(false);
const data = ref({});

onMounted(async () => {
    const response = await dashboardService.getStats();

    loaded.value = true;

    data.value = response.data;
})
</script>