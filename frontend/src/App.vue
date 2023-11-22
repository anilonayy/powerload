<template>
  <RouterView />
</template>



<script>

import toastr from 'toastr';

toastr.options = {
  closeButton: true,
    newestOnTop: false,
  progressBar: true,
  positionClass : "toast-top-right",
};
</script>