<template>
  <div class="inline-flex gap-1" id="duration-text">
    <div v-if="value.h">
      <span>{{ value.h }}</span>
      <span class="text-xs">{{ $t('DATE.HOUR.MEDIUM') }}</span>
    </div>
    <div v-if="value.i">
      <span>{{ value.i }}</span>
      <span class="text-xs">{{ $t('DATE.MINUTE.MEDIUM') }}</span>
    </div>
    <div v-if="value.s && (options.s ?? true)">
      <span>{{ value.s }}</span>
      <span class="text-xs">{{ $t('DATE.SECOND.MEDIUM') }}</span>
    </div>
  </div>
</template>

<script setup>
import { defineProps } from 'vue';

const props = defineProps({
  value: {
    type: Object,
    required: true
  },
  options: {
    type: Object,
    default: () => ({})
  }
});
</script>

<style scoped>
#duration-text span {
  padding: 0 1px;
}
</style>
