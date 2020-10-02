<template lang="pug">
  .text-left
    h6.text-yellow.d-inline-block Selecciona una sucursal:
    .row
      .col-md-6.col-lg-4
        select.form-control.form-control-sm.d-inline-block.rounded-pill(
          name="branch-selected"
          id="branch-selected"
          :value="get_branch_selected"
          @change="changeBranch")
          option(value="") Selecciona una opción
          option(value="tlalnepantla") Tlalnepantla
          option(value="cuautitlan-izcalli") Cuautitlán Izcalli
          option(value="coacalco") Coacalco

</template>

<script>
import { mapGetters, mapActions } from 'vuex'
export default {
  name: 'branch-selected',
  computed: {
    ...mapGetters([
      'get_branch_selected',//get branch selected
    ])
  },
  methods: {
    ...mapActions([
      'setBranchSelected'
    ]),
    changeBranch(){
      let data = document.getElementById('branch-selected').value
      this.setBranchSelected(data)
    }
  },
}
</script>