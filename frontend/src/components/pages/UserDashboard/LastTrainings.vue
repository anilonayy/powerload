<template>
    <Panel class="md:p-4">
        <div id="card-header" class="border-b border-1 mb-2 pb-2 relative">
            <h2 class="text-2xl font-bold">Son 5 antrenman</h2>
            
            <div class="text-xs underline">
                <router-link :to="{ name: 'training-history' }">tümünü gör</router-link>
            </div>
        </div>

        <div v-if="loaded">
            <div v-if="list?.length" class="space-y-4">
                <div v-for="(data, index) in list" :key="index">
                    <div class="p-4 pb-1 bg-white border rounded-xl text-gray-800  text-xs">
                        <div class="flex justify-between">
                            <div class="text-gray-400 text-xs">Süre: {{ data?.duration }}</div>
                            <div class="text-gray-400 text-xs flex gap-1 items-start"><PassedTimeIcon class="w-3 relative -top-1"/> {{ data?.completed_date }} </div>
                        </div>

                        
                            <div v-if="data.status === 0" class="inline-flex self-center bg-green-400 text-white text-[.6rem] rounded-md px-1">
                                Devam Ediyor
                            </div>
                            <div v-else-if="data.status === 1" class="inline-flex self-center bg-green-400 text-white text-[.6rem] rounded-md px-1">
                                Tamamlandı
                            </div>
                            <div v-else class="inline-flex self-center bg-green-400 text-white text-[.6rem] rounded-md px-1">
                                İptal Edildi
                            </div>
                            <div class="flex gap-2">
                                <router-link :to="{ name: 'show-training-history', params: { trainingLogId: data.id } }" class="font-semibold hover:text-yellow-800 hover:underline cursor-pointer flex gap-1 items-center">
                                    {{ data?.training?.name }}
                                    <RightIcon class="w-2.5" />
                                    {{ data?.training_day?.name }} 
                                </router-link>
                            </div>
                    </div>
                </div>
            </div>
            <div v-else class="text-sm text-gray-600 italic mt-4">
                Henüz antrenman geçmişiniz bulunmamaktadır.
            </div>
        </div>
        <LastTrainingsSkeleton v-else />
    </Panel>
</template>


<script setup>
import { onMounted, ref } from "vue";
import trainingLogService from '@/services/trainingLogService';

import Panel from '@/components/shared/Panel.vue';
import LastTrainingsSkeleton from '@/components/skeletons/UserDashboard/LastTrainingsSkeleton.vue';
import RightIcon from '@/components/icons/RightIcon.vue';
import PassedTimeIcon from '@/components/icons/PassedTimeIcon.vue';

const loaded = ref(false);
const list = ref([]);

onMounted(async () => {
    const response = await trainingLogService.getAllLogs(new URLSearchParams([ ['take', '5'], ['descBy', 'id']]));

    list.value = response.data;
    loaded.value = true;
})
</script>