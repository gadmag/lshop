<template>
    <div class="container">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-title"><span>Customer match</span></div>
                <select v-model="query.filter_match">
                    <option value="end">end</option>
                    <option value="or">or</option>
                </select>
            </div>
            <div class="panel-body">

                <slot v-if="collection.data && collection.data.length"
                      v-for="item in collection.data"
                      :item='item'>

                </slot>
            </div>
        </div>
    </div>
</template>
<script>

    export default {

        props: {
            url: String,
        },

        data() {
            return {
                loading: true,
                query: {
                    order_by: 'created_st',
                    order_direction: 'desc',
                    filter_match: 'end',
                    limit: 10,
                    page: 1,
                },

                collection: {
                    data: []
                }
            }
        },

        mounted() {
            console.log('Component filterable mounted.');
            this.fetch();
        },

        methods: {
            fetch() {
                axios.get(this.url)
                    .then((res) => {
                        Vue.set(this.$data, 'collection', res.data.collection);
                        this.query.page = res.data.collection.current_page;
                    })
                    .catch((error) => {

                    })
                    .finally(() => {
                        this.loading = false;
                    })
            }
        }
    }
</script>