<script setup>
    import Header from '@/Components/UserLayout/Header.vue';
    import Footer from '@/Components/UserLayout/Footer.vue';
</script>


<template>
    <div class="flex flex-col h-full">
        <Header />

        <main>
            <slot />
        </main>

        <Footer />
    </div>
</template>

