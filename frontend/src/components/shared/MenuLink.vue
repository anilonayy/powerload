<template>
  <li>
    <router-link :to="to" class="hover:underline p-2">
      <slot />
    </router-link>
  </li>
</template>

<script>
export default {
  props: ['to']
};
</script>
