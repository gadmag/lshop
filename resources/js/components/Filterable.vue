<template>
  <div class="container">
    <div class="row head-title">
      <div class="col-md-3"></div>
      <div class="col-md-9">
        <h1 id="spinner-loader" class="title py-2 text-center">{{ category ? category.name : 'Каталог товаров' }}</h1>
      </div>
    </div>
    <div class="row">
      <aside class="col-md-3">
        <div class="block product-filter">
          <div v-for="(group, f) in filterGroups" class="filter">

            <h5 class="title text-muted" data-toggle="collapse" :data-target="'#'+group.name+'Collapse'"
                :class="(!group.collapsed)?'collapsed':''">
              <span>{{ group.title }}</span>
            </h5>
            <div v-if="group.item" :id="group.name+'Collapse'" :class="(group.collapsed)?'show':''"
                 class="ml-2 py-3 collapse multi-collapse filter-list">
              <div class="checkbox">
                <div v-for="(item,i) in group.item"
                     class="form-check custom-control custom-checkbox mb-1">
                  <input class="custom-control-input" :id="item.type+'-'+i" type="checkbox"
                         :value="JSON.stringify(item.name)"
                         @input="selectField(item, f, $event)">
                  <label class="custom-control-label" :for="item.type+'-'+i">{{ item.name }}</label>
                </div>
              </div>
            </div>
            <div v-else :id="group.name+'Collapse'" :class="(group.collapsed)?'show':''"
                 class="ml-2 py-3 collapse multi-collapse price-filter">
              <vue-slider ref="slider" :lazy="false"
                          @drag-end="selectPrice"
                          :tooltip="'focus'" :use-keyboard="true"
                          v-model="filterPrice.valuePrice"
                          :min="filterPrice.min"
                          :max="filterPrice.max">

              </vue-slider>
              <div class="my-2 d-flex justify-content-between">
                <div class="price-input">
                  <input id="minPrice" type="text" @input="selectPrice" class="form-control form-control-sm"
                         v-model="filterPrice.valuePrice[0]">
                </div>
                <div class="py-1 price_dash"> —</div>
                <div class="price-input">
                  <input id="maxPrice" type="text" @input="selectPrice" class="form-control form-control-sm"
                         v-model="filterPrice.valuePrice[1]">
                </div>
                <div class="py-1 price_dash"><span>руб.</span></div>
              </div>
            </div>
          </div>
        </div>
      </aside>
      <div class="content col-md-9">
        <div v-if="collection.total > 0">
          <div class="text-right"><span class="text-muted">Найдено:</span> <b>{{ collection.total }}</b></div>
          <div class="py-1 mb-3 product-list-header">
            <div class="filterable-sort d-flex justify-content-center">
              <div class="form-inline">
                <div class="form-group mb-2">
                  <span class="text-muted">Сортировать по:&nbsp;</span>
                  <div class="dropdown">
                    <a class="dropdown-toggle" id="dropdownSortHeader" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">{{ orderTitle }}</a>
                    <div class="dropdown-menu" aria-labelledby="dropdownSortHeader">
                      <button @click="updateOrderField" v-for="field in orderables"
                              :data-orders="JSON.stringify(field.options)" class="dropdown-item"
                              type="button">{{ field.title }}
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="product-list-body">
            <div class="row">
              <slot v-if="collection.data"
                    v-for="(item, key, index) in collection.data"
                    :item='item, key'>
              </slot>
            </div>
          </div>
          <div class="text-right"><span class="text-muted">Найдено:</span> <b>{{ collection.total }}</b></div>
          <div class="product-list-footer">
            <div class="row">
              <div class="col-sm-6">
                <div class="py-2 limit-buttons">
                  <span class="text-muted">Показывать по</span>
                  <a href="#" :class="(collection.per_page == limit)?'active':''"
                     v-for="limit in paginateItemLimits" v-on:click.stop.prevent="selectLimit"
                     class="badge badge-light">{{ limit }}</a>
                </div>
              </div>
              <div class="text-right col-sm-6">
                <div class="paginate-badge py-2">
                  <a class="badge badge-light" @click.stop.prevent="prevPage"
                     :disabled="collection.current_page > 1" href="#"><i
                      class="far fa-angle-left"></i></a>
                  <a @click.stop.prevent="changePage(page)" class="badge badge-light"
                     v-for="page in pagesNumber"
                     :class="{'active': page == collection.current_page}">{{ page }}</a>
                  <a class="badge badge-light" @click.stop.prevent="nextPage"
                     :disabled="collection.current_page < collection.last_page" href="#"><i
                      class="far fa-angle-right"></i></a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="text-center" v-else>
          <span>Товаров не найдено, попробуйте расширить диапазон фильтра.</span>
        </div>
      </div>
    </div>


  </div>
</template>
<script>
import vueSlider from 'vue-slider-component';

export default {

  props: {
    category: null,
    url: String,
    filterGroups: Array,
    orderables: Array,
    paginateItemLimits: Array,
  },

  components: {
    vueSlider
  },

  data() {
    return {
      loading: true,
      appliedFilters: [],
      filterCandidates: [],
      arr: [],
      orderTitle: '',
      filterPrice: {
        valuePrice: [10, 2000],
        min: 0,
        max: 2000,
      },

      query: {
        sort: 'created_at',
        direction: 'desc',
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
    this.setOrderTitle({name: this.query.sort, direction: this.query.direction});
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
    chunkedItems() {
      if (this.collection.data && this.collection.data.length > 0) {
        return _.chunk(this.collection.data, 3)
      }

    },

    pagesNumber() {
      if (!this.collection.to) {
        return [];
      }
      let from = this.collection.current_page - 2;
      if (from < 1) {
        from = 1;
      }
      let to = from + (2 * 2);
      if (to >= this.collection.last_page) {
        to = this.collection.last_page;
      }
      let pagesArray = [];
      for (let page = from; page <= to; page++) {
        pagesArray.push(page);
      }
      return pagesArray;
    }
  },

  methods: {

    setOrderTitle(options) {
      let _this = this
      this.orderables.filter(function (item) {
        if ((item.options.name == options.name) && (item.options.direction == options.direction)) {
          _this.orderTitle = item.title;
        }
      });

    },
    updateOrderField(e) {
      const value = JSON.parse(e.target.getAttribute('data-orders'));
      this.setOrderTitle(value);
      Vue.set(this.query, 'sort', value.name);
      Vue.set(this.query, 'direction', value.direction);
      this.applyChange()
    },

    isField(type, e, i, fields) {
      return -1
    },

    resetFilter() {
      this.appliedFilters.splice(0);
      this.filterCandidates.splice(0);
      this.addFilter();
      this.query.page = 1;
      this.applyChange();
    },
    applyFilter() {
      Vue.set(this.$data, 'appliedFilters',
          JSON.parse(JSON.stringify(this.filterCandidates))
      );
      this.query.page = 1;
      this.applyChange();
    },
    selectPrice() {
      let minPrice = this.filterPrice.valuePrice[0];
      let maxPrice = this.filterPrice.valuePrice[1];

      if (this.filterCandidates.indexOf(0) === -1) {
        Vue.set(this.filterCandidates[0], 'operator', 'between');
      }
      this.filterCandidates[0].field_value[0] = minPrice;
      this.filterCandidates[0].field_value2 = maxPrice;
      this.applyFilter();
    },
    selectField(item, i, e) {
      let value = e.target.value;
      if (value.length === 0) {
        return
      }
      let obj = JSON.parse(value);
      if (e.target.checked) {
        if (this.filterCandidates.indexOf(i) === -1) {
          Vue.set(this.filterCandidates[i], 'operator', 'equal_in');
        }
        this.filterCandidates[i].field_value.push(obj);
      } else {
        this.filterCandidates[i].field_value.splice(this.filterCandidates[i].field_value.indexOf(obj), 1);
      }
      this.applyFilter();

    },

    addFilter() {
      let arr = []
      this.filterGroups.forEach(function (item, i) {
        arr[i] = {
          field: item.field,
          operator: '',
          field_value: [],
          field_value2: '',
        }
      });
      this.filterCandidates = arr;

    },

    applyChange() {
      this.scrollTo();
      NProgress.configure({
        parent: '#spinner-loader',
        easing: 'ease',
        speed: 300,
      });
      NProgress.start();
      this.fetch();
    },

    updateLimit() {
      this.query.page = 1;
      this.applyChange();
    },
    selectLimit(event) {
      if (event) {
        let limit = event.target.innerHTML;
        this.query.limit = limit;
      }
      this.updateLimit();
    },

    changePage(page) {
      this.query.page = Number(page);
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
          f[`f[${i}][field]`] = filter.field;
          f[`f[${i}][operator]`] = filter.operator
          f[`f[${i}][query_1]`] = filter.field_value.join(',');
          if (filter.field_value2) {
            f[`f[${i}][query_2]`] = filter.field_value2;
          }
        }

      });
      return f
    },
    scrollTo() {
      $([document.documentElement, document.body]).animate({
        scrollTop: $("#spinner-loader").offset().top - 90
      }, 800);
    },
    fetch() {
      this.loading = true;

      const filters = this.getFilters();

      const params = {
        ...filters,
        ...this.query,
      };

      axios.get(this.url, {params: params})
          .then((res) => {
            Vue.set(this.$data, 'collection', res.data.collection);
            this.query.page = res.data.collection.current_page;
          })
          .catch((error) => {
            console.log(error);
          })
          .finally(() => {
            this.loading = false;
            NProgress.done();
          })
    }
  }
}
</script>