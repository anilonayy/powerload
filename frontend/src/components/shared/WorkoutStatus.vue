<template>
  <div v-if="code === 0" class="inline-flex self-center bg-yellow-400 text-white text-[.6rem] rounded-md px-1">
    {{ $t('DASHBOARD.LAST_WORKOUTS.STATUS.CONTINUE') }}
  </div>
  <div v-else-if="code === 1" class="inline-flex self-center bg-green-400 text-white text-[.6rem] rounded-md px-1">
    {{ $t('DASHBOARD.LAST_WORKOUTS.STATUS.COMPLETED') }}
  </div>
  <div v-else class="inline-flex self-center bg-red-400 text-white text-[.6rem] rounded-md px-1">
    {{ $t('DASHBOARD.LAST_WORKOUTS.STATUS.CANCELED') }}
  </div>
</template>

<script setup>
import { defineProps } from 'vue'

defineProps({
  code: {
    type: Number,
    required: true
  }
})
</script>
