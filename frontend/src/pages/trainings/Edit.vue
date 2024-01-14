<template>
    <Panel>
      <BackButton :to="{ name: 'training-list' }">{{ $t('TRAININGS.EDIT.BACK_TRAININGS') }}</BackButton>

      <PanelHeader class="p-2">
        <template v-slot:title>{{ $t('TRAININGS.EDIT.TITLE') }} </template>
        <template v-slot:description> {{ $t('TRAININGS.EDIT.DESCRIPTION') }} </template>
        <hr>
      </PanelHeader>

      <TrainBuilder :training="training" />
    </Panel>
</template>

<script setup>
import Panel from '@/components/shared/Panel.vue'
import PanelHeader from '@/components/shared/PanelHeader.vue'
import TrainBuilder from '@/components/panel/add/TrainBuilder.vue'
import BackButton from '@/components/buttons/BackButton.vue'
</script>