<template lang="pug">
  div
    button.btn.btn-cart-control.btn-cart-controll-remove.border-danger
      .oi.oi-minus.text-danger
    
    input.form-control.form-control-sm.w-50.w-md-25.d-inline-block.mx-2.align-middle(type="text" readonly)

    button.btn.btn-cart-control.btn-cart-controll-add.border-info
      .oi.oi-plus.text-info
</template>

<script>
export default {
  name: 'cart-control-buttons'
}
</script>

<style lang="sass">
  .btn-cart-control
    align-items: center
    border-radius: 50%
    display: inline-flex
    height: 35px
    justify-content: center
    vertical-align: middle
    width: 35px
</style>