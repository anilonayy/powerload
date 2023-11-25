<template>
    <HeaderText class="text-center">#GymSide </HeaderText>
    <div class="flex gap-4">
        <PanelAside/>
        <Panel class="w-full">
            <slot/>
        </Panel>
        <div class="main">
           
        </div>
        
    </div>
</template>

<script setup>
import Panel from "@/Components/Form/Panel.vue";
import HeaderText from "../Components/Shared/HeaderText.vue";
import PanelAside from '@/Components/Panel/PanelAside.vue';

</script>

