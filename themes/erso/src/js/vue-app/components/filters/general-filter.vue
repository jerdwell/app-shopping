<template lang="pug">
  .container
    .row.w-100
      .col-md-4
        label.text-light Buscar Producto
        input.form-control.rounded-pill(type="search" placeholder="Buscar productos" v-model="data_search" @input="generalFilter")
        .list-group.mt-3(v-if="no_results")
          .list-group-item.bg-transparent.border-danger.text-danger.p-1 #[i.oi.oi-x] No existen coincidencias
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
  name: 'general-filter',
  data(){
    return {
      data_search: '',
      no_results: false,
      loading: false
    }
  },
  computed: {
    ...mapGetters([
      'get_list_products', //get list products
    ])
  },
  methods: {
    ...mapActions([
      'generalSearch', // search by general data
      'clearProducts', //clear store products
    ]),
    async generalFilter(){
      if(this.data_search.replace(/\s/g, '').length <= 0){
        this.no_results = true
        setTimeout(() => {
          this.no_results = false
        }, 3000);
        return
      }
      try {
        this.loading = true
        let products = await this.generalSearch(this.data_search)
        this.loading = false
        return
        if(this.get_list_products.data.length > 0){
          this.no_results = false
          return this.$parent.searchProduct = false
        }
        this.no_results = true
        setTimeout(() => { this.no_results = false }, 3000);
      } catch (error) {
        console.log(error)
      }
    }
  },
  mounted() {
    this.clearProducts()
  },
}
</script>