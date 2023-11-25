<template>
    <HeaderText class="text-center mb-7">#Powerload </HeaderText>
    <div class="flex gap-4  flex-col md:flex-row">
        <PanelAside/>
        <div class="w-full">
            <slot/>
        </div>
    </div>
</template>

<script setup>
import HeaderText from "@/Components/Shared/HeaderText.vue";
import PanelAside from '@/Components/Panel/PanelAside.vue';
</script>

