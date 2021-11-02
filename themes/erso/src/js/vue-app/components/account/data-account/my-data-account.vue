<template lang="pug">
.container
    .row
        .col-md-10.offset-md-1
            .card.bg-light
                .card-header.bg-dark
                    h4.text-white.text-center.m-0 Mi cuenta
                .card-body
                    hr
                    nav.nav.nav-pills.nav-justified.mb-4
                        a.nav-item.nav-link(href="#" :class="view == 'personal-data' ? 'active' : null" @click.prevent="view = 'personal-data'") Datos personales
                        a.nav-item.nav-link(href="#" :class="view == 'password' ? 'active' : null" @click.prevent="view = 'password'") Contraseña
                        a.nav-item.nav-link(href="#" :class="view == 'address' ? 'active' : null" @click.prevent="view = 'address'") Dirección
                    personalForm(v-if="view == 'personal-data'")
                    formPassword(v-if="view == 'password'")
                    formAddress(v-if="view == 'address'")
</template>

<script>
import personalForm from './personal-form'
import formPassword from './form-password'
import formAddress from './form-address'
import { mapActions } from 'vuex'
export default {
    name: 'my-data-account',
    components: {
        personalForm,
        formPassword,
        formAddress
    },
    data() {
        return {
            view: 'personal-data',
            data_account: {}
        }
    },
    methods: {
        ...mapActions([
            'getDataAccount', // get data account
        ]),
        async getData(){
            try {
                let data_account = await this.getDataAccount()
                this.data_account = data_account.data
            } catch (error) {
                console.log(error)
            }
        }
    },
    mounted(){
        this.getData()
    }
}
</script>