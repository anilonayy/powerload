<template>
  <div class="mb-5 ps-0">
    <HeaderText class="font-semibold lg:text-md mt-0">
      <slot name="title" />
    </HeaderText>

    <p class="leading-5 text-sm text-gray pb-2">
      <slot name="description" />
    </p>

    <slot />
  </div>
</template>

<script setup>
import HeaderText from '@/components/shared/HeaderText.vue';
</script>
