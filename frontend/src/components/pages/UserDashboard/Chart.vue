<template>
    <div class="h-full">
        <div class="h-full" v-if="loaded">
        <div class="grid grid-cols-12 items-center gap-3">
                <div class="title font-semibold text-lg col-span-12 md:col-span-4">{{ $t('DASHBOARD.CHART.TITLE') }}</div>

                <div class="col-span-12 md:col-span-4">
                    <Label class="text-sm">{{ $t('DASHBOARD.CHART.FREQUENCY') }}</Label>
                    <AgSelect 
                        :options="dateFrequencies"
                        read-text="name"
                        read-value="value"
                        v-model="currentFrequency"
                        class="w-full"
                        @updateModel="updateFrequencyModel($event)"
                    />
                </div>

                <div class="col-span-12 md:col-span-4">
                    <Label class=text-sm>{{ $t('DASHBOARD.CHART.EXERCISE') }}</Label>
                    <AgSelect
                        :options="options"
                        read-text="name"
                        read-value="value"
                        placeholder="EXERCISE.SELECT"
                        search
                        v-model="currentExercise"
                        @updateModel="updateExercise($event)"
                    >
                    <template #option="option">
                        <div class="flex gap-3">
                            
                            <img v-if="option?.category?.length" :src="getIconName(option.category)"  width="25" class="object-contain">
                            <div> {{ option.text }}</div>
                        </div>
                    </template>
                </AgSelect>
                </div>
        </div>
        <div class="body mt-4" ref="chartWrapper">
            <canvas id="chart" ref="chart" width="400" height="auto"></canvas>
        </div>
        </div>
        <GraphSkeleton v-else />
    </div>
</template>

<script setup>
import {computed, inject, onMounted, ref} from 'vue'
import {useI18n} from 'vue-i18n';
import {useStore} from 'vuex';
import {useRoute} from 'vue-router';
import {debounce, getIconName} from '@/utils/helpers'
import dashboardService from '@/services/dashboardService';
import Chart from 'chart.js/auto'

import GraphSkeleton from '@/components/skeletons/UserDashboard/GraphSkeleton.vue'
import Label from '@/components/form/Label.vue'
import AgSelect from '@/components/shared/AgSelect.vue'

const store = useStore();
const t = useI18n().t;
const toast = inject('toast');
const route = useRoute();
const loaded = ref(false);


const dateFrequencies = ref([
    {
        name: t('DASHBOARD.CHART.FREQUENCY_OPTIONS.YEARLY.TEXT'),
        value: t('DASHBOARD.CHART.FREQUENCY_OPTIONS.YEARLY.VALUE')
    },
    {
        name: t('DASHBOARD.CHART.FREQUENCY_OPTIONS.MONTHLY.TEXT'),
        value: t('DASHBOARD.CHART.FREQUENCY_OPTIONS.MONTHLY.VALUE')
    },
    {
        name: t('DASHBOARD.CHART.FREQUENCY_OPTIONS.WEEKLY.TEXT'),
        value: t('DASHBOARD.CHART.FREQUENCY_OPTIONS.WEEKLY.VALUE')
    }
]);

const options = computed(() => store.getters['_exerciseList']);
const currentExercise = ref({
    category: "Bacak",
    text: "Bench Press",
    value: 7
});
const currentFrequency = ref(dateFrequencies.value[0]);
const chartWrapper = ref();

onMounted(async () => {
    await buildChart({
        exercise_id: currentExercise.value.value,
        date_frequency: currentFrequency.value.value
    });

    loaded.value = true;
});

const buildChart = async (options = {}) => {
    setTimeout(async () => {
        loaded.value = false;

        if(chartWrapper?.value?.children?.length === 0) {
            return;
        }

        chartWrapper.value.children[0].remove();
        const node = document.createElement('canvas');
        node.setAttribute('id', 'chart');
        chartWrapper.value.appendChild(node);  

        loaded.value = true;

        const response = await dashboardService.getExerciseHistory(options);

        const labels = [];
        const values = [];

        response.data.map((data) => {
            labels.push(data.label);
            values.push(data.data.max ?? 0);
        });

        if (values.every(value => value === 0)) {
            toast.warning(t('DASHBOARD.CHART.NO_DATA_MESSAGE'));
        }

        new Chart('chart', {
            type: 'line',
            data: {
            labels,
            datasets: [{
                label: 'kg',
                data: values,
                borderWidth: 1
            }]
            },
            options: {
            scales: {
                y: {
                beginAtZero: true
                }
            }
            }
        });
    }, 100);
}

const updateExercise = ($event) => {
    currentExercise.value = $event;
    reBuildChart();
}

const updateFrequencyModel = ($event) => {
    currentFrequency.value = $event;
    reBuildChart();
}

const reBuildChart = () => {
    const exercise_id = Number(currentExercise.value.value);
    const date_frequency = Number(currentFrequency.value.value);

    exercise_id && date_frequency && buildChart({exercise_id,date_frequency});
}


window.addEventListener('resize', debounce(() => {
    if(route.name === 'dashboard') {
        reBuildChart();
    }
}, 300));
</script>