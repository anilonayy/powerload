<script setup>
    import Header from './layout/Header.vue';
    import Footer from './layout/Footer.vue';
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

