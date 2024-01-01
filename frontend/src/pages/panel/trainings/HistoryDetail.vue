<template>
    <div>
        <Panel>
            <HistoryDetailSkeleton v-if="!loaded" />
            <div v-else>
                <back-button> Geri Dön </back-button>

                <TrainResults :data="trainLog"></TrainResults>
            </div>
        </Panel>
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import { useRoute } from "vue-router";
import trainingLogService from '@/services/trainingLogService';
import router from "@/router";

import Panel from "@/components/form/Panel.vue";
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