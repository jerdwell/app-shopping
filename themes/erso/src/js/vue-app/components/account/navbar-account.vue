<template lang="pug">
.navbar-account.navbar.bg-dark
  .container.d-flex
    a.navbar-brand(href="/")
      img(src="/themes/erso/assets/img/brand/brand_logo_erso_white.svg")
    i.fas.fa-bars.text-light.icon-menu-account(@click.prevent="$parent.menu_active = !$parent.menu_active")
</template>

<script>
export default {
  name: "navbar-account"
}
</script>

<style lang="sass" scoped>
.navbar-account
  box-shadow: 0 5px 5px rgba(0,0,0, .5)
  left: 0
  position: fixed
  top: 0
  width: 100%
  z-index: 1000
  .container
    .navbar-brand
      img
        height: 40px
    .icon-menu-account
      font-size: 25px
  @media screen and (min-width: 768px)
    .container
      .icon-menu-account
        display: none

</style>