<template>
  <div>
    <Panel>
      <HistorySkeleton v-if="!loaded" />
      <div v-else>
        <PanelHeader class="p-2">
          <template v-slot:title> {{ $t('WORKOUT_HISTORY.LIST.TITLE') }} </template>
          <template v-slot:description>
            {{ $t('WORKOUT_HISTORY.LIST.DESCRIPTION') }}
          </template>
          <hr />
        </PanelHeader>
        <TableWrapper v-if="workoutHistories.length">
          <table  class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 border">
            <thead
              class="border bg-neutral-800 font-medium text-white border-black dark:border-neutral-500 dark:bg-neutral-900"
            >
              <tr>
                <th scope="col" class="px-6 py-3">{{ $t('WORKOUT_HISTORY.LIST.TABLE.NAME') }}</th>
                <th scope="col" class="px-6 py-3">{{ $t('WORKOUT_HISTORY.LIST.TABLE.DURATION') }}</th>
                <th scope="col" class="px-6 py-3">{{ $t('WORKOUT_HISTORY.LIST.TABLE.DATE') }}</th>
                <th scope="col" class="px-6 py-3">{{ $t('WORKOUT_HISTORY.LIST.TABLE.SEE') }}</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="(log, index) in workoutHistories"
                :key="index"
                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
              >
                <th
                  scope="row"
                  class="px-6 py-4 font-bold text-gray-900 whitespace-nowrap dark:text-white"
                >
                  <router-link
                    :to="{ name: 'workout', params: { trainId: log.workout.id } }"
                    class="text-gray-900 font-bold dark:text-blue-500 flex items-center gap-1"
                  >
                    {{ log.workout?.name }}
                    <RightIcon class="h-4 w-4 inline" />
                    {{ log.workout_day?.name }}
                  </router-link>
                </th>
                <td class="px-6 py-4">
                  <DynamicDuration :value="log.duration" />
                </td>
                <td class="px-6 py-4">

                  <DynamicDate :value="log.workout_date" type="long" />

                </td>
                <td class="px-6 py-4 flex gap-3">
                  <router-link
                    :to="{ name: 'show-workout-history', params: { workoutLogId: log.id } }"
                  >
                    <div class="orange-btn">{{ $t('WORKOUT_HISTORY.LIST.SEE_BUTTON') }}</div>
                  </router-link>
                </td>
              </tr>
            </tbody>
          </table>
        </TableWrapper>
        <div
          v-else
          class="w-full text-center bg-gray-200 text-gray-800 rounded-md p-3 py-6 text-md"
        >
          <span>{{ $t('WORKOUT_HISTORY.LIST.NO_DATA') }}</span>
        </div>
      </div>
      <Pagination :data="workoutHistories"  @pagination-change-page="changePage($event)"  class="flex items-end me-2" />
    </Panel>
  </div>
</template>

<script setup>
import {onMounted, ref} from 'vue'
import useWorkoutHistory from '@/composables/workoutHistory';

import Panel from '@/components/shared/Panel.vue'
import PanelHeader from '@/components/shared/PanelHeader.vue'
import TableWrapper from '@/components/shared/TableWrapper.vue'
import RightIcon from '@/components/icons/RightIcon.vue'
import HistorySkeleton from '@/components/skeletons/HistorySkeleton.vue'
import Pagination from '@/components/shared/Pagination.vue';
import DynamicDate from '@/components/date/DynamicDate.vue';
import DynamicDuration from "@/components/date/DynamicDuration.vue";

const { workoutHistories, loaded, getWorkoutHistories } = useWorkoutHistory();

const params = ref({
  page: 1,
  take: 10,
  paginate: 1
});

onMounted(async () => {
  await getWorkoutHistories(params.value);
})

const changePage = async (page) => {
  params.value.page = page;

  await getWorkoutHistories(params.value);
}
</script>
