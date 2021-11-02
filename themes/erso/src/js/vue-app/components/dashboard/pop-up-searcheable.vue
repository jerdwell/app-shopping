<template lang="pug">
div
  .bg-pop-searchable
  .pop-up-searcheable
    .pop-up-content
      .card
        .card-header.text-right.p-2
          slot(name="pop-header")
        .card-body
          slot(name="pop-content")
</template>

<script>
export default {
  name: 'pop-up-component'
}
</script>

<style lang="sass">
.bg-pop-searchable
  background: rgba(#000,.9)
  height: 100%
  left: 0
  position: fixed
  top: 0
  width: 100%
  z-index: 2000
.pop-up-searcheable
  left: 50%
  position: fixed
  top: 50%
  transform: translate(-50%, -50%)
  z-index: 2000
  .pop-up-content
    max-height: 80%
    max-width: 400px
    width: 90%
    z-index: 100
  @media screen and (min-width: 768px)
    &::after
     display: none
    .pop-up-content
      width: 300px
</style>