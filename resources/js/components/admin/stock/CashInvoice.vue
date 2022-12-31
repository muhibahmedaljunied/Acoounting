<template>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card" id="printme" style="outline: auto;outline-color:red;border-radius:10;">
              <div class="card-header">

                <table style="width: 100%">
                  <thead>
                    <right-side :data_style='data_style'></right-side>

                    <tr></tr>

                    <tr></tr>
                    <tr>
                      <td colspan="1"></td>

                      <td style="text-align: left">
                        <button @click="prints('printme')">
                          <i class="fas fa-print" style="font-size: 24px; color: rgb(34, 192, 60)"></i>
                        </button>
                      </td>
                    </tr>

                  </thead>
                </table>

              </div>
              <div class="card-body">
                <table class="table table-bordered text-right" style="width: 100%;font-size:large ;text-align:center">
                  <thead style="background:red">
                    <tr>
                      <td>#</td>
                      <th>اسم المنتج</th>
                      <th>الحاله</th>
                      <th>المواصفات والطراز</th>
                      <th class="wd-15p border-bottom-0">كميه الصرف</th>
                      <th>المخزن</th>
                      <!-- <th>الرف</th> -->
                      <!-- <th class="wd-15p border-bottom-0">الكميه المرتحعه</th> -->

                    </tr>
                  </thead>
                  <tbody v-if="cash_detail && cash_detail.length" :key="index">
                    <tr v-for="(cash_details, index) in cash_detail" :key="index">
                      <td>{{ index + 1 }}</td>
                      <td>{{ cash_details.product }}</td>
                      <td>{{ cash_details.status }}</td>
                      <td>{{ cash_details.desc }}</td>
                      <td>{{ cash_details.qty }}</td>
                      <td>{{ cash_details.store }}</td>
                      <!-- <td>{{ cash_details.shelve }}</td> -->
                      <!-- <td>{{ cash_details.qty_return }}</td> -->

                    </tr>
                  </tbody>
                  <tbody v-else>
                    <tr>
                      <td align="center" colspan="4">
                        <h3> لايوجد بيانات </h3>
                      </td>
                    </tr>
                  </tbody>
                </table>
                 <footer-side :data_style='data_style'></footer-side>
            

              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script>

import RightSide from "./Style/RightSide";
import FooterSide from "./Style/FooterSide";
export default {
  components: {
    RightSide,
    FooterSide,

  },
  data() {
    return {
      cashes: 0,
      cash_detail: 0,
      timestamp: "",
      user: '',

      // ------for style--------
      data_style: {
        'right': 'اسم العميل',
        'left': 0,
        'number': 0,
        'date': 0,
        'title': 'سند صرف مخزني',
        'check':0,
         'user':0,

      },

    };
  },
  created() {

    setInterval(getNow, 1000);
  },
  mounted() {
    let uri = `/invoice_cash/${this.$route.params.id}`;
    this.axios.post(uri).then((response) => {
      console.log(response.data.users.name);
      this.user = response.data.users.name;

      this.cash_detail = response.data.cash_details;
      this.cashes = response.data.cashes;

      // -----------------for style----------
      this.data_style.left = this.cashes[0].name;
      this.data_style.number = this.cashes[0].cash_id;
      this.data_style.date = this.cashes[0].date;
       this.data_style.user = this.user;
      // --------------------------

    });
  },
  methods: {

    prints(printme) {

      printDiv(printme);
    },
  },
  computed: {},
};
</script>
<style scoped>
th,td{
  text-align: center;
}
td h2 {
  line-height: 20px;
}
</style>

