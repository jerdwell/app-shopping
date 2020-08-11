<template lang="pug">
  div
    label.text-center.text-light Auto - Armadora:
    .input-group.mb-3.rounded-pill(style="overflow:hidden;")
      .input-group-prepend
        .input-group-text
          i.oi.oi-magnifying-glass(v-if="!$parent.car_model_selected.model_id")
          i.oi.oi-x.text-danger(v-else)
      input.form-control.form-control-sm(
        type="search"
        placeholder="Buscar"
        @change="serach_cars"
        v-model="car_search"
        v-if="!$parent.car_model_selected.model_id")
      input.form-control.form-control-sm(
        type="text"
        :value="getCarModel()"
        v-on:click="$parent.car_model_selected = {}"
        v-else
      )
    
    .text-center(v-if="loading")
      .spinner-border
    
    ul.list-group.bg-transparent.small.list-models-searchable(v-if="results && !$parent.car_model_selected.model_id")
      li.list-group-item.bg-transparent.border-light.p-0(v-if="carsModels.data && carsModels.data.length > 0")
        table.table.table-results
          thead
            tr
              th.bg-yellow.text-light
              th.bg-yellow.text-light Marca
              th.bg-yellow.text-light Vehículo
          tbody
            tr(v-for="(car_model, index) in carsModels.data" :key="index")
              td
                input.form-control-checkbox.mr-2(
                  type="radio"
                  :name="car_model.shipowner_slug"
                  :value="{model_id:car_model.model_id, shipowner_id: car_model.shipowner_id}"
                  v-model="$parent.car_model_selected"
                  @change="getListProductsFiletered")
              td.text-white {{ car_model.shipowner_name }}
              td.text-white {{ car_model.model_name }}

      li.list-group-item.bg-transparent.p-1.border-danger.text-danger(v-if="carsModels.data && carsModels.data.length <= 0") #[span.oi.oi-circle-x] No existen resultados


</template>

<script>
import { mapActions } from 'vuex'
export default {
  name: 'car-filters',
  data(){
    return {
      loading: false,
      results: false,
      carsModels: [],
      car_search: ''
    }
  },
  methods: {
    ...mapActions([
      'serachProductModelShipowner', //sel tis products finded
    ]),
    async serach_cars(){
      if(this.car_search.replace(/\s/g, '').length <= 0) {
        this.carsModels = []
        return false
      }
      this.loading = true
      try {
        let carsModels = await this.$http.get(`/search-car-model/${this.car_search}`)
        this.loading = false
        this.results = true
        this.carsModels = carsModels
      } catch (error) {
        console.log(errors);
      }
    },
    async getListProductsFiletered(){
      if(this.$parent.car_model_selected.model_id == '' && this.$parent.car_model_selected.shipowner_id == '') return false
      try{
        let products = await this.serachProductModelShipowner(this.$parent.car_model_selected)
      }catch(error){
        console.log(error)
      }
    },
    getCarModel(){
      let model_id = this.$parent.car_model_selected.model_id
      let shipowner_id = this.$parent.car_model_selected.shipowner_id
      let data = this.carsModels.data.find(i => i.model_id == model_id && i.shipowner_id == shipowner_id)
      return data.shipowner_name + ' - ' + data.model_name
    }
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
</style>