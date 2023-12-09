<template>
    <div class="flex flex-col lg:flex-row h-full">
        <Sidebar />
        <main class="flex-1 p-4 mt-8 lg:ms-72" id="content-area">
            <slot />
        </main>
    </div>
</template>

<script setup>
    import Sidebar from '@/Components/Shared/Sidebar.vue';
</script>