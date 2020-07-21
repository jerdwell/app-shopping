<template lang="pug">

  .pop-product-cart
    .pop-product-overlay
    .pop-product-item.card
      .card-body.text-dark
        h4.text-center.text-muted {{ productData.product_name }}
        hr
        .row
          .col-md-5
            img.w-100(:src="productData.product_cover.path")
          .col-md-7
            h6.text-muted Aplicación
            p {{ productData.product_description }}
            div(v-if="productData.product_brands_customer.length > 0")
              ul.list-group(v-if="productData.product_brands_customer.length > 0")
                li.list-group-item(v-for="(brand, index) in productData.product_brands_customer" :key="index")
                  h5 Marca: {{ brand.brand_name }}
                  hr
                  ul.list-group.list-group-flush
                    li.list-group-item.py-1 #[b Precio: ] #[b.lead ${{ brand.pivot.brand_public_price }}]
                    li.list-group-item.py-1(v-show="brand.pivot.remark != null") #[b Observaciones: ] {{ brand.pivot.remark }}
                    li.list-group-item.py-1(v-if="productData.product_stock != null") #[small Disponible en las sucursales de: ]
                      p.my-1.py-0.border-info.border-bottom.pb-2(v-for="(branch, i) in getStockBrand(productData.product_stock, brand.pivot.brand_code)" :key="i")
                        small #[b.text-info Sucursal: ] {{ branch.branch_name }}
                        br
                        //- small #[b.text-info Stock: ] {{ branch.stock_product }}pz.
                        //- br
                        //- button.btn.btn-sm.btn-info Agregar
                        CartControlButtons
                        
                        //TODO: Falta agregar la funcionalidad del botón para agregar elementos al carrito de compra u order.
                    
                    li.list-group-item.py-1(v-else)
                      h4.text-center.text-muted No existen productos disponibles
            h4.text-center.text-muted(v-else) No existen productos disponibles
        .text-right.my-2
          button.btn.btn-info(@click="$parent.showPop = false") Cerrar

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
    getStockBrand(stock, code){
      let item = stock.filter(i => { if(i.brand_code == code) return i })
      return item
    }
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