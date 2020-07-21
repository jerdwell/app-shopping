import Vue from 'vue'
import { store } from './store'
import Axios from 'axios'

Axios.defaults.baseURL = '/api/v1'
Axios.defaults.headers.commons = {
  'X-Requested-With': 'XMLHttpRequest',
  'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
}

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