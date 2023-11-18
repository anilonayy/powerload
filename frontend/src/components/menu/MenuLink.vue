<template>
    <li>
        <router-link :to="to" class="hover:bg-red-200 p-2">
            <slot />
        </router-link>
    </li>
</template>


<script>
export default {
    props: ['to']
}
</script>