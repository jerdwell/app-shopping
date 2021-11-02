<template lang="pug">
.container
  .row
    .col-md-10.offset-md-1
      .card
        .card-header.bg-dark
          h2.text-center.text-light Lista de cotizaciones
        .card-body
          listQuotations()
</template>

<script>
import listQuotations from './list-quotations'
export default {
  name: 'quotations',
  components: {
    listQuotations
  }
}
</script>