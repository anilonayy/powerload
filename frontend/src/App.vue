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

import toastr from 'toastr';

toastr.options = {
  closeButton: true,
    newestOnTop: false,
  progressBar: true,
  positionClass : "toast-top-right",
};
</script>