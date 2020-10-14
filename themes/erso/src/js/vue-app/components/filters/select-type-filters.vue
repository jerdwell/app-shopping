<template lang="pug">
  .container
    branchSelected.mb-3
    div(v-show="get_branch_selected")
      h6.text-yellow Buscar por:
      ul.nav.nav-tabs.border-yellow.nav-tabs-filters.mb-4
        li.nav-item.border-yellow.px-3.py-2(:class="$parent.type_filter == 'car' ? 'bg-yellow nav-item-active' : null")
          label.m-0.text-light
            input.form-check-input.m-0.mr-2.position-static(type="radio" name="typeSearch" v-model="$parent.type_filter" value="car")
            span Auto
        li.nav-item.border-yellow.px-3.py-2(:class="$parent.type_filter == 'shipowner' ? 'bg-yellow nav-item-active' : null")
          label.m-0.text-light
            input.form-check-input.m-0.mr-2.position-static(type="radio" name="typeSearch" v-model="$parent.type_filter" value="shipowner")
            span Armadora
        //- li.nav-item.border-yellow.px-3.py-2(:class="$parent.type_filter == 'general' ? 'bg-yellow nav-item-active' : null")
          label.m-0.text-light
            input.form-check-input.m-0.mr-2.position-static(type="radio" name="typeSearch" v-model="$parent.type_filter" value="general")
            span General
        li.nav-item.border-yellow.px-3.py-2(:class="$parent.type_filter == 'code' ? 'bg-yellow nav-item-active' : null")
          label.m-0.text-light
            input.form-check-input.m-0.mr-2.position-static(type="radio" name="typeSearch" v-model="$parent.type_filter" value="code")
            span Código
      
</template>

<script>
import { mapGetters } from 'vuex'
import branchSelected from './branch-selected'
export default {
  name: 'select-type-filters',
  components: {
    branchSelected
  },
  computed: {
    ...mapGetters([
      'get_branch_selected', //sucursal seleccionada
    ])
  },
}
</script>

<style lang="sass">
  .nav-tabs-filters
    .nav-item
      border-radius: 5px 5px 0 0
      border: solid 1px white
      &:hover > *
        cursor: pointer
    .nav-item-active
      border-radius: 10px 30px 0 0
</style>