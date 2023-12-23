<template>
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
            class="border-b bg-neutral-800 font-medium text-white dark:border-neutral-500 dark:bg-neutral-900"
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
            Henüz antrenman eklemedin! Antrenman ekleyip gücüne güç katmaya başlayabilirsin!
        </div>

        
      </div>
    </Panel>
</template>

<script setup>
import { onMounted, ref, inject } from 'vue'
import Panel from '@/components/form/Panel.vue'
import PanelHeader from '@/components/panel/PanelHeader.vue'
import ButtonCmp from '@/components/buttons/ButtonCmp.vue'


const axios = inject('axios');
const swal = inject('swal');
const toast = inject('toast');

const trainings = ref([])

onMounted(async () => {
  try {
    const response = await axios.get('/trainings');

    trainings.value = response.data
  } catch (error) {
    toast.error(error.message);
  }
})

const removeTraining = async (id) => {
      const swalWithBootstrapButtons = swal.mixin({
        customClass: {
          confirmButton: "bg-red-500 text-white py-2 px-4 rounded-md ms-2",
          cancelButton: "bg-gray-400 text-white py-2 px-4 rounded-md"
        },
        buttonsStyling: false
      });

    swalWithBootstrapButtons.fire({
      title: 'Emin misin?',
      text: 'Bu işlem geri alınamaz!',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Sil',
      cancelButtonText: 'Vazgeçtim',
      reverseButtons: true,
    })
    .then(async (result) => {
      if (result.isConfirmed) {
        try {
          const response = await axios.delete(`/trainings/${ id }`)

          trainings.value = trainings.value.filter((training) => training.id !== id);

          toast.success(response.message);
        } catch (error) {
          toast.error(error.message);
        }
      }
    })
}
</script>
