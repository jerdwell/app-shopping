<template lang="pug">

  .pop-product-cart
    .pop-product-overlay
    .pop-product-item.card
      .card-body.text-dark
        h4.text-center.text-muted {{ productData.product_name }}
        hr
        .row
          .col-8.col-md-4.offset-2.offset-md-0
            img.w-100(:src="`/storage/app/media/${productData.product_cover}`")
          .col-12.col-md-8
            span.h6.text-info Costo: {{ productData.public_price == null ? 'No hay dato' : `$${productData.public_price}` }}
            br
            span.small.text-muted #[b Notas: ] {{ productData.product_note }}
            br
            span.small.text-muted #[b Año: ] {{ productData.product_year }}
            br
            span.small.text-muted #[b Aplicación: ] {{ productData.product_escription }}
            br
            span.small.text-muted #[b Modelo: ] {{ productData.car.model_name }}
            br
            span.small.text-muted #[b Auto: ] {{ productData.shipowner.shipowner_name }}
            br
            span.small.text-muted #[b Marca: ] {{ productData.brand.brand_name }}
            br
            div.mt-2
              label.text-secondary Selecciona una sucursal
              select.form-control(style="max-width:350px;")
                option(value="") Selecciona una opción
                option(value="") Tlalnepantla
                option(value="") Cuautitlan Izcalli
                option(value="") Coacalco
            .mt-4.text-center(style="max-width:350px;")
              h6.text-muted Agregar
              button.btn.btn-danger.bg-transparent.border-danger.text-danger #[.oi.oi-minus]
              input.form-control-inline.mx-1.align-middle.text-center(disabled value="0" style="max-width:100px;")
              button.btn.btn-info.bg-transparent.border-info.text-info #[.oi.oi-plus]
        
        .text-right.my-2.mt-5
          button.btn.btn-info.btn-block(@click="$parent.showPop = false") Cerrar

      //- span {{productData}}
  
</template>

<script>
import CartControlButtons from './cart-control-buttons'
export default {
  components: {
    CartControlButtons
  },
  props: [
    'productData', //información del producto
  ],
  methods: {  
  },

  mounted(){
    document.querySelector('.navbar-main-erso').style.opacity = 0
    document.body.style.overflowY = 'hidden'
  },

  destroyed(){
    document.querySelector('.navbar-main-erso').style.opacity = 1
    document.body.style.overflowY = 'auto'
  }
}
</script>

<style lang="sass">
.pop-product-cart
  left: 0
  height: 100vh
  overflow-y: auto
  padding: 30px 3%
  position: fixed
  top: 0
  width: 100%
  z-index: 3100
  .pop-product-overlay
    background: rgba(#000, .5)
    height: 100vh
    left: 0
    position: fixed
    top: 0
    width: 100vw
  .pop-product-item
    margin: auto
    max-width: 800px!important
</style>