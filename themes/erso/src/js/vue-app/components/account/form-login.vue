<template lang="pug">
  div
    slot(name="form" v-if="!show_form_recovery")
    recoveryAccount(v-else)
    .text-center.text-md-right
      a.text-info.small(href="#" @click.prevent="show_form_recovery = !show_form_recovery" v-if="!show_form_recovery") Recuperar contraseña 
    .text-center.mt-4
      button.btn.btn-info(:disabled="loading" @click.prevent="testLoading" v-if="!show_form_recovery")
        .spinner-border.spinner-border-sm.align-middle.mr-2(v-if="loading")
        span Ingresar
      div(v-if="!get_show_register")
        hr.border-light
        button.btn.btn-warning(@click.prevent="showRegister") Crear una cuenta
</template>

<script>
import recoveryAccount from './recovery-account'
import { mapActions, mapGetters } from 'vuex'
export default {
  name: 'form-login',
  components: {
    recoveryAccount
  },
  watch: {
    get_token: (newData, oldData) => {
      if(newData != '') window.location.href = '/mi-cuenta'
    }
  },
  data() {
    return {
      user: '',
      password: '',
      loading: false,
      show_form_recovery: false
    }
  },
  computed: {
    ...mapGetters([
      'get_token',// get token account
      'get_show_register',// get conditional to show form register
    ])
  },
  methods: {
    ...mapActions([
      'setDataAccount', //set data account
      'showRegister', //set if form register is showed
    ]),
    testLoading(){
      let valid = true
      let items = ['user', 'password-user']
      items.forEach(e => {
        let input = document.getElementById(e)
        let data = input.value
        let feedback = document.getElementById('valid-' + e)
        try {
          feedback.classList.remove('d-block')
          feedback.innerHTML = ''
          if(data.replace(/\s/g, '').length <= 0) throw 'Este campo no puede estar vacío'
          let patter_mail = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
          if(e == 'user' && !patter_mail.test(data)) throw 'Este usuario no es un dato válido'
        } catch (error) {
          valid = false
          feedback.classList.add('d-block')
          feedback.innerHTML = error
        }
      })
      if(valid) this.login()
    },
    async login(){
      this.loading = true
      try {
        let login = await this.$http.post('/account/login', {
          email: document.getElementById('user').value,
          password: document.getElementById('password-user').value
        })
        let swal = await this.$swal({
          title: 'inicio de sesión',
          text: `Bienvenido, has iniciado sesión: ${login.data.name}`,
          icon: 'success',
          buttons: false
        })
        this.setDataAccount({
          name: login.data.name,
          token: login.data.token
        })
      } catch (error) {
        this.$swal({
          title: 'Inicio de sesión',
          text: `Error al intentar ingresar: ${error.response.data}`,
          icon: 'error',
          buttons: false
        })
      }
      this.loading = false
    }
  },
  beforeMount(){
    if(this.get_show_register) this.showRegister()
    if(this.get_token != '') window.location.href = '/mi-cuenta'
  }
}
</script>