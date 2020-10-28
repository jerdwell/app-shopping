<template lang="pug">
  .container-fluid
    .row
      .col-md-4
        label.text-light Buscar Código
        .input-group.mb-3.rounded-pill(style="overflow:hidden;")
          .input-group-prepend
            .input-group-text
              i.fas.fa-list
          input.form-control.form-control-sm(type="search" placeholder="Capturar código" v-model="data_search" @input="delaySearch")
        .list-group(v-show="no_results")
          .list-group-item.bg-transparent.border-danger.p-1.mt-3.text-danger #[i.oi.oi-x] No existen resultados
        .text-center(v-if="loading")
          .spinner-border.text-light

</template>

<script>
import { mapGetters, mapActions } from 'vuex'
export default {
  name: 'filter-by-code',
  data() {
    return {
      loading: false,
      no_results: false,
      data_search: '',
      delay: 0
    }
  },
  computed: {
    ...mapGetters([
      'get_list_products', //get list products 
    ])
  },
  methods: {
    ...mapActions([
      'searchByCode',//seaach by code
      'clearProducts',//clear products
    ]),
    delaySearch(){
      clearTimeout(this.delay)
      this.delay = setTimeout(() => {
        this.searchProducts()
      }, 700);
    },
    async searchProducts(){
      if(this.data_search.replace(/\s/g, '').length <= 0){
        this.no_results = true
        setTimeout(() => {
          this.no_results = false
        }, 3000);
        return
      }
      try {
        this.loading = true
        let products = await this.searchByCode(this.data_search)
        this.loading = false
        if(this.get_list_products.data.length <= 0){
          this.no_results = true
          setTimeout(() => {
            this.no_results = false
          }, 3000);
          return
        }
        this.$parent.searchProduct = false
      } catch (error) {
        console.log(error);
      }
    }
  },
  mounted(){
    this.clearProducts()
  }
}
</script>