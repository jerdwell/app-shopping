<template lang="pug">
.navbar-filters
  .filters
    .row
      .col-md-4.search-item
        label Buscar por auto
        select.form-control#car-search
          option(value="" v-for="item in 10" :key="item") Auto {{ item  }}
      .col-md-4.search-item
        label Buscar por marca
        select.form-control#brand-search
          option(value="" v-for="item in 10" :key="item") Marca {{ item  }}
      .col-md-4.search-item
        label Búsqueda general
        .input-group.bg-white.rounded-pill.mr-0.ml-auto.item-search(style="overflow: hidden; max-width:400px;")
          input.form-control.border-0(type="text" placeholder="Buscar" style="box-shadow: none;")
          .input-group-prepend.p-0
            .input-group-text.bg-transparent.border-0
              span.oi.oi-magnifying-glass

</template>

<style lang="sass" scoped>
.navbar-filters
  .filters
    .row
      .search-item
        margin-bottom: 20px
        label
          color: #ffffff
    
</style>