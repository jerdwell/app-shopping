<template lang="pug">
div
  span.text-yellow Marca:
  br
  inputIndicatorFilter(
    :val="brand")
  popUpSearcheable(v-if="show_pop")
    template(slot="pop-header")
      a.d-flex.justify-content-between.align-items-center.text-info(href="#" @click.prevent="show_pop = false" style="text-decoration: none!important;")
        span Selecciona una marca
        .fas.fa-times.text-danger
    template(slot="pop-content" v-if="year")
      label.label.small.text-muted Seleccionar marca
      select.form-control.form-control-sm(type="search" placeholder="Buscar auto" v-model="brand_fiter" @change="goToBrand")
        option(value="") Selecciona una marca
        option(v-for="(brand, index) in list_brands" :key="brand.brand_slug" :value="brand.brand_slug") {{ brand.brand_name }}
    template(slot="pop-content" v-else)
      .text-center.text-muted.py-4
        h5 Primero debes seleccionar un año
</template>

<script>
import inputIndicatorFilter from './input-indicator-filter'
import popUpSearcheable from '../../components/dashboard/pop-up-searcheable'
export default {
  name: 'products-brand-filter',
  props: [
    'category',
    'categories',
    'model',
    'shipowner',
    'year',
    'branch',
    'brands',
    'brand',
  ],
  components: {
    inputIndicatorFilter,
    popUpSearcheable
  },
  data() {
    return {
      show_pop: false,
      brand_fiter: ''
    }
  },
  computed: {
    list_brands(){
      let list = this.brands.map(e => {
        return e.brand
      })
      return list
    }
  },
  methods: {
    togglePopUp(){
      if (this.category && this.shipowner && this.model && this.year) {
        this.show_pop = !this.show_pop
      }
    },
    goToBrand(){
      if(this.brand_fiter && this.category && this.shipowner && this.model && this.year) {
        let url = `/productos/${this.branch}/${this.category}`
        if(this.shipowner) url += `/${this.shipowner}`
        if(this.model) url += `/${this.model}`
        if(this.year) url += `/${this.year}`
        url += `/${this.brand_fiter}`
        location.assign(url)
      }
    },
    resetDefault(){
      let url = `/productos/${this.branch}/${this.category}/${this.shipowner}/${this.model}/${this.year}`
      location.assign(url)
    }
  },
}
</script>