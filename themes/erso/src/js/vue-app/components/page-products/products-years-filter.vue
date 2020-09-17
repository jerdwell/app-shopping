<template lang="pug">
.cars-types-container
  a.text-light(href="#" v-show="!year_selected" @click.prevent="getYears") Año #[i.fas(:class="show_pop ? 'fa-chevron-down' : 'fa-chevron-right'")]
  div(v-show="year_selected")
    a.text-light(href="#" @click.prevent="resetDefault") #[.fas.fa-times.text-danger.mr-1] {{ year_selected }}
    input.form-control(type="hidden" name="year-selected" id="year-selected" v-model="year_selected")
  popUpSearcheable(v-show="show_pop")
    template(slot="pop-header")
      a.fas.fa-times.text-danger(href="#" @click.prevent="show_pop = false" style="text-decoration: none!important;")
    template(slot="pop-content")
      label.label.small.text-muted Seleccionar año
      select.form-control.form-control-sm(type="search" placeholder="Buscar auto" v-model="year_selected" @change="setYearSelected")
        option(value="") Selecciona un año
        option(v-for="(year, index) in years" :key="year") {{ year }}
      .mt-3(v-if="errors")
        .border.border-warning.p-2.rounded-lg.text-muted {{ errors }}

</template>

<script>
import popUpSearcheable from '../../components/dashboard/pop-up-searcheable'
export default {
  name: 'products-years-filter',
  props:[ 'category' ],
  data() {
    return {
      data_search: '',
      years: [],
      show_pop: false,
      year_selected: '',
      alias: '',
      errors: ''
    }
  },
  components: {
    popUpSearcheable
  },
  methods: {
    async getYears(){
      try {
        let car = document.getElementById('car-selected')
        if(!car || car.value == '') return false
        car = car.value.split('-')
        let results = await this.$http.get(`search-products/${car[0]}/${car[1]}`)
        if(!results.data || results.data.years.length <= 0) throw 'No existen resultados'
        let years = []
        results.data.years.map(e => {
          years = [...e.product_year.split('-'), ...years]
        })
        let range = []
        let min = Math.min(...years)
        let max = Math.max(...years)
        while (min <= max) range.push(min++)
        this.show_pop = true
        this.years = range
      } catch (error) {
        this.errors = error
      }
    },
    setYearSelected(){
      this.show_pop = false
      let car = document.getElementById('car-selected')
      if(!car || car.value == '') return false
      let url = `/productos/${this.category}/${car.value.replace('-', '/')}/${this.year_selected}`
      location.assign(url)
    },
    resetDefault(){
      this.show_pop = true
      this.year_selected = ''
      this.alias = ''
    }
  },
}
</script>

<style lang="sass" scoped>
.list-cars
  max-height: 200px
  overflow: hidden
  overflow-y: auto
</style>