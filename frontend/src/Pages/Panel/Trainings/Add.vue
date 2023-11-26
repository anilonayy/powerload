<template>
  <PanelLayout class="p-5">
    <Panel class="lg:px-8">
      <PanelHeader
        class="p-2"
        title="Antrenman Ekle"
        description="Antrenmanına günler ekleyebilir ,günlere isim verebilir, antrenman anında bu günlere direkt tıklayarak erişebilirsin!"
      />

      <TrainBuilder />
      
    </Panel>
  </PanelLayout>
</template>

<script setup>
import PanelLayout from '@/Layouts/PanelLayout.vue'
import Panel from '@/Components/Form/Panel.vue'
import PanelHeader from '@/Components/Panel/PanelHeader.vue'
import TrainBuilder from '@/Components/Panel/Add/TrainBuilder.vue'
</script>