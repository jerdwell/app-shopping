<template lang="pug">
.row
  .col-md-6
    label.small.text-center.text-light Armadora:
    .input-group.mb-3.rounded-pill(style="overflow:hidden;")
      .input-group-prepend
        .input-group-text
          i.fas.fa-list
      select.form-control.form-control-sm(@change="getListCarsShipowners" v-model="$parent.car_model_selected.shipowner_id")
        option(value="") Selecciona una opción
        option(v-for="(shipowner,key) in listShipowners" :key="shipowner.id" :value="shipowner.id") {{ shipowner.shipowner_name }}
    
    .text-center(v-if="loading")
      .spinner-border.text-light
  
  .col-md-6
    label.text-center.text-light Auto:
    .input-group.mb-3.rounded-pill(style="overflow:hidden;")
      .input-group-prepend
        .input-group-text
          i.fas.fa-list
      select.form-control.form-control-sm(@change="getListProductsFiletered" v-model="$parent.car_model_selected.model_id")
        option(value="") Selecciona una opción
        option(v-for="car in listCars" :key="car.id" :value="car.car.id") {{ car.car.car_name }}

</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
  name: 'shipowner-filters',
  data(){
    return {
      loading: false,
      results: false,
      shipowners: [],
      shipowner_search: '',
      listShipowners: [],
      listCars: []
    }
  },
  computed:{
    ...mapGetters([
      'get_branch_selected', //get branch selected
    ])
  },
  methods: {
    ...mapActions([
      'serachProductModel', //sel tis products finded
      'setListShipowners', //get list shipowners
    ]),
    async serach_cars(){
      if(this.shipowner_search.replace(/\s/g, '').length <= 0) {
        this.shipowners = []
        return false
      }
      this.loading = true
      try {
        let shipowners = await this.$http.get(`/search-shipowner/${this.get_branch_selected}/${encodeURI(this.shipowner_search)}`)
        this.loading = false
        this.results = true
        this.shipowners = shipowners
      } catch (error) {
        error
      }
    },
    async getListProductsFiletered(){
      this.$parent.category_selected = ''
      this.$parent.year_selected = ''
      if(this.$parent.car_model_selected.model_id == '' && this.$parent.car_model_selected.shipowner_id == '') return false
      this.loading = true
      try{
        this.loading = false
        let products = await this.serachProductModel(this.$parent.car_model_selected)
      }catch(error){
        this.loading = false
        console.log(error)
      }
    },
    getCarModel(){
      let model_id = this.$parent.car_model_selected.model_id
      let shipowner_id = this.$parent.car_model_selected.shipowner_id
      let data = this.shipowners.data.find(i => i.car.id == model_id && i.shipowner.id == shipowner_id)
      console.log(data)
      return data.shipowner.shipowner_name + ' - ' + data.car.car_name
    },
    async getListShipowners(){
      this.loading = true
      try {
        let list = await this.setListShipowners()
        this.listShipowners = list.data
        this.loading = false
      } catch (error) {
        console.log(error)
        this.loading = false
      }
    },
    async getListCarsShipowners() {
      this.loading = true
      try {
        let listCars = await this.$http.get(`list-shipowners-cars/${this.$parent.car_model_selected.shipowner_id}`)
        this.listCars = listCars.data
        this.loading = false
      } catch (error) {
        this.loading = false
        console.log(error)
      }
    }
  },
  mounted() {
    this.getListShipowners()
  },
}
</script>

<style lang="sass" scoped>
  .input-group-prepend
    cursor: pointer
  input
    &:focus
      border: none
      box-shadow: none
  .list-models-searchable
    max-height: 200px
    overflow-y: auto
  .table-results
    position: relative
    thead
      tr
        th
          position: sticky
          top: 0
          left: 0
    tbody
      tr
        td
          cursor: pointer
</style>