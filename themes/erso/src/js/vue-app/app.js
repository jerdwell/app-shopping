import Vue from 'vue'
import { store } from './store'

import navbarFilters from './components/filters/navbar-filters'

const app = new Vue({
  el: '#app',
  components: {
    navbarFilters
  },
  template: '',
  store,
  data: {}
})