import Swal from 'sweetalert2/dist/sweetalert2.min.js';

export default {
  install: (app) => {
    // SweetAlert nesnesini global olarak tanımla
    app.provide('toast', Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.onmouseenter = Swal.stopTimer;
          toast.onmouseleave = Swal.resumeTimer;
        }
      }));
  }
};