<template lang="pug">
.shipowners-types-container
  span.text-yellow Armadora:
  br
  inputIndicatorFilter(
    :val="shipowner_selected")

  popUpSearcheable(v-if="show_pop")
    template(slot="pop-header")
      a.d-flex.justify-content-between.align-items-center.text-info(href="#" @click.prevent="show_pop = false" style="text-decoration: none!important;")
        span Selecciona una armadora
        i.fas.fa-times.text-danger
    template(slot="pop-content")
      ul.list-shipowners.list-group.list-group-flush.mt-3(v-if="list_shipowners.length > 0")
        li.list-group-item.p-1.list-search-car-item
          label
            select.form-control(v-model="shipowner_setted" @change="gotToShipowner()")
              option(value="") Selecciona una opción
              option(v-for="(item, index) in list_shipowners" :key="item.id" :value="item.id") {{ item.shipowner_name }}
      .mt-3(v-if="errors")
        .border.border-warning.p-2.rounded-lg.text-muted {{ errors }}
</template>

<script>
import inputIndicatorFilter from './input-indicator-filter'
import popUpSearcheable from '../../components/dashboard/pop-up-searcheable'
export default {
  name: 'product-shipowner-filter',
  components: {
    popUpSearcheable,
    inputIndicatorFilter
  },
  data() {
    return {
      show_pop: false,
      alias: '',
      shipowner: '',
      list_shipowners: [],
      shipowner_setted: '',
      errors: ''
    }
  },
  props: [
    'branch',
    'category',
    'shipowner_selected'
  ],
  methods: {
    async getListShipowners(){
      let list = await this.$http.get('list-shipowners')
      this.list_shipowners = list.data
    },
    gotToShipowner(){
      location.assign(`/productos/${this.branch}/${this.category}/${this.shipowner_setted}`)
    },
    resetDefault(){
      location.assign(`/productos/${this.branch}/${this.category}`)
    }
  },
  mounted() {
    this.getListShipowners()
  },
}
</script>