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
import { onMounted, inject, ref } from "vue";
import { useRoute } from "vue-router";
import Panel from "@/components/form/Panel.vue";
import BackButton from "@/components/buttons/BackButton.vue";
import TrainResults from "@/components/pages/TrainCompleted/TrainResults.vue";
import HistoryDetailSkeleton from '@/components/skeletons/HistoryDetailSkeleton.vue';

const axios = inject('axios');
const router = useRoute();

const loaded = ref(false);
const trainLog = ref({});

onMounted(async () => {
    try {
        const trainLogId = router.params.trainingLogId;
        const response = await axios.get(`/training-logs/${ trainLogId }`);
        trainLog.value = response.data;

        loaded.value = true;
    } catch (error) {
        console.error('error :>> ', error);
    }
});
</script>