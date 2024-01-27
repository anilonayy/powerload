<template>
    <div>
        <Panel>
            <HistoryDetailSkeleton v-if="!loaded" />
            <div v-else>
                <BackButton :to="{ name: 'workout-history' }"> {{ $t('TRAINING_HISTORY.SHOW.BACK_TO_LIST') }}</BackButton>
                <PanelHeader class="p-2">
                    <template v-slot:title> {{ $t('TRAINING_HISTORY.SHOW.TITLE') }} </template>
                    <template v-slot:description> {{ $t('TRAINING_HISTORY.SHOW.DESCRIPTION') }} </template>
                    <hr>
                </PanelHeader>

                <WorkoutResults :data="trainLog" />
            </div>
        </Panel>
    </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import { useRoute } from "vue-router";
import workoutLogService from '@/services/workoutLogService';
import router from "@/router";

import Panel from "@/components/shared/Panel.vue";
import PanelHeader from "@/components/shared/PanelHeader.vue";
import BackButton from "@/components/buttons/BackButton.vue";
import WorkoutResults from "@/components/pages/WorkoutCompleted/WorkoutResults.vue";
import HistoryDetailSkeleton from '@/components/skeletons/HistoryDetailSkeleton.vue';

const loaded = ref(false);
const trainLog = ref({});

onMounted(async () => {
    try {
        const trainLogId = useRoute().params.workoutLogId;

        if(isNaN(Number(trainLogId))) {
            router.push({ name: 'workout-history' });

            return;
        }

        trainLog.value = (await workoutLogService.getLog(trainLogId)).data;
        loaded.value = true;
    } catch (error) {
        console.error('error :>> ', error);
    }
});
</script>