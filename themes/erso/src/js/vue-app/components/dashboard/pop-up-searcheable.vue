<template lang="pug">
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
.pop-up-searcheable
  position: relative
  &::after
    background: rgba(0,0,0,.5)
    display: inline-block
    content: ''
    height: 100%
    left: 0
    position: fixed
    top: 0
    width: 100%
  .pop-up-content
    left: 50%
    position: fixed
    max-height: 80%
    top: 50%
    transform: translate(-50%,-50%)
    max-width: 400px
    width: 90%
    z-index: 100
  @media screen and (min-width: 768px)
    &::after
     display: none
    .pop-up-content
      left: 0
      position: absolute
      top: 100%
      transform: translate(0)
      width: 300px
</style>