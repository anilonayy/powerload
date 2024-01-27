<template>
    <div v-if="errors && errors[errorKey] && errors[errorKey].length > 0">
        <div v-for="(error, index) in errors[errorKey]" :key="index">
            <div v-if="Object.keys(error).length && isObject(error)">
                <div v-for="(errorKeys, innerIndex) in Object.keys(error)" :key="innerIndex">
                    <InputError class="mt-2" :message="error[errorKeys]" />
                </div>
            </div>
            <div v-else>
                <InputError class="mt-2" :message="error" />
            </div>
            
        </div>
    </div>
</template>

<script setup>
import { defineProps } from 'vue';

import InputError from '@/components/form/InputError.vue'

const props = defineProps({
    errors: {
        type: Object,
        required: true
    },
    errorKey: {
        type: String,
        required: true
    }
})

const isObject = (field) => typeof field === 'object' && field !== null;
</script>