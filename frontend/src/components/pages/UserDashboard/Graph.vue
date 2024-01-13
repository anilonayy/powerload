<template>
    <div class="h-full">
        <div class="h-full" v-if="loaded">
        <div class="grid grid-cols-12 items-center">
                <div class="title  font-semibold text-lg col-span-12 md:col-span-8">Harekete göre ağırlık grafiği</div>
                <AgSelect
                :options="options"
                read-text="name"
                read-value="value"
                placeholder="Select Exercise"
                search
                v-model="x"
                class="col-span-12 md:col-span-4 mx-auto"
                @updateModel="updateModel($event)"
                >
                <template #option="option">
                    <div class="flex gap-3">
                    <img :src="getIconName(option.category)"  width="25" class="object-contain">
                    <div>
                        {{ option.text }}
                    </div>
                    </div>
                </template>
            </AgSelect>
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
import { getIconName } from '@/utils/helpers'
import dashboardService from '@/services/dashboardService';
import Chart from 'chart.js/auto'

import GraphSkeleton from '@/components/skeletons/UserDashboard/GraphSkeleton.vue'
import AgSelect from '@/components/shared/AgSelect.vue'

const store = useStore();
const toast = inject('toast');

const options = computed(() => store.getters['_exerciseList']);
const currentExercise = ref({
    category: "Bacak",
    text: "Squat",
    value: 7
});
const date_frequency = ref(2);

const loaded = ref(false);
const chartWrapper = ref();

onMounted(async () => {
    await buildChart({
        exercise_id: currentExercise.value.value,
        date_frequency: date_frequency.value
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

const updateModel = ($event) => {
    buildChart({
        exercise_id: $event,
        date_frequency: date_frequency.value
    })
}
</script>