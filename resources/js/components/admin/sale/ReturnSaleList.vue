<template>
<div>
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
    <div class="card-header pb-0">
         
                <span class="h2"> مرتجع مبيعات</span>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table text-md-nowrap" id="example1">
              <thead>
                <tr>
                  <th class="wd-15p border-bottom-0">رقم السند</th>
                  <th class="wd-15p border-bottom-0">العميل</th>
                    <th class="wd-15p border-bottom-0">الكميه</th>
                  <th class="wd-15p border-bottom-0">تاريخ المرتجع</th>
<th class="wd-15p border-bottom-0">سبب الارجاع </th>
                  <th class="wd-15p border-bottom-0">العمليات</th>
                </tr>
              </thead>
              <tbody v-if="return_sale && return_sale.length > 0">
                <tr v-for="return_sales in return_sale">
                  <td>{{ return_sales.return_id }}</td>
                  <td>{{ return_sales.customer_name }}</td>

    <td>{{ return_sales.quantity_return }}</td>
                  <td>{{ return_sales.return_date }}</td>
 <td>{{ return_sales.note }}</td>
                  <td>
                    <!-- <button

                    @click="supply_details(supplies.id)"
                      type="button"
    
                      class="btn btn-danger"
                    >
                      <i class="mdi mdi-account-minus"></i>
                    </button> -->

                    <!-- <router-link
                      :to="`/return_sale_details/${return_sales.return_id}`"
                      class="btn btn-success"
                    >
                      <span><i class="fa fa-search-plus"></i></span>
                    </router-link>
                           <router-link
                    :to="`/return_sale_invoice/${return_sales.return_id}`"
                        class="btn btn-success">
                    
                      <span>فاتوره</span>
                    </router-link> -->


                             
        <div class="optionbox">
           <select   @change="changeRoute(index)"  v-model="operationselected[index]"  name="العمليات"  class="form-control" >
      <option   class="btn btn-success"   v-bind:value="['/returnsale_details/',return_sales.return_id,0]">
                      تفاصيل
                    </option>
   
 
      <option   class="btn btn-success" v-bind:value="['/return_sale_invoice/',return_sales.return_id,1]">
                      سند مرتجع مبيعات
                 </option>
      <option  class="btn btn-success"  v-bind:value="['/return_sale_recive/',return_sales.return_id,2]">
                      سند استلام مرتجع مبيعات
                   </option>
                      <option  class="btn btn-success"  v-bind:value="['/return_sale_invoice_cancel/',return_sales.sale_id,3]">
                   الفاء الفاتوره
                   </option>
                      <option  class="btn btn-success"  v-bind:value="['/return_sale_invoice_update/',return_sales.sale_id,4]">
                   تعديل الفاتوره
                   </option>
    
  </select>
  </div>



                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

  </div>
   <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header pb-0">
         
                <span class="h2">تفاصيل مرتجع المبيعات</span>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table text-md-nowrap" id="example1">
              <thead>
                <tr>
                  <!-- <th class="wd-15p border-bottom-0">رقم المرتجع</th> -->
                  <th class="wd-15p border-bottom-0">المنتج</th>
                      <th class="wd-15p border-bottom-0">الحاله</th>
                                         <th>المواصفات والطراز</th>
                  <th class="wd-15p border-bottom-0">الكميه</th>
                         <th class="wd-15p border-bottom-0">المخزن</th>
             
                </tr>
              </thead>
           
                  <tbody  v-if="return_detail && return_detail.length > 0">
                <tr v-for="return_details in return_detail">
                  <!-- <td>{{ return_details.supply_return_id }}</td> -->
                  <td>{{ return_details.product_name }}</td>
                   <td>{{ return_details.status }}</td>
                                 <td>{{ return_details.desc }}</td>
                             <td>{{ return_details.qty_return }}</td>
                                    <td>{{ return_details.code }}</td>
                 


        

                  
                </tr>
               
              </tbody>
              <tbody v-else>
 <tr>
                  <td align="center" colspan="3">  <h3>لايوجد اي مرتجعات</h3></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

  
</template>
<script>
export default {
  data() {
    return {
      return_sale: "yes",
      return_detail:'',
      operationselected:[],
    };
  },
  mounted() {



    this.axios.post(`/listreturn_sale/${this.$route.params.id}`).then((response) => {
      this.return_sale = response.data.return_sales;

      this.$root.logo = "CashList";
    });
  },
  methods: {
        changeRoute(index) {
      

        if(this.operationselected[index][2] == 0){
          
           this.axios
          .post(this.operationselected[index][0]+this.operationselected[index][1])
          .then((response) => {

            this.return_detail = response.data.return_details;
            
          })
          .catch(({ response }) => {
            console.error(response);
          });

        }else{

            this.$router.push(this.operationselected[index][0]+this.operationselected[index][1]);
        }
     
            },
    // supply_details(id){
    //     this.axios.post(`supply_details/${id}`).then(response => {
    // 		toast.fire({
    //                           title: "Deleted!",
    //                           text: "Your category has been deleted.",
    //                           button: "Close", // Text on button
    //                           icon: "success", //built in icons: success, warning, error, info
    //                           timer: 3000, //timeOut for auto-close
    //                           buttons: {
    //                               confirm: {
    //                               text: "OK",
    //                               value: true,
    //                               visible: true,
    //                               className: "",
    //                               closeModal: true
    //                               },
    //                               cancel: {
    //                               text: "Cancel",
    //                               value: false,
    //                               visible: true,
    //                               className: "",
    //                               closeModal: true,
    //                               }
    //                           }
    //                       })
    //               // this.$router.push('category')
    // 	})
    // }
  },
};
</script>

<style scoped>

.optionbox select {
    background: #E62968;
    color: #fff;
    padding: 10px;
    width: 120px;
    height: 30px;
    border: none;
    font-size: 20px;
    box-shadow: 0 5px 18px rgb(93, 15, 9);
    -webkit-appearance: button;
    outline: none;
}




</style>



