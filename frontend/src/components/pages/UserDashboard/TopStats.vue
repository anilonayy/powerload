<template>
    <div class="">

        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4 mt-4">
            <div class="flex items-center justify-start text-center gap-4 bg-purple-200  p-2 rounded-md">
                <div class="flex items-center justify-center w-10 h-10 aspect-square mb-3 rounded-full bg-purple-50 sm:w-12 sm:h-12">
                    <DumbellIcon />
                </div>

                <div class="text-start" v-if="loaded" >
                    <h6 class="text-2xl font-semibold text-deep-purple-accent-400"> {{ data?.training_count ?? '' }} </h6>
                    <p>Antrenman</p>
                </div>

                <TopStatsSkeleton v-else />
            </div>

            <div class="flex items-center justify-start text-center gap-4 bg-indigo-200  p-2 rounded-md">
                <div class="flex items-center justify-center w-10 h-10 aspect-square mb-3 rounded-full bg-indigo-50 sm:w-12 sm:h-12">
                    <PassedTimeIcon />
                </div>

                <div class="text-start" v-if="loaded">
                    <h6 class="text-2xl font-semibold text-deep-purple-accent-400"> {{ data?.average_training_time ?? '' }} </h6>
                    <p>Ortalama Süre</p>
                </div>
                <TopStatsSkeleton v-else />
            </div>
            
            <div class="flex items-center justify-start text-center gap-4 bg-blue-200  p-2 rounded-md">
                <div class="flex items-center justify-center w-10 h-10 aspect-square mb-3 rounded-full bg-blue-50 sm:w-12 sm:h-12">
                    <CountSticksIcon />
                </div>

                <div class="text-start" v-if="loaded">
                    <h6 class="text-2xl font-semibold text-deep-purple-accent-400"> {{ data?.average_exercise_count ?? '' }} </h6>
                    <p>Ortalama Hareket</p>
                </div>
                <TopStatsSkeleton v-else />
            </div>

            <div class="flex items-center justify-start text-center gap-4 bg-red-200  p-2 rounded-md">
                <div class="flex items-center justify-center w-10 h-10 aspect-square mb-3 rounded-full bg-blue-50 sm:w-12 sm:h-12">
                    <CountSticksIcon />
                </div>

                <div class="text-start" v-if="loaded">
                    <h6 class="text-2xl font-semibold text-deep-purple-accent-400">?</h6>
                    <p>?</p>
                </div>
                <TopStatsSkeleton v-else />
            </div>
        </div>
        <div class="text-xs  italic pt-2 leading-2 text-gray-600">
            *Bu veriler yalnızca <b>tamamlanmış</b> antrenmanlardan hesaplanmaktadır.
        </div>
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

    console.log('data.value :>> ', data.value);
})
</script>