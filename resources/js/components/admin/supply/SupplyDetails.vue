<template>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <span class="h2">تفاصيل الشراء</span>


              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <!-- <th>  رقم الفاتوره </th> -->
                        <th>اسم المنتج</th>
                        <th> المواصفات والطراز</th>
                        <th>الحاله</th>
                        <th>المخزن</th>

                        <th class="wd-15p border-bottom-0"> كميه الشراء</th>
                        <th>الوحده</th>
                        <th class="wd-15p border-bottom-0"> السعر </th>
                        <th class="wd-15p border-bottom-0"> الاجمالي </th>

                        <!-- <th class="wd-15p border-bottom-0">  الكميه المرتحعه</th> -->


                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="supply_details in supply_detail">
                        <!-- <td>{{ supply_details.id }}</td> -->
                        <td>{{ supply_details.name }}</td>
                        <td>{{ supply_details.desc }}</td>
                        <td>{{ supply_details.status }}</td>
                        <td>{{ supply_details.code }}</td>
                        <td>{{ supply_details.quantity }}</td>
                        <td>{{ supply_details.unit }}</td>
                        <td>{{ supply_details.price }}</td>
                        <td>{{ supply_details.total }}</td>
                        <!-- <td>{{ supply_details.qty_return }}</td> -->



                      </tr>
                      <tr>

                        <td colspan="7" style="text-align:center;color:red;font-size:large">الاجمالي</td>
                        <td>{{ total }}</td>
                      </tr>
                      <!-- <a 
                      @click="$router.go(-1)"
                      class="btn btn-success"
                      ><span> تراجع</span></a
                    > -->
                    </tbody>

                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--
            *******************************************************************
            *******************************************************************
                                 MODAL ALERTA VACIAR
            *******************************************************************
            *******************************************************************
            -->


      <!-- /.modal -->

      <!--
            *******************************************************************
            *******************************************************************
                                FIN MODAL ALERTA VACIAR
            *******************************************************************
            *******************************************************************
            -->
    </section>
  </div>
</template>

<script>

export default {
  data() {
    return {

      supply_detail: 0,
      total: 0,
    };
  },
  mounted() {
    let uri = `/details_supply/${this.$route.params.id}`;
    this.axios.post(uri).then((response) => {
      console.log(response);



      this.supply_detail = response.data.supply_details;

      this.supply_detail.forEach((item) => {
        this.total = parseInt(item.total) + parseInt(this.total);
      });

    });
  },
  methods: {
    // refund(e) {
    //   this.axios.post("/order/refund",this.showOrderDetailsP).then((response) => {
    //   //  console.log(response.data);
    //   });
    // },
  },
  computed: {
    // showshowOrderDetailsOrderDetails() {
    //   this.showOrderDetailsP = this.$store.getters.getProductInformation;
    //   this.showOrderDetailsP.forEach((item) => {
    //         // this.Total_quantity = item.total + this.Total;
    //         this.Total = item.total + this.Total;
    //         this.NET_TO_PAY = item.total + this.NET_TO_PAY;
    //       });
    //   return this.showOrderDetailsP;
    // },
    // showProductInformation() {
    //   return this.$store.getters.getProductInformation;
    // },
    // showCustomerInformation() {
    //   return this.$store.getters.getCustomerInformation;
    // },
    // showorderInformation() {
    //   return this.$store.getters.getOrderInformation;
    // },
    // showpaymentInformation() {
    //   return this.$store.getters.getPaymentInformation;
    // },
  },
};
</script>

