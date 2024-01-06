<template>
    <div>
        <Panel>
            <HistoryDetailSkeleton v-if="!loaded" />
            <div v-else>
                <BackButton :to="{ name: 'training-history' }"> Antrenman Geçmişine Dön </BackButton>
                <PanelHeader class="p-2">
                    <template v-slot:title> Antrenman Sonuçları </template>
                    <template v-slot:description> Antrenman sonuçlarını görebilirsin! </template>
                </PanelHeader>

                <TrainResults :data="trainLog" />
            </div>
        </Panel>
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import { useRoute } from "vue-router";
import trainingLogService from '@/services/trainingLogService';
import router from "@/router";

import Panel from "@/components/shared/Panel.vue";
import PanelHeader from "@/components/shared/PanelHeader.vue";
import BackButton from "@/components/buttons/BackButton.vue";
import TrainResults from "@/components/pages/TrainCompleted/TrainResults.vue";
import HistoryDetailSkeleton from '@/components/skeletons/HistoryDetailSkeleton.vue';

const loaded = ref(false);
const trainLog = ref({});

onMounted(async () => {
    try {
        const trainLogId = useRoute().params.trainingLogId;

        if(isNaN(Number(trainLogId))) {
            router.push({ name: 'training-history' });

            return;
        }

        trainLog.value = (await trainingLogService.getLog(trainLogId)).data;
        loaded.value = true;
    } catch (error) {
        console.error('error :>> ', error);
    }
});
</script>