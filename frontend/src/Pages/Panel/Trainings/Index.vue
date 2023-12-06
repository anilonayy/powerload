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
          <ButtonCmp class="bg-indigo-800 text-white"> Antrenman Ekle </ButtonCmp>
        </router-link>

        <div v-if="trainings.length">
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
            <tr
              v-for="(training, index) in trainings"
              :key="index"
              class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
            >
              <th
                scope="row"
                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
              >
                {{ training.name }}
              </th>
              <td class="px-6 py-4">0</td>
              <td class="px-6 py-4">{{ training.created_at }}</td>
              <td class="px-6 py-4 flex gap-3">
                <router-link
                  :to="{ name: 'training', params: { trainId: training.id } }"
                  class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
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
            Henüz antrenman eklemedin! Antrenman ekleyip gücüne güç katmaya başlayabilirsin!
        </div>

        
      </div>
    </Panel>
  </PanelLayout>
</template>

<script setup>
import { onMounted, ref, inject } from 'vue'
import PanelLayout from '@/Layouts/PanelLayout.vue'
import Panel from '@/Components/Form/Panel.vue'
import PanelHeader from '@/Components/Panel/PanelHeader.vue'
import ButtonCmp from '@/Components/buttons/ButtonCmp.vue'
import axios from '@/Utils/axios.js'

const trainings = ref([])
const swal = inject('swal');
const toast = inject('toast');

onMounted(async () => {
  try {
    const response = await axios.get('/trainings');

    trainings.value = response.data
  } catch (error) {
    toast.fire({
      icon: "error",
      title: error.message
    });
  }
})

const removeTraining = async (id) => {
  swal.fire({
      title: 'Emin misin?',
      text: 'Bu işlem geri alınamaz!',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sil',
      cancelButtonText: 'Vazgeçtim',
      reverseButtons: false
    })
    .then(async (result) => {
      if (result.isConfirmed) {
        try {
          const response = await axios.delete(`/training/${ id }`)

          trainings.value = trainings.value.filter((training) => training.id !== id);

          toast.fire({
            icon: "success",
            title: response.message
          });
        } catch (error) {
          toast.fire({
            icon: "error",
            title: error.message
          })
        }
      }
    })
}
</script>
