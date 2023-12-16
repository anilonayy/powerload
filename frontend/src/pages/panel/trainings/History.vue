<template>
    <Panel>
        <PanelHeader 
            class="p-2"
            title="Antrenman Geçmişi"
            description="Antrenman geçmişinizi buradan takip edebilirsiniz 👀"
        />

        <div @click="fetch()" class=" h-14 bg-red-300 w-full cursor-pointer">
          FETCH 
        </div>
        <div v-if="trainings.length">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="border-b bg-neutral-800 font-medium text-white dark:border-neutral-500 dark:bg-neutral-900">
            <tr>
                <th scope="col" class="px-6 py-3">Antrenman Adı</th>
                <th scope="col" class="px-6 py-3">Uygulanan Gün</th>
                <th scope="col" class="px-6 py-3">Oluşturulma Tarihi</th>
                <th scope="col" class="px-6 py-3">İşlemler</th>
            </tr>
        </thead>
        <tbody>
            <tr
                v-for="(training, index) in trainings"
                :key="index"
                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
            >
                <th scope="row" class="px-6 py-4 font-bold text-gray-900 whitespace-nowrap dark:text-white">
                    <router-link :to="{ name: 'training', params: { trainId: training.id } }" class="text-gray-900 font-bold dark:text-blue-500 hover:underline">
                        {{ training.name }}
                    </router-link>
                </th>
              <td class="px-6 py-4">0</td>
              <td class="px-6 py-4">{{ training.created_at }}</td>
              <td class="px-6 py-4 flex gap-3">
                <router-link
                  :to="{ name: 'training', params: { trainId: training.id } }"
                  class=" text-blue-600 dark:text-blue-500 hover:underline"
                >
                  <ButtonCmp class="bg-orange-400 text-white border-orange-400 hover:bg-orange-300"
                    >Düzenle</ButtonCmp
                  >
                </router-link>

                <ButtonCmp
                  class="bg-red-500 text-white border-red-500 hover:bg-red-400"
                  @click="removeTraining(training.id)"
                >
                  Sil
                </ButtonCmp>
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
import Panel from "@/components/form/Panel.vue";
import PanelHeader from '@/components/panel/PanelHeader.vue'

const axios = inject('axios');

const trainings = ref([]);

onMounted(() => {
    getTrainingHistory();
});

const getTrainingHistory = async () => {
    
};

const fetch = async () => {
  await axios.get("/trainings/history");
}
</script>
