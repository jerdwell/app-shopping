<template lang="pug">
.shipowners-types-container
  a(:class="shipowner_selected ? 'text-yellow' : 'text-light'" href="#" v-show="!shipowner && !alias" @click.prevent="show_pop = !show_pop") {{ shipowner_selected ? shipowner_selected :'Armadora'}}
    i.fas.ml-1(:class="show_pop ? 'fa-chevron-down' : 'fa-chevron-right'" v-if="!shipowner_selected")
    i.fas.ml-1(:class="show_pop ? 'fa-chevron-down' : 'fa-check'" v-else)
  div(v-show="shipowner && alias")
    a.text-light(href="#" @click.prevent="resetDefault") #[.fas.fa-times.text-danger.mr-1] {{ alias }}
    input.form-control(type="hidden" id="car-selected" v-model="shipowner")

  popUpSearcheable(v-show="show_pop")
    template(slot="pop-header")
      a.fas.fa-times.text-danger(href="#" @click.prevent="show_pop = false" style="text-decoration: none!important;")
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
import popUpSearcheable from '../../components/dashboard/pop-up-searcheable'
export default {
  name: 'product-shipowner-filter',
  components: {
    popUpSearcheable
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
      console.log(this.shipowner_setted);
    }
  },
  mounted() {
    this.getListShipowners()
  },
}
</script>