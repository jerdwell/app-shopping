<template lang="pug">
.input-indicator-filter
  .input-group.input-group-sm
    .input-group-prepend
      .input-group-text(v-if="val && !notShowReset" @click.prevent="$parent.resetDefault")
        .fas.fa-times.text-danger
      .input-group-text(@click.prevent="$parent.show_pop = !$parent.show_pop")
        .fas.fa-list.text-info
    input.form-control.form-control-sm(type="text" readonly :value="val ? val : 'Selecciona'")
</template>

<script>
export default {
  name: 'input-indicator-filter',
  props: [
    'notShowReset',
    'val'
  ]  
}
</script>

<style lang="sass">
  .input-indicator-filter > *
    cursor: pointer
</style>