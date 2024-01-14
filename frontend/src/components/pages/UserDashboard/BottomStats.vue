<template>
    <div>
        <div class="p-6  px-0">
            <h2 class="text-2xl font-bold">{{ $t('DASHBOARD.PERSONAL_RECORDS.TITLE') }}</h2>
            <table  v-if="loaded" class="mt-4 w-full min-w-max table-auto text-left border border-1" >
                <thead>
                <tr>
                    <th class="cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 p-4 transition-colors hover:bg-blue-gray-50">
                        <p class="antialiased font-sans text-sm text-blue-gray-900 flex items-center justify-between gap-2 font-normal leading-none opacity-70">
                            {{ $t('DASHBOARD.PERSONAL_RECORDS.TABLE.EXERCISE') }}
                    </p>
                    </th>
                    <th class="cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 p-4 transition-colors hover:bg-blue-gray-50">
                    <p class="antialiased font-sans text-sm text-blue-gray-900 flex items-center justify-between gap-2 font-normal leading-none opacity-70"> 
                        {{ $t('DASHBOARD.PERSONAL_RECORDS.TABLE.CATEGORY') }}
                    </p>
                    </th>
                    <th class="cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 p-4 transition-colors hover:bg-blue-gray-50">
                    <p class="antialiased font-sans text-sm text-blue-gray-900 flex items-center justify-between gap-2 font-normal leading-none opacity-70"> 
                        {{ $t('DASHBOARD.PERSONAL_RECORDS.TABLE.WEIGHT') }}
                    </p>
                    </th>
                    <th class="cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 p-4 transition-colors hover:bg-blue-gray-50">
                    <p class="antialiased font-sans text-sm text-blue-gray-900 flex items-center justify-between gap-2 font-normal leading-none opacity-70"> 
                        {{ $t('DASHBOARD.PERSONAL_RECORDS.TABLE.DATE') }}
                    </p>
                    </th>
                    <th class="cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 p-4 transition-colors hover:bg-blue-gray-50">
                    <p class="antialiased font-sans text-sm text-blue-gray-900 flex items-center justify-between gap-2 font-normal leading-none opacity-70">
                        {{ $t('DASHBOARD.PERSONAL_RECORDS.TABLE.SEE') }}
                    </p>
                    </th>
                </tr>
                </thead>
                <tbody v-if="personalRecords.length">
                    <tr v-for="(data, index) in personalRecords" :key="index">
                        <td class="p-4 border-b border-blue-gray-50">
                            {{ data.exercise_name }}
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            {{ data.category_name }}
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            {{ data.max }}
                        </td>
                    
                        <td class="p-4 border-b border-blue-gray-50">
                            <p class="block antialiased font-sans text-sm leading-normal text-blue-gray-900 font-normal">
                            {{ data.training_end_time }}
                            </p>
                        </td>
                        <td class="p-4 border-b border-blue-gray-50">
                            <router-link :to="{ name: 'show-training-history', params: { trainingLogId: data.training_id } }">
                                <EyeIcon />
                            </router-link>
                        </td>
                    </tr>
                </tbody>
                <td v-else class="text-sm text-gray-600 italic mt-4 p-4" colspan="5">
                    {{ $t('DASHBOARD.PERSONAL_RECORDS.NO_PR') }}
                </td>
            </table>
            <TableSkeleton v-else />
            
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import dashboardService from '@/services/dashboardService';

import TableSkeleton from '@/components/skeletons/UserDashboard/TableSkeleton.vue'
import EyeIcon from '@/components/icons/EyeIcon.vue'

const loaded = ref(false);
const personalRecords = ref([]);

onMounted(async () => {
    const response = await dashboardService.getPersonalRecords();
    
    personalRecords.value = response.data;

    loaded.value = true;
})
</script>