<template>
   <div class="aside w-72">
      <Panel class="p-4 d-flex gap-3 flex-col">
               <BadgeLink :to="{ name: 'genel-bakis' }"  :class="{ active: routeName === 'genel-bakis' }" > 
                  <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M17 12h-2l-2 5-2-10-2 5H7"/></svg>
                  Genel Bakış
               </BadgeLink> 

               <BadgeLink :to="{ name: 'profil-ayarlari' }"> 
                  <svg class="mr-2" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 21a8 8 0 0 1 10.434-7.62"/><circle cx="10" cy="8" r="5"/><circle cx="18" cy="18" r="3"/><path d="m19.5 14.3-.4.9"/><path d="m16.9 20.8-.4.9"/><path d="m21.7 19.5-.9-.4"/><path d="m15.2 16.9-.9-.4"/><path d="m21.7 16.5-.9.4"/><path d="m15.2 19.1-.9.4"/><path d="m19.5 21.7-.4-.9"/><path d="m16.9 15.2-.4-.9"/></svg>
                  Profil Ayarları
               </BadgeLink> 
      </Panel>      
   </div>
</template>


<script setup>
import BadgeLink from "@/Components/Shared/BadgeLink.vue";
import Panel from '@/Components/Form/Panel.vue';
</script>



<style scoped>
.router-link-active {
      background-color: rgb(219 234 254 / .5);
}

.router-link-active:hover {
      background-color: rgb(219 234 254 / .3);
}
</style>