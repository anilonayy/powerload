<template>
  
    <div class="flex flex-col lg:flex-row h-full">
      <Sidebar />
      <main
        class="flex-1 mt-8 lg:mt-0 lg:ms-72 h-full justify-center items-center"
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
import Sidebar from '@/Components/Shared/Sidebar.vue'
import LayoutContainer from '@/Components/Shared/LayoutContainer.vue'
import BottomBar from '@/Components/Shared/BottomBar.vue'
</script>