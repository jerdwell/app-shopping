<template lang="pug">
div
  slot
  .g-recaptcha.mb-3(data-sitekey="6LcauM8ZAAAAAEGNjVwatYy_lg-s5YOfr4HbGgCN" data-theme="dark")
  button.btn.btn-info.btn-lg(@click.prevent="ValidateData" :disabled="loading")
    .spinner-border.spinner-border-sm.align-middle.mr-2(v-if="loading")
    span.align-middle Contactar
</template>

<script>
export default {
  name: 'button-contact-form',
  data() {
    return {
      loading: false,
      items: [
        'fullname',
        'phone',
        'email',
        'comments',
      ]
    }
  },
  methods: {
    ValidateData(){
      let recaptcha_token = grecaptcha.getResponse()
      let errors = false
      this.items.forEach(e => {
        let item = document.getElementById(e)
        let val = item.value
        try {
          if(e == 'fullname' && val.replace(/\s/g, '').length <= 5) throw 'El nombre no es un dato váldo'
          if(e == 'email' && !/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(val)) throw 'El correo no es un dato válido'
          if(e == 'phone' && val.length != 10) throw 'El número telefónico debe contener 10 números especificamente.'
          if(e == 'comments' && val.replace(/\s/g, '').length <= 10 ) throw 'Los comentarios no son un dato válido, mínimo 10 palabras'
        } catch (error) {
          this.$swal(
            'Validación de formulario',
            error,
            'error'
          )
          errors = true
        }
      })
      if(!recaptcha_token){
        this.$swal(
          'Validación de formulario',
          'No se puede enviar el mensaje sin comprobar el recaptcha',
          'error'
        )
        return
      }
      if(!errors) this.sendDataContact({
        name: document.getElementById('fullname').value,
        email: document.getElementById('email').value,
        phone: document.getElementById('phone').value,
        comments: document.getElementById('comments').value,
        recaptcha_token: recaptcha_token
      })
    },
    async sendDataContact(data){
      this.loading = true
      try {
        let contact = await this.$http.post('/contact-form', data)
        let message = await this.$swal(
          'Mensaje de contacto',
          'Tu mensaje ha sido enviado exitosamente',
          'success'
        )
        document.getElementById('fullname').value = ''
        document.getElementById('email').value = ''
        document.getElementById('phone').value = ''
        document.getElementById('comments').value = ''
        this.loading = false
      } catch (error) {
        this.$swal(
          'Validación de formulario',
          'Lo sentimos, no hemos podido envíar tus datos, inténtalo de nuevo',
          'error'
        )
        this.loading = false
      }
    }

  },
}
</script>

<style lang="sass">
input.input-number::-webkit-outer-spin-button,
input.input-number::-webkit-inner-spin-button 
  -webkit-appearance: none

input[type=number].input-number
  -moz-appearance: textfield
</style>