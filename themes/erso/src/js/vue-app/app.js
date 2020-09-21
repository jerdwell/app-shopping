import Vue from 'vue'
import { store } from './store'
import Axios from 'axios'
import DatePicker from 'vuejs-datepicker'
import {en, es} from 'vuejs-datepicker/dist/locale' //lang for date-picker
DatePicker.props.language.default = () => es
Vue.component('datePicker', DatePicker)

Axios.defaults.baseURL = '/api/v1'

Vue.prototype.$http = Axios

//dashboard
import butttonSearchProducts from './components/dashboard/button-search-products'

//filters
import filtersSearchProducts from './components/filters/filters-search-products'
import mainProductsBrowser from './components/filters/main-products-browser'
import cartButtonState from './components/cart/cart-button-state'
import productHandler from './components/cart/product-handler'
import VueSwal from 'vue-swal'

//account
import FormRegister from './components/account/form-register'
import FormLogin from './components/account/form-login'
import MyAccount from './components/account/my-account'

Vue.use(VueSwal)
//cart shopping
import cartFixedGlobal from './components/cart/cart-fixed-global'
import productItemBrowser from './components/cart/product-item-browser'

//products
import productsCarsFilter from './components/page-products/products-cars-filter'
import productsYearsFilter from './components/page-products/products-years-filter'

//blog
import categoryFilterBlog from './components/blog/category-filter-blog'

const app = new Vue({
  el: '#app',
  components: {
    filtersSearchProducts,
    mainProductsBrowser,
    cartButtonState,
    butttonSearchProducts,
    cartFixedGlobal,
    FormRegister,
    FormLogin,
    MyAccount,
    productHandler,
    productsCarsFilter,
    productsYearsFilter,
    productItemBrowser,
    categoryFilterBlog
  },
  template: '',
  store,
  data: {}
})