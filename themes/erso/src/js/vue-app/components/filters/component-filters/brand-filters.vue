<template lang="pug">
div
  label.small.text-center.text-light Marcas
  //- span {{list_brands}}
  .input-group.mb-3.rounded-pill(style="overflow:hidden;")
    .input-group-prepend
      .input-group-text
        i.fas.fa-list
    select.form-control.form-control-sm(
      v-model="$parent.brand_selected"
      @change="addBrandToFilter"
      :disabled="$parent.year_selected == '' && $parent.category_selected == ''")
      option(value="") Selecciona una opción
      option(v-for="(brand, index) in list_brands" :key="brand.id" :value="brand.brand_slug") {{ brand.brand_name }}
  .text-center(v-if="loading")
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
      'get_brands_related'
    ]),
    list_brands(){
      let brands = this.get_brands_related.map(e => {
        return e.brand
      })
      return brands
    }
  },
  methods: {
    ...mapActions([
      'serachProductModel', //search products
    ]),
    async addBrandToFilter(){
      this.$parent.car_model_selected['brand'] = this.$parent.brand_selected
      this.loading = true
      await this.serachProductModel(this.$parent.car_model_selected)
      this.loading = false
    }
  },
}
</script>