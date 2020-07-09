import Vue from 'vue'
import { store } from './store'
import Axios from 'axios'

Axios.defaults.baseURL = 'http://www.erso.com.mx/api/v1'

Vue.prototype.$http = Axios

import navbarFilters from './components/filters/navbar-filters'
import mainProductsBrowser from './components/filters/main-products-browser'
import cartButtonState from './components/cart/cart-button-state'

const app = new Vue({
  el: '#app',
  components: {
    navbarFilters,
    mainProductsBrowser,
    cartButtonState
  },
  template: '',
  store,
  data: {}
})