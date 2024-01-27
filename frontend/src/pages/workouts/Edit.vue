<template>
    <Panel>
      <BackButton :to="{ name: 'workout-list' }">{{ $t('TRAININGS.EDIT.BACK_TRAININGS') }}</BackButton>

      <PanelHeader class="p-2">
        <template v-slot:title>{{ $t('TRAININGS.EDIT.TITLE') }} </template>
        <template v-slot:description> {{ $t('TRAININGS.EDIT.DESCRIPTION') }} </template>
        <hr>
      </PanelHeader>

      <WorkoutBuilder :workout="workout" />
    </Panel>
</template>

<script setup>
import Panel from '@/components/shared/Panel.vue'
import PanelHeader from '@/components/shared/PanelHeader.vue'
import WorkoutBuilder from '@/components/workouts/WorkoutBuilder.vue'
import BackButton from '@/components/buttons/BackButton.vue'
</script>