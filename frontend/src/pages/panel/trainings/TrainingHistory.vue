<template>
    <div>
      <Panel>
        <HistorySkeleton v-if="!loaded" />  
        <div v-else>
          <PanelHeader 
              class="p-2"
              title="Antrenman Geçmişi"
              description="Antrenman geçmişinizi buradan takip edebilirsiniz 👀"
          />

          <div v-if="trainingLogs.length" class="relative overflow-x-auto sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="border-b bg-neutral-800 font-medium text-white dark:border-neutral-500 dark:bg-neutral-900">
                  <tr>
                      <th scope="col" class="px-6 py-3">Antrenman Bilgisi</th>
                      <th scope="col" class="px-6 py-3">Antrenman Süresi</th>
                      <th scope="col" class="px-6 py-3">Antrenman Tarihi</th>
                      <th scope="col" class="px-6 py-3">İncele</th>
                  </tr>
              </thead>
              <tbody>
                  <tr
                      v-for="(log, index) in trainingLogs"
                      :key="index"
                      class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                  >
                      <th scope="row" class="px-6 py-4 font-bold text-gray-900 whitespace-nowrap dark:text-white">
                          <router-link 
                            :to="{ name: 'training', params: { trainId: log.training.id } }" 
                            class="text-gray-900 font-bold dark:text-blue-500 flex gap-3">
                              {{ log.training.name }} 
                              <RightIcon class="h-3 w-3 inline" />  
                              {{ log.training.training_day_name }}                            
                          </router-link>
                      </th>
                    <td class="px-6 py-4"> {{ log?.duration }} </td>
                    <td class="px-6 py-4">{{ log?.training_date }}</td>
                    <td class="px-6 py-4 flex gap-3">
                      <router-link
                        :to="{ name: 'single-training-history', params: { trainingLogId: log.id } }"
                        class=" text-blue-600 dark:text-blue-500 hover:underline"
                      >
                        <ButtonCmp class="bg-orange-400 text-white border-orange-400 hover:bg-orange-300"
                          >Detaylı İncele</ButtonCmp
                        >
                      </router-link>
                    </td>
                  </tr>
              </tbody>
            </table>
          </div>

          <div v-else class="w-full text-center bg-gray-200 text-gray-800 rounded-md p-3 py-6  text-md">
              <span>Henüz antrenman geçmişiniz bulunmamaktadır.</span>
          </div>
        </div>
      </Panel>
      
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import trainingLogService from '@/services/trainingLogService'

import PanelHeader from '@/components/panel/PanelHeader.vue'
import ButtonCmp from '@/components/buttons/ButtonCmp.vue'
import RightIcon from '@/components/icons/RightIcon.vue'
import Panel from '@/components/form/Panel.vue'
import HistorySkeleton from '@/components/skeletons/HistorySkeleton.vue'

const trainingLogs = ref([]);
const loaded = ref(false);

onMounted(async () => {
    try {
      trainingLogs.value = (await trainingLogService.getAllLogs()).data;
      loaded.value = true;
    } catch (error) {
      console.log('error :>> ', error);
    }
});
</script>
