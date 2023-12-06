<template>
  <PanelLayout class="p-5">
    <Panel>
      <PanelHeader
        class="p-2"
        title="Antrenmanlar"
        description="Antrenmanların burada listelenir yeni antrenman ekleyebilir ve bunların içine antrenman günleri ve hareketler ekleyebilirsin."
      />

      <div class="relative overflow-x-auto sm:rounded-lg">
        <router-link :to="{ name: 'add-train' }" class="block mb-6">
            <ButtonCmp class="bg-indigo-800 text-white">
                Antrenman Ekle
            </ButtonCmp>
        </router-link>

        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
          <thead
            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
          >
            <tr>
              <th scope="col" class="px-6 py-3">Antrenman Adı</th>
              <th scope="col" class="px-6 py-3">Uygulanan Gün</th>
              <th scope="col" class="px-6 py-3">Oluşturulma Tarihi</th>
              <th scope="col" class="px-6 py-3">İşlemler</th>
            </tr>
          </thead>
          <tbody>
            <tr  v-for="(training,index) in trainings" :key="index" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
              <th
                scope="row"
                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
              >
                {{ training.name }}
              </th>
              <td class="px-6 py-4">0</td>
              <td class="px-6 py-4"> {{ training.created_at }} </td>
              <td class="px-6 py-4">
                <router-link :to="{ name: 'training', params: { trainId: training.id } }" class="font-medium text-blue-600 dark:text-blue-500 hover:underline"> 
                  Düzenle
                </router-link>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </Panel>
  </PanelLayout>
</template>

<script setup>

import { onMounted, ref } from 'vue'
import PanelLayout from '@/Layouts/PanelLayout.vue'
import Panel from '@/Components/Form/Panel.vue'
import PanelHeader from '@/Components/Panel/PanelHeader.vue'
import ButtonCmp from '@/Components/buttons/ButtonCmp.vue'
import axios from '@/Utils/axios.js'
import toastr from 'toastr';

const trainings = ref([]);

onMounted(async () => {
  try {
      const response = await axios.get('/trainings');

      trainings.value = response.data;
  } catch (error) {
      toastr.error(error.title,error.message);
  }
})
</script>
