<template>
  <div class="list-product">
    <filterable v-bind="filterable">
      <template slot-scope="{item, key}">
        <div :class="((key) % 2)? `even`:`odd`" class="product-column col-6 col-sm-6 col-md-6 col-lg-4">
          <div class="product-item mb-3  card">
            <img class="card-img-top img-fluid"
                 :src="'/storage/files/250x250/'+getImage(item)"
                 alt="Картинка">

            <span v-if="isSpecial(item)" class="special-badge"> -{{ percentSpecial(item) }}%</span>
            <a @click="toggleWishList(item.id)">
              <span class="ico ico-wishlist link-wishlist" :class="getClassWishList(item.id)"></span>
            </a>
            <div class="card-body">
              <div class="product-name text-center">
                <a class="" :href="'/products/'+item.alias">{{ item.title }}</a>
              </div>
              <div class="product-price text-center">
                <span class="special" v-if="isSpecial(item)">{{ priceSpecial(item) }} р.</span>
                <span v-if="item.type == 'service'">{{ Number(item.price) }} р.</span>
                <span
                    v-else-if="item.product_options[0]">{{ Number(item.product_options[0].price).toFixed(0) }} р.</span>
              </div>
              <div class="product-link text-center"><a class="text-uppercase btn btn-outline-dark"
                                                       :href="'/products/'+item.alias">Подробнее</a>
              </div>
            </div>
          </div>
        </div>
        <div v-if="(key+1) % 3 == 0" class="w-100 d-none d-lg-block"></div>
        <div v-if="(key+1) % 2 == 0" class="w-100 d-none d-sm-block d-lg-none"></div>
      </template>
    </filterable>
  </div>
</template>

<script>
export default {
  props: ['filters'],
  data() {
    return {
      className: '',
      filterable: {
        url: '/api/products',
        orderables: [
          {title: 'Дата (новые)', options: {name: 'created_at', direction: 'desc'}},
          {title: 'Дата (старые)', options: {name: 'created_at', direction: 'asc'}},
          {title: 'Цена (убывание)', options: {name: 'productOptions.price', direction: 'desc'}},
          {title: 'Цена (возрастание)', options: {name: 'productOptions.price', direction: 'asc'}},
          {title: 'Имя (Я - А)', options: {name: 'title', direction: 'desc'}},
          {title: 'Имя (А - Я)', options: {name: 'title', direction: 'asc'}},
        ],
        filterGroups: [
          {title: 'Стоимость', name: 'price', field: 'productOptions.price', collapsed: true},
          {
            title: 'Материал',
            name: 'material',
            field: 'material',
            collapsed: true,
            item: this.filters.material
          },
          {title: 'Категории', name: 'categories', field: 'catalogs.name', item: this.filters.categories},
          {
            title: 'Цвет покрытия',
            name: 'coating',
            field: 'productOptions.color',
            item: this.filters.coating
          },
          {
            title: 'Цвет камня',
            name: 'stone',
            field: 'productOptions.color_stone',
            item: this.filters.stone
          },
        ],
        paginateItemLimits: [12, 24, 50]
      }
    }
  },
  mounted() {
    console.log('Component ProductList2 mounted.')
  },
  methods: {

    getClassWishList(id) {

      if (this.isWishList(id)) {
        return 'fas fa-heart';
      }
      return 'fal fa-heart';

    },

    isWishList(id) {
      let wishList = this.$parent.wishList;
      if (_.find(wishList, item => item.id == id)) {
        return true;
      }
      return false;
    },

    toggleWishList(id) {
      if (!this.isWishList(id)) {
        this.addToWishList(id)
        return;
      }
      this.removeToWishList(id);
    },

    addToWishList(id) {
      bus.$emit('added-to-wishlist', id);
    },

    removeToWishList(id) {
      let wishList = this.$parent.wishList;
      let key = _.findKey(wishList, item => item.id == id);
      bus.$emit('remove-to-wishlist', key);
    },

    addToCart() {
      bus.$emit('added-to-cart', this.product);
    },


    percentSpecial(item) {
      let price = item.product_options[0] ? item.product_options[0].price : item.price;
      return Math.floor(item.product_special.price / price * 100);
    },

    priceSpecial(item) {
      let price = item.product_options[0] ? item.product_options[0].price : item.price;
      let specialPrice = price - item.product_special.price
      return specialPrice.toFixed(0);
    },


    getImage(product) {
      let filename = '';
      let options = product.product_options;
      if (product.files && product.files.length) {
        return product.files[0].name;
      }
      if (!options) {
        return ''
      }
      for (let i = 0; i < options.length; i++) {
        if (options[i].files && options[i].files.length) {
          return options[i].files[0].name;
        }
      }

      return '';
    },

    isSpecial(item){
      if (item.product_special){
        let dateCurrent = new Date();
        let dateStart = new Date(item.product_special.date_start);
        let dateEnd = new Date(item.product_special.date_end);
        return (dateStart <= dateCurrent) && (dateEnd >= dateCurrent)
      }
      return  false;
    },


  },

}
</script>
