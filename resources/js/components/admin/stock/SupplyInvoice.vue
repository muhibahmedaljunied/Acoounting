<template>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card" id="printme" style="outline: auto; outline-color: red; border-radius: 10">
              <div class="card-header">
                <div class="table-responsive">
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
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered text-right"
                    style="width: 100%; font-size: large ;text-align:center">
                    <thead style="background: red">
                      <tr>
                        <td>#</td>
                        <th>اسم المنتج</th>
                        <th>الحاله</th>
                        <th>المواصفات والطراز</th>
                        <th class="wd-15p border-bottom-0">الكميه الوارده</th>
                        <!-- <th class="wd-15p border-bottom-0">الكميه المرتحعه</th> -->
                        <th>المخزن</th>
                        <!-- <th>الرف</th> -->
                      </tr>
                    </thead>
                    <tbody v-if="supply_detail && supply_detail.length">
                      <tr v-for="(supply_details, index) in supply_detail" :key="index">
                        <td>{{ index + 1 }}</td>
                        <td>{{ supply_details.product }}</td>
                        <td>{{ supply_details.status }}</td>
                        <td>{{ supply_details.desc }}</td>
                        <td>{{ supply_details.qty }}</td>
                        <!-- <td>{{ supply_details.qty_return }}</td> -->
                        <td>{{ supply_details.store }}</td>
                        <!-- <td>{{ supply_details.shelve_name }}</td> -->
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
                </div>
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
      supplies: 0,
      supply_detail: 0,
      timestamp: "",
      user: "",

      data_style: {
        'right': 'اسم المورد',
        'left': 0,
        'number': 0,
        'date': 0,
        'title': 'سند توريد مخزني',
           'check':0,
           'user':0,

      },


    };
  },
  created() {

    setInterval(getNow, 1000);
  },
  mounted() {
    let uri = `/invoice_supply/${this.$route.params.id}`;
    this.axios.post(uri).then((response) => {
      console.log(response.data.users.name);
      this.user = response.data.users.name;
      this.supply_detail = response.data.supply_details;
      this.supplies = response.data.supplies;

      // -----------------for style----------
      this.data_style.left = this.supplies[0].name;
      this.data_style.number = this.supplies[0].supply_id;
      this.data_style.date = this.supplies[0].date;
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

