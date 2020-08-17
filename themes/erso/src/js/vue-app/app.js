import Vue from 'vue'
import { store } from './store'
import Axios from 'axios'

Axios.defaults.baseURL = '/api/v1'

Vue.prototype.$http = Axios

//dashboard
import butttonSearchProducts from './components/dashboard/button-search-products'

//filters
import filtersSearchProducts from './components/filters/filters-search-products'
import mainProductsBrowser from './components/filters/main-products-browser'
import cartButtonState from './components/cart/cart-button-state'
import VueSwal from 'vue-swal'

//account
import FormRegister from './components/account/form-register'
import FormLogin from './components/account/form-login'
import MyAccount from './components/account/my-account'

Vue.use(VueSwal)
//cart shopping
import cartFixedGlobal from './components/cart/cart-fixed-global'

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
    MyAccount
  },
  template: '',
  store,
  data: {}
})