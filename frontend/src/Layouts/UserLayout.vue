<template>
    <div class="flex flex h-full">
        <!-- <Header /> -->
        <Sidebar />
        <main class="flex-1 p-4" id="content-area">
            <slot />
        </main>
    </div>
</template>

<script setup>
    import Header from '@/Components/Shared/Header.vue';
    import Footer from '@/Components/Shared/Footer.vue';
    import Sidebar from '@/Components/Shared/Sidebar.vue';
</script>



<style lang="css">
    #content-area {
        height: 100%;
        min-height: 100vh;
        overflow-y: scroll;
    }
</style>