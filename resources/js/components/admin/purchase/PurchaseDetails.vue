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

                               <th class="wd-15p border-bottom-0">  كميه الشراء</th>
                               <th class="wd-15p border-bottom-0"> السعر </th>
                                <th class="wd-15p border-bottom-0">  الاجمالي   </th>
                               
                   <!-- <th class="wd-15p border-bottom-0">  الكميه المرتحعه</th> -->
                     
                      
                    </tr>
                  </thead>
                  <tbody>
                    <tr  v-for="purchase_details in purchase_detail">
                      <!-- <td>{{ purchase_details.id }}</td> -->
                      <td>{{ purchase_details.name }}</td>
                        <td>{{ purchase_details.desc }}</td>
                          <td>{{ purchase_details.status }}</td>
                             <td>{{ purchase_details.code }}</td>
                      <td>{{ purchase_details.quantity }}</td>
                        <td>{{ purchase_details.price }}</td>
                          <td>{{ purchase_details.total }}</td>
                            <!-- <td>{{ purchase_details.qty_return }}</td> -->
                    

                        
                    </tr>
                    <tr >

<td colspan="7" style="text-align:center;color:red;font-size:large">الاجمالي</td>
<td>{{total}}</td>
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
     
      purchase_detail: 0,
      total:0,
    };
  },
  mounted() {
      let uri = `/details_purchase/${this.$route.params.id}`;
    this.axios.post(uri).then((response) => {
      console.log(response);

         

      this.purchase_detail = response.data.purchase_details;

this.purchase_detail.forEach((item) => {
            this.total =parseInt(item.total) + parseInt(this.total);
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

