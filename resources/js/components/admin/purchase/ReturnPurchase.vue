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
                        <!-- <th class="wd-15p border-bottom-0">الوحده</th> -->

                        <th class="wd-15p border-bottom-0"> سعر الوحده</th>
                        <!-- <th class="wd-15p border-bottom-0">  الخصم</th> -->


                        <th>الكميه المتوفره</th>
                        <th>الحاله</th>
                        <th> المواصفات والطراز</th>
                        <th>المخزن</th>
                        <th>الكميه المسموح ارجاعها</th>
                        <th class="wd-15p border-bottom-0">الوحده</th>
                        <th>اضافه</th>
                      </tr>
                    </thead>
                    <tbody v-if="detail && detail.length > 0">
                      <tr v-for="(purchase_details, index) in detail" :key="index">
                        <input v-model="id = purchase_details.purchase_id" readonly type="hidden" name="name" id="name"
                          class="form-control" />

                        <td>
                          <div class="form-group">
                            <input v-model="purchase_details.product" readonly type="text" name="name" id="name"
                              class="form-control" />
                          </div>
                        </td>
                        <!-- <td>
                          <div class="form-group">
                            <input v-model="purchase_details.qty" readonly type="text" name="name" id="name"
                              class="form-control" />
                          </div>
                        </td> -->
                        <!-- <td>{{ purchase_details.qty }} {{ purchase_details.unit }}</td> -->

                        <td>

                          <div v-for="temx in purchase_details.units">

                            <span v-if="temx.name == purchase_details.unit">

                              <span v-if="temx.unit_type == 1">

                                {{ purchase_details.qty }} {{ temx.name }}

                              </span>

                              <span v-if="temx.unit_type == 0">

                                <span v-if="purchase_details.qty / purchase_details.rate >= 1">
                                  {{ Math.floor((purchase_details.qty / purchase_details.rate)) }}{{
                                    purchase_details.units[0].name
                                  }}
                                </span>

                                <span v-if="purchase_details.qty % purchase_details.rate >= 1">
                                  و
                                  {{ Math.floor((purchase_details.qty % purchase_details.rate)) }}{{
                                    purchase_details.units[1].name
                                  }}
                                </span>
                              </span>

                            </span>



                          </div>

                        </td>



                        <td>
                          <div class="form-group">
                            <input v-model="purchase_details.price" readonly type="text" name="name" id="name"
                              class="form-control" />
                          </div>


                        </td>
                        <!-- <td>
                          <div class="form-group">
                            <input v-model="purchase_details.avilable_qty" type="text" name="name" id="name"
                              class="form-control" readonly />
                          </div>
                        </td> -->

                        <td>

                          <div v-for="temx in purchase_details.units">



                            <span v-if="temx.unit_type == 0">

                              <span v-if="purchase_details.avilable_qty / purchase_details.rate >= 1">
                                {{ Math.floor((purchase_details.avilable_qty / purchase_details.rate)) }}{{
                                  purchase_details.units[0].name
                                }}
                              </span>

                              <span v-if="purchase_details.avilable_qty % purchase_details.rate >= 1">
                                {{ Math.floor((purchase_details.avilable_qty % purchase_details.rate)) }}{{
                                  purchase_details.units[1].name
                                }}
                              </span>
                            </span>

                          </div>

                        </td>



                        <td>{{ purchase_details.status }}</td>
                        <td>{{ purchase_details.desc }}</td>
                        <td>{{ purchase_details.store }}</td>

                        <td>
                          <div class="form-group">
                            <input v-if="purchase_details.avilable_qty > purchase_details.qty_remain"
                              v-model="purchase_details.qty_remain" type="number" min="1"
                              :max="purchase_details.qty_remain" step="1" class="form-control" />

                            <input v-else-if="purchase_details.avilable_qty == purchase_details.qty_remain"
                              v-model="purchase_details.qty_remain" type="number" min="1"
                              :max="purchase_details.qty_remain" step="1" class="form-control" />
                            <input v-else-if="purchase_details.avilable_qty < purchase_details.qty_remain"
                              v-model="purchase_details.qty_remain = purchase_details.avilable_qty" type="number"
                              min="1" :max="purchase_details.avilable_qty" step="1" class="form-control" />


                          </div>

                        </td>
                        <td>
                          <div class="form-group">
                            <input v-model="purchase_details.unit" readonly type="text" name="name" id="name"
                              class="form-control" />
                          </div>
                        </td>
                        <!-- <td>
                          <div v-for="temx in purchase_details.units">

                            <span v-if="temx.unit_type == 1">
                              {{ parseInt(purchase_details.avilable_qty / purchase_details.rate) }} {{ temx.name }}
                            </span>
                            <span v-if="temx.unit_type == 0">
                              <span
                                v-if="Math.floor(((purchase_details.avilable_qty / purchase_details.rate) - parseInt(purchase_details.avilable_qty / purchase_details.rate)) * purchase_details.rate) != 0">
                                و
                                {{
                                  Math.floor(((purchase_details.avilable_qty / purchase_details.rate) -
                                    parseInt(purchase_details.avilable_qty / purchase_details.rate)) *
                                    purchase_details.rate)
                                }}{{
  temx.name
}}
                              </span>

                            </span>
                          </div>

                        </td> -->

                        <td>
                          <input v-if="
                            purchase_details.qty_return !=
                            purchase_details.quantity
                          " v-model="check_state[index]" @change="
  add_one_return(
    purchase_details.qty_remain,
    index,
    purchase_details.product_id,
    purchase_details.store_id,
    purchase_details.status_id,
    purchase_details.desc,

    [
      purchase_details.unit_id,
      purchase_details.rate,
      purchase_details.unit_type
    ],

  )
" type="checkbox" class="btn btn-info waves-effect">
                        </td>
                      </tr>
                      <tr>
                        <td colspan="10">
                          <div class="m-t-30 col-md-12">
                            <label for="date">الاجمالي</label><br />
                            <input name="number" type="number" class="form-control" />


                          </div>
                        </td>
                      </tr>

                      <tr>
                        <td colspan="10">
                          <div class="m-t-30 col-md-12">
                            <label for="date">طريقه الدفع</label><br />


                            <select name="forma_pago" class="form-control" id="forma_pago" 
                            >
                              
                    
                              <option v-bind:value="1">نقد</option>
                              <option v-bind:value="2">أجل</option>
                            </select>                          </div>
                        </td>
                      </tr>
                      <tr>
                       
                        <td colspan="10">
                          <div class="m-t-30 col-md-12">
                            <label for="date">التاريخ</label><br />

                            <input name="date" type="date" v-model="dateselected" class="form-control" />
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
import operation from '../../../../js/operation.js';
export default {
  mixins: [operation],
  data() {
    // return data;

    return {


      purchase_detail: 0,
      purchase_id: "",
      seen: false,
      not_qty: true,
      message_check: false,
      text_message: 0,
    };
  },
  mounted() {
    this.table = 'purchase_details';
    this.type = 'PurchaseReturn';
    this.type_refresh = 'decrement';

    let uri = `/purchase_details/${this.$route.params.id}`;
    this.axios.post(uri, { table: this.table }).then((response) => {

      this.detail = response.data.purchase_details;
      console.log(response);

    });
  },
  methods: {
   

    add_one_return(qty_return, index, product, store, status, desc, unit) {


      console.log(product, index);
      console.log(qty_return, index);
      console.log(unit, index);
      console.log(desc, index);
      console.log(store, index);
      console.log(status, index);

      if (this.check_state[index] == true) {


        // if (qty != 0) {

        // if (qty <= availabe_qty) {

        this.counts[index] = index;
        this.product[index] = product;
        this.qty[index] = qty_return;
        this.unit[index] = unit;
        this.desc[index] = desc;
        this.store[index] = store;
        this.status[index] = status;
        // }
        // }



      } else if (this.check_state[index] == false) {

        this.$delete(this.counts, index);
        this.$delete(this.product, index);
        this.$delete(this.qty, index);
        this.$delete(this.unit, index);
        this.$delete(this.desc, index);
        this.$delete(this.store, index);
        this.$delete(this.status, index);


      }

    },




  },
 

};
</script>

