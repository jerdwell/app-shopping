<template lang="pug">
div
  label.text-center.text-light Categoría
  .input-group.mb-3.rounded-pill(style="overflow:hidden;")
    .input-group-prepend
      .input-group-text
        i.fas.fa-list
    select.form-control.form-control-sm(
      v-model="$parent.category_selected"
      @change="addCategoryToFilter"
      :disabled="$parent.model_selected != '' ? false :true")
      option(value="") Selecciona una opción
      option(v-for="(category, index) in get_categories_related" :key="index" :value="category.id") {{ category.category_name }}
  .list-group.mt-3(v-if="no_results")
    .list-group-item.border-danger.p-1.bg-transparent.text-danger #[i.oi.oi-x] No existen resultados
  .text-center(v-if="loading")
      .spinner-border.text-light
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
  name: 'category-filters',
  data() {
    return {
      no_results: false,
      loading: false
    }
  },
  computed: {
    ...mapGetters([
      'get_categories_related'
    ])
  },
  methods: {
    ...mapActions([
      'serachProductModel', //search products
    ]),
    async addCategoryToFilter(){
      this.$parent.car_model_selected['category'] = this.$parent.category_selected
      this.loading = true
      await this.serachProductModel(this.$parent.car_model_selected)
      this.loading = false
    }
  },
}
</script>