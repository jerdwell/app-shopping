<template lang="pug">
form(@submit.prevent="validRegister")
  slot(name="form")
  .text-center.my-3
    hr
    button.btn.btn-info(:disabled="loading" type="submit")
      .spinner-border.spinner-border-sm.mr-2.align-middle(v-if="loading")
      span Registrarme
</template>

<script>
export default {
  name: 'form-register',
  data() {
    return {
      items: [
        'firstname',
        'lastname',
        'email',
        'phone',
        'password',
        'password2',
        'address1',
        'zip_code',
        'suburb',
        'country',
        'state',
        'city',
        'address2',
      ],
      loading: false
    }
  },
  methods: {
    validRegister(){
      let valid = true
      this.items.forEach(e => {
        let input = document.getElementById(e)
        let data = input.value
        let feedback = document.getElementById(`valid-${e}`)
        input.classList.remove('is-valid', 'is-invalid')
        feedback.classList.remove('d-block')
        try {
          switch (e) {
            case 'email':
              this.validEmail(data)
              break;
            case 'phone':
              this.validPhone(data)
              break;
            case 'password' || 'password2':
              this.validPassword()
              break;
            case 'zip_code':
              this.validZipCode(data)
              break;
            case 'address2':
              return
              break;
          
            default:
              if(data.replace(/\s/g, '').length <= 0) throw 'Este campo no puede estar vacío'
              break;
          }
          input.classList.add('is-valid')
          feedback.innerHTML = ''
        } catch (error) {
          valid = false
          feedback.classList.add('d-block')
          input.classList.add('is-invalid')
          feedback.innerHTML = error
          console.log(error)
        }
      })
      if(valid) this.registerUser()
    },

    validEmail(data){
      let pattern = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
      if(!pattern.test(data)) throw 'El correo no tiene un formato válido'
    },
    validPhone(data){
      let pattern = /^[0-9]{10}/
      if(!pattern.test(data)) throw 'El teléfono no es un dato válido'
    },
    validPassword(){
      let input1 = document.getElementById('password')
      let input2 = document.getElementById('password2')
      let password1 = input1.value
      let password2 = input2.value
      let pattern = /^(?:(?=.*[a-z])(?:(?=.*[A-Z])(?=.*[\d\W])|(?=.*\W)(?=.*\d))|(?=.*\W)(?=.*[A-Z])(?=.*\d)).{8,}$/
      if(password1 != password2) throw 'Las contraseñas no coinciden'
      if(!pattern.test(password1) || !pattern.test(password1)) throw 'La contraseña no cuenta con los parámetros de seguridad, intenta usar almenos una mayúscula, números y símbolos'
    },
    validZipCode(data){
      let pattern = /^[0-9]{5}/
      if(!pattern.test(data)) throw 'Las contraseñas no coinciden'
    },
    async registerUser(){
      this.loading = true
      let data = {}
      this.items.map(e => {
        if(e != 'password2') data[e] = document.getElementById(e).value
      })
      try {
        let register = await this.$http.post('/account/register', data)
        let swal = await this.$swal({
          title: 'Registro de usuario',
          text: `Usuario registrado con éxito, revisa tu bandeja de entrada.`,
          icon: 'success'
        })
        window.location.reload()
      } catch (error) {
        this.$swal({
          title: 'Registro de usuario',
          text: `Error al registrar el usuario: ${error.response.data}`,
          icon: 'error'
        })
      }
      this.loading = false
    }

  },
}
</script>