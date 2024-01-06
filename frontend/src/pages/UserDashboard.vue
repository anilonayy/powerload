<template>
    <div>
        <Panel class="w-full p-4">
            <PanelHeader class="mb-0">
                <template v-slot:title> <div class="text-center">Genel Bakış</div> </template>
            </PanelHeader>

            <div id="stats" class="flex flex-col gap-8">
                <TopStats />
                <MiddleStats />
                <BottomStats />
            </div>
        </Panel>
    </div>
</template>

<script setup>
import Panel from '@/components/shared/Panel.vue';
import PanelHeader from '@/components/shared/PanelHeader.vue';
import TopStats from '@/components/pages/UserDashboard/TopStats.vue';
import MiddleStats from '@/components/pages/UserDashboard/MiddleStats.vue';
import BottomStats from '@/components/pages/UserDashboard/BottomStats.vue';
</script>