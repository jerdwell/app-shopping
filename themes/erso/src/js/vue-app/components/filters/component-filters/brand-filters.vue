<template lang="pug">
div(v-if="get_brands_related.length > 0")
  label.small.text-center.text-light Marcas
  //- span {{list_brands}}
  .input-group.mb-3.rounded-pill(style="overflow:hidden;")
    .input-group-prepend
      .input-group-text
        i.fas.fa-list
    select.form-control.form-control-sm(
      v-model="$parent.brand_selected"
      @change="addBrandToFilter"
      :disabled="$parent.model_selected != '' ? false :true")
      option(value="") Selecciona una opción
      option(v-for="(brand, index) in list_brands" :key="brand.id" :value="brand.id") {{ brand.brand_name }}
  //- .list-group.mt-3(v-if="no_results")
    .list-group-item.border-danger.p-1.bg-transparent.text-danger #[i.oi.oi-x] No existen resultados
  //- .text-center(v-if="loading")
      .spinner-border.text-light
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
  name: 'brand-filters',
  data() {
    return {
      no_results: false,
      loading: false
    }
  },
  computed: {
    ...mapGetters([
      // 'get_categories_related'
      'get_brands_related'
    ]),
    list_brands(){
      let brands = this.get_brands_related.map(e => {
        return e.brand
      })
      console.log(brands);
      return brands
    }
  },
  methods: {
    ...mapActions([
      'serachProductModel', //search products
    ]),
    async addBrandToFilter(){
      // this.$parent.car_model_selected['category'] = this.$parent.brand_selected
      // this.loading = true
      // await this.serachProductModel(this.$parent.car_model_selected)
      // this.loading = false
    }
  },
}
</script>