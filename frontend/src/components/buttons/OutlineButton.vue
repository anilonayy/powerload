<template>
  <ButtonCmp :class="defaultClasses">
    <slot />
  </ButtonCmp>
</template>

<script>
import ButtonCmp from './ButtonCmp.vue';

export default {
    data() {
        return {
            defaultClasses: 'border-2 border-gray-300'
        }
    },
    components: {
        ButtonCmp
    }
}
</script>

<style>


</style>