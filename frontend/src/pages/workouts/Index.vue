<template>
  <Panel>
    <WorkoutListSkeleton v-if="!loaded" />
    <div v-else>
      <PanelHeader class="p-2">
        <template v-slot:title> {{ $t('WORKOUTS.LIST.TITLE') }} </template>
        <template v-slot:description>
          {{ $t('WORKOUTS.LIST.DESCRIPTION') }}
        </template>
        <hr />
      </PanelHeader>

      <div class="relative overflow-x-auto sm:rounded-lg">
        <router-link :to="{ name: 'add-train' }" class="block mb-6">
          <div class="indigo-btn"> {{ $t('WORKOUTS.LIST.ADD_BUTTON') }} </div>
        </router-link>

        <div v-if="workouts?.data?.length">
          <TableWrapper>
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
              <thead
                  class="border-b bg-neutral-800 font-medium text-white border-black dark:border-neutral-500 dark:bg-neutral-900"
              >
              <tr>
                <th scope="col" class="px-6 py-3">{{ $t('WORKOUTS.LIST.TABLE.WORKOUT_NAME') }}</th>
                <th scope="col" class="px-6 py-3">{{ $t('WORKOUTS.LIST.TABLE.APPLIED_DAY') }}</th>
                <th scope="col" class="px-6 py-3">{{ $t('WORKOUTS.LIST.TABLE.CREATED_AT') }}</th>
                <th scope="col" class="px-6 py-3">{{ $t('WORKOUTS.LIST.TABLE.ACTIONS') }}</th>
              </tr>
              </thead>
              <tbody>
              <tr
                  v-for="(workout, index) in workouts?.data"
                  :key="index"
                  class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
              >
                <th
                    scope="row"
                    class="px-6 py-4 font-bold text-gray-900 whitespace-nowrap dark:text-white"
                >
                  <router-link
                      :to="{ name: 'workout', params: { trainId: workout.id } }"
                      class="text-gray-900 font-bold dark:text-blue-500 hover:underline"
                  >
                    {{ workout.name }}
                  </router-link>
                </th>
                <td class="px-6 py-4">{{ workout.workout_logs_count }}</td>
                <td class="px-6 py-4">{{ workout.created_at }}</td>
                <td class="px-6 py-4 flex gap-3">
                  <router-link :to="{ name: 'workout', params: { trainId: workout.id } }">
                    <div class="orange-btn">
                      {{ $t('WORKOUTS.LIST.EDIT_BUTTON') }}
                    </div>
                  </router-link>

                  <div class="red-btn" @click="removeWorkoutModal(workout.id)">
                    {{ $t('WORKOUTS.LIST.DELETE_BUTTON') }}
                  </div>
                </td>
              </tr>
              </tbody>
            </table>
          </TableWrapper>

          <Pagination :data="workouts"  @pagination-change-page="changePage($event)"  class="flex items-end me-2" />
        </div>


        <div
          v-else
          class="w-full text-center bg-gray-200 text-gray-800 rounded-md p-3 py-6 text-md"
        >
          {{ $t('WORKOUTS.LIST.NO_DATA') }}
        </div>
      </div>
    </div>
  </Panel>
</template>

<script setup>
import {inject, onMounted, ref} from 'vue';
import {useI18n} from 'vue-i18n';
import useWorkout from "@/composables/workout";

import Panel from '@/components/shared/Panel.vue';
import PanelHeader from '@/components/shared/PanelHeader.vue';
import TableWrapper from '@/components/shared/TableWrapper.vue';
import WorkoutListSkeleton from '@/components/skeletons/WorkoutListSkeleton.vue';
import Pagination from "@/components/shared/Pagination.vue";

const swal = inject('swal');
const toast = inject('toast');
const translator = useI18n();

const { workouts, loaded, errors, getWorkouts, removeWorkout } = useWorkout();
const config = ref({
    page: 1,
    take: 10,
    paginate: 1
});

onMounted(async () => {
  await getWorkouts(config.value);
})

const removeWorkoutModal = async (id) => {
  const swalWithBootstrapButtons = swal.mixin({
    customClass: {
      confirmButton: 'bg-red-500 text-white py-2 px-4 rounded-md ms-2',
      cancelButton: 'bg-gray-300 text-black py-2 px-4 rounded-md'
    },
    buttonsStyling: false
  })

  swalWithBootstrapButtons
    .fire({
      title: translator.t('WORKOUTS.LIST.DELETE_ACTION.TITLE'),
      text: translator.t('WORKOUTS.LIST.DELETE_ACTION.TEXT'),
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: translator.t('WORKOUTS.LIST.DELETE_ACTION.CONFIRM_BUTTON'),
      cancelButtonText: translator.t('WORKOUTS.LIST.DELETE_ACTION.CANCEL_BUTTON'),
      reverseButtons: true
    })
    .then(async (result) => {
      if (result.isConfirmed) {
        await removeWorkout({
          id,
          success: () => toast.success(translator.t('WORKOUTS.LIST.DELETE_ACTION.SUCCESS')),
          error: (error) => toast.error(error.message)
        });
      }
    })
}
const changePage = async (page) => {
  config.value.page = page;
  await getWorkouts(config.value);
}
</script>
