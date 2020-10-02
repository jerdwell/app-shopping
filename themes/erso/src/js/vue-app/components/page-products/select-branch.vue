<template lang="pug">
  a.branch-item.my-3(:href="'/productos/' + branch.slug " @click.prevent="setBranch")
    .branch-item-icon.bg-primary
      .fas.fa-map-marker-alt.text-white
    h3.branch-item-name.text-center.mt-3 {{ branch.branch_name }}
</template>
<script>
import { mapActions } from 'vuex'
export default {
  name: 'select-branch',
  props: ['branch'],
  methods: {
    ...mapActions([
      'setBranchSelected', //set branch selected
    ]),
    setBranch(){
      this.setBranchSelected(this.branch.slug)
      location.assign('/productos/' + this.branch.slug)
    }
  },
}
</script>