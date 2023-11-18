<template>
  <ButtonCmp class="border-2 border-gray-200">
    <slot />
  </ButtonCmp>
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