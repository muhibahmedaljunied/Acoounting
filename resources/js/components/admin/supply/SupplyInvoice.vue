<template>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card" id="printme" style="outline: auto; outline-color: red; border-radius: 10">
              <div class="card-header">
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
                        <h2>قياده القوه الصاروخيه</h2>
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
                        <h2>رقم السند :{{ supplies[0].supply_id }}</h2>
                        <br />

                        <h2>تاريخ السند : {{ supplies[0].supply_date }}</h2>
                        <br />

                        <h2>
                          اسم المورد : {{ supplies[0].supplier_name }}

                        </h2>
                        <br />
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
                        <h1> سند  توريد</h1>
                      </td>
                      <td></td>
                    </tr>
                  </thead>
                </table>
                <!-- <table style="width: 100% ; oمخزتيutline:double;">
                  <thead>
                    <tr>
                      <td colspan="5">
                        <h3>رقم السند :{{ supplies[0].supply_id }}</h3>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="5">
                        <h3>تاريخ السند : {{ supplies[0].date }}</h3>
                      </td>
                    </tr>

                    <tr>
                      <td colspan="5">
                        <h3>
                          اسم المورد : {{ supplies[0].name }}
                          {{ supplies[0].last_name }}
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
                <table class="table table-bordered text-right" style="width: 100%; font-size: x-large">
                  <thead style="background: red">
                    <tr>
                      <th>اسم المنتج</th>
                      <th> المواصفات والطراز</th>
                      <th>الحاله</th>
                      <th>السعر</th>
                      <th class="wd-15p border-bottom-0">الكميه الوارده</th>
                      <!-- <th class="wd-15p border-bottom-0">الكميه المرتحعه</th> -->
                      <th>المخزن</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="supply_details in supply_detail">
                      <td>{{ supply_details.product }}</td>
                      <td>{{ supply_details.desc }}</td>
                      <td>{{ supply_details.status }}</td>
                      <td>{{ supply_details.price }}</td>
                      <!-- <td>{{ supply_details.qty }}</td> -->
                 
                      <td>


                        <div v-for="temx in supply_details.qty_after_convert['qty']">



<span v-for="temx2 in temx">


  <span style="float: right;">
    {{ temx2[0] }}
    <span style="color: red;">
      {{ temx2[1] }}
    </span>

  </span>



</span>

<!-- <span v-if="temx.unit_type == 0">


<span>{{ Math.floor((stock.quantity)) }}</span><span style="color: red;"> {{
temx.name }}</span>



</span> -->

</div>

</td>





                      <!-- <td>{{ supply_details.qty_return }}</td> -->
                      <td>{{ supply_details.store }}</td>
                    </tr>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th colspan="7"> الاجمالي:{{ supplies[0].sub_total }}</th>


                    </tr>
                    <tr>
                      <th colspan="7"> اجمالي الضريبه:{{ supplies[0].tax_amount }}</th>


                    </tr>
                    <tr>

                      <th colspan="7"> الخصم:{{ supplies[0].discount }}</th>


                    </tr>
                    <tr style="background-color: aqua;">

                      <th colspan="7"> الاجمالي الكلي:{{ supplies[0].grand_total }}</th>


                    </tr>

                  </tfoot>
                </table>
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
      supplies: 0,
      supply_detail: 0,
      timestamp: "",
      supplier: "",
      table: 'supply_details',
    };
  },
  created() {
    setInterval(this.getNow, 1000);
  },
  props: ['data'],
  mounted() {

    let uri = `/invoice_supply/${this.data}`;
    this.axios.post(uri, { table: this.table }).then((response) => {

      console.log(response);
      this.user = response.data.users.name;
      this.supply_detail = response.data.supply_details;
      this.supplies = response.data.supplies;
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

tfoot {
  line-height: x-small;
}
</style>

