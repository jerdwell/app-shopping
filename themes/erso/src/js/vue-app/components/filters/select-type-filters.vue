<template lang="pug">
  div.mt-2
    legend.text-muted.text-center Selecciona un filtro
    .row
      .col-md-4.text-center
        label
          input.form-check-input(type="radio" name="typeSearch" v-model="$parent.type_filter" value="car")
          span.text-light.small Búsqueda por auto
      .col-md-4.text-center
        label
          input.form-check-input(type="radio" name="typeSearch" v-model="$parent.type_filter" value="general")
          span.text-light.small Búsqueda general
      .col-md-4.text-center
        label
          input.form-check-input(type="radio" name="typeSearch" v-model="$parent.type_filter" value="code")
          span.text-light.small Búsqueda por código
      
      
</template>

<script>
export default {
  name: 'select-type-filters'
}
</script>