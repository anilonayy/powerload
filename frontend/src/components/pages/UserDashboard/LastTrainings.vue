<template>
    <Panel class="md:p-4">
        <div id="card-header" class="border-b border-1 mb-2 pb-2 relative">
            <h2 class="text-2xl font-bold">Son 5 antrenman</h2>
            
            <div class="text-xs underline">
                <router-link :to="{ name: 'training-history' }">tümünü gör</router-link>
            </div>
        </div>

        <div class="space-y-4" v-if="loaded">
            <div v-for="(data, index) in list" :key="index" >
                <div class="p-4 pb-1 bg-white border rounded-xl text-gray-800 space-y-2">
                    <div class="flex justify-between">
                        <div class="text-gray-400 text-xs">1s 25dk sürdü</div>
                        <div class="text-gray-400 text-xs">4h</div>
                    </div>
                    <div class="font-semibold hover:text-yellow-800 hover:underline cursor-pointer">PPL -> Bacak Günü </div>
                </div>
            </div>
        </div>
        <LastTrainingsSkeleton v-else />

        
    </Panel>
</template>


<script setup>
import { ref } from "vue";

import Panel from '@/components/shared/Panel.vue';
import LastTrainingsSkeleton from '@/components/skeletons/UserDashboard/LastTrainingsSkeleton.vue';

const loaded = ref(false);
const list = ref([
    {
        id:1,
        name: 'sadasdas adsasdsadas'    
    },
    {
        id:1,
        name: 'sadasdas adsasdsadas'    
    },
    {
        id:1,
        name: 'sadasdas adsasdsadas'    
    },
    {
        id:1,
        name: 'sadasdas adsasdsadas'    
    },
    {
        id:1,
        name: 'sadasdas adsasdsadas'    
    }
]);
</script>