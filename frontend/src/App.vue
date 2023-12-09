<template>
  <UserLayout>
        <LayoutContainer>
            <RouterView />
        </LayoutContainer>
    </UserLayout>
</template>



<script setup>
  import UserLayout from '@/Layouts/UserLayout.vue';
  import LayoutContainer from '@/Components/Shared/LayoutContainer.vue';
</script>