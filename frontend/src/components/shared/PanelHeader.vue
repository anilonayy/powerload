<template>
    <div class="mb-5">
        <HeaderText class="font-semibold lg:text-md mt-0"> {{ props.title }} </HeaderText>

        <p class="leading-5 text-sm text-gray pb-2">{{ props.description }}</p>

        <hr>
    </div>
</template>

<script setup>
import { defineProps } from 'vue';
import HeaderText from "@/components/shared/HeaderText.vue";

const props = defineProps(['title','description'])
</script>