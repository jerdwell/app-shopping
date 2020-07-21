<template lang="pug">
div
  label.text-center Categoría {{ $parent.model_search }}
  select.form-control.rounded-pill(
    v-model="$parent.category_search"
    :disabled="$parent.model_search != '' ? false :true"
    @change="$parent.searchData")
    option(value="") Selecciona una opción
    option(value="cat1") Amortiguadores
    option(value="cat2") Suspenciones
    option(value="cat3") Direcciones
    option(value="cat4") Tracciones
</template>

<script>
export default {
  name: 'category-filters'
}
</script>