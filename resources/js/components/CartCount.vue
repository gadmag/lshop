<template>
    <span v-if="cartcount > 0" class="badge badge-cart">{{cartcount}}</span>

</template>

<script>
    export default {
        props: ['cartcount'],
        mounted() {
            console.log('Component mounted.')
        },
    }
</script>