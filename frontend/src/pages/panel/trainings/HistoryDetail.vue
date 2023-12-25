<template>
    <div>
        <Panel>
            <back-button>
                Geri Dön
            </back-button>

            <section class="mt-12">
                <div class="top-info-boxes-group flex flex-col md:flex-row justify-between text-sm md:text-base">
                    <div class="left-info-boxes flex flex-col gap-1 ">
                        <div class="info-box flex gap-3">
                            <div class="font-extralight">Antrenman Başlangıç: </div>
                            <div class="font-semibold"> {{ trainLog.created_at }} </div>
                        </div>

                        <div class="info-box flex gap-3">
                            <div class="font-extralight">Antrenman Bitiş: </div>
                            <div class="font-semibold"> {{ trainLog.training_end_time }} </div>
                        </div>

                        <div class="info-box flex gap-3">
                            <div class="font-extralight">Antrenman Süresi: </div>
                            <div class="font-semibold"> {{ trainingTime() }} </div>
                        </div>
                    </div>
                    <div class="right-info-boxes flex flex-col">
                            <div class="info-box flex gap-3">
                                <div class="font-extralight">Antrenman Adı: </div>
                                <div class="font-semibold"> {{ trainLog.training.name }} </div>
                            </div>

                            <div class="info-box flex gap-3">
                                <div class="font-extralight">Antrenman Günü: </div>
                                <div class="font-semibold"> {{ trainLog.training_day.name }} </div>
                            </div>
                    </div>
                </div>
            </section>

            <section>
                <div id="training-header" class="my-4">

                </div>

                <div id="trainings" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-3">
                    <div v-for="(exercise, index) in trainLog.exercises" :key="index">
                        <div class="w-full border border-1 border-gray-300 rounded-md p-2">
                                <div class="card-header font-semibold text-center">
                                    {{ exercise.exercise.name }}
                                </div>
                                <hr>

                                <div class="card-body flex flex-col gap-2">
                                    
                                </div>
                        </div>
                    </div>
                </div>
            </section>
            
        </Panel>
    </div>
</template>

<script setup>
import { onMounted, inject, ref } from "vue";
import { useRoute } from "vue-router";
import Panel from "@/components/form/Panel.vue";
import BackButton from "@/components/buttons/BackButton.vue";
import moment from 'moment';

const axios = inject('axios');
const router = useRoute();

const trainLog = ref({
    training: {
        name: '',
        id: '',
    },
    training_day: {
        name: '',
        id: '',
    },
    exercises: [],
});

onMounted(async () => {
    try {
        const trainLogId = router.params.trainingLogId;
        const response = await axios.get(`/training-logs/${ trainLogId }`);
        trainLog.value = response.data;
    } catch (error) {
        console.error('error :>> ', error);
    }
});

const trainingTime = () => {
    const startTime = moment(trainLog.value.created_at);
    const endTime = moment(trainLog.value.training_end_time);

    return moment.duration(endTime.diff(startTime)).humanize();
}

</script>