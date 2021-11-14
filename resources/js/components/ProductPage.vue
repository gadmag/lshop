<template>
  <div class="row">
    <div class="col-sm-6">
      <ul class="list-unstyled" v-if="files" id="thumbnails">
        <li class="image-product-item" v-for="(image, key, index) in files">
          <a class="group2" v-if="key == 0" :href="'/storage/files/'+ image.name"><img
              class="img-fluid" :src="'/storage/files/600x450/'+ image.name" alt="Фото продукта"></a>
          <a class="group2" v-else :href="'/storage/files/'+ image.name"><img class="img-thumbnail"
                                                                              :src="'/storage/files/90x110/'+ image.name"
                                                                              alt="Фото продукта"></a>
        </li>
      </ul>
      <div class="clearfix"></div>
    </div>
    <div class="col-sm-6">
      <h1 class="page-title">{{ product.title }}</h1>

      <div class="sku-block clearfix">
        <strong>Артикул:</strong> <span>{{ product.model }}</span>
      </div>
      <div class="description-block">
        <ul class="nav nav-tabs">
          <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home">Описание</a></li>
          <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#menu1">Характеристики</a></li>
        </ul>

        <div class="tab-content">
          <div id="home" v-html="product.description" class="tab-pane fade show active"></div>
          <div id="menu1" class="tab-pane fade">
            <p v-if="product.model"><strong>Модель:</strong> <span>{{ product.model }}</span></p>
            <p v-if="product.material"><strong>Материал:</strong> <span>{{ product.material }}</span></p>
            <p v-if="product.size"><strong>Размер:</strong> <span>{{ product.size }}</span></p>
            <p v-if="weight"><strong>Вес:</strong> <span>{{ weight }} гр.</span></p>
          </div>
        </div>
      </div>
      <div class="price-block">
        <h2><span v-bind:class="{'through': isSpecial}" class="price">{{ getPrice }} &#8381;</span></h2>
        <h2 v-if="isSpecial"><span class="special-price">{{ getSpecialPrice }} </span><span>&#8381;</span></h2>
      </div>

      <div v-if="discount" class="discount-block">
        <hr>
        <span>{{ discount.quantity }} и более {{ discount.price }} &#8381;</span>
        <hr>
      </div>

      <div class="add-to-cart">
        <div v-if="options && options.length > 0" class="options-block">
          <div class="form-group">
            <label for="dropdownOptions">Выбор цвета: </label>
            <div class="dropdown">
              <button class="btn btn-light dropdown-toggle" id="dropdownOptions" data-toggle="dropdown"
                      aria-haspopup="true" aria-expanded="false">{{ titleOption }}
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownSortHeader">
                <button :disabled="option.quantity <= 0" @click="selectOption($event, option)"
                        v-for="(option) in options"
                        :data-id="option.id" class="dropdown-item"
                        type="button">{{ fullOptionName(option) }}
                </button>
              </div>
            </div>
          </div>
        </div>
        <div v-if="services && services.length > 0" class="engraving-block">
          <div class="form-check custom-checkbox">
            <input @change="check($event)" name="" type="checkbox" id="checkEngraving" class="custom-control-input">
            <label data-toggle="collapse" data-target="#engravingBox"
                   class="custom-control-label" for="checkEngraving"
                   aria-expanded="false" aria-controls="engravingBox">Добавить гравировку</label>
          </div>
          <div id="engravingBox" :aria-expanded="false" class="collapse">
            <div class="form-group">
              <select class="form-control" v-model="engraving.id" :class="{'is-invalid': errors && errors['options.engraving.id']}">
                <option disabled value="">Выбрать тип гравировки</option>
                <option v-for="service in services" :value="service.id">
                  {{ service.title }}
                  <template v-if="service.price > 0"> ({{ service.price }} р.)</template>
                </option>
              </select>
              <span v-if="errors && errors['options.engraving.id']" class="invalid-feedback"
                    role="alert">Тип гравировки обязателен для заполнения</span>
            </div>
            <div class="form-group">
              <select class="form-control" v-model="engraving.font" :class="{'is-invalid': errors && errors['options.engraving.font']}">
                <option disabled value="">Выбрать шрифт</option>
                <option v-for="font in fonts" :value="font.title">{{ font.title }}</option>
              </select>
              <span v-if="errors && errors['options.engraving.font']" class="invalid-feedback"
                    role="alert">Шрифт обязателен для заполнения</span>
            </div>
            <div class="form-group">
              <label for="engravingText">Текст гравировки:</label>
              <textarea v-model="engraving.text" id="engravingText" rows="3" class="form-control"
                        :class="{'is-invalid': errors && errors['options.engraving.text']}"></textarea>
              <span v-if="errors && errors['options.engraving.text']" class="invalid-feedback"
                    role="alert">Поле Текст гравировки обязательно для заполнения, если не выбран файл.</span>
            </div>
            <div class="form-group">
              <image-upload @getFiles="getFileName($event)"
                            name="engravingUpload" :box-input="false"
                            :allow-multiple="false" action="/uploadFiles"></image-upload>

            </div>

            <div class="form-group">
              <label for="engravingComment">Комментарий:</label>
              <textarea v-model="engraving.comment" class="form-control" id="engravingComment" rows="3"></textarea>
            </div>

          </div>
        </div>

        <div class="quantity form-group">
          <label for="quantity">Кол-во</label>
          <input type="number" v-model="query_options.quantity" name="quantity" id="quantity"
                 class="form-control" :max="product.quantity">
        </div>
        <div class="button-block clearfix">
          <button :disabled="product.quantity <= 0" class="mb-2 btn-dark btn"
                  @click="addToCart(product.id)">Добавить в корзину
          </button>

          <button class="mb-2 btn-dark btn"
                  @click="toggleWishList? removeToWishList(product.id) : addToWishList(product.id)">
            Добавить
            в избранное
          </button>
        </div>


        <hr>
        <div class="share-block clearfix">
          <div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,moimir,twitter"></div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['product', 'fonts'],
  data: function () {
    return {
      className: '',
      files: [],
      options: this.product.product_options,
      special: this.product.product_special,
      services: this.product.services,
      engraving: {
        id: '',
        text: '',
        price: '',
        font: '',
        comment: '',
        filename: '',
        isChecked: false
      },
      titleOption: null,
      query_options: {
        id: null,
        quantity: 1,
      },
      errors: '',
      message: ''
    }
  },
  mounted() {
    this.allImagesProduct();
    if (this.options) {
      this.titleOption = this.fullOptionName(this.options[0]);
      this.query_options.id = this.options[0].id;
    }

    console.log('Component mounted.');

  },
  methods: {
    selectOption(e, option) {
      const id = option.id;
      this.query_options.id = id;
      this.titleOption = this.fullOptionName(option);
      this.files.forEach(function (file, i, arr) {
        if (file.uploadstable_id == id) {
          let element = file;
          arr.splice(i, 1);
          arr.splice(0, 0, element);
        }
      });
    },

    getOptionByID(id) {
      let option = false;
      this.options.forEach(function (item, i) {
        if (id === item.id) {
          option = item;
        }
      });
      return option;
    },
    addOptionPrice(price, discount_price = 0) {
      let id = this.query_options.id;
      if (id !== null) {
        let option = this.getOptionByID(id);
        let total_price = parseFloat(option.price) - parseFloat(discount_price);
        return total_price.toFixed(2);
      }
      let total_price = (price - discount_price)
      return total_price.toFixed(2);
    },

    fullOptionName(option) {
      let optionFullName = '';
      if (option.color) {
        optionFullName = "Цвет: " + option.color
      }
      if (option.color_stone) {
        let separator = optionFullName ? optionFullName + '/' : '';
        optionFullName = separator + "Цвет камня: " + option.color_stone
      }
      return optionFullName
    },

    allImagesProduct() {
      let _this = this;
      this.files = this.product.files ? this.product.files : [];
      if (!this.product.product_options) {
        return this.files
      }
      this.product.product_options.forEach(function (item, i) {
        if (item.files != undefined && item.files != null) {
          item.files.forEach(function (file) {
            _this.files.push(file);
          })
        }
      });

      return this.files;
    },

    check(e) {
      if (e.target.checked) {
        return this.engraving.isChecked = true
      }
      this.engraving.isChecked = false;
      this.engraving.id = '';
      this.engraving.text = '';
      this.engraving.comment = '';
      this.engraving.price = '';
      this.engraving.font = '';
      this.engraving.filename = '';

    },

    addToCart(id) {
      this.engraving.qty = this.query_options.quantity;
      this.query_options.engraving = this.engraving;
      if (this.query_options.id) {
        let url = '/api/add-to-cart/' + id + '?options=' + JSON.stringify(this.query_options);
        console.log(this.query_options);
        axios.get(url)
            .then(function (response) {
              this.errors = '';
              this.message = '';
              if (response.data.errors) {
                return this.errors = response.data.errors;
              }
              if (response.data.message) {
                return this.message = response.data.message;
              }

              if (response.data.cart) {
                bus.$emit('added-to-cart', response.data);
              }

            }.bind(this))
            .catch(function (error) {
              this.message = null;
              let status = error.response.status;
              this.errors = error.response.data.errors;
              this.message = this.getErrorMessage(status);
            }.bind(this));
      }

    },

    getFileName(filename) {
      this.engraving.filename = filename[0];
    },

    addToWishList(id) {
      bus.$emit('added-to-wishlist', id);
    },

    removeToWishList(id) {
      bus.$emit('remove-to-wishlist', id);
    },


  },

  computed: {
    weight() {
      if (this.query_options.id) {
        let option = this.getOptionByID(this.query_options.id);
        return option.weight;
      }
      return null;
    },
    getPrice() {
      return this.addOptionPrice(this.product.price);
    },

    discount() {

      if (this.query_options.id) {
        let option = this.getOptionByID(this.query_options.id);
        return option.discount;
      }
      return null;
    },

    getDiscountPrice() {
      return this.addOptionPrice(this.product.price, this.discount.price);
    },

    getSpecialPrice() {
      return this.addOptionPrice(this.product.price, this.special.price);
    },

    toggleWishList() {
      if (this.$parent.wishList[this.product.id]) {
        if (window.location.pathname.replace('/', '') == 'wishlist') {
          delete this.product;
        }

        this.className = 'ico ico-wishlist link-wishlist fa fa-heart';
        return true;
      } else {
        this.className = 'ico ico-wishlist link-wishlist fa fa-heart-o';
        return false;
      }
    },

    isSpecial() {
      if (this.special) {
        let dateCurrent = new Date();
        let dateStart = new Date(this.special.date_start);
        let dateEnd = new Date(this.special.date_end);
        return (dateStart <= dateCurrent) && (dateEnd >= dateCurrent)
      }
      return false
    },


  }
}
</script>
