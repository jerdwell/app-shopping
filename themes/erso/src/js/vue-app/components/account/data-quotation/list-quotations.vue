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
            button.btn.btn-warning.btn-sm.mr-1.mb-1(v-if="quotation.status != 'declined' && quotation.status != 'successed'") Cancelar
            a.btn.btn-info.btn-sm(:href="`/api/v1/quotations/get/${quotation.id}/${get_token}`" v-if="quotation.status != 'declined'") Descargar
</template>

<script>
import { mapActions, mapGetters } from "vuex";
export default {
  name: "list-quotations",
  data() {
    return {
      list_quotations: [],
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
    }
  },
  mounted() {
    this.getListQuotations(null);
  },
};
</script>