import Vue from 'vue'
import Vuex from 'vuex'
import VuexPerists from 'vuex-persist'

// Modules
import Cart from './cart'

const vuexLocal = new VuexPerists({
  storage: window.localStorage
})

Vue.use(Vuex)

export const store = new Vuex.Store({
  modules: {
    Cart
  },
  plugins: [ vuexLocal.plugin ]
})
