<template lang="pug">
    div
        h3.text-light.text-center Recuperar contraseña
        hr.border-light
        .row
            .col-12
                label.label.text-light Correo
                .input-group.rounded-pill.border-yellow(style="overflow: hidden; border: solid 1px;")
                    .input-group-prepend.border-0
                    .input-group-text.bg-yellow.border-0
                        i.oi.oi-person.text-light
                    input.form-control.form-control-sm.border-0(
                        type="email"
                        name="mail_recovery"
                        id="mail_recovery"
                        v-model="mail_recovery"
                        placeholder="tu@correo"
                        required)
                .text-center.mt-4
                    button.btn.btn-danger(@click.prevent="$parent.show_form_recovery = false") Cancelar
                    button.btn.btn-info.ml-3(@click.prevent="recoveryAccount" :disabled="loading")
                        .spinner-border.spinner-border-sm.align-middle.mr-2(v-if="loading")
                        span Recuperar
</template>

<script>
export default {
    name: 'recovery-account',
    data() {
        return {
            mail_recovery: '',
            loading: false
        }
    },
    methods: {
        async recoveryAccount(){
            this.loading = true
            try {
                let res = await this.$http.post('/account/recovery-account', { email: this.mail_recovery })
                this.$swal(
                    'Restauración de contraseña',
                    'Tu contraseña se ha enviado a tu correo electrónico, revisa tu bandeja de entrada.',
                    'success'
                ).then(res => {
                    this.loading = false
                    this.$parent.show_form_recovery = false
                })
            } catch (error) {
                this.loading = false
                this.$swal(
                    'Restauración de contraseña',
                    'Lo sentimos, esta cuenta no se puede recuperar.',
                    'error'
                )
            }
        }
    },
}
</script>