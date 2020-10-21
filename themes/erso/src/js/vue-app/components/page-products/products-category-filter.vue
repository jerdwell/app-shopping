<template lang="pug">
div
  span.text-yellow Categoría:
  //- i.fas.fa-chevron-right.mr-2.text-yellow
  a.text-yellow(href="#" @click.prevent="show_pop = !show_pop")
    span &nbsp; {{ category }}
  popUpSearcheable(v-if="show_pop")
    template(slot="pop-header")
      a.d-flex.justify-content-between.align-items-center.text-info(href="#" @click.prevent="show_pop = false" style="text-decoration: none!important;")
        span Selecciona una categoría
        .fas.fa-times.text-danger
    template(slot="pop-content")
      label.label.small.text-muted Seleccionar categoría
      select.form-control.form-control-sm(type="search" placeholder="Buscar auto" v-model="category_fiter" @change="goToCategory")
        option(value="") Selecciona una categoría
        option(v-for="(category, index) in categories" :key="category.slug" :value="category.category_slug") {{ category.category_name }}
</template>

<script>
import popUpSearcheable from '../../components/dashboard/pop-up-searcheable'
export default {
  name: 'products-category-filter',
  props: [
    'category',
    'categories',
    'model',
    'shipowner',
    'year',
    'branch',
  ],
  components: {
    popUpSearcheable
  },
  data() {
    return {
      show_pop: false,
      category_fiter: ''
    }
  },
  methods: {
    goToCategory(){
      if(this.category_fiter) {
        let url = `/productos/${this.branch}/${this.category_fiter}`
        if(this.shipowner) url += `/${this.shipowner}`
        if(this.model) url += `/${this.model}`
        if(this.year) url += `/${this.year}`
        location.assign(url)
      }
    }
  }
}
</script>