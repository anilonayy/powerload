<template>
    <div>
        <div class="p-6  px-0">
            <h2 class="text-2xl font-bold">Kişisel Rekorlar (PR)</h2>
            <table  v-if="loaded" class="mt-4 w-full min-w-max table-auto text-left border border-1" >
                <thead>
                <tr>
                    <th class="cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 p-4 transition-colors hover:bg-blue-gray-50">
                        <p class="antialiased font-sans text-sm text-blue-gray-900 flex items-center justify-between gap-2 font-normal leading-none opacity-70">
                            Egzersiz Adı
                    </p>
                    </th>
                    <th class="cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 p-4 transition-colors hover:bg-blue-gray-50">
                    <p class="antialiased font-sans text-sm text-blue-gray-900 flex items-center justify-between gap-2 font-normal leading-none opacity-70"> Egzersiz Kategorisi
                    </p>
                    </th>
                    <th class="cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 p-4 transition-colors hover:bg-blue-gray-50">
                    <p class="antialiased font-sans text-sm text-blue-gray-900 flex items-center justify-between gap-2 font-normal leading-none opacity-70"> PR (kg)
                    </p>
                    </th>
                    <th class="cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 p-4 transition-colors hover:bg-blue-gray-50">
                    <p class="antialiased font-sans text-sm text-blue-gray-900 flex items-center justify-between gap-2 font-normal leading-none opacity-70"> Tarih 
                    </p>
                    </th>
                    <th class="cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 p-4 transition-colors hover:bg-blue-gray-50">
                    <p class="antialiased font-sans text-sm text-blue-gray-900 flex items-center justify-between gap-2 font-normal leading-none opacity-70">İncele</p>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="p-4 border-b border-blue-gray-50">
                    bench
                    </td>
                    <td class="p-4 border-b border-blue-gray-50">
                    <div class="flex items-center gap-3">
                        asd
                    </div>
                    </td>
                    <td class="p-4 border-b border-blue-gray-50">
                    asfas
                    </td>
                
                    <td class="p-4 border-b border-blue-gray-50">
                        <p class="block antialiased font-sans text-sm leading-normal text-blue-gray-900 font-normal">
                        23/04/18
                        </p>
                    </td>
                    <td class="p-4 border-b border-blue-gray-50">
                    <EyeIcon />
                    </td>
                </tr>
                </tbody>
            </table>
            <TableSkeleton v-else />
            
        </div>
    </div>
</template>

<script setup>
import TableSkeleton from '@/components/skeletons/UserDashboard/TableSkeleton.vue'
import EyeIcon from '@/components/icons/EyeIcon.vue'
import { onMounted, ref } from 'vue'

const loaded = ref(false);

onMounted(() => {
    console.log('hi');
})
</script>