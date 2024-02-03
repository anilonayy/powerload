<template>
    <div v-if="isAuthenticated && componentWillShow"
        class="fixed bottom-0 left-0 w-full flex justify-center items-end h-10 md:hidden"
    >
    <div class="w-full h-full" @click="handleWorkout()">
        <div class="w-full h-full flat-btn bg-indigo-800 hover:bg-indigo-600 active:bg-indigo-700  text-white">
            <div v-if="!isWorkoutSelected">
                {{ $t('BOTTOM_BAR.START_WORKOUT') }}
            </div>
            <div v-else>
                {{ $t('BOTTOM_BAR.CONTINUE_WORKOUT') }}
            </div>
        </div>
    </div>
    </div>
</template>


<script setup>
import {computed, inject, ref, watch} from 'vue';
import {useRoute} from 'vue-router';
import {useStore} from 'vuex';
import router from '@/router';
import workoutLogService from '@/services/workoutLogService';
import {useI18n} from 'vue-i18n';

const store = useStore();
const route = useRoute();
const toast = inject('toast');
const { t } = useI18n();

const isAuthenticated = computed(() => store.getters['_isAuthenticated']);
const workoutLogId = computed(() => store.getters['_workoutLogId']);
const isWorkoutSelected = computed(() => store.getters['_isWorkoutSelected']);
const componentWillShow = ref(route.name  !== "on-workout");


const handleWorkout = async () => {
    try {
        if (isWorkoutSelected.value) {
            router.push({ name: 'on-workout', params: { workoutLogId: workoutLogId.value} });
            return;
        }

        const response = await workoutLogService.createEmptyLog();

        router.push({ name: 'on-workout', params: { workoutLogId: response.data.id} });
    } catch (error) {
        console.error(error);
        toast.error(t('ERRORS.UNKNOWN'))
    }
}


watch(
    () => route.fullPath,
    async (newUrl, oldUrl) => {
        const hiddenUrls = ['antrenmanlar/', 'on-workout', 'antrenman-tamamlandi'];
        componentWillShow.value = !hiddenUrls.some(url => newUrl.includes(url));

        if(isAuthenticated.value) {
            if(!isWorkoutSelected.value) {
                await workoutLogService.getLastLog();
            }
        }
    })
</script>