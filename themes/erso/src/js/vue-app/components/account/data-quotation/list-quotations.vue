<template lang="pug">
.mt-3
  .table-responsive(v-if="list_quotations.length > 0")
    table.table.tablestriped
      thead
        tr.bg-dark.text-light
          th #
          th.text-center Fecha
          th.text-center Costo
          th.text-center status
          th(style="max-width:100px;")
      tbody
        tr(v-for="(quotation, index) in list_quotations" :key="index")
          td {{ index + 1 }}
          td.text-center {{ quotation.created_at }}
          td.text-center ${{ quotation.amount.replace(/\B(?=(\d{3})+(?!\d))/g, ",") }}
          td.text-center
            .badge.small(:class="setDataItem(quotation.status).class") {{ setDataItem(quotation.status).text }}
          td.text-center
            .d-inline-block.p-0.m-0.mr-1.mb-1(v-if="quotation.status != 'declined' && quotation.status != 'successed'")
              //- button.btn.btn-warning.btn-sm(
                v-if="setButtonState(quotation.created_at)"
                :disabled="loading && loading == quotation.id"
                @click.prevent="cancelOrder(quotation.id, quotation.created_at)")
                  .spinner-border.spinner-border-sm.mr-2.align-middle(v-if="loading && loading == quotation.id")
                  span.align-middle Cancelar
            a.btn.btn-info.btn-sm(:href="`/api/v1/quotations/get/${quotation.id}/${get_token}`" v-if="quotation.status != 'declined'") Descargar
</template>

<script>
import { mapActions, mapGetters } from "vuex";
export default {
  name: "list-quotations",
  data() {
    return {
      list_quotations: [],
      loading: false
    };
  },
  computed: {
    ...mapGetters([
      'get_token', //get token 
    ])
  },
  methods: {
    ...mapActions([
      "get_list_quotations", //lista de cotizaciones
      "cancel_order", //Cancelar cotizaciones
    ]),
    async getListQuotations(url) {
      try {
        let list = await this.get_list_quotations(url);
        this.list_quotations = list.data
      } catch (error) {
        console.log(error);
      }
    },
    setDataItem(status){
      let data = {
        text: null,
        class: null
      }
      switch (status) {
        case 'active':
          data.text = 'Activa'
          data.class = 'bg-info text-light'
          break;
        case 'successed':
          data.text = 'Entregada'
          data.class = 'bg-success text-light'
          break;
        case 'declined':
          data.text = 'Cancelada'
          data.class = 'bg-danger text-light'
          break;
      
        default:
          data.text = 'Activa'
          data.class = 'bg-info text-light'
          break;
      }
      return data
    },
    async cancelOrder(id, created){
      try {
        let answer = await this.$swal({
          title: 'Cancelación de órden',
          text: 'Por favor, captura el motivo de tu cancelación.',
          icon: 'warning',
          content: 'input',
          buttons: {
            cancel: 'cancelar',
            confirm: {
              value: '',
            },
          }
        })
        if(!answer) return false
        this.loading = id
        if(answer.replace(/\s/g, '').length <= 10) throw 'Necesitas un motivo para cancelar esta órden, almenos 10 caracteres.'
        let cancel = await this.cancel_order({id: id, message: answer})
        let notification = await this.$swal({
          title: 'Cancelación de órden',
          text: 'La órden se ha cancelado exitosamente',
          icon: 'success',
          button: 'Aceptar'
        })
        this.getListQuotations(null)
        this.loading = false
      } catch (error) {
        this.loading = false
        this.$swal(
          'Cancelación de órden',
          error,
          'error'
        )
      }
    },
    setButtonState(created){
      let expire = this.$moment(created).add(3,'hours').format()
      if(this.$moment(this.$moment().format()).isAfter(expire)){
        return false
      }
      return true
    }
  },
  mounted() {
    this.getListQuotations(null);
  },
};
</script>