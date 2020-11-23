<template lang="pug">
.mb-3.product-item-browser(
    data-aos="fade-up"
    data-aos-offset="50"
  )
  .card-product-item.card
    .card-header.p-0.bg-white(stye="z-index:0; position: relative;")
      a.link.text-info.mb-4(:href="`/productos/${get_branch_selected}/producto/${product.id}`")
        .product-brand-container.py-1
          img.product-brand-img(v-lazy="'/storage/app/media/' + product.brand.brand_logo" v-if="product.brand.brand_logo")
        .product-item-image.bg-white
          img(v-lazy="'/storage/app/media/products/' + (product.product_cover != '' ? product.product_cover : 'no_disponible.jpg')")
          //- img.w-100(:src="'/storage/app/media/products/' + (product.product_cover != '' ? product.product_cover : 'no_disponible.jpg')")
    .card-body.p-0
      .product-item-data.py-3.bg-dark
        .product-item-data-description.text-lg-center.pt-lg-3
          a.link.text-info.mb-4(:href="`/productos/${get_branch_selected}/producto/${product.id}`" style="text-decoration:none;")
            span.h6.text-info {{ product.product_name }}
          p.mb-0.small
            span.text-light Marca: {{ product.brand.brand_name }}
            br
            span.text-light Nota: 
              span(v-if="product_notes != 'N/A'") {{ product_notes.length < 60 ? product_notes : product_notes.substring(0,60) + '...' }} #[a.text-info.small(v-if="product_notes.length > 60" :href="`/productos/producto/${product.id}`") Ver más]
              span(v-else) {{ product_notes }}
            br
            span.text-light Stock: {{ product_stock }}
            br
            span.text-light #[b.text-yellow.text-center Auto - Armadora]:
            br
            div.car-shipowner-description
              small.small.text-light {{ car_shipowner.preview }}
              a.text-yellow.small(v-if="car_shipowner.complements.length > 3" href="#" @click.prevent="toggleModalComplements") &nbsp; ... ver todos ({{car_shipowner.complements.length}} más)

            span.small.text-light Código: {{ product.erso_code }}
            br
            b.text-info.mb-0.pb-0.lead(v-if="!get_token") {{ product.public_price != null ? '$' + product.public_price.replace(/\B(?=(\d{3})+(?!\d))/g, ",") : 'Precio no disponible' }}
            b.text-info.mb-0.pb-0.lead(v-else) {{ product.customer_price != null ? '$' + product.customer_price.replace(/\B(?=(\d{3})+(?!\d))/g, ",") : 'Precio no disponible' }}
        .col-12.bg-light.py-2.pb-3.mt-2
          product-handler(:product="product")
  .complements-applications.bg-dark(v-if="show_complements")
    .close-complements-applications-container.bg-dark.p-2.text-right
      a.close-complements-applications.border-danger.bg-dark(href="#" @click.prevent="toggleModalComplements")
        .fas.fa-times.text-danger
    ul.list-group
      li.list-group-item.text-yellow.bg-transparent(v-for="(complement, index) in car_shipowner.complements" :key="index") {{ complement }}
</template>

<script>
import { mapGetters } from 'vuex'
import productHandler from './product-handler'
export default {
  data() {
    return {
      show_complements: false
    }
  },
  props: [
    'product'
  ],
  computed: {
    ...mapGetters([
      'get_token', //get token user
      'get_branch_selected', //get branch selected
    ]),
    product_stock(){
      let branch = this.product.branches.find(e => e.slug == this.get_branch_selected)
      return branch && branch.pivot.stock != 0 ? branch.pivot.stock + 'pz' : 'No disponible'
    },
    product_notes(){
      let notes = []
      this.product.applications.forEach(note => {
        if(note.note != ''){
          if(notes.indexOf(note.note) < 0) notes.push(note.note)
        }
      })
      return (notes.length <= 0) ? 'N/A' : notes.join(',')
    },
    car_shipowner(){
      let car_shipowner = []
      let complements = []
      let i = 0
      this.product.applications.forEach(e => {
        if(i < 3){
          car_shipowner.push(e.car.car_name)
        }
        complements.push(e.car.car_name + ' / ' + e.shipowner.shipowner_name)
        i ++
      })
      return {
        preview: car_shipowner.join(', '),
        complements: complements
      }
    }
  },
  components: {
    productHandler
  },
  methods: {
    toggleModalComplements(){
      this.show_complements = !this.show_complements
    }
  },
}
</script>

<style lang="sass">
.card-product-item
.product-item-browser
  border-radius: 30px!important
  overflow: hidden!important
  box-shadow: 0 5px 15px rgba(0,0,0,.6)
  .product-item-image
    align-items: center
    height: 200px
    display: flex
    flex-wrap: wrap
    justify-content: center
    width: 100%
    img
      width: 90%
  .product-item-data
    // margin-top: -20px
    z-index: 10
    // border-radius: 30px 30px 5px 5px
    padding-bottom: 0!important
    position: relative
    .product-item-data-description
      height: 250px
      .car-shipowner-description
        max-height: 80px!important
        overflow: hidden
        overflow-y: auto
  @media screen and(min-width: 1024px)
    .product-item-image
      height: 250px
.complements-applications
  left: 50%
  max-height: 60%
  max-width: 400px
  overflow: hidden
  overflow-y: auto
  position: fixed
  top: 50%
  transform: translate(-50%,-50%)
  width: 90%
  z-index: 900
  .close-complements-applications-container
    left: 0
    position: sticky
    top: 0
    z-index: 900
    .close-complements-applications
      align-items: center
      border: solid 2px
      border-radius: 50%
      display: inline-flex
      flex-wrap: wrap
      justify-content: center
      height: 25px
      width: 25px
.product-brand-container
  text-align: center
  height: 50px
  width: 100%
  .product-brand-img
    display: inline-block
    height: 100%
    width: auto
</style>