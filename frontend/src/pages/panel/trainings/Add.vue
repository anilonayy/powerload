<template>
    <Panel>
      <router-link :to="{ name: 'training-list' }">
        <button-cmp class="bg-black text-white flex gap-3">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
        </svg>
          Antrenmanlara Dön
        </button-cmp>
      </router-link>
      <PanelHeader
        class="p-2"
        title="Antrenman Ekle"
        description="Antrenmanına günler ekleyebilir ,günlere isim verebilir, antrenman anında bu günlere direkt tıklayarak erişebilirsin!"
      />

      <TrainBuilder />
      
    </Panel>
</template>

<script setup>
import Panel from '@/components/form/Panel.vue'
import PanelHeader from '@/components/panel/PanelHeader.vue'
import TrainBuilder from '@/components/panel/add/TrainBuilder.vue'
import ButtonCmp from '@/components/buttons/ButtonCmp.vue'
</script>