<template lang="pug">
.controll-filters
  a.button-filters(v-show="!searchProduct" @click="toggleSearch" href="#filter-products")
      span Buscar productos
      span.oi.oi-magnifying-glass.icon-button-filter
  button.button-filters(v-show="searchProduct" @click="toggleSearch")
    span.text-yellow.mr-2 Cancelar búsqueda
    span.oi.oi-x.icon-button-filter.text-yellow.border-yellow
</template>

<script>
export default {
  name: 'button-search-products',
  data() {
    return {
      searchProduct: false
    }
  },
  methods: {
    toggleSearch(){
      this.searchProduct = !this.searchProduct
    }
  },
}
</script>

<style lang="sass">
.controll-filters
  .button-filters
    align-items: center
    background: transparent
    display: inline-flex
    border: none
    color: white
    justify-content: flex-end
    flex-direction: row-reverse
    width: 100%
    .icon-button-filter
      align-items: center
      border-radius: 50%
      border: solid 2px white
      display: inline-flex
      justify-content: center
      height: 40px
      margin-right: 10px
      width: 40px
  @media screen and (min-width: 768px)
    .button-filters
      padding: 0
      margin-bottom: 20px
  @media screen and (min-width: 1024px)
    .button-filters
      margin-bottom: 0px
      span
        &:first-child
          text-align: right
</style>