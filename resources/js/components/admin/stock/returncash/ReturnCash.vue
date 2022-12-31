<template>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <span class="h2">اضافه مرتجع صرف</span>
               
               
              </div>
           

              <div class="card-body">
                  <div class="table-responsive">
                <table    class="table table-bordered text-right"
                  style="width: 100%; font-size: x-large">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>اسم المنتج</th>
                              <th>الحاله</th>
                                                         <th>المواصفات والطراز</th>
                      <th>الكميه الصرفه</th>
                        <th>المخزن</th>
              
                      <th>الكميه المسموح ارجاعها</th>

                               <th>اضافه</th>
                    </tr>
                  </thead>
             
                                <tbody v-if="detail &&  detail.length > 0"> 

                           <tr v-for="(cash_details,index) in detail" :key="index">
                      <input
                        v-model="id = cash_details.cash_id"
                        readonly
                        type="hidden"
                        name="name"
                        id="name"
                        class="form-control"
                      />
                      <td>{{index+1}}</td>

                      <td>
                        <div class="form-group">
                          <input
                            v-model="cash_details.product"
                            readonly
                            type="text"
                            name="name"
                            id="name"
                            class="form-control"
                          />
                        </div>
                      </td>
                              <td>{{ cash_details.status }}</td>
                                 <td>{{ cash_details.desc }}</td>
                      <td>
                        <div class="form-group">
                          <input
                            v-model="cash_details.qty"
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
                            v-model="cash_details.store"
                             readonly
                            type="text"
                            name="name"
                            id="name"
                            class="form-control"
                          />
                        </div>
                      </td>
              
                      <td>

                        <div class="form-group" v-if="cash_details.qty_remain == 0">
                          <input 
                  readonly
                            v-model="cash_details.qty_remain"
                             type="number"
                      
                            min="1"
                             :max="cash_details.qty_remain"
                             step="1"
                            class="form-control"
               
                          />
                          </div>

                           <div class="form-group" v-else>
                          <input 
                  
                            v-model="cash_details.qty_remain"
                             type="number"
                      
                            min="1"
                             :max="cash_details.qty_remain"
                             step="1"
                            class="form-control"
               
                          />
                          </div>

                        
                        <!-- <a v-if="cash_details.qty_return != cash_details.quantity"  @click="add_return(cash_details.qty_remain,index,cash_details.product_id,cash_details.store_id,cash_details.status_id,cash_details.desc)"    class="tn btn-info btn-lg waves-effect btn-agregar"><i class="fa fa-plus-circle"></i></a>  -->

                         <!-- <span v-if="cash_details.qty_return-cash_details.quantity == 0" > لا يمكن اجراء عمليه ارجاع </span> -->
                      </td>
                       <td v-if="cash_details.qty_remain != 0">
                      <input
                     type="checkbox"
                       
               @change="add_one_return(cash_details.qty_remain,index,cash_details.product_id,cash_details.store_id,cash_details.status_id,cash_details.desc)"
                        class="btn btn-info waves-effect"
                        >
                    </td>
                    
                    </tr>
                    <tr>
                      <td colspan="10">
                        <div class="m-t-30 col-md-12">
                          <label for="date">التاريخ</label><br />

                          <input
                            name="date"
                            type="date"
                            v-model="date"
                            class="form-control"
                          />
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="10">
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

                    <a  v-if="not_qty"
                      @click="Add_return()"
                      class="btn btn-success"
                      ><span>تاكيد العمليه</span></a
                    >

                   
                      <div v-if="seen" class="alert alert-warning" role="alert">
  قم باضافه الكميه المرتجعه
</div>
                  </tbody>
                   <tbody v-else>
                <tr>
                  <td align="center" colspan="10">  <h3>لايوجد كمبه متوفره في المخزن او انه تم ارجاع الكميه  كامله.</h3></td>
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
//     return {
     
//       cash_detail: 0,
//       cash_id: "",
//       dateselected:new Date().toISOString().substr(0, 10),
//       note: "",
//       Total_quantity:0,
//        return_qty:[],
//        seen:false,

// not_qty:true,
//              message_check:false,
//  text_message:0,
//     };
  },
  mounted() {
      let uri = `/cash_details/${this.$route.params.id}`;
    this.axios.post(uri).then((response) => {
      console.log(response.data);
      this.detail = response.data.cash_details;

      this.type = 'return_cash';
    this.type_refresh = 'increment';

     
    });
  },
  methods: {

    

//     refund() {

         
//       this.axios.post("/cashreturn", {
//           old: this.cash_detail,
//           date: this.dateselected,
//           note: this.note,
//           cash_id:this.cash_id,
//           return_qty:this.return_qty,
//            total: this.Total_quantity,
//            type:'return_cash',

//         }).then((response) => {

//                 if(response.data.message != 0){

                  
//                       toastMessage("تم الارجاع بنجاح");

//                           this.$router.go(-1);
                   
//                 }else{
// toastMessage("فشل",response.data.text);
       

//                 }
                   
//       });

            
//     },
//    add_return(qty_return,index,product_id,store_id,status_id,desc){

    

//      this.Total_quantity=parseInt(this.Total_quantity)+ parseInt(qty_return);
   

//         this.return_qty[index] = {product_id:product_id,
//                                       store_id:store_id,
//                                       status_id:status_id,
//                                       desc:desc,
//                                       qty:qty_return
//          };
//           console.log(this.return_qty);
    
//     },

add_one_return( qty_return,index,product_id,store_id,status_id,desc) {

  alert(qty_return);

if (this.check_state[index] == true) {

  this.total_quantity = parseInt(this.total_quantity) + parseInt(qty_return);



  if (qty_return != 0) {


    // if (qty_return <= availabe_qty) {


      this.counts[index] = index;

      this.product[index] = product_id;
      this.qty[index] = qty_return;
      this.desc[index] = desc;

      this.store[index] = store_id;
      this.status[index] = status_id;

    


    // }
  }


} else if (this.check_state[index] == false) {

  this.$delete(this.counts, index);
  this.$delete(this.product, index);
  this.$delete(this.qty, index);
  this.$delete(this.desc, index);
  this.$delete(this.product_name, index);
  this.$delete(this.store, index);
  this.$delete(this.status, index);
  this.$delete(this.availabe_qty, index);


}

 console.log(this.counts);
  console.log(this.product);
  console.log(this.qty);
  console.log(this.desc);
  console.log(this.store);
  console.log(this.status);

},

Add_return() {

// alert('ddddddddddd');
Add_return(this)

},


  },
  
};
</script>

