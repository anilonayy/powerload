import axios from 'axios';

const createAxiosInstance = () => {

 const instance = axios.create({
   baseURL: 'http://127.0.0.1:8000/api',
   withCredentials: false,
 });

 // Request interceptor
 instance.interceptors.request.use(
   config => {
     // Bearer token'ı ekleyin
     config.headers.Authorization = `Bearer ${ localStorage.getItem('_token') }`;
     return config;
   },
   error => {
     return Promise.reject(error);
   }
 );

 // Response interceptor
 instance.interceptors.response.use(
   response => {
     return response.data;
   },
   error => {
     // Token hatası kontrolü
     if (error.response.status === 401) {
       // Token geçerliliğini kaybederse burada işlemleri yapabilirsiniz.
       // Örneğin, Vuex'taki token'ı temizleyebilir ve kullanıcıyı oturumdan çıkarabilirsiniz.
       localStorage.removeItem('_token');
     }
     return Promise.reject(error);
   }
 );

 return instance;
};

export default createAxiosInstance();
