<template>
    <span v-if="wishcount != 0" class="badge-wishlist">{{wishcount}}</span>

</template>

<script>
    export default {
        props: ['wishcount'],

        mounted() {
            console.log('Component mounted.')
        },
    }
</script>