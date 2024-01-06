<template>
  <div class="h-full">
    <div class="h-full" v-if="loaded">
      <div class="grid grid-cols-4 items-center">
            <div class="title col-span-2">Harekete göre ağırlık grafiği</div>
            <AgSelect
              :options="options"
              read-text="name"
              read-value="value"
              placeholder="Select Exercise"
              search
              v-model="x"
              class="col-span-2"
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
      <div class="body">
        GRAFİK ALANI
      </div>
    </div>
    <GraphSkeleton v-else />
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useStore } from 'vuex';
import { getIconName } from '@/utils/helpers'

import GraphSkeleton from '@/components/skeletons/UserDashboard/GraphSkeleton.vue'

const store = useStore();

import AgSelect from '@/components/shared/AgSelect.vue'

const options = computed(() => store.getters['_exerciseList']);
const x = ref({});




</script>