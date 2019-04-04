<template>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="panel">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <div v-if="filterCandidates" v-for="filters in filterCandidates">
                                <span v-if="filters" v-for="filter in filters">{{filter}} &nbsp;</span>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <div class="filter">
                            <!-- Single button -->
                            <div class="custom-control custom-checkbox mb-3">
                                <input type="checkbox" class="custom-control-input" id="customCheck1" checked>
                                <label class="custom-control-label" for="customCheck1">Checkboxes are cool</label>
                            </div>
                            <div v-for="(group, f) in filterGroups" class="">
                                <h4>{{group.title}} <span class="caret"></span></h4>

                                <div class="filter-list">
                                    <div class="checkbox">
                                        <div v-for="(item,i) in group.item" class="form-group form-check">
                                            <input class="form-check-input" :id="item.type+'-'+i" type="checkbox" :value="JSON.stringify(item.name)"
                                                   @input="selectField(item, f, $event)">
                                            <label :for="item.type+'-'+i">{{item.name}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="header filterable-sort clearfix">
                    <div class="form-inline">
                        <div class="form-group align-content-end mb-2">
                            <span>Сортировать: </span>
                            <select class="form-control" :disabled="loading" @input="updateOrderField">
                                <option v-for="field in orderables" :value="JSON.stringify(field.options)"
                                        :selected="field && field.options.name == query.order_by && field.options.direction == query.order_direction">
                                    {{field.title}}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <slot v-if="collection.data && collection.data.length"
                              v-for="(item, key, index) in collection.data"
                              :item='item, key'>
                        </slot>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-xs-6">
                            <select class="form-control" v-model="query.limit" name="" id="" :disabled="loading"
                                    @change="updateLimit">
                                <option>12</option>
                                <option>16</option>
                                <option>24</option>
                                <option>50</option>
                            </select>
                            <small> Показано с {{collection.from}} по {{collection.to}} из {{collection.total}}
                                записей.
                            </small>
                        </div>
                        <div class="text-right col-xs-6">
                            <button class="btn btn-outline-black" :disabled="!collection.prev_page_url || loading" @click="prevPage">
                                &laquo;
                                Prev
                            </button>
                            <button class="btn btn-outline-black" :disabled="!collection.next_page_url || loading" @click="nextPage">Next
                                &raquo;
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</template>
<script>

    export default {

        props: {
            url: String,
            filterGroups: Array,
            orderables: Array,
        },

        data() {
            return {
                loading: true,
                appliedFilters: [],
                filterCandidates: [],
                arr: [],
                query: {
                    order_by: 'created_at',
                    order_direction: 'desc',
                    filter_match: 'and',
                    limit: 12,
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
            this.addFilter();
        },

        computed: {
            fetchOperators(f) {
                return (f) => {
                    return this.availableOperators().filter((operator) => {
                        if (f.field && operator.parent.includes(f.field.type)) {
                            return operator;
                        }
                    })
                }
            },
            chunkedItems () {
                if (this.collection.data && this.collection.data.length > 0) {
                    return _.chunk(this.collection.data, 3)
                }

            }
        },

        methods: {

            updateOrderField(e) {
                const value = JSON.parse(e.target.value);
                Vue.set(this.query, 'order_by', value.name);
                Vue.set(this.query, 'order_direction', value.direction);
                this.applyChange()
            },
            exportToCSV() {

            },

            isField(type, e, i, fields) {
                return -1
            },

            resetFilter() {
                this.appliedFilters.splice(0)
                this.filterCandidates.splice(0)
                this.addFilter()
                this.query.page = 1
                this.applyChange()
            },
            applyFilter() {
                Vue.set(this.$data, 'appliedFilters',
                    JSON.parse(JSON.stringify(this.filterCandidates))
                )
                this.query.page = 1;
                this.applyChange()
            },
            selectField(item, i, e) {

                let value = e.target.value;
                let fieldCount = this.filterGroups.length;
                let filterLenght = this.filterCandidates.length;

                if (value.length === 0) {

                    return
                }

                let obj = JSON.parse(value);
                if (e.target.checked) {
                    if (this.filterCandidates.indexOf(i) === -1) {
                        // Vue.set(this.filterCandidates[i], 'field', item.type);
                        Vue.set(this.filterCandidates[i], 'operator', 'equal_in');
                    }
                    this.filterCandidates[i].field_value.push(obj);
                } else {
                    this.filterCandidates[i].field_value.splice(this.filterCandidates[i].field_value.indexOf(obj), 1);
                    if (this.filterCandidates[i].field_value.length == 0) {
                        this.filterCandidates.splice(i, 1);
                    }
                }
                this.applyFilter();

            },

            addFilter(field) {
                let arr = []
                this.filterGroups.forEach(function (item, i) {
                    arr[i] = {
                        field: item.name,
                        operator: '',
                        field_value: [],
                    }
                });
                this.filterCandidates = arr;

            },

            applyChange() {
                this.fetch();
            },

            updateLimit() {
                this.query.page = 1;
                this.applyChange();
            },

            prevPage() {
                if (this.collection.prev_page_url) {

                    this.query.page = Number(this.query.page) + -1;
                    this.applyChange();
                }
            },
            nextPage() {

                if (this.collection.next_page_url) {

                    this.query.page = Number(this.query.page) + 1;
                    this.applyChange();
                }
            },

            getFilters() {
                const f = {}
                this.appliedFilters.forEach((filter, i) => {

                    if (filter.field_value.length > 0) {
                        // console.log(i);
                        f[`f[${i}][field]`] = filter.field;
                        f[`f[${i}][operator]`] = filter.operator
                        f[`f[${i}][query_1]`] = filter.field_value.join(',');
                        f[`f[${i}][query_2]`] = '';
                    }

                })
                return f
            },
            fetch() {
                this.loading = true;
                const filters = this.getFilters();

                const params = {
                    ...filters,
                    ...this.query,
                }

                axios.get(this.url, {params: params})
                    .then((res) => {
                        Vue.set(this.$data, 'collection', res.data.collection);
                        this.query.page = res.data.collection.current_page;
                    })
                    .catch((error) => {
                        console.log(error)
                    })
                    .finally(() => {
                        this.loading = false;
                    })
            }
        }
    }
</script>