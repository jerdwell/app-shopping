<template lang="pug">
div
  label.text-center Categoría
  select.form-control.rounded-pill(
    v-model="$parent.category_selected"
    :disabled="$parent.model_selected != '' ? false :true"
    @change="getProducts")
    option(value="") Selecciona una opción
    option(value="amortiguadores") Amortiguadores
    option(value="suspensiones") Suspensiones
    option(value="direcciones") Direcciones
    option(value="tracciones") Tracciones
    option(value="frenos") Tracciones
    option(value="embragues") Embragues
  .list-group.mt-3(v-if="no_results")
    .list-group-item.border-danger.p-1.bg-transparent.text-danger #[i.oi.oi-x] No existen resultados
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
  name: 'category-filters',
  data() {
    return {
      no_results: false
    }
  },
  computed: {
    ...mapGetters([
      'getListProducts'
    ])
  },
  methods: {
    ...mapActions([
      'searchProducts',
    ]),
    async getProducts(){
      let products = await this.searchProducts({
        category: this.$parent.category_selected,
        model: this.$parent.model_selected,
      })
      if(this.getListProducts.length > 0){
        this.no_results = false
        this.$parent.model_selected = ''
        this.$parent.category_selected = ''
        this.$parent.car_selected = ''
        return this.$parent.$parent.searchProduct = false
      }
      this.no_results = true
      setTimeout(() => { this.no_results }, 3000);
    }
  }
}
</script>