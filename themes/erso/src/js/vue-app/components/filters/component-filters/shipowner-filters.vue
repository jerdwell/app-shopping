<template lang="pug">
  div
    label.text-center.text-light Armadora:
    .input-group.mb-3.rounded-pill(style="overflow:hidden;")
      .input-group-prepend
        .input-group-text
          i.fas.fa-search(v-if="!$parent.car_model_selected.model_id")
          i.fas.fa-times.text-danger(v-else)
      input.form-control.form-control-sm(
        type="search"
        placeholder="Buscar"
        @input="serach_cars"
        v-model="shipowner_search"
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
      li.list-group-item.bg-transparent.border-light.p-0(v-if="shipowners.data && shipowners.data.length > 0")
        table.table.table-results
          thead
            tr
              th.bg-yellow.text-light
              th.bg-yellow.text-light Marca
              th.bg-yellow.text-light Auto
          tbody
            tr(v-for="(car_model, index) in shipowners.data" :key="index")
              td
                input.form-control-checkbox.mr-2(
                  type="radio"
                  :name="car_model.id"
                  :value="{model_id:car_model.car.id, shipowner_id: car_model.shipowner.id}"
                  v-model="$parent.car_model_selected"
                  @change="getListProductsFiletered")
              td.text-white(@click.prevent="toggleCheckboxBtn(car_model.id)") {{ car_model.shipowner.shipowner_name }}
              td.text-white(@click.prevent="toggleCheckboxBtn(car_model.id)") {{ car_model.car.car_name }}

      li.list-group-item.bg-transparent.p-1.border-danger.text-danger(v-if="shipowners.data && shipowners.data.length <= 0") #[span.fas.fa-times-circle] No existen resultados


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
      shipowner_search: ''
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
      try{
        let products = await this.serachProductModel(this.$parent.car_model_selected)
      }catch(error){
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
    toggleCheckboxBtn(id){
      let input = document.getElementsByName(id)[0]
      input.click()
    }
  }
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