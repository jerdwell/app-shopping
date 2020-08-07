<template lang="pug">
div
  label.text-center.text-light Categoría
  select.form-control.form-control-sm.rounded-pill(
    v-model="$parent.category_selected"
    :disabled="$parent.model_selected != '' ? false :true")
    option(value="") Selecciona una opción
    option(v-for="(category, index) in get_categories_related" :key="index" :value="category.category.id") {{ category.category.category_name }}
  .list-group.mt-3(v-if="no_results")
    .list-group-item.border-danger.p-1.bg-transparent.text-danger #[i.oi.oi-x] No existen resultados
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
export default {
  name: 'category-filters',
  data() {
    return {
      no_results: false
    }
  },
  computed: {
    ...mapGetters([
      'get_categories_related'
    ])
  },
  methods: {
    
  }
}
</script>