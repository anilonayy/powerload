<template>
    <button type="button" :class="buttonClasses">
        <slot />
    </button>
</template>


<script>
export default {
    props: ['bg','text'],
    computed: {
        buttonClasses() {
            return `inline-flex justify-center rounded-lg text-sm py-2.5 px-4 ${ this.bg ? `bg-${ this.bg }` : '' }  ${ this.text ? `text-${ this.text }` : 'text-black' } border-2 border-${ this.bg } `
        }
    }
}
</script>