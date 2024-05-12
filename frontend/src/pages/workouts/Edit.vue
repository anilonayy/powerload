<template>
  <Panel>
    <BackButton :to="{ name: 'workout-list' }">{{ $t('WORKOUTS.EDIT.BACK_WORKOUTS') }}</BackButton>

    <PanelHeader class="p-2">
      <template v-slot:title>{{ $t('WORKOUTS.EDIT.TITLE') }} </template>
      <template v-slot:description> {{ $t('WORKOUTS.EDIT.DESCRIPTION') }} </template>
      <hr />
    </PanelHeader>

    <WorkoutBuilder :workout="workout" />
  </Panel>
</template>

<script setup>
import Panel from '@/components/shared/Panel.vue';
import PanelHeader from '@/components/shared/PanelHeader.vue';
import WorkoutBuilder from '@/components/workouts/WorkoutBuilder.vue';
import BackButton from '@/components/buttons/BackButton.vue';
</script>
