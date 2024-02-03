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

        <TableWrapper v-if="workoutLogs.length">
          <table
            class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 border"
          >
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
                v-for="(log, index) in workoutLogs"
                :key="index"
                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
              >
                <th
                  scope="row"
                  class="px-6 py-4 font-bold text-gray-900 whitespace-nowrap dark:text-white"
                >
                  <router-link
                    :to="{ name: 'workout', params: { trainId: log.workout.id } }"
                    class="text-gray-900 font-bold dark:text-blue-500 flex items-center gap-3"
                  >
                    {{ log.workout?.name }}
                    <RightIcon class="h-4 w-4 inline" />
                    {{ log.workout_day?.name }}
                  </router-link>
                </th>
                <td class="px-6 py-4">{{ log?.duration }}</td>
                <td class="px-6 py-4">{{ log?.workout_date }}</td>
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
    </Panel>
  </div>
</template>

<script setup>
import {onMounted, ref} from 'vue'
import workoutLogService from '@/services/workoutLogService'

import Panel from '@/components/shared/Panel.vue'
import PanelHeader from '@/components/shared/PanelHeader.vue'
import TableWrapper from '@/components/shared/TableWrapper.vue'
import RightIcon from '@/components/icons/RightIcon.vue'
import HistorySkeleton from '@/components/skeletons/HistorySkeleton.vue'

const workoutLogs = ref([])
const loaded = ref(false)

onMounted(async () => {
  try {
    workoutLogs.value = (await workoutLogService.getAllLogs()).data
    loaded.value = true
  } catch (error) {
    console.log('error :>> ', error)
  }
})
</script>
