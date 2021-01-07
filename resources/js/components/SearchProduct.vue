<template>

    <div class="input-group mb-2 mr-sm-2">
      <input id="keywords" @focus="onFocus" name="keywords" placeholder="Быстрый поиск" autocomplete="off" type="text"
             v-model.trim="keywords" class="form-control">
      <div class="input-group-append">
        <button class="btn" type="button"><i class="far fa-search"></i></button>
      </div>
      <div v-show="toggled" class="dropdown-list" v-if="results && results.length > 0">
        <a  @click="linkProd($event)" class="search-item d-flex" v-for="product in results" :key="product.id" :href="product.path">
          <div class="img-product">
            <img :src="'/storage/files/90x110/'+product.firstImages" alt="">
          </div>
          <div class="text">
            <div class="title" v-html="highlight(product.title)"></div>
            <div class="price"><strong>{{ product.lastPrice }}</strong> <span class="rub">₽</span></div>
          </div>
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item text-center" :href="this.url"><strong>Все результаты, {{ this.count }}
          товаров</strong></a>
      </div>

    </div>
</template>

<script>
export default {
  name: "SearchProduct",
  props: {
    route: '',
    searchAction: ''
  },
  data() {
    return {
      results: '',
      toggled: false,
      keywords: '',
      url: '',
      count: ''
    }
  },
  created: function() {
    let self = this;

    window.addEventListener('click', function(e){
      // close dropdown when clicked outside
      if (!self.$el.contains(e.target)){
        self.toggled = false;
      }
    })
  },
  watch: {
    keywords(after, before) {
      let _this = this;

      this.url = this.searchAction + "?keywords=" + this.keywords;
      this.throttledMethod(_this);

    },
  },
  methods: {
    fetch() {
      axios.get(this.route, {params: {keywords: this.keywords}})
          .then(response => {
            this.results = response.data.products;
            this.count = response.data.count;
          })
          .catch(error => {
            console.log(error)
          });
    },
    onFocus() {
      this.toggled = !this.toggled;
    },


    linkProd(target){
      console.log(target);
    },

    highlight(text) {
      return text.replace(new RegExp(this.keywords, 'gi'), '<span class="highlighted">$&</span>');
    },

    throttledMethod: _.debounce((_this) => {
      _this.fetch();
    }, 300)
  }
}
</script>

<style scoped>

</style>