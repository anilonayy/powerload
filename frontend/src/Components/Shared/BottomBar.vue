<template>
    <div v-if="isAuthenticated && componentWillShow"
        class="fixed bottom-0 left-0 w-full flex justify-center items-center h-14"
    >

    <router-link :to="{name: 'on-train', params:{ trainId: getTraining.trainId } }">
        <ButtonCmp class="w-full h-full bg-indigo-600 text-white border-indigo-600 rounded-none">
            <div v-if="trainingStep === 0">
                Antrenmana Başla!
            </div>
            <div v-else>
                Antrenmana Devam Et!  
            </div>
        </ButtonCmp>
    </router-link>
    </div>
</template>


<script setup>
import { computed } from 'vue';
import { useRoute } from 'vue-router';
import { useStore } from 'vuex';
import ButtonCmp from '@/Components/buttons/ButtonCmp.vue';

const store = useStore();
const route = useRoute();

const isAuthenticated = computed(() => store.getters['_isAuthenticated']);
const trainingStep = computed(() => store.getters['_getTrainingStep']);
const getTraining = computed(() => store.getters['_getTraining']);
const componentWillShow = route.name  !== "on-train";
</script>