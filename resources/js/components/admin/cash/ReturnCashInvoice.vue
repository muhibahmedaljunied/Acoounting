<template>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card" id="printme" style="outline: auto;outline-color:red;border-radius:10;">
              <div class="card-header">
                 
                <table style="width: 100% ;outline:double;">
                      <thead>
                    <tr>
                      <td
                        rowspan="4"
                        style="text-align: center; line-height: 1px"
                      >
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
                      <td
                        rowspan="4"
                        style="text-align: center; line-height: 1px"
                      >
                        <img
                          :src="`/assets/img/images3.jpg`"
                          height="150px"
                          alt="products image"
                        />
                      </td>
                      <td
                        rowspan="4"
                        style="text-align: center; line-height: 1px"
                      >
                        <h2>رقم السند :{{ return_cashs[0].cash_id }}</h2>
                        <br />

                        <h2>تاريخ السند :{{ return_cashs[0].date }}</h2>
                        <br />

                        <h2>اسم العميل : {{ return_cashs[0].name }}</h2>
                      </td>
                    </tr>
                    <tr></tr>

                    <tr></tr>
                    <tr>
                      <td colspan="1"></td>

                      <td style="text-align: left">
                        <button @click="printDiv('printme')">
                          <i
                            class="fas fa-print"
                            style="font-size: 24px; color: rgb(34, 192, 60)"
                          ></i>
                        </button>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="1"></td>

                      <td
                        style="
                          text-align: center;
                          border-radius: 10px;
                          background-color: red;
                        "
                      >
                        <h1> فاتوره مرتجع مبيعات </h1>
                      </td>
                      <td></td>
                    </tr>
                  </thead>

                  <!-- <thead>
                    <tr>
                      <td colspan="5">
                        <h5>رقم السند :{{ return_cashs[0].cash_id }}</h5>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="5">
                        <h5>تاريخ السند : {{ return_cashs[0].date }}</h5>
                      </td>
                    </tr>

                    <tr>
                      <td colspan="5">
                        <h5>
                          اسم العميل : {{ return_cashs[0].name }} 
                     
                        </h5>
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
                  </thead> -->
                </table>
              </div>
              <div class="card-body">
                <table
                  class="table table-bordered text-right"
                  style="width: 100%"
                >
                  <thead style="background:red">
                    <tr>
                      <th>اسم المنتج</th>
                      <th class="wd-15p border-bottom-0">كميه </th>
                      <th class="wd-15p border-bottom-0">الكميه المرتحعه</th>
                      <th>الحاله</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="cash_details in cash_detail">
                      <td>{{ cash_details.product_name }}</td>
                      <td>{{ cash_details.quantity }}</td>
                      <td>{{ cash_details.qty_return }}</td>
                      <td>{{ cash_details.status }}</td>
                    </tr>
                  </tbody>
                              <tfoot >
                    <tr>
                      <th colspan="4"> الاجمالي:{{ return_cashs[0].sub_total }}</th>
                     
             
                            </tr>
                     <tr>
                        <th colspan="4">  اجمالي الضريبه:{{ return_cashs[0].tax_amount }}</th>
          
            
                    </tr>
                     <tr>
                
                      <th colspan="4"> الخصم:{{ return_cashs[0].discount }}</th>
                   
         
                    </tr>
                    <tr style="background-color: aqua;">
                
                      <th colspan="4"> الاجمالي الكلي:{{ return_cashs[0].grand_total }}</th>
                   
         
                    </tr>
                  
                  </tfoot>
                </table>
                 <div id = "intro" style = "text-align:left;">
          <h5>{{ timestamp }}</h5>
      </div>
      <div id = "intro" style = "text-align:right;">
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
      return_cashs: 0,
      cash_detail: 0,
        timestamp: "",
       user:'',
    };
  },
  created() {
     setInterval(this.getNow, 1000);
  },
  mounted() {
    let uri = `/invoice_return_cash/${this.$route.params.id}`;
    this.axios.post(uri).then((response) => {
        // console.log(response.data.cash_return_details);
        this.user = response.data.users.name;

      this.cash_detail = response.data.return_cash_details;
      this.return_cashs = response.data.return_cashs;
    });
  },
  methods: {
  
  },
  computed: {},
};
</script>

