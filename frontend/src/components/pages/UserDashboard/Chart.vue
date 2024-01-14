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
                        placeholder="Select Exercise"
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
        <div class="body" ref="chartWrapper">
            <canvas id="chart" ref="chart" width="400" height="auto"></canvas>
        </div>
        </div>
        <GraphSkeleton v-else />
    </div>
</template>

<script setup>
import { ref, computed, onMounted, inject } from 'vue'
import { useStore } from 'vuex';
import { useRoute } from 'vue-router';
import { getIconName, getFrequencyForSelect, debounce } from '@/utils/helpers'
import dashboardService from '@/services/dashboardService';
import Chart from 'chart.js/auto'

import GraphSkeleton from '@/components/skeletons/UserDashboard/GraphSkeleton.vue'
import Label from '@/components/form/Label.vue'
import AgSelect from '@/components/shared/AgSelect.vue'

const store = useStore();
const toast = inject('toast');
const route = useRoute();
const loaded = ref(false);

const dateFrequencies = getFrequencyForSelect();

const options = computed(() => store.getters['_exerciseList']);
const currentExercise = ref({
    category: "Bacak",
    text: "Bench Press",
    value: 7
});
const currentFrequency = ref(dateFrequencies[0]);
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
            toast.warning('Bu hareket için henüz veri bulunmamaktadır.');
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
    const exercise_id = currentExercise.value.value;
    const date_frequency = currentFrequency.value.value;

    exercise_id && date_frequency && buildChart({exercise_id,date_frequency});
}


window.addEventListener('resize', debounce(() => {
    if(route.name === 'dashboard') {
        reBuildChart();
    }
}, 300));
</script>