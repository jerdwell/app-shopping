<template lang="pug">
.controll-filters
  a.button-filters(v-show="!get_show_filters" @click="toggleSearch" href="#filter-products")
    span Cotizar productos
    i.fas.fa-search.icon-button-filter
  button.button-filters(v-show="get_show_filters" @click="toggleSearch")
    span.text-yellow Cancelar
    i.oi.oi-x.icon-button-filter.text-yellow.border-yellow
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
  name: 'button-search-products',
  computed: {
    ...mapGetters([
      'get_show_filters', //get param to show filters
    ])
  },
  methods: {
    ...mapActions([
      'toggleFliters', //toggle search filters
    ]),
    toggleSearch(){
      this.toggleFliters()
    }
  },
  mounted(){
    if(performance.navigation.type == performance.navigation.TYPE_RELOAD) this.get_show_filters ? this.toggleFliters() : null
  }
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
      margin-right: 10px
      line-height: 0
      top: 0
      height: 40px
      width: 40px
  @media screen and (min-width: 768px)
    .button-filters
      padding: 0
      margin-bottom: 20px
  @media screen and (min-width: 1024px)
    width: 100%
    .button-filters
      justify-content: flex-end
      margin-bottom: 0px
      flex-direction: row
      .icon-button-filter
        margin-right: 0
        margin-left: 10px
      span
        &:first-child
          text-align: right
        width: calc(100% - 50px)
</style>