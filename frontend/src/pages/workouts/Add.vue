<template>
    <Panel>
      <BackButton :to="{ name: 'workout-list' }">{{ $t('TRAININGS.ADD.BACK_TRAININGS') }}</BackButton>
      
      <PanelHeader class="p-2">
        <template v-slot:title>{{ $t('TRAININGS.ADD.TITLE') }}</template>
        <template v-slot:description> {{ $t('TRAININGS.ADD.DESCRIPTION') }}</template>
        <hr>
      </PanelHeader>

      <WorkoutBuilder />
    </Panel>
</template>

<script setup>
import Panel from '@/components/shared/Panel.vue'
import PanelHeader from '@/components/shared/PanelHeader.vue'
import WorkoutBuilder from '@/components/workouts/WorkoutBuilder.vue'
import BackButton from '@/components/buttons/BackButton.vue'
</script>