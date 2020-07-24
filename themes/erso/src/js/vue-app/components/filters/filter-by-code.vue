<template lang="pug">
  .container
    .container
      .row.w-100
        .col-md-4
          label.text-light Buscar Código
          input.form-control.rounded-pill(type="search" placeholder="Capturar código")
          button.btn.btn-info.mt-4 Buscar 

</template>

<script>
export default {
  name: 'filter-by-code'
}
</script>