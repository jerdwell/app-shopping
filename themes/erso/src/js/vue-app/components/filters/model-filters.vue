<template lang="pug">
  div
    label.text-center Modelo
    select.form-control.rounded-pill(v-model="$parent.model_search" :disabled="$parent.car_search == ''")
      option(value="") Selecciona una opción
      option(value="modelo 1") Modelo 1
      option(value="modelo 2") Modelo 2
      option(value="modelo 3") Modelo 3

</template>

<script>
export default {
  name: 'model-filters'
}
</script>