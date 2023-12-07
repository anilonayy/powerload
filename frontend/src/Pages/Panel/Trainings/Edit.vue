<template>
  <PanelLayout class="p-5">
    <Panel>
      <router-link :to="{ name: 'trainings' }">
        <button-cmp class="bg-black text-white">
          Antrenmanlara Dön
        </button-cmp>
      </router-link>
      <PanelHeader
        class="p-2"
        title="Antrenmanını Düzenle"
        description="Antrenmanına günler ekleyebilir ,günlere isim verebilir, antrenman anında bu günlere direkt tıklayarak erişebilirsin!"
      />

      <TrainBuilder :training="training" />
    </Panel>
  </PanelLayout>
</template>

<script setup>
import PanelLayout from '@/Layouts/PanelLayout.vue'
import Panel from '@/Components/Form/Panel.vue'
import PanelHeader from '@/Components/Panel/PanelHeader.vue'
import TrainBuilder from '@/Components/Panel/Add/TrainBuilder.vue'
import ButtonCmp from '@/Components/buttons/ButtonCmp.vue'
</script>