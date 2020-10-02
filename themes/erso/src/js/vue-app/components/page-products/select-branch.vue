<template lang="pug">
  a.branch-item(:href="'/productos/' + branch.slug " @click.prevent="setBranch")
    .branch-item-icon.bg-primary
      .fas.fa-map-marker-alt.text-white
    h3.branch-item-name.text-center.text-white.mt-3 {{ branch.branch_name }}
</template>
<script>
import { mapActions } from 'vuex'
export default {
  name: 'select-branch',
  props: ['branch'],
  methods: {
    ...mapActions([
      'setBranchSelected', //set branch selected
    ]),
    setBranch(){
      this.setBranchSelected(this.branch.slug)
      location.assign('/productos/' + this.branch.slug)
    }
  },
}
</script>
<style lang="sass">
.branch-item
  align-content: center
  background-image: radial-gradient(rgba(#000,.5) 0%, rgba(#000,.5) 50%, rgba(#000,.9) 50%, rgba(#000,.9) 100%)
  background-size: 5px 5px
  display: flex
  flex-wrap: wrap
  justify-content: center
  padding: 30px
  text-decoration: none!important
  width: 100%
  &:hover
    .branch-item-icon
      transform: scale(1.2) rotate(15deg)
      box-shadow: 0 10px 10px rgba(#000, .6)
    .branch-item-name
      transform: scale(1.2)
  .branch-item-icon
    align-items: center
    border-radius: 50%
    height: 120px
    display: flex
    justify-content: center
    font-size: 80px
    transition: all ease .5s
    width: 120px
  .branch-item-name
    text-shadow: 0 0 10px rgba(#000,.9)
    transition: all ease .5s
    width: 100%
  @media screen and(min-width:768px)
    align-content: flex-start
    padding-top: 60px
    height: 300px
    width: calc(100% / 3)
</style>