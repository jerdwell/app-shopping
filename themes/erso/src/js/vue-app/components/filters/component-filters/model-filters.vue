<template lang="pug">
  div
    label.text-center Modelo
    select.form-control.rounded-pill(v-model="$parent.model_selected" :disabled="$parent.car_selected == ''")
      option(value="") Selecciona una opción
      option(v-for="(model, index) in models.data" :key="index" :value="model.car.id") {{ model.car.model_name }}

</template>

<script>
export default {
  name: 'model-filters',
  watch: {
    '$parent.car_selected' () {
      this.getModels()
    }
  },
  data() {
    return {
      models: []
    }
  },
  methods: {
    async getModels(){
      if(this.$parent.car_selected.replace(/\s/g, '') <= 0) return false
      try{
        let models = await this.$http.get(`get-models/${this.$parent.car_selected}`)
        this.models = models
      }catch(error){
        console.log(error)
      }
    }
  }
}
</script>