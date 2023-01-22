<template>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <span class="h2">اضافه مرتجع توريد</span>
              </div>
              <!-- <div class="text-center">
                <span v-if="message_check" class="alert alert-warning" role="alert">
                  ادخل كمبه اكبر من 0 و اقل من {{ text_message }}
                </span>
              </div> -->

              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered text-right" style="width: 100%; font-size: x-large">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>اسم المنتج</th>
                        <th>الحاله</th>
                        <th>المواصفات والطراز</th>
                        <th class="wd-15p border-bottom-0"> الكميه الوارده</th>
                        <th>الكميه المتوفره</th>
                        <th>المخزن</th>
                        <!-- <th>الرف</th> -->


                        <th>الكميه المسموح ارجاعها</th>
                        <th>اضافه</th>
                      </tr>
                    </thead>
                    <tbody v-if="detail && detail.length > 0">
                      <tr v-for="(supply_details, index) in detail" :key="index">
                        <input v-model="id = supply_details.supply_id" readonly type="hidden" name="name"
                          id="name" class="form-control" />
                        <td>{{ index + 1 }}</td>

                        <td>
                          <div class="form-group">
                            <input v-model="supply_details.product" readonly type="text" name="name" id="name"
                              class="form-control" />
                          </div>
                        </td>
                        <td>{{ supply_details.status }}</td>
                        <td>{{ supply_details.desc }}</td>
                        <td>
                          <div class="form-group">
                            <input v-model="supply_details.qty" readonly type="text" name="name" id="name"
                              class="form-control" />
                          </div>
                        </td>
                        <td>
                          <div class="form-group">
                            <input v-model="supply_details.avilable_qty" readonly type="text" name="name" id="name"
                              class="form-control" />
                          </div>
                        </td>
                        <td>

                          <div class="form-group">
                            <input v-model="supply_details.store" readonly type="text" name="name" id="name"
                              class="form-control" />
                          </div>
                        </td>
                      


                        <td>
                          <div class="form-group">

                            <input v-if="supply_details.avilable_qty > supply_details.qty_remain"
                              v-model="supply_details.qty_remain" type="number" :min="1"
                              :max="supply_details.qty_remain" :step="1" class="form-control" />

                            <input v-else-if="supply_details.avilable_qty == supply_details.qty_remain"
                              v-model="supply_details.qty_remain" type="number" :min="1"
                              :max="supply_details.qty_remain" :step="1" class="form-control" />
                            <input v-else-if="supply_details.avilable_qty < supply_details.qty_remain"
                              v-model="supply_details.qty_remain = supply_details.avilable_qty" type="number" :min="1"
                              :max="supply_details.avilable_qty" :step="1" class="form-control" />








                            <!-- <input
                          v-if="supply_details.qty_return == supply_details.quantity"
                          readonly='true'
                            v-model=" supply_details.qty_return"
                            type="text"
                            name="name"
                            id="name"
                            min="1"
                             :max='supply_details.avilable_qty'
                            class="form-control"
                            @input="check_qty(supply_details.supply_id,supply_details.qty_return,supply_details.quantity,supply_details.avilable_qty)"
                          />

                               <input v-else
                 
                            v-model=" supply_details.qty_return"
                            type="text"
                            name="name"
                            id="name"
                            min="1" 
                            max="7"
                            class="form-control"
                            @input="check_qty(supply_details.supply_id,supply_details.qty_return,supply_details.quantity,supply_details.avilable_qty)"
                          /> -->

                            <!-- <a   @click="add_return(supply_details.qty_remain,supply_details.quantity,supply_details.avilable_qty,supply_details.product_id)"    class="tn btn-info btn-lg waves-effect btn-agregar"><i class="fa fa-plus-circle"></i></a>  -->

                            <!-- <a v-if="supply_details.qty_remain < supply_details.avilable_qty"    @click="add_return(supply_details.qty_return,supply_details.quantity,supply_details.avilable_qty,supply_details.product_id)"    class="tn btn-info btn-lg waves-effect btn-agregar"><i class="fa fa-plus-circle"></i></a>  -->

                            <!-- <a v-if="supply_details.qty_return != supply_details.quantity"   @click="add_return(supply_details.qty_remain,index,supply_details.product_id,supply_details.store_id,supply_details.status_id,supply_details.desc)"     class="tn btn-info btn-lg waves-effect btn-agregar"><i class="fa fa-plus-circle"></i></a>    -->
                            <!-- <span v-if="supply_details.qty_return != supply_details.quantity"> لا يمكن اجراء عمليه ارجاع </span> -->







                          </div>
                        </td>
                        <td>
                          <input v-if="supply_details.qty_remain != 0"
                            @change="add_one_return(supply_details.qty_remain, index, supply_details.product_id, supply_details.store_id, supply_details.status_id, supply_details.desc)"
                            type="checkbox" v-model="check_state[index]" class="btn btn-info waves-effect">
                            
                        </td>

                      </tr>
                      <tr>
                        <td colspan="10">
                          <div class="m-t-30 col-md-12">
                            <label for="date">التاريخ</label><br />

                            <input name="date" type="date" v-model="date" class="form-control" />
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="10">
                          <div class="m-t-30 col-md-12">
                            <label for="date">ملاحظات</label><br />
                            <input v-model="note" type="text" name="name" id="name" class="form-control" />
                          </div>
                        </td>
                      </tr>

                      <a v-if="not_qty" @click="Add_return()" class="btn btn-success"><span>تاكيد العمليه</span></a>

<!-- 
                      <div>


                        <div v-if="seen" class="alert alert-warning" role="alert">
                          قم باضافه الكميه المرتجعه
                        </div>

                      </div> -->
                    </tbody>
                    <tbody v-else>
                      <tr>
                        <td align="center" colspan="10">
                          <h3>لايوجد كمبه متوفره في المخزن او انه تم ارجاع الكميه المورده كامله.</h3>
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
    //   supply_detail: "",
    //   supply_id: "",
    //   date: new Date().toISOString().substr(0, 10),
    //   note: "",
    //   Total_quantity: 0,
    //   return_qty: [],
    //   check_state: [],
    //   seen: false,
    //   not_qty: true,
    //   message_check: false,
    //   text_message: 0,

    // };
  },
  mounted() {
    let uri = `/supply_details/${this.$route.params.id}`;
    this.axios.post(uri).then((response) => {
      // alert('sdsdsdsdsdsddssdsd');
      console.log(response.data.supply_details)
      this.detail = response.data.supply_details;

      // this.$root.logo = "SupplyDetails";


    this.type = 'return_supply';
    this.type_refresh = 'decrement';


    });
  },
  methods: {



   

    add_one_return( qty_return, index, product_id, store_id, status_id, desc) {



      if (this.check_state[index] == true) {

        this.total_quantity = parseInt(this.total_quantity) + parseInt(qty_return);
        alert(qty_return);
    

        if (qty_return != 0) {


          // if (qty_return <= availabe_qty) {


            this.counts[index] = index;

            this.product[index] = product_id;
            this.qty[index] = qty_return;
            this.desc[index] = desc;

            this.store[index] = store_id;
            this.status[index] = status_id;

            // this.availabe_qty[index] = availabe_qty;


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

