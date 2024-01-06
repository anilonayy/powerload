<template>
    <div class="">

        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4 mt-4">
            <div class="flex items-center justify-start text-center gap-4 bg-purple-200  p-2 rounded-md">
                <div class="flex items-center justify-center w-10 h-10 mb-3 rounded-full bg-purple-50 sm:w-12 sm:h-12">
                    <DumbellIcon />
                </div>

                <div class="text-start" v-if="loaded" >
                    <h6 class="text-2xl font-semibold text-deep-purple-accent-400">123</h6>
                    <p>Antrenman</p>
                </div>

                <TopStatsSkeleton v-else />
            </div>

            <div class="flex items-center justify-start text-center gap-4 bg-indigo-200  p-2 rounded-md">
                <div class="flex items-center justify-center w-10 h-10 mb-3 rounded-full bg-indigo-50 sm:w-12 sm:h-12">
                    <PassedTimeIcon />
                </div>

                <div class="text-start" v-if="loaded">
                    <h6 class="text-2xl font-semibold text-deep-purple-accent-400">1s 45dk</h6>
                    <p>Ortalama Süre</p>
                </div>
                <TopStatsSkeleton v-else />
            </div>
            
            <div class="flex items-center justify-start text-center gap-4 bg-blue-200  p-2 rounded-md">
                <div class="flex items-center justify-center w-10 h-10 mb-3 rounded-full bg-blue-50 sm:w-12 sm:h-12">
                    <CountSticksIcon />
                </div>

                <div class="text-start" v-if="loaded">
                    <h6 class="text-2xl font-semibold text-deep-purple-accent-400">6</h6>
                    <p>Ortalama Hareket</p>
                </div>
                <TopStatsSkeleton v-else />
            </div>

            <div class="flex items-center justify-start text-center gap-4 bg-red-200  p-2 rounded-md">
                <div class="flex items-center justify-center w-10 h-10 mb-3 rounded-full bg-blue-50 sm:w-12 sm:h-12">
                    <CountSticksIcon />
                </div>

                <div class="text-start" v-if="loaded">
                    <h6 class="text-2xl font-semibold text-deep-purple-accent-400">?</h6>
                    <p>?</p>
                </div>
                <TopStatsSkeleton v-else />
            </div>
        </div>
    </div>
</template>

<script setup>
import DumbellIcon from '@/components/icons/DumbellIcon.vue';
import PassedTimeIcon from '@/components/icons/PassedTimeIcon.vue';
import CountSticksIcon from '@/components/icons/CountSticksIcon.vue';
import TopStatsSkeleton from '@/components/skeletons/UserDashboard/TopStatsSkeleton.vue';
import { onMounted, ref } from 'vue';


const loaded = ref(false);

onMounted(() => {

})
</script>