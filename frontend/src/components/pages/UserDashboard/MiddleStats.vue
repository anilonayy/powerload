<template>
  <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
    <div class="sm:col-span-2 lg:col-span-2">
      <Chart />
    </div>
    <div class="sm:col-span-2 lg:col-span-1">
      <LastWorkout />
    </div>
  </div>
</template>

<script setup>
import Chart from '@/components/pages/UserDashboard/Chart.vue';
import LastWorkout from '@/components/pages/UserDashboard/LastWorkouts.vue';
</script>
