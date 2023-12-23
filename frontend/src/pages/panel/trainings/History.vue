<template>
    <Panel>
        <PanelHeader 
            class="p-2"
            title="Antrenman Geçmişi"
            description="Antrenman geçmişinizi buradan takip edebilirsiniz 👀"
        />

        <div v-if="trainings.length">
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
                    v-for="(training, index) in trainings"
                    :key="index"
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                >
                    <th scope="row" class="px-6 py-4 font-bold text-gray-900 whitespace-nowrap dark:text-white">
                        <router-link 
                          :to="{ name: 'training', params: { trainId: training.id } }" 
                          class="text-gray-900 font-bold dark:text-blue-500 flex gap-3">
                            <PrimaryBadge class="flex justify-center items-center w-full">
                              {{ training.training.name }} 
                            </PrimaryBadge>
                            <SecondaryBadge class="flex justify-center items-center w-full">
                              {{ training.training_day.name }}
                            </SecondaryBadge>
                            
                        </router-link>
                    </th>
                  <td class="px-6 py-4"> {{ calculateTrainingTime(training) }} </td>
                  <td class="px-6 py-4">{{ formatTrainingTime(training) }}</td>
                  <td class="px-6 py-4 flex gap-3">
                    <router-link
                      :to="{ name: 'single-training-history', params: { trainingLogId: training.id } }"
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
            

    </Panel>
</template>

<script setup>
import { onMounted, ref, inject } from "vue";
import moment from 'moment';
import Panel from "@/components/form/Panel.vue";
import PanelHeader from '@/components/panel/PanelHeader.vue'
import ButtonCmp from '@/components/buttons/ButtonCmp.vue'
import PrimaryBadge from '@/components/badges/PrimaryBadge.vue';
import SecondaryBadge from '@/components/badges/SecondaryBadge.vue';

const axios = inject('axios');

const trainings = ref([]);

onMounted(() => {
    getTrainingHistory();
});

const getTrainingHistory = async () => {
  const response =  await axios.get("/trainings/history");

  trainings.value = response.data;
}

const calculateTrainingTime = ({ created_at, training_end_time }) => {
  
  const startDate = moment(Number(created_at * 1000));
  const endDate =  moment(Number(training_end_time * 1000));

  const hours = endDate.diff(startDate, 'h');
  const minute = endDate.diff(startDate, 'm');

  return `${ hours ? `${ hours } Saat` : '' }  ${ minute ? `${ minute } Dakika` : '' }`;
}

const formatTrainingTime =  ({ training_end_time }) => {
  return moment(Number(training_end_time * 1000)).calendar();
}
</script>
