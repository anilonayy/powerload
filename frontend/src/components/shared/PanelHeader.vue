<template>
    <div class="mb-5">
        <HeaderText class="font-semibold lg:text-md mt-0"> 
            <slot name="title" />
        </HeaderText>

        <p class="leading-5 text-sm text-gray pb-2">
            <slot name="description" />
        </p>

        <hr>
    </div>
</template>

<script setup>
import HeaderText from "@/components/shared/HeaderText.vue";
</script>