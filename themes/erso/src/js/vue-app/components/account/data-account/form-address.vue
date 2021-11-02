<template lang="pug">
div
    h5.text-muted.text-center.mb-3 Dirección 
    .row
        .col-md-5.col-lg-6.mb-2
            label.small.label.text-muted Calle y número:
            input.form-control(type="text" name="address1" id="address1" autocomplete="off" v-model="$parent.data_account.address.address1" required)
            .invalid-feedback#valid-address1
        .col-md-4.mb-2
            label.small.label.text-muted Colonia:
            input.form-control(type="text" name="suburb" id="suburb" autocomplete="off" v-model="$parent.data_account.address.suburb" required)
            .invalid-feedback#valid-suburb
        .col-md-3.col-lg-2.mb-2
            label.small.label.text-muted Código postal:
            input.form-control(type="number" name="zip_code" id="zip_code" min="0" autocomplete="off" v-model="$parent.data_account.address.zip_code" required)
            .invalid-feedback#valid-zip_code
        .col-md-6.col-lg-4.mb-2
            label.small.label.text-muted Delegación:
            input.form-control(type="text" name="country" id="country" autocomplete="off" v-model="$parent.data_account.address.country" required)
            .invalid-feedback#valid-country
        .col-md-6.col-lg-4.mb-2
            label.small.label.text-muted Estado:
            select.form-control(required name="state" id="state" autocomplete="off" v-model="$parent.data_account.address.state")
                option(value="CDMX") CDMX
                option(value="EDOMEX") Estado de México
            .invalid-feedback#valid-state
        .col-md-6.col-lg-4.mb-2
            label.small.label.text-muted Ciudad:
            input.form-control(type="text" name="city" id="city" autocomplete="off" v-model="$parent.data_account.address.city" required)
            .invalid-feedback#valid-city
        .col-md-12.mb-2
            label.small.label.text-muted Referencias:
            input.form-control(type="text" name="address2" id="address2" autocomplete="off" v-model="$parent.data_account.address.address2" required)
            .invalid-feedback#valid-address2
        .col-12
            hr
            .text-center.py-4
                button.btn.btn-info.btn-block(:disabled="loading" @click.prevent="validForm")
                    .spinner-border.spinner-border-sm.align-middle.mr-2(v-if="loading")
                    span.align-middle Guardar
</template>

<script>
import { mapActions } from 'vuex';
export default {
    name: 'form-address',
    data() {
        return {
            loading: false,
            items: [
                'address1',
                'suburb',
                'zip_code',
                'country',
                'state',
                'city',
                'address2'
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
                input.classList.remove('is-valid', 'is-invalid')
                feedback.classList.remove('d-block')
                feedback.innerHTML = ''
                try {
                    if(['address1', 'suburb', 'country', 'state', 'city'].indexOf(e) >= 0) this.validData('text', input.value)
                    if(e == 'zip_code') this.validData('zip_code', input.value)
                    if(e == 'address2') return
                    input.classList.add('is-valid')
                } catch (error) {
                    errors = true
                    input.classList.add('is-invalid')
                    feedback.classList.add('d-block')
                    feedback.innerHTML = error
                    // console.log(error)
                }
            });
            if(errors){
                this.$swal('Validación de datos', 'Lo sentimos, revisa la información y llena los campos correctamente')
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
                case 'zip_code':
                    pattern = /^[0-9]{5}$/
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
                    address1: this.$parent.data_account.address.address1,
                    suburb: this.$parent.data_account.address.suburb,
                    zip_code: this.$parent.data_account.address.zip_code,
                    country: this.$parent.data_account.address.country,
                    state: this.$parent.data_account.address.state,
                    city: this.$parent.data_account.address.city,
                    address2: this.$parent.data_account.address.address2,
                }
                let updated =  await this.updateDataAccount({ data, type: 'address' })
                this.$swal('Actualización de datos.', updated, 'success').then(res => {
                    this.$parent.getData()
                })
                this.loading = false
            } catch (error) {
                console.log(error)
                this.$swal('Actualización de datos.', error, 'error')
                this.loading = false
            }
        }
    },
}
</script>

<style lang="sass">
input::-webkit-outer-spin-button,input::-webkit-inner-spin-button
    -webkit-appearance: none
    margin: 0

input[type=number] 
    -moz-appearance: textfield
</style>