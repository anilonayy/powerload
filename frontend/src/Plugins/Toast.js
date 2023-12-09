import Swal from 'sweetalert2/dist/sweetalert2.min.js';


const swal = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.onmouseenter = Swal.stopTimer;
      toast.onmouseleave = Swal.resumeTimer;
    }
  });



const toast = {
    success: (title) => swal.fire({ icon: 'success', title }),
    warning: (title) => swal.fire({ icon: 'warning', title }),
    error: (title) => swal.fire({ icon: 'error', title }),
};

export default {
  install: (app) => {
    app.provide('toast', toast);
  }
};