<template>
  <button-cmp class="border-2 border-gray-200">
    <slot />
  </button-cmp>
</template>

<script>
import ButtonCmp from '@/Components/buttons/ButtonCmp.vue';

export default {
    components: {
        ButtonCmp
    }
}
</script>

<style>


</style>