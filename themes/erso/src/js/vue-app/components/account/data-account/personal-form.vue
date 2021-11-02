<template lang="pug">
div
    h5.text-muted.text-center.mb-3 Datos personales 
    .row
        .col-md-6.mb-2
            label.small.label.text-muted Nombre(s):
            input.form-control(type="text" name="firstname" id="firstname" autocomplete="off" v-model="$parent.data_account.firstname" required)
            .invalid-feedback#valid-firstname
        .col-md-6.mb-2
            label.small.label.text-muted Apellidos:
            input.form-control(type="text" name="lastname" id="lastname" autocomplete="off" v-model="$parent.data_account.lastname" required)
            .invalid-feedback#valid-lastname
        .col-md-6.mb-2
            label.small.label.text-muted Correo:
            input.form-control(type="email" name="email" id="email" autocomplete="off" v-model="$parent.data_account.email" required)
            .invalid-feedback#valid-email
        .col-md-6.mb-2
            label.small.label.text-muted Teléfono:
            input.form-control(type="number" name="phone" id="phone" min="9999999999" max="9999999999" autocomplete="off" v-model="$parent.data_account.phone" required)
            .invalid-feedback#valid-phone
        .col-12
            hr
            .text-center.py-4
                button.btn.btn-info.btn-block(:disabled="loading" @click.prevent="validForm")
                    .spinner-border.spinner-border-sm.align-middle.mr-2(v-if="loading")
                    span.align-middle Guardar
</template>

<script>
import { mapActions } from 'vuex'
export default {
    name: 'personal-form',
    data() {
        return {
            loading: false,
            items: [
                'firstname',
                'lastname',
                'email',
                'phone',
            ]
        }
    },
    methods: {
        ...mapActions([
            'updateDataAccount', //update data account
        ]),
        validForm(){
            let errors = false
            this.items.forEach(e => {
                let input = document.getElementById(e)
                let feedback = document.getElementById(`valid-${e}`)
                feedback.innerHTML = ''
                feedback.classList.remove('d-block')
                input.classList.remove('is-valid', 'is-invalid')
                try {
                    if(['firstname', 'lastname'].indexOf(e) >= 0) this.validData('text', input.value)
                    if(e == 'phone') this.validData('phone', input.value)
                    input.classList.add('is-valid')
                } catch (error) {
                    feedback.innerHTML = error
                    feedback.classList.add('d-block')
                    input.classList.add('is-invalid')
                    errors = true
                    console.log(error)
                }
            })
            if(errors){
                this.$swal('Validación de datos', 'Lo sentimos, revisa los campos ya que alguno de estos no es válido', 'warning')
                return
            }
            this.updateData()
        },

        validData(type, data){
            let pattern
            switch (type) {
                case 'text':
                    if(data.replace(/\s/g, '').length < 2) throw 'Este campo no es válido'
                    break;
                case 'phone':
                    pattern = /^[0-9]{10}$/
                    if(!pattern.test(data)) throw 'Este campo no es válido'
                    break;
            
                default:
                    break;
            }
        },

        async updateData(){
            this.loading = true
            try {
                let data = {
                    firstname: this.$parent.data_account.firstname,
                    lastname: this.$parent.data_account.lastname,
                    email: this.$parent.data_account.email,
                    phone: this.$parent.data_account.phone,
                }
                let updated =  await this.updateDataAccount({ data, type: 'personal' })
                this.$swal('Actualización de datos.', updated, 'success').then(res => {
                    this.$parent.getData()
                })
                this.loading = false
            } catch (error) {
                this.loading = false
                this.$swal('Actualización de datos.', error, 'error')
            }
        }
    },
}
</script>

<style lang="sass" scoped>
    input::-webkit-outer-spin-button,input::-webkit-inner-spin-button
        -webkit-appearance: none
        margin: 0

    input[type=number] 
        -moz-appearance: textfield

</style>