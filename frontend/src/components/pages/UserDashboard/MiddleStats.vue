<template>
    <div class="grid  sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <div class="sm:col-span-2 lg:col-span-2">
            <Graph />    
        </div> 
        <div class="sm:col-span-2 lg:col-span-1">
            <LastTraining />
        </div>
    </div>
</template>

<script setup>
import Graph from "@/components/pages/UserDashboard/Graph.vue";
import LastTraining from "@/components/pages/UserDashboard/LastTrainings.vue";
</script>