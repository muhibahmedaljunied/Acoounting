<template>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <span class="h3"> فاتوره مردود مشتريات</span>

              </div>
              <div class="text-center">

              </div>

              <div class="card-body">
                <div class="row">
                  <div class="col-md-2">


                    <label for="date">رقم الفاتوره</label><br />

                    <!-- <input v-model="data.purchase_id" style="background-color: beige;" class="form-control" /> -->

                    <div>{{ data.purchase_id }}</div>

                  </div>
                  <div class="col-md-2">
                    <label for="pagoPrevio">المورد</label>

                    <div>{{ data.supplier_name }}</div>


                  </div>
                  <div class="col-md-4">
                    <label for="pagoPrevio">اجمالي الفاتوره</label>

                    <div>{{ data.grand_total }}</div>



                  </div>




                </div>


                <br>
                <hr>
                <div class="row">
                  <div class="col-md-2">




                    <label for="date">التاريخ</label><br />

                    <input style="background-color: beige;" name="date" type="date" v-model="dateselected"
                      class="form-control" />




                  </div>
                  <div class="col-md-2" v-if="data.payment_status == 'pendding'">

                    <label for="date">طريقه الدفع</label><br />

                    <input readonly style="background-color: beige;" name="date" type="text" value="أجل"
                      class="form-control" />



                  </div>
                  <div class="col-md-2" v-else>

                    <label for="date">طريقه الدفع</label><br />


                    <select style="background-color: beige;" name="forma_pago" class="form-control" id="forma_pago"
                      v-model="Way_to_pay_selected" v-on:change="onwaychange">


                      <option v-bind:value="1">نقد</option>
                      <option v-bind:value="2">أجل</option>
                      <option v-bind:value="3">بنك</option>

                    </select>


                  </div>


                  <div class="col-md-4">
                    <h5 class="card-title"> الحساب</h5>
                    <div class="custom-search">

                      <input :id="'PurchaseReturn_account_tree'" type="text" readonly class="custom-search-input">
                      <input :id="'PurchaseReturn_account_tree_id'" type="hidden" readonly class="custom-search-input">


                      <button class="custom-search-botton" type="button" data-toggle="modal"
                        data-target="#exampleModalAccount">
                        <i class="fa fa-plus-circle"></i></button>
                    </div>
                  </div>




                </div>

                <br>
                <hr>

                <div class="row">



                  <div class="col-md-4">
                    <label for="cliente"> الحساب التفصيلي</label>

                    <select class="form-control" style="background-color: beige;" name="forma_pago"
                      id="select_account_PurchaseReturn_group">

                    </select>

                  </div>






                  <div class="col-md-4">
                    <label for="pagoPrevio">البيان</label>


                    <input class="form-control" style="background-color: beige;" type="text" v-model="description">


                  </div>

                  <div class="col-md-4">
                    <label for="pagoPrevio">اختيار الكل</label> <br>

                    <input v-model="check_state_all" @change="check_all_return()" type="checkbox"
                      class="btn btn-info waves-effect">
                  </div>


                </div>

                <br>
                <hr>

                <div class="row">
                  <div class="col-m-12">
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <!-- <th>الرقم</th> -->
                            <th>اسم المنتج</th>
                            <th>كميه الشراء</th>
                            <!-- <th class="wd-15p border-bottom-0">الوحده</th> -->

                            <!-- <th class="wd-15p border-bottom-0"> سعر الوحده</th> -->
                            <!-- <th class="wd-15p border-bottom-0">  الخصم</th> -->


                            <th>الكميه المتوفره</th>
                            <th>الحاله</th>
                            <th> المواصفات والطراز</th>
                            <th>المخزن</th>
                            <th>الكميه المسموح ارجاعها</th>
                            <th>السعر</th>

                            <th>الوحده</th>
                            <th>الكميه المرتجعه الفعليه</th>
                            <th>قيمه المرتجع</th>

                            <th>اضافه</th>
                          </tr>
                        </thead>
                        <tbody v-if="detail && detail.length > 0">
                          <tr v-for="(purchase_details, index) in detail" :key="index">

                            <input v-model="id = purchase_details.purchase_id" readonly type="hidden" name="name"
                              id="name" class="form-control" />

                            <td>


                              {{ purchase_details.product }}
                            </td>

                            <td>


                              <div v-for="temx in purchase_details.qty_after_convert">



                                <span v-for="temx2 in temx">


                                  <span v-for="temx3 in temx2">



                                    <span>
                                      {{ temx3[0] }}
                                    </span>
                                    <span style="color: red;">
                                      {{ temx3[1] }}
                                    </span>

                                  </span>
                                </span>

                                <!-- <span v-if="temx.unit_type == 0">


  <span>{{ Math.floor((stock.quantity)) }}</span><span style="color: red;"> {{
temx.name }}</span>



</span> -->

                              </div>



                              <!-- <div v-for="temx in purchase_details.units">



                                <span v-if="temx.unit_type == 0">

                                  <span v-if="purchase_details.qty / purchase_details.rate >= 1">
                                    {{ Math.floor((purchase_details.qty / purchase_details.rate)) }}{{
                      purchase_details.units[0].name
                    }}
                                  </span>

                                  <span v-if="purchase_details.qty % purchase_details.rate >= 1">
                                    {{ Math.floor((purchase_details.qty % purchase_details.rate)) }}{{
                      purchase_details.units[1].name
                    }}
                                  </span>
                                </span>


                              </div> -->
                            </td>




                            <td>

                              <div v-for="temx in purchase_details.qty_after_convert">



                                <span v-for="temx2 in temx">


                                  <span v-for="temx3 in temx2">



                                    <span>
                                      {{ temx3[0] }}
                                    </span>
                                    <span style="color: red;">
                                      {{ temx3[1] }}
                                    </span>

                                  </span>
                                </span>

                                <!-- <span v-if="temx.unit_type == 0">


<span>{{ Math.floor((stock.quantity)) }}</span><span style="color: red;"> {{
temx.name }}</span>



</span> -->

                              </div>


                              <!-- <div v-for="temx in purchase_details.units">



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





                              </div> -->

                            </td>



                            <td>{{ purchase_details.status }}</td>
                            <td>{{ purchase_details.desc }}</td>
                            <td>{{ purchase_details.store }} <input id="select_account_PurchaseReturn" type="hidden"
                                v-model="purchase_details.store_account"></td>

                            <td>

                              <div v-for="temx in purchase_details.qty_after_convert">



                                <span v-for="temx2 in temx">


                                  <span v-for="temx3 in temx2">



                                    <span>
                                      {{ temx3[0] }}
                                    </span>
                                    <span style="color: red;">
                                      {{ temx3[1] }}
                                    </span>

                                  </span>
                                </span>

                                <!-- <span v-if="temx.unit_type == 0">


<span>{{ Math.floor((stock.quantity)) }}</span><span style="color: red;"> {{
temx.name }}</span>



</span> -->

                              </div>


                              <!-- <div v-for="temx in purchase_details.units">

                                <span v-if="temx.unit_type == 0">

                                  <span v-if="purchase_details.qty_remain / purchase_details.rate >= 1">
                                    {{ Math.floor((purchase_details.qty_remain / purchase_details.rate)) }}{{
                      purchase_details.units[0].name
                    }}
                                  </span>

                                  <span v-if="purchase_details.qty_remain % purchase_details.rate >= 1">
                                    {{ Math.floor((purchase_details.qty_remain % purchase_details.rate)) }}{{
                      purchase_details.units[1].name
                    }}
                                  </span>
                                </span>



                              </div> -->



                            </td>

                            <td> <input style="background-color: controlbeige;" v-model="purchase_details.price"
                                type="number" min="1" step="1" class="form-" /> </td>

                            <td>


                              <select v-if="check_state[index] == true" style="background-color: beige;"
                                :id="'select_unit' + index" v-model="unit[index]" name="type" class="form-control"
                                required>

                                <option disabled v-for="unit in purchase_details.units"
                                  v-bind:value="[unit.id, unit.rate, unit.unit_type]">
                                  {{ unit.name }}
                                </option>


                              </select>


                              <select v-on:change="calculate_price(index, purchase_details)" v-else
                                style="background-color: beige;" :id="'select_unit' + index" v-model="unit[index]"
                                name="type" class="form-control" required>

                                <option v-for="unit in purchase_details.units"
                                  v-bind:value="[unit.id, unit.rate, unit.unit_type]">
                                  {{ unit.name }}
                                </option>


                              </select>
                            </td>
                            <td>
                              <div class="form-group">
                                <input @input="calculate_price(index, purchase_details)"
                                  style="background-color: beige;" v-model="qty[index]" type="number" min="1" step="1"
                                  class="form-control" />

                              </div>

                            </td>

                            <td>
                              <input v-model="total[index]" readonly name="number" type="number" class="form-control" />

                            </td>

                            <td v-if="purchase_details.qty_remain != 0">
                              <input v-model="check_state[index]" @change="

                      check_one_return(purchase_details, index)

                      " type="checkbox" class="btn btn-info waves-effect">
                            </td>

                            <td v-else>
                              <input v-model="check_state[index]" @change="

                      check_one_return(purchase_details, index)
                      " type="checkbox" class="btn btn-info waves-effect" disabled>
                            </td>


                          </tr>




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

                <br>
                <hr>
                <div class="row">
                  <div class="col-md-6">







                    <div class="row">

                      <div class="col-md-12"> <label for="pagoPrevio">نوع العمله</label>
                        <select class="form-control" name="forma_pago" id="forma_pago">
                          <option v-bind:value="2">ريال يمني </option>
                          <option v-bind:value="1">دولار امريكي</option>
                          <option v-bind:value="2">ريال سعودي </option>
                        </select>
                      </div>
                      <div class="col-md-12">
                        <label for="pagoPrevio">الخصم (%)</label>
                        <input type="number" @input="take_discount" v-model="discount" :min="0" :max="99" :step="1"
                          oninput="validity.valid||(value='');" class="form-control input_cantidad"
                          onkeypress="return valida(event)" />

                      </div>
                      <div class="col-md-12">
                        <label for="pagoPrevio">مصروفات مباشره</label>
                        <input type="number" :min="0" :max="99" :step="1" oninput="validity.valid||(value='');"
                          class="form-control input_cantidad" onkeypress="return valida(event)" />

                      </div>

                      <div class="col-md-12">
                        <label for="pagoPrevio">تاريخ الاستحقاق</label>
                        <input type="date" class="form-control" />

                      </div>
                      <div class="col-md-3">&nbsp;</div>
                      <div class="col-md-12">
                        <label for="total" class="text-left"> اجمالي المرتجع: {{ To_pay }}</label>


                      </div>
                      <div class="col-md-12">
                        <div class="text-center">
                          <a style="
                                width: 100%;
                                padding-top: 0.5em;
                                padding-bottom: 0.5em;
                                font-size: 18pt;" href="javascript:void" @click="Add_return()"
                            class="btn btn-info waves-effect waves-light" id="pagar">
                            <i class="fa fa-credit-card"></i></a>
                        </div>
                      </div>

                    </div>

                  </div>
                  <div class="col-md-6">

                    <div class="row">

                      <div class="col-md-12">
                        <label for="pagoPrevio">اجمالي الكميه</label>

                        <input type="text" readonly="readonly" id="cantidad_total" v-model="total_quantity"
                          class="form-control" />
                        <input type="hidden" id="items_totales" />
                        <input type="hidden" id="registros_totales" />
                      </div>


                      <div class="col-md-12">
                        <label for="subTotal">الاجمالي (بدون ضريبه) <small></small></label>
                        <input type="text" readonly id="subtotal_general_si" name="subtotal_general_si" value="0.00"
                          v-model="sub_total" class="form-control" />
                      </div>

                      <div class="col-md-12">
                        <label for="impuestosTotales">مجموع الضريبه</label>
                        <input type="text" readonly="readonly" id="impuestos_totales" v-model="total_tax"
                          class="form-control" />
                      </div>

                      <div class="col-md-12">
                        <label for="subTotal">الاجمالي (مع الضريبه) <small></small></label>

                        <input type="text" readonly id="subtotal_general" name="subtotal_general" v-model="grand_total"
                          class="form-control" />
                        <input type="hidden" id="subtotal_general_sf" name="subtotal_general_sf" value="0.00" />
                      </div>

                      <div class="col-md-12" v-show="show">
                        <label for="pagoPrevio">المدفوع</label>
                        <input class="form-control" type="text" id="paid" v-on:input="credit" v-model="paid"
                          style="color: red" />
                        <input type="hidden" id="items_totales" />
                        <input type="hidden" id="registros_totales" />
                      </div>

                      <div class="col-md-12" v-show="show">
                        <label for="pagoPrevio">المتبقي</label>
                        <input type="text" readonly="readonly" id="remaining" class="form-control"
                          v-model="remaining" />
                        <input type="hidden" id="items_totales" />
                        <input type="hidden" id="registros_totales" />
                      </div>
                      <div class="col-md-12">
                        <div class="text-center">
                          <a style="
                                width: 100%;
                                padding-top: 0.5em;
                                padding-bottom: 0.5em;
                                font-size: 18pt;" href="javascript:void" @click="Add_return()"
                            class="btn btn-info waves-effect waves-light" id="pagar">
                            <i class="fa fa-credit-card"></i></a>
                        </div>
                      </div>
                    </div>




                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="modal fade" id="exampleModalAccount" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">

                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">

                  <div class="well" id="treeview_json_account"></div>

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
import tree from '../../../../js/tree/tree.js';
export default {
  mixins: [operation, tree],
  data() {
    // return data;

    return {
      qty: [],
      unit: [],
      account_in_list: [],
      store: [],
      counts: {},
      description: '',
      count: 1,
      supplier: [],
      treasury: [],
      purchase_detail: 0,
      purchase_id: "",
      suppliers: '',
      treasuries: '',
      show_treasury: true,
      show_bank: false,
      seen: false,
      not_qty: true,
      message_check: false,
      text_message: 0,
      check_state_all: '',



    };
  },
  props: ['data'],
  mounted() {
    this.table = 'purchase_details';
    this.type = 'PurchaseReturn';
    this.type_refresh = 'decrement';

    console.log(this.data);

    if (this.data.payment_status == 'pendding') {

      this.Way_to_pay_selected = 2;

    }

    let uri = `/purchase_details_in_return/${this.data.purchase_id}`;
    //  let uri = `/purchase_details/${this.$route.params.id}`;
    this.axios.post(uri, { table: this.table }).then((response) => {
      console.log(response);
      this.detail = response.data.details;
      // this.suppliers = response.data.suppliers;
      // this.treasuries = response.data.treasuries;


    });


    // ------------------------------------------------





    this.type_of_tree = 1;


    this.showtree('account', 'tree_account');

  },



  methods: {
    // check_one_return(avilable_qty, qty_remain, index, qty, unit) {
    set_values(index) {

      this.counts[index] = index;
    },

    check_one_return(purchase_details, index) {




      if (this.check_qty(
        this.qty[index],
        this.unit[index],
        purchase_details.qty_remain,
        purchase_details.avilable_qty,

      ) == 0) {
        return 0;
      }
      this.handle(purchase_details, index);
      // this.set_values(index);
      // this.calc_grand_total(index);
      // // this.calc_tax(index);
      // this.calc_qty(index);

      // if (this.check_state[index] == false) {

      //   this.$delete(this.counts, index);

      // }

      // this.To_pay = this.grand_total;
      // this.remaining = this.grand_total;




      // -----------------------------------------------------------------

      // if (this.check_state[index] == true) {



      //   if (this.check_qty(
      //     this.qty[index],
      //     this.unit[index],
      //     purchase_detail.qty_remain,
      //     purchase_detail.avilable_qty,
      //   ) == 0
      //   ) {
      //     return 0;
      //   }



      //   this.counts[index] = index;

      //   this.account_in_list[index] = purchase_detail.store_account;
      //   this.store[index] = purchase_detail.store_id;

      // } else if (this.check_state[index] == false) {
      //   this.$delete(this.counts, index);
      // }

      // console.log(this.counts, index);
      // console.log(this.qty, index);
      // console.log(this.unit, index);


    },

    check_all_return() {




      for (let index = 0; index < this.detail.length; index++) {

        if (this.check_state_all == true) {


          this.check_state[index] = true;

        } else {

          this.check_state[index] = false;
        }

        this.detail.forEach(element => {

          this.check_one_return(element, index);
        });





      }


      // console.log(this.counts, index);
      // console.log(this.qty, index);
      // console.log(this.unit, index);


    },
    check_qty(qty, unit, qty_remain, avilable_qty) {

      var producter_qty = 0;

      if (unit[2] == 1) {

        producter_qty = qty * unit[1];
      } else {

        producter_qty = qty;
      }

      if (producter_qty > qty_remain) {

        toastMessage('فشل', "الكميه المدخله اكبر من المسموحه", 'error');
        return 0;

      }

      if (producter_qty > avilable_qty) {

        toastMessage('فشل', "الكميه المدخله اكبر من المتوفره", 'error');
        return 0;

      }


      if (producter_qty <= 0) {

        toastMessage('فشل', "تأكد من الكميه المدخله", 'error');
        return 0;

      }


      return 1;
    },
    calculate_price(index, purchase_details) {

      this.grand_total = 0;
      var unit = $(`#select_unit${index}`).val();
      unit = unit.split(",");

      console.log(unit);

      if (unit[2] == 0) {


        this.total[index] = purchase_details.price * this.qty[index];

      }

      if (unit[2] == 1) {

        this.total[index] = purchase_details.price * unit[1] * this.qty[index];

      }



      if (this.qty[index] == 0) {
        this.total[index] = 0;
        // this.tax[index] = 0
      }
      // this.calc_grand_total();



      if (purchase_details.qty <= 0 || purchase_details.price <= 0) {

        toastMessage('فشل', "تأكد من البيانات المدخله", 'error');
        return 0;

      }



    },
    onwaychange(e) {
      this.paid = 0;
      this.remaining = 0;
      let input = e.target;
      this.type_payment = input.value;
      if (input.value == 2) {
        this.show = true;
        this.remaining = this.grand_total;
      } else {
        this.show = false;
      }


      if (input.value == 1) {
        this.show_treasury = true;
        this.show_bank = false;
        this.paid = this.grand_total;
      }

      if (input.value == 3) {
        this.show_bank = true;
        this.show_treasury = false;
        this.paid = this.grand_total;
      }
    },
    Add_return() {


      // if (this.return_qty.length != 0) {
      // var url = this.type.toLowerCase();
      if (this.Way_to_pay_selected == 1) { //this is default if user not detect any way

        this.paid = this.grand_total;

      }





      this.axios
        .post(`/purchasereturn`, {

          count: this.counts,
          unit: this.unit,
          qty: this.qty,

          credit: {
            account_id: this.account_in_list,
            value: this.total,
            account_details: this.store,

          },
          debit: {

            account_id: $(`#PurchaseReturn_account_tree_id`).val(),
            value: this.grand_total,
            account_details: $(`#select_account_${this.type}_group`).val(),

          },
          // -----------------------------------------------------------

          type_daily: 'purchasereturn',
          payment_type: this.Way_to_pay_selected,
          daily_index: 0,
          description: this.description,
          type_refresh: this.type_refresh,
          supplier_id: this.data.id,
          treasury: this.treasury[0],
          type: this.type,
          old: this.detail,
          date: this.dateselected,
          purchase_id: this.id,
          grand_total: this.grand_total,
          remaining: this.remaining,
          paid: this.paid,






        })
        .then((response) => {
          console.log(response.data);

          if (response.data.status != 0) {

            this.seen = false;
            toastMessage("تم الارجاع بنجاح");
            // this.$router.go(-1);

          } else {

            toastMessage("فشل", response.data.message);




          }


        });
      // }


    },



  },


};
</script>
