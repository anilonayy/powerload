<template>
    <div class="flex flex-col h-full">
        <Header />

        <main>
            <slot />
        </main>

        <Footer />
    </div>
</template>

<script setup>
    import Header from '@/Components/Shared/Header.vue';
    import Footer from '@/Components/Shared/Footer.vue';
</script>

