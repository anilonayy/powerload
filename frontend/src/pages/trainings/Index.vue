<template>
  <Panel>
    <TrainingListSkeleton v-if="!loaded" />
    <div v-else>
      <PanelHeader class="p-2">
        <template v-slot:title> Antrenmanlar </template>
        <template v-slot:description>
          Antrenmanların burada listelenir yeni antrenman ekleyebilir ve bunların içine antrenman
          günleri ve hareketler ekleyebilirsin.
        </template>
        <hr />
      </PanelHeader>

      <div class="relative overflow-x-auto sm:rounded-lg">
        <router-link :to="{ name: 'add-train' }" class="block mb-6">
          <div class="indigo-btn">Antrenman Ekle</div>
        </router-link>

        <TableWrapper v-if="trainings.length">
          <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead
              class="border-b bg-neutral-800 font-medium text-white border-black dark:border-neutral-500 dark:bg-neutral-900"
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
                  class="px-6 py-4 font-bold text-gray-900 whitespace-nowrap dark:text-white"
                >
                  <router-link
                    :to="{ name: 'training', params: { trainId: training.id } }"
                    class="text-gray-900 font-bold dark:text-blue-500 hover:underline"
                  >
                    {{ training.name }}
                  </router-link>
                </th>
                <td class="px-6 py-4">{{ training.training_logs_count }}</td>
                <td class="px-6 py-4">{{ training.created_at }}</td>
                <td class="px-6 py-4 flex gap-3">
                  <router-link :to="{ name: 'training', params: { trainId: training.id } }">
                    <div class="orange-btn">Düzenle</div>
                  </router-link>

                  <div class="red-btn" @click="removeTraining(training.id)">Sil</div>
                </td>
              </tr>
            </tbody>
          </table>
        </TableWrapper>

        <div
          v-else
          class="w-full text-center bg-gray-200 text-gray-800 rounded-md p-3 py-6 text-md"
        >
          Henüz antrenman eklemedin! Antrenman ekleyip gücüne güç katmaya başlayabilirsin!
        </div>
      </div>
    </div>
  </Panel>
</template>

<script setup>
import { onMounted, ref, inject } from 'vue'
import trainingService from '@/services/trainingService'

import Panel from '@/components/shared/Panel.vue'
import PanelHeader from '@/components/shared/PanelHeader.vue'
import TableWrapper from '@/components/shared/TableWrapper.vue'
import TrainingListSkeleton from '@/components/skeletons/TrainingListSkeleton.vue'

const swal = inject('swal')
const toast = inject('toast')

const loaded = ref(false)
const trainings = ref([])

onMounted(async () => {
  try {
    const response = await trainingService.getAllTrainings()

    trainings.value = response.data
    loaded.value = true
  } catch (error) {
    toast.error(error.message)
  }
})

const removeTraining = async (id) => {
  const swalWithBootstrapButtons = swal.mixin({
    customClass: {
      confirmButton: 'bg-red-500 text-white py-2 px-4 rounded-md ms-2',
      cancelButton: 'bg-gray-400 text-white py-2 px-4 rounded-md'
    },
    buttonsStyling: false
  })

  swalWithBootstrapButtons
    .fire({
      title: 'Emin misin?',
      text: 'Bu işlem geri alınamaz!',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Sil',
      cancelButtonText: 'Vazgeçtim',
      reverseButtons: true
    })
    .then(async (result) => {
      if (result.isConfirmed) {
        try {
          await trainingService.deleteTraining(id)

          trainings.value = trainings.value.filter((training) => training.id !== id)

          toast.success('Antrenman başarıyla silindi!')
        } catch (error) {
          toast.error(error.message)
        }
      }
    })
}
</script>
