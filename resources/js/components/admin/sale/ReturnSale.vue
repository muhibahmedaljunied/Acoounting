<template>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <span class="h2">اضافه مرتجع بيع</span>
              </div>
              <div class="text-center">
                <span
                  v-if="message_check"
                  class="alert alert-warning"
                  role="alert"
                >
                  ادخل كمبه اكبر من 0 و اقل من {{ text_message }}
                </span>
              </div>

              <div class="card-body">
                  <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <!-- <th>الرقم</th> -->
                      <th>اسم المنتج</th>
           
                           <th> المواصفات والطراز</th>
                                        <th>الحاله</th>
                               <th>المخزن</th>
                      <th>الكميه المباعه</th>
                      <th>  سعر الحبه</th>

             
                      <th>الكميه المسموح ارجاعها</th>
                        <th>اضافه</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="(sale_details, index) in sale_detail"
                      :key="index"
                    >
                      <input
                        v-model="sale_id=sale_details.sale_id"
                        readonly
                        type="hidden"
                        name="name"
                        id="name"
                        class="form-control"
                      />

                      <td>
                        <div class="form-group">
                          <input
                            v-model="sale_details.product"
                            readonly
                            type="text"
                            name="name"
                            id="name"
                            class="form-control"
                          />
                        </div>
                      </td>
                             <td>{{ sale_details.desc }}</td>
                                    <td>{{ sale_details.status }}</td>
                                           <td>{{ sale_details.store }}</td>
                      <td>
                        <div class="form-group">
                          <input
                            v-model="sale_details.qty"
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
                            v-model="sale_details.price"
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
                            v-model="sale_details.qty_remain"
                            type="number"
                            min="1"
                            :max="sale_details.qty_remain"
                            step="1"
                            class="form-control"
                          />
                        </div>
                      
                      </td>

                       <td>
                      <input
                      
                          v-if="
                            sale_details.qty_return != sale_details.quantity
                          "
                             v-model="check_state[index]"
                        @change="
                            add_return(
                              sale_details.qty_remain,
                              index,
                              sale_details.product_id,
                              sale_details.store_id,
                              sale_details.status_id,
                              sale_details.desc
                            )
                          "
                     type="checkbox"
                       
               
                        class="btn btn-info waves-effect"
                        >
                    </td>
                    </tr>
                    <tr>
                      <td colspan="8">
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
                      <td colspan="8">
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
                    <div v-if="seen" class="alert alert-warning" role="alert">
                      قم باضافه الكميه المرتجعه
                    </div>
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

    // return data;
    return {
      sale_detail: 0,
      sale_id: "",
      dateselected: "2021-11-18",
      note: "",
      Total_quantity: 0,
      check_state:[],
      return_qty: [],
      seen: false,

      not_qty: true,
      message_check: false,
      text_message: 0,
    };
  },
  mounted() {
    let uri = `/sale_details/${this.$route.params.id}`;
    this.axios.post(uri).then((response) => {
      this.sale_detail = response.data.sale_details;

      // this.$root.logo = "CashDetails";
    });
  },
  methods: {
    check_qty(sale_id = 0, qty_return, quantity) {
      if (qty_return > quantity || qty_return == 0) {
        this.text_message = quantity;
        this.message_check = true;
      } else {
        this.message_check = false;
      }

      // });
    },

    refund() {
      if (this.return_qty.length != 0) {
        this.axios
          .post("/salereturn", {
            old: this.sale_detail,
            date: this.dateselected,
            note: this.note,
            sale_id: this.sale_id,
            return_qty: this.return_qty,
            total: this.Total_quantity,
            type:'return_sale',
          })
          .then((response) => {
            if (response.data.message != 0) {
              this.seen = false;
              toastMessage("تم الارجاع بنجاح");
            } else {
              toastMessage("فشل", response.data.text);
            }
            this.$router.go(-1);
          });
      } else {
        this.seen = true;
      }
    },
     add_return(  qty_return,index, product_id, store_id, status_id,desc) {


    

     if(this.check_state[index] == true){
      
          
                  this.Total_quantity =parseInt(this.Total_quantity) + parseInt(qty_return);
                  this.return_qty[index] = {
                      product_id: product_id,
                      store_id: store_id,
                      status_id: status_id,
                      desc: desc,
                      qty: qty_return,
                    };
              
          
        
      
        
        console.log(this.return_qty);

     } else if(this.check_state[index] == false){

      this.$delete(this.return_qty,index);

         console.log(this.return_qty);
     }

    },
    // add_return(qty_return, index, product_id, store_id, shelve_id, status_id) {
    //   this.Total_quantity =
    //     parseInt(this.Total_quantity) + parseInt(qty_return);

    //   this.return_qty[index] = {
    //     product_id: product_id,
    //     store_id: store_id,
    //     shelve_id: shelve_id,
    //     status_id: status_id,
    //     qty: qty_return,
    //   };
    // },
  },
  computed: {},
};
</script>

