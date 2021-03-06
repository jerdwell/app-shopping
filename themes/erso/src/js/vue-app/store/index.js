import Vue from 'vue'
import Vuex from 'vuex'
import VuexPerists from 'vuex-persist'

// Modules
import Cart from './cart'
import Products from './products'
import Account from './account'
import Quotations from './quotations'

const vuexLocal = new VuexPerists({
  storage: window.sessionStorage
})

Vue.use(Vuex)

export const store = new Vuex.Store({
  modules: {
    Cart,
    Products,
    Account,
    Quotations
  },
  plugins: [ vuexLocal.plugin ]
})
