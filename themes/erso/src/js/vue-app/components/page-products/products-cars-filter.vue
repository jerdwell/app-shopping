<template lang="pug">
.cars-types-container
  span.text-yellow Auto:
  br
  inputIndicatorFilter(
    :val="model_selected")

  popUpSearcheable(v-if="show_pop") 
    template(slot="pop-header")
      a.d-flex.justify-content-between.align-items-center.text-info(href="#" @click.prevent="show_pop = false" style="text-decoration: none!important;")
        span Selecciona un auto
        .fas.fa-times.text-danger
    template(slot="pop-content")
      .input-group
        .input-group-prepend
          .input-group-text
            i.fas.fa-search
        select.form-control.form-control-sm(v-model="car_selected" @change="setCarSelected")
          option(value="") Selecciona una opción
          option(v-for="item in list_cars" :key="item.id" :value="item.car") {{ item.car.car_name }}
      .mt-3(v-if="errors")
        .border.border-warning.p-2.rounded-lg.text-muted {{ errors }}

</template>

<script>
import inputIndicatorFilter from './input-indicator-filter'
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
      errors: '',
      list_cars: []
    }
  },
  props: [
    'model_selected',
    'shipowner',
    'branch',
    'category',
  ],
  components: {
    inputIndicatorFilter,
    popUpSearcheable
  },
  methods: {
    async getListCar(){
      if(!this.shipowner) return
      let list = await this.$http.get(`/list-shipowners-cars/${this.shipowner}`)
      this.list_cars = list.data
    },
    setCarSelected(){
      this.show_pop = false
      this.alias = this.car_selected.car_name
      this.car_selected = this.shipowner + '/' + this.car_selected.id
      location.assign(`/productos/${this.branch}/${this.category}/${this.car_selected}`)
    },
    resetDefault(){
      location.assign(`/productos/${this.branch}/${this.category}/${this.shipowner}`)
    }
  },
  mounted() {
    this.getListCar()
  },
}
</script>

<style lang="sass" scoped>
.list-cars
  max-height: 200px
  overflow: hidden
  overflow-y: auto
.list-search-car-item, .list-search-car-item label
  cursor: pointer
</style>