<template>
  
    <div class="flex flex-col md:flex-row h-full">
      <Sidebar />
      <main
        class="flex-1 mt-8 md:mt-0 md:ms-72 h-full justify-center items-center"
        id="content-area"
      >
        <LayoutContainer>
            <slot />
         </LayoutContainer>
      </main>

      <BottomBar />
    </div>
 
</template>

<script setup>
import Sidebar from '@/components/shared/Sidebar.vue'
import LayoutContainer from '@/components/shared/LayoutContainer.vue'
import BottomBar from '@/components/shared/BottomBar.vue'
</script>