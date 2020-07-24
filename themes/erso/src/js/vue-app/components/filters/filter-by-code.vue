<template lang="pug">
  .container
    .container
      .row.w-100
        .col-md-4
          label.text-light Buscar Código
          input.form-control.rounded-pill(type="search" placeholder="Capturar código" v-model="data_search")
          .list-group(v-show="no_results")
            .list-group-item.bg-transparent.border-danger.p-1.mt-3.text-danger #[i.oi.oi-x] No existen resultados
          button.btn.btn-info.mt-4(@click.prevent="searchProducts" :disabled="loading")
            .spinner-border(v-if="loading")
            span Buscar

</template>

<script>
import { mapGetters, mapActions } from 'vuex'
export default {
  name: 'filter-by-code',
  data() {
    return {
      loading: false,
      no_results: false,
      data_search: ''
    }
  },
  computed: {
    ...mapGetters([
      'getListProducts', //get list products 
    ])
  },
  methods: {
    ...mapActions([
      'searchByCode',//seaach by code
    ]),
    async searchProducts(){
      try {
        this.loading = true
        let products = await this.searchByCode(this.data_search)
        this.loading = false
        if(this.getListProducts.length <= 0){
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
  }
}
</script>