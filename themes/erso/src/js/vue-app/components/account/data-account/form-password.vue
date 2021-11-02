<template lang="pug">
div
    h5.text-muted.text-center.mb-3 Contraseña 
    .row
        .col-12.mb-3
            .alert.alert-light
                small.text-info *La contraseña de contener almenos 8 caracteres, mayúsculas y minúsculas, números y simbolos.
        .col-md-6.mb-2
            label.small.label.text-muted Contraseña: 
            input.form-control(type="password" name="password" id="password" autocomplete="off" required)
            .invalid-feedback#valid-password
        .col-md-6.mb-2
            label.small.label.text-muted Confirma la contraseña:
            input.form-control(type="password" name="confirm-password" id="confirm-password" autocomplete="off" required)
            .invalid-feedback#valid-confirm-password
        .col-12
            hr
            .text-center.py-4(@click.prevent="changePassword")
                button.btn.btn-info Guardar
</template>

<script>
import { mapActions } from 'vuex'
export default {
    name: 'form-password',
    methods: {
        ...mapActions([
            'change_password', //change password
        ]),
        async changePassword(){
            let input_password = document.getElementById('password')
            let input_password_confirm = document.getElementById('confirm-password')
            let feedback_password = document.getElementById('valid-password')
            let pattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[._\-\{\}!@#\$%\^&\*"'\[\]\?\¡\¿\(\)\/])(?=.{8,})/
            let errors = false
            try {
                input_password.classList.remove('is-invalid')
                input_password_confirm.classList.remove('is-invalid')
                feedback_password.classList.remove('d-block')
                feedback_password.innerHTML = ''
                if(!pattern.test(input_password.value)) throw 'invalid_secure'
                if(input_password.value != input_password_confirm.value) throw 'invalid_coincidence'
                let update = await this.change_password(input_password.value)
                input_password.value = ''
                input_password_confirm.value = ''
                let notification = await this.$swal('Actualización de datos', update, 'success')
            } catch (error) {
                if(error == 'invalid_secure'){
                    input_password.classList.add('is-invalid')
                    feedback_password.classList.add('d-block')
                    feedback_password.innerHTML = 'La contraseña no cumple con los parámetros de seguridad.'
                }else if(error == 'invalid_coincidence'){
                    input_password_confirm.classList.add('is-invalid')
                    feedback_password.classList.add('d-block')
                    feedback_password.innerHTML = 'Las contraseñas no coinciden.'
                    input_password.classList.add('is-invalid')
                }else{ 
                    this.$swal('Actualización de datos', 'Lo sentimos, no se puede actualizar tu coontraseña', 'success')
                }
                errors = true
            }
            
        }
    },

}
</script>