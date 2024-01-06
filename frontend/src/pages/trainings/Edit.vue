<template>
    <Panel>
      <BackButton :to="{ name: 'training-list' }">Antrenmanlara Dön</BackButton>

      <PanelHeader class="p-2">
        <template v-slot:title> Antrenmanını Düzenle </template>
        <template v-slot:description> Antrenmanına günler ekleyebilir ,günlere isim verebilir, antrenman anında bu günlere direkt tıklayarak erişebilirsin! </template>
<<<<<<< HEAD
        <hr>
=======
>>>>>>> f276ca3718923ea6c93d52697d34f99363aedc6d
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