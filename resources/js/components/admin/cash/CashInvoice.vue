<template>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card" id="printme" style="outline: auto;outline-color:red;border-radius:10;">
              <div class="card-header">
                <div class="table-responsive">

                  <table style="width: 100%">
                    <thead>
                      <tr>
                        <td rowspan="4" style="text-align: center; line-height: 1px">
                          <h2>الجمهوريه اليمنيه</h2>
                          <br />
                          <h2>وزاره الدفاع</h2>
                          <br />
                          <h2>رياسه هيه الاركات</h2>
                          <br />
                          <h2>قياده القوات الجويه والدفاع</h2>
                          <br />
                          <h2>الدراسات والابحاث</h2>
                          <br />
                          <h2>المخازن</h2>
                          <br />
                        </td>
                        <td rowspan="4" style="text-align: center; line-height: 1px">
                          <img :src="`/assets/img/images3.jpg`" height="150px" alt="products image" />
                        </td>
                        <td rowspan="4" style="text-align: center; line-height: 1px">
                          <h2>رقم السند :{{ cashs[0].cash_id }}</h2>
                          <br />

                          <h2>تاريخ السند : {{ cashs[0].cash_date }}</h2>
                          <br />

                          <h2>اسم العميل : {{ cashs[0].name }}</h2>
                        </td>
                      </tr>
                      <tr></tr>

                      <tr></tr>
                      <tr>
                        <td colspan="1"></td>

                        <td style="text-align: left">
                          <button @click="printDiv('printme')">
                            <i class="fas fa-print" style="font-size: 24px; color: rgb(34, 192, 60)"></i>
                          </button>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="1"></td>

                        <td style="
                          text-align: center;
                          border-radius: 10px;
                          background-color: red;
                        ">
                          <h1> فاتوره مبيعات </h1>
                        </td>
                        <td></td>
                      </tr>
                    </thead>
                  </table>
                </div>
                <!-- <table style="width: 100% ;outline:double;">
                  <thead>
                    <tr>
                      <td colspan="5">
                        <h3>رقم السند :{{ cashs[0].cash_id }}</h3>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="5">
                        <h3>تاريخ السند : {{ cashs[0].date }}</h3>
                      </td>
                    </tr>

                    <tr>
                      <td colspan="5">
                        <h3>
                          اسم العميل : {{ cashs[0].name }}
                     
                        </h3>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="5" style="text-align: left">
                        <button @click="printDiv('printme')">
                          <i
                            class="fas fa-print"
                            style="font-size: 24px; color: rgb(34, 192, 60)"
                          ></i>
                        </button>
                      </td>
                    </tr>
                  </thead>
                </table> -->
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered text-right" style="width: 100%;font-size:x-large">
                    <thead style="background:red">
                      <tr>
                        <th>اسم المنتج</th>

                        <th> المواصفات والطراز</th>
                        <th>الحاله</th>


                        <th>السعر</th>
                        <th class="wd-15p border-bottom-0">كميه المباعه</th>
                        <th>المخزن</th>
                        <!-- <th class="wd-15p border-bottom-0">الكميه المرتحعه</th> -->

                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="cash_details in cash_detail">
                        <td>{{ cash_details.product_name }}</td>
                        <td>{{ cash_details.desc }}</td>
                        <td>{{ cash_details.status }}</td>
                        <td>{{ cash_details.price }}</td>
                        <!-- <td>{{ cash_details.qty }}</td> -->

                        <td>

                          <div v-for="temx in cash_details.units">

                            <span v-if="temx.name == cash_details.unit">

                              <span v-if="temx.unit_type == 1">

                                {{ cash_details.qty }} {{ temx.name }}

                              </span>

                              <span v-if="temx.unit_type == 0">

                                <span v-if="cash_details.qty / cash_details.rate >= 1">
                                  {{ Math.floor((cash_details.qty / cash_details.rate)) }}{{
                                    cash_details.units[0].name
                                  }}
                                </span>

                                <span v-if="cash_details.qty % cash_details.rate >= 1">
                                  و
                                  {{ Math.floor((cash_details.qty % cash_details.rate)) }}{{
                                    cash_details.units[1].name
                                  }}
                                </span>
                              </span>

                            </span>



                          </div>

                        </td>


                        <td>{{ cash_details.store }}</td>
                        <!-- <td>{{ cash_details.qty_return }}</td> -->

                      </tr>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th colspan="7"> الاجمالي:{{ cashs[0].sub_total }}</th>


                      </tr>
                      <tr>
                        <th colspan="7"> اجمالي الضريبه:{{ cashs[0].tax_amount }}</th>


                      </tr>
                      <tr>

                        <th colspan="7"> الخصم:{{ cashs[0].discount }}</th>


                      </tr>
                      <tr style="background-color: aqua;">

                        <th colspan="7"> الاجمالي الكلي:{{ cashs[0].grand_total }}</th>


                      </tr>

                    </tfoot>
                  </table>
                </div>
                <div id="intro" style="text-align: left">
                  <h5>{{ timestamp }}</h5>
                  <h5>امين المخازن:{{ user }}</h5>
                </div>

              </div>


            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
export default {
  data() {
    return {
      cashs: 0,
      cash_detail: 0,
      timestamp: "",
      user: '',
      table: '',
    };
  },
  created() {
    setInterval(this.getNow, 1000);
  },
  mounted() {
    this.table ='cash_details';
    let uri = `/invoice_cash/${this.$route.params.id}`;
    this.axios.post(uri, { table: this.table }).then((response) => {
      console.log(response.data.users.name);
      this.user = response.data.users.name;

      this.cash_detail = response.data.cash_details;
      this.cashs = response.data.cashs;
    });
  },
  methods: {


  },
  computed: {},
};
</script>
<style scoped>
.table-bordered {
  border: 2px solid black;
}

.table-bordered th,
.table-bordered td {
  border: 2px solid black;
  text-align: center;
  font-size: 40px;
}

td h2 {
  line-height: 20px;
}
</style>

