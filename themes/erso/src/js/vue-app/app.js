import Vue from 'vue'
import { store } from './store'
import Axios from 'axios'
import VueAwesomeSwiper from 'vue-awesome-swiper' //swiper
import DatePicker from 'vuejs-datepicker'
import moment  from 'moment'
import {en, es} from 'vuejs-datepicker/dist/locale' //lang for date-picker
import ZoomOnHover from 'vue-zoom-on-hover'
DatePicker.props.language.default = () => es
Vue.component('datePicker', DatePicker)

Vue.use(ZoomOnHover)

import 'swiper/swiper-bundle.css'//styles for swiper
Vue.use(VueAwesomeSwiper) //use swiper

import VueLazyLoad from 'vue-lazyload'
Vue.use(VueLazyLoad)

Axios.defaults.baseURL = '/api/v1'

Vue.prototype.$http = Axios
Vue.prototype.$moment = moment

//dashboard
import butttonSearchProducts from './components/dashboard/button-search-products'
import buttonAccountRegister from './components/dashboard/button-account-register'
import floatingButton from './components/dashboard/floating-button';

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
import productFilters from './components/page-products/product-filters'
import productShipownerFilter from './components/page-products/product-shipowner-filter'
import productsCarsFilter from './components/page-products/products-cars-filter'
import productsYearsFilter from './components/page-products/products-years-filter'
import selectBranch from './components/page-products/select-branch'

//blog
import categoryFilterBlog from './components/blog/category-filter-blog'
import blogSearch from './components/blog/blog-search'

//contact forms
import contactForm from './components/contact-forms/contact-form'

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
    categoryFilterBlog,
    buttonAccountRegister,
    contactForm,
    blogSearch,
    selectBranch,
    productShipownerFilter,
    productFilters,
    floatingButton
  },
  template: '',
  store,
  data: {}
})