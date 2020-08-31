<template lang="pug">
.cars-types-container
  a.text-light(href="#" v-show="!year_selected && !alias" @click.prevent="getYears") Año #[i.fas(:class="show_pop ? 'fa-chevron-down' : 'fa-chevron-right'")]
  div(v-show="year_selected && alias")
    a.text-light(href="#" @click.prevent="resetDefault") #[.fas.fa-times.text-danger.mr-1] {{ alias }}
    input.form-control(type="text" name="car-selected" v-model="year_selected")
  popUpSearcheable(v-show="show_pop")
    template(slot="pop-header")
      a.fas.fa-times.text-danger(href="#" @click.prevent="show_pop = false" style="text-decoration: none!important;")
    template(slot="pop-content")
      label.label.small.text-muted Seleccionar año
      select.form-control.form-control-sm(type="search" placeholder="Buscar auto" v-model="data_search")
      //- ul.list-cars.list-group.list-group-flush.mt-3(v-if="cars.length > 0")
        li.list-group-item.p-1(v-for="(car, index) in cars" :key="car.model_id")
          label
            input.form-control-checkbox.mr-2(type="checkbox" @click="setCarSelected(car)")
            .small.d-inline-block {{ car.shipowner_name }} - {{ car.model_name }}
      //- .mt-3(v-if="errors")
        .border.border-warning.p-2.rounded-lg.text-muted {{ errors }}

</template>

<script>
import popUpSearcheable from '../../components/dashboard/pop-up-searcheable'
export default {
  name: 'products-years-filter',
  data() {
    return {
      data_search: '',
      cars: [],
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
        car = car.value.split('-')
        // this.years = []
        // if (this.data_search.length <= 0) return
        let years = await this.$http.get(`search-products/${car[0]}/${car[1]}`)
        console.log(years)
        // if(cars.data.length <= 0) return this.errors = 'No existen coincidencias'
        // this.years = years.data
        // console.log(years)
      } catch (error) {
        this.errors = error
        console.log(error)
      }
    },
    // setCarSelected(car){
    //   this.show_pop = false
    //   this.year_selected = car.model_id
    //   this.alias = car.shipowner_name + '-' + car.model_name
    // },
    // resetDefault(){
    //   this.show_pop = true
    //   this.year_selected = ''
    //   this.alias = ''
    // }
  },
}
</script>

<style lang="sass" scoped>
.list-cars
  max-height: 200px
  overflow: hidden
  overflow-y: auto
</style>