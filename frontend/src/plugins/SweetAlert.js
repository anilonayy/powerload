import Swal from 'sweetalert2/dist/sweetalert2.min.js';
import 'sweetalert2/dist/sweetalert2.min.css';

export default {
  install: (app) => {
    // SweetAlert nesnesini global olarak tanımla
    app.provide('swal', Swal);
  }
};
