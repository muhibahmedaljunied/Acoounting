<template>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <span class="h2">اضافه مرتجع شراء</span>
              </div>
              <div class="text-center">
                <!-- <span
                  v-if="message_check"
                  class="alert alert-warning"
                  role="alert"
                >
                  ادخل كمبه اكبر من 0 و اقل من {{ text_message }}
                </span> -->
              </div>

              <div class="card-body">
                  <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <!-- <th>الرقم</th> -->
                      <th>اسم المنتج</th>
                      <th class="wd-15p border-bottom-0">كميه الشراء</th>
                      <th class="wd-15p border-bottom-0">   سعر الحبه</th>
                      <!-- <th class="wd-15p border-bottom-0">  الخصم</th> -->


                      <th>الكميه المتوفره</th>
                      <th>الحاله</th>
                           <th> المواصفات والطراز</th>
                               <th>المخزن</th>
                      <th>الكميه المسموح ارجاعها</th>
                      
                                 <th>اضافه</th>
                    </tr>
                  </thead>
                  <tbody v-if="detail && detail.length > 0">
                    <tr
                      v-for="(purchase_details, index) in detail"
                      :key="index"
                    >
                      <input
                        v-model="id = purchase_details.purchase_id"
                        readonly
                        type="hidden"
                        name="name"
                        id="name"
                        class="form-control"
                      />

                      <td>
                        <div class="form-group">
                          <input
                       
                            v-model="purchase_details.product"
                            readonly
                            type="text"
                            name="name"
                            id="name"
                            class="form-control"
                          />
                        </div>
                      </td>
                      <td>
                        <div class="form-group">
                          <input
                      
                            v-model="purchase_details.qty"
                            readonly
                            type="text"
                            name="name"
                            id="name"
                            class="form-control"
                          />
                        </div>
                      </td>
                      <td>
                        <div class="form-group">
                          <input
                      
                            v-model="purchase_details.price"
                            readonly
                            type="text"
                            name="name"
                            id="name"
                            class="form-control"
                          />
                        </div>
                     

                      </td>
                      <td>
                        <div class="form-group">
                          <input
                   
                            v-model="purchase_details.avilable_qty"
                            type="text"
                            name="name"
                            id="name"
                            class="form-control"
                            readonly
                          />
                        </div>
                      </td>
                      <td>{{ purchase_details.status }}</td>
                         <td>{{ purchase_details.desc }}</td>
                         <td>{{ purchase_details.store }}</td>

                      <td>
                        <div class="form-group">
                          <input
                    
                            v-if="
                              purchase_details.avilable_qty >
                              purchase_details.qty_remain
                            "
                            v-model="purchase_details.qty_remain"
                            type="number"
                            min="1"
                            :max="purchase_details.qty_remain"
                            step="1"
                            class="form-control"
                          />

                          <input
                 
                            v-else-if="
                              purchase_details.avilable_qty ==
                              purchase_details.qty_remain
                            "
                            v-model="purchase_details.qty_remain"
                            type="number"
                            min="1"
                            :max="purchase_details.qty_remain"
                            step="1"
                            class="form-control"
                          />
                          <input
                     
                            v-else-if="
                              purchase_details.avilable_qty <
                              purchase_details.qty_remain
                            "
                            v-model="
                              purchase_details.qty_remain =
                                purchase_details.avilable_qty
                            "
                            type="number"
                            min="1"
                            :max="purchase_details.avilable_qty"
                            step="1"
                            class="form-control"
                          />

                        
                        </div>

                      </td>

 <td>
                      <input
 
                       v-if="
                              purchase_details.qty_return !=
                              purchase_details.quantity
                            "
                            v-model="check_state[index]"
                            @change="
                              add_one_return(
                                purchase_details.qty_remain,
                                index,
                                purchase_details.product_id,
                                purchase_details.store_id,
                                purchase_details.status_id,
                                purchase_details.desc
                              )
                            "
                     type="checkbox"
                       
               
                        class="btn btn-info waves-effect"
                        >
                    </td>
                    </tr>
                    <tr>
                      <td colspan="9">
                        <div class="m-t-30 col-md-12">
                          <label for="date">التاريخ</label><br />

                          <input
                            name="date"
                            type="date"
                            v-model="dateselected"
                            class="form-control"
                          />
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="9">
                        <div class="m-t-30 col-md-12">
                          <label for="date">ملاحظات</label><br />
                          <input
                            v-model="note"
                            type="text"
                            name="name"
                            id="name"
                            class="form-control"
                          />
                        </div>
                      </td>
                    </tr>

                    <a v-if="not_qty" @click="refund()" class="btn btn-success"
                      ><span>تاكيد العمليه</span></a
                    >

                    <div>
                      <div v-if="seen" class="alert alert-warning" role="alert">
                        قم باضافه الكميه المرتجعه
                      </div>
                    </div>
                  </tbody>
                  <tbody v-else>
                    <tr>
                      <td align="center" colspan="3">
                        <h3>
                          لايوجد كمبه متوفره في المخزن او انه تم ارجاع الكميه
                          المورده كامله.
                        </h3>
                      </td>
                    </tr>
                  </tbody>
                </table>
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
    return data;

    // return {
    //   purchase_detail: 0,
    //   purchase_id: "",
    //   dateselected: "2021-11-18",
    //   note: "",
    //   Total_quantity: 0,
    //     check_state:[],
    //   return_qty: [],
    //   seen: false,
    //   not_qty: true,
    //   message_check: false,
    //   text_message: 0,
    // };
  },
  mounted() {
    let uri = `/purchase_details/${this.$route.params.id}`;
    this.axios.post(uri).then((response) => {
      
      this.detail = response.data.purchase_details;
console.log(this.detail);
     
    });
  },
  methods: {
    // refund() {
    //   // console.log(this.return_qty.length);

    //   if (this.return_qty.length != 0) {
    //     //  console.log(this.Total_quantity)
    //     this.axios
    //       .post("/purchasereturn", {
    //         old: this.detail,
    //         date: this.dateselected,
    //         note: this.note,
    //         purchase_id: this.purchase_id,
    //         return_qty: this.return_qty,

    //         total: this.Total_quantity,
    //         type:'return_purchase',
            
    //       })
    //       .then((response) => {
    //         if (response.data.message != 0) {
    //           console.log(response);

    //           this.seen = false;
    //           toastMessage("تم الارجاع بنجاح");
    //         } else {
    //           toastMessage("فشل", response.data.text);
    //         }

    //         this.$router.go(-1);
    //       });
    //   } else {
    //     this.seen = true;
    //   }
    // },


    //   add_return(qty_return, index, product_id, store_id,status_id,desc) {


    
    //  if(this.check_state[index] == true){
      
      
    //     this.Total_quantity =
    //     parseInt(this.Total_quantity) + parseInt(qty_return);

    //    this.return_qty[index] = {
    //     product_id: product_id,
    //     store_id: store_id,
    //     status_id: status_id,
    //     desc: desc,
    //     qty: qty_return,
    //   };
    
      
    //     console.log(this.return_qty);

    //  } else if(this.check_state[index] == false){

    //   this.$delete(this.return_qty,product_id);

    //      console.log(this.return_qty);
    //  }

    // },
    add_one_return() {
   
   // alert('ddddddddddd');
Add_return(this)

},


  },
 
};
</script>

