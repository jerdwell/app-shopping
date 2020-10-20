<template lang="pug">
.cars-types-container
  a(:class="model_selected ? 'text-yellow' :'text-light'" href="#" v-show="!car_selected && !alias" @click.prevent="show_pop = !show_pop")
    span {{ model_selected ? model_selected :'Auto'}}
    i.fas.ml-1(:class="show_pop ? 'fa-chevron-down' : 'fa-chevron-right'" v-if="!model_selected")
    i.fas.ml-1(:class="show_pop ? 'fa-chevron-down' : 'fa-check'" v-else)
  div(v-show="car_selected && alias")
    a.text-light(href="#" @click.prevent="resetDefault") #[.fas.fa-times.text-danger.mr-1] {{ alias }}
    input.form-control(type="hidden" id="car-selected" v-model="car_selected")

  popUpSearcheable(v-show="show_pop")
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
      this.show_pop = true
      this.car_selected = ''
      this.alias = ''
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