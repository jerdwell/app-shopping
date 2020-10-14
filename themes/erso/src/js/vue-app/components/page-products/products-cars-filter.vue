<template lang="pug">
.cars-types-container
  a.text-light(href="#" v-show="!car_selected && !alias" @click.prevent="show_pop = !show_pop") {{ model_shipowner ? model_shipowner :'Auto'}} #[i.fas(:class="show_pop ? 'fa-chevron-down' : 'fa-chevron-right'")]
  div(v-show="car_selected && alias")
    a.text-light(href="#" @click.prevent="resetDefault") #[.fas.fa-times.text-danger.mr-1] {{ alias }}
    input.form-control(type="hidden" id="car-selected" v-model="car_selected")

  popUpSearcheable(v-show="show_pop")
    template(slot="pop-header")
      a.fas.fa-times.text-danger(href="#" @click.prevent="show_pop = false" style="text-decoration: none!important;")
    template(slot="pop-content")
      label.label.small.text-muted Buscar
      .input-group
        .input-group-prepend
          .input-group-text
            i.fas.fa-search
        input.form-control.form-control-sm(type="search" placeholder="Buscar auto" @keypress="filterCar" v-model="data_search")
      ul.list-cars.list-group.list-group-flush.mt-3(v-if="cars.length > 0")
        li.list-group-item.p-1(v-for="(car, index) in cars" :key="car.id")
          label
            input.form-control-checkbox.mr-2(type="checkbox" @click="setCarSelected(car)")
            .small.d-inline-block {{ car.car.car_name }} - {{ car.shipowner.shipowner_name }}
      .mt-3(v-if="errors")
        .border.border-warning.p-2.rounded-lg.text-muted {{ errors }}

</template>

<script>
import popUpSearcheable from '../../components/dashboard/pop-up-searcheable'
export default {
  name: 'products-cars-filter',
  data() {
    return {
      data_search: '',
      cars: [],
      show_pop: false,
      car_selected: '',
      alias: '',
      errors: ''
    }
  },
  props: [
    'model_shipowner',
    'branch',
    'category',
  ],
  components: {
    popUpSearcheable
  },
  methods: {
    async filterCar(){
      try {
        this.cars = []
        if (this.data_search.length <= 0) return
        let cars = await this.$http.get(`/search-car-model/${this.data_search}`)
        if(cars.data.length <= 0) return this.errors = 'No existen coincidencias'
        this.cars = cars.data
      } catch (error) {
        this.errors = error
      }
    },
    setCarSelected(car){
      console.log(car)
      this.show_pop = false
      this.car_selected =  car.car.id + '-' + car.shipowner.id
      this.alias = car.car.car_name + '-' + car.shipowner.shipowner_name
      location.assign(`/productos/${this.branch}/${this.category}/${this.car_selected.replace('-','/')}`)
    },
    resetDefault(){
      this.show_pop = true
      this.car_selected = ''
      this.alias = ''
    }
  },
  mounted() {
    console.log(this.model_shipowner);
  },
}
</script>

<style lang="sass" scoped>
.list-cars
  max-height: 200px
  overflow: hidden
  overflow-y: auto
</style>