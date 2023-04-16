<template>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <span class="h2">تفاصيل الصرف</span>
               
               
              </div>
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>اسم المنتج</th>
                        <th>الحاله</th>
                                     <th>المواصفات والطراز</th>
                      <th>الكميه المصروفه</th>
                       <!-- <th>الكميه المرتجعه</th> -->
                    
                       <th> المخزن</th>
                           
                       <!-- <th> الرف</th> -->
                    </tr>
                  </thead>
                  <tbody v-if="cash_detail && cash_detail.length > 0">
                    <tr v-for="(cash_details, index) in cash_detail" :key="index" >
                      <td>{{ index+1}}</td>
                      <td>{{ cash_details.product }}</td>
                         <td>{{ cash_details.status }}</td>
                                     <td>{{ cash_details.desc }}</td>
                      <td>{{ cash_details.quantity }}</td>
                      <!-- <td>{{ cash_details.qty_return }}</td> -->
          
                                    <td>{{ cash_details.store }}</td>
                                           <!-- <td>{{ cash_details.shelve_name }}</td> -->
                    </tr>
                   
                  </tbody>
                   <tbody v-else>
                <tr>
                  <td align="center" colspan="4"><h3>  لايوجد بيانات </h3></td>
                </tr>
              </tbody>
                  <!-- <tfoot>
                    <tr>
                      <th>Order no.</th>
                      <th>Order Total</th>
                      <th>Order Status</th>
                      <th>Date Order</th>
                    </tr>
                  </tfoot> -->
                </table>
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
     
      cash_detail: 0,
    };
  },
  mounted() {
      let uri = `/details_cash/${this.$route.params.id}`;
    this.axios.post(uri).then((response) => {
      this.cash_detail = response.data.cash_details;

      this.$root.logo = "CashDetails";
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

