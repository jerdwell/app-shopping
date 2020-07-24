<template lang="pug">
  .container
    .row.w-100
      .col-md-4
        label.text-light Buscar Producto
        input.form-control.rounded-pill(type="search" placeholder="Buscar productos" v-model="data_search")
        .list-group.mt-3(v-if="no_results")
          .list-group-item.bg-transparent.border-danger.p-1 #[i.oi.oi-x] No existen coincidencias
        button.btn.btn-info.mt-4(@click.prevent="generalFilter" :disabled="loading")
          .spinner-border.mr-2(v-if="loading")
          span Buscar
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
      'getListProducts', //get list products
    ])
  },
  methods: {
    ...mapActions([
      'generalSearch',
    ]),
    async generalFilter(){
      this.loading = true
      let products = await this.generalSearch(this.data_search)
      this.loading = false
      if(this.getListProducts.length > 0){
        this.no_results = false
        return this.$parent.searchProduct = false
      }
      this.no_results = true
      setTimeout(() => { this.no_results = false }, 3000);
    }
  },
}
</script>