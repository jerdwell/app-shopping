<template lang="pug">
  .container-fluid
    .filters-container
      .filter-select-branch
        branchSelected
      ul.nav-tabs-filters.border-yellow
        li.nav-tabs-filter-item.border-yellow(:class="$parent.type_filter == 'car' ? 'bg-yellow nav-tabs-filter-item-active' : null")
          label.m-0.text-light
            input.form-check-input.m-0.mr-2.position-static(type="radio" name="typeSearch" v-model="$parent.type_filter" value="car")
            span Auto
        li.nav-tabs-filter-item.border-yellow(:class="$parent.type_filter == 'shipowner' ? 'bg-yellow nav-tabs-filter-item-active' : null")
          label.m-0.text-light
            input.form-check-input.m-0.mr-2.position-static(type="radio" name="typeSearch" v-model="$parent.type_filter" value="shipowner")
            span Armadora
        li.nav-tabs-filter-item.border-yellow(:class="$parent.type_filter == 'code' ? 'bg-yellow nav-tabs-filter-item-active' : null")
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
.filters-container
  width: 100%
  .filter-select-branch
    margin-bottom: 30px
    width: 100%
  .nav-tabs-filters
    padding: 0
    .nav-tabs-filter-item
      border: none
      cursor: pointer
      list-style: none
      padding: 5px
      >*
        cursor: pointer
    .nav-tabs-filter-item-active
      border-radius: 5px
  @media screen and (min-width:768px)
    .nav-tabs-filters
      align-items: center
      display: flex
      justify-content: center
      .nav-tabs-filter-item
        padding: 5px 30px
        width: calc(100% / 3)
  @media screen and(min-width: 1024px)
    align-items: flex-end
    display: flex
    justify-content: space-between
    margin-bottom: 30px
    .filter-select-branch
      margin-bottom: 0
      width: 300px
    .nav-tabs-filters
      border-bottom: solid 1px
      margin-bottom: 0
      justify-content: flex-start
      width: calc(100% - 330px)
      .nav-tabs-filter-item
        border-radius: 5px 5px 0 0
        border: solid 1px
        border-bottom: none
        width: auto
      .nav-tabs-filter-item-active
        border-radius: 5px 30px 0 0
  // @media screen and(min-width: 1280px)
  //   .filter-select-branch
  //     width: 400px
  //   .nav-tabs-filters
  //     width: calc(100% - 420px)
</style>