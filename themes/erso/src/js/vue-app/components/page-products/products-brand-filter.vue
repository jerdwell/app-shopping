<template lang="pug">
div
  span.text-yellow Marca:
  br
  a(href="#" :class="brand ? 'text-yellow' : 'text-light'" @click.prevent="togglePopUp")
    span.text-capitalize {{ brand ? brand : 'Selecciona' }}
    i.fas.ml-1(:class="show_pop ? 'fa-chevron-down' : 'fa-chevron-right'" v-if="!brand")
    i.fas.ml-1(:class="show_pop ? 'fa-chevron-down' : 'fa-check'" v-else)
  popUpSearcheable(v-if="show_pop")
    template(slot="pop-header")
      a.d-flex.justify-content-between.align-items-center.text-info(href="#" @click.prevent="show_pop = false" style="text-decoration: none!important;")
        span Selecciona una marca
        .fas.fa-times.text-danger
    template(slot="pop-content")
      label.label.small.text-muted Seleccionar marca
      select.form-control.form-control-sm(type="search" placeholder="Buscar auto" v-model="brand_fiter" @change="goToBrand")
        option(value="") Selecciona una marca
        option(v-for="(brand, index) in list_brands" :key="brand.brand_slug" :value="brand.brand_slug") {{ brand.brand_name }}
</template>

<script>
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
    }
  },
}
</script>