<template>
    <span v-if="cartcount != 0" class="badge">{{cartcount}}</span>

</template>

<script>
    export default {
        props: ['cartcount'],
        mounted() {
            console.log('Component mounted.')
        },
        // data(){
        //
        // }
    }
</script>