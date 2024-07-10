<template>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <span class="h3"> مرتجع توريد</span>
              </div>
              <div class="text-center">

              </div>

              <div class="card-body">
                <div class="row">
                  <div class="col-md-2">


                    <label for="date">رقم الفاتوره</label><br />

                    <!-- <input v-model="data.supply_id" style="background-color: beige;" class="form-control" /> -->

                    <div>{{ data.supply_id }}</div>

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

                      <input :id="'SupplyReturn_account_tree'" type="text" readonly class="custom-search-input">
                      <input :id="'SupplyReturn_account_tree_id'" type="hidden" readonly class="custom-search-input">


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
                      id="select_account_SupplyReturn_group">

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
                            <th>كميه التوريد</th>
                            <!-- <th class="wd-15p border-bottom-0">الوحده</th> -->

                            <!-- <th class="wd-15p border-bottom-0"> سعر الوحده</th> -->
                            <!-- <th class="wd-15p border-bottom-0">  الخصم</th> -->


                            <th>الكميه المتوفره</th>
                            <th>الحاله</th>
                            <th> المواصفات والطراز</th>
                            <th>المخزن</th>
                            <th>الكميه المسموح ارجاعها</th>
                            <th>التكلفه</th>

                            <th>الوحده</th>
                            <th>الكميه المرتجعه الفعليه</th>
                            <th>قيمه المرتجع</th>

                            <th>اضافه</th>
                          </tr>
                        </thead>
                        <tbody v-if="detail && detail.length > 0">
                          <tr v-for="(supply_details, index) in detail" :key="index">
                            <input v-model="id = supply_details.supply_id" readonly type="hidden" name="name" id="name"
                              class="form-control" />

                            <td>


                              {{ supply_details.product }}
                            </td>

                            <td>


                              <div v-for="temx in supply_details.qty_after_convert['qty']">



                                <span v-for="temx2 in temx">


                                  <span style="float: right;">
                                    {{ temx2[0] }}
                                    <span style="color: red;">
                                      {{ temx2[1] }}
                                    </span>

                                  </span>



                                </span>

                                <!-- <span v-if="temx.unit_type == 0">


<span>{{ Math.floor((stock.quantity)) }}</span><span style="color: red;"> {{
temx.name }}</span>



</span> -->

                              </div>
                            </td>




                            <td>

                              <div v-for="temx in supply_details.qty_after_convert['quantity']">



                                <span v-for="temx2 in temx">


                                  <span style="float: right;">
                                    {{ temx2[0] }}
                                    <span style="color: red;">
                                      {{ temx2[1] }}
                                    </span>

                                  </span>



                                </span>

                                <!-- <span v-if="temx.unit_type == 0">


<span>{{ Math.floor((stock.quantity)) }}</span><span style="color: red;"> {{
temx.name }}</span>



</span> -->

                              </div>

                            </td>



                            <td>{{ supply_details.status }}</td>
                            <td>{{ supply_details.desc }}</td>
                            <td>{{ supply_details.store }} <input id="select_account_SupplyReturn" type="hidden"
                                v-model="supply_details.store_account"></td>

                            <td>

                              <div v-for="temx in supply_details.qty_after_convert['qty_remain']">



                                <span v-for="temx2 in temx">


                                  <span style="float: right;">
                                    {{ temx2[0] }}
                                    <span style="color: red;">
                                      {{ temx2[1] }}
                                    </span>

                                  </span>



                                </span>

                                <!-- <span v-if="temx.unit_type == 0">


<span>{{ Math.floor((stock.quantity)) }}</span><span style="color: red;"> {{
temx.name }}</span>



</span> -->

                              </div>



                            </td>

                            <td>

                              {{ supply_details.price }}
                            </td>

                            <td>


                              <select v-if="check_state[index] == true" style="background-color: beige;"
                                :id="'select_unit' + index" v-model="unit[index]" name="type" class="form-control"
                                required>

                                <option disabled v-for="unit in supply_details.units"
                                  v-bind:value="[unit.unit_id, unit.rate]">
                                  {{ unit.name }}
                                </option>


                              </select>


                              <select v-on:change="calculate_total(index, supply_details.price)" v-else
                                style="background-color: beige;" :id="'select_unit' + index" v-model="unit[index]"
                                name="type" class="form-control" required>

                                <option v-for="unit in supply_details.units" v-bind:value="[unit.unit_id, unit.rate]">
                                  {{ unit.name }}
                                </option>


                              </select>
                            </td>
                            <td>
                              <div class="form-group">
                                <input v-if="check_state[index] == true" readonly style="background-color: beige;"
                                  v-model="qty[index]" type="number" class="form-control" />


                                <input v-else @input="calculate_total(index, supply_details.price)"
                                  style="background-color: beige;" v-model="qty[index]" type="number" min="1" step="1"
                                  class="form-control" />

                              </div>

                            </td>

                            <td>
                              <input v-if="check_state[index] == true" readonly v-model="total[index]" name="number"
                                type="number" class="form-control" />

                              <input v-else v-on:change="calculate_total(index, supply_details.price)"
                                v-model="total[index]" readonly name="number" type="number" class="form-control" />

                            </td>

                            <td v-if="supply_details.qty_remain != 0">
                              <input v-model="check_state[index]" @change="

                      calculate()

                      " type="checkbox" class="btn btn-info waves-effect">
                            </td>

                            <td v-else>
                              <input v-model="check_state[index]" @change="

                      calculate()
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
                  <div class="col-md-12">







                    <div class="row">

                      <div class="col-md-12"> <label for="pagoPrevio">نوع العمله</label>
                        <select class="form-control" name="forma_pago" id="forma_pago">
                          <option v-bind:value="2">ريال يمني </option>
                          <option v-bind:value="1">دولار امريكي</option>
                          <option v-bind:value="2">ريال سعودي </option>
                        </select>
                      </div>


                    </div>

                  </div>
                  <div class="col-md-12">

                    <div class="row">

                      <div class="col-md-12">
                        <label for="pagoPrevio">اجمالي الكميه</label>

                        <input @input="calculate()" type="text" id="cantidad_total" v-model="total_quantity"
                          class="form-control" />

                      </div>


                      <div class="col-md-12">
                        <label for="subTotal">اجمالي المرتجع <small></small></label>

                        <input @input="calculate()" type="text" id="subtotal_general" name="subtotal_general"
                          v-model="grand_total" class="form-control" />
                        <input type="hidden" id="subtotal_general_sf" name="subtotal_general_sf" value="0.00" />
                      </div>

                      <div class="col-md-12" v-show="show">
                        <label for="pagoPrevio">المدفوع</label>
                        <input @input="calculate()" class="form-control" type="text" id="paid" v-on:input="credit"
                          v-model="paid" style="color: red" />

                      </div>

                      <div class="col-md-12" v-show="show">
                        <label for="pagoPrevio">المتبقي</label>
                        <input @input="calculate()" type="text" id="remaining" class="form-control"
                          v-model="remaining" />

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

import operation from '../../../operation.js';
import tree from '../../../../js/tree/tree.js';
export default {
  mixins: [operation, tree],
  data() {
    // return data;

    return {
      description: '',
      count: 1,
      supply_detail: 0,
      Way_to_pay_selected: 1,
      supply_id: "",
      show_treasury: true,
      show_bank: false,
      seen: false,
      not_qty: true,
      message_check: false,
      text_message: 0,
      total: [],
      grand_total: 0,
      paid: 0,
      remaining: 0,
      check_state_all: '',


    };
  },
  props: ['data'],
  mounted() {
    this.table = 'supply_details';
    this.type = 'SupplyReturn';
    this.type_refresh = 'decrement';

    console.log(this.data);

    if (this.data.payment_status == 'pendding') {

      this.Way_to_pay_selected = 2;

    }

    let uri = `/supply_details_in_return/${this.data.supply_id}`;
    //  let uri = `/supply_details/${this.$route.params.id}`;
    this.axios.post(uri, { table: this.table, operation: 'ReturnOperationQty' }).then((response) => {
      console.log(response);
      this.detail = response.data.details;
      // this.suppliers = response.data.suppliers;
      this.treasuries = response.data.treasuries;


    });


    // ------------------------------------------------





    this.type_of_tree = 1;
    this.first_row = 0;


    this.showtree('account', 'tree_account');

  },

  // watch: {
  //   Way_to_pay_selected(newVal, oldVal) {
  //     $(`#treeview_json_account`).jstree(true).destroy();
  //     this.showtree('account', 'tree_account', this.Way_to_pay_selected);

  //     // console.log(newVal, oldVal);
  //   }
  // },

  methods: {
    // check_one_supply(avilable_qty, qty_remain, index, qty, unit) {
    // check_one_supply(supply_detail, index) {



    //   if (this.check_state[index] == true) {



    //     if (this.check_qty(
    //       supply_detail.avilable_qty,
    //       supply_detail.qty_remain,
    //       this.qty[index],
    //       this.unit[index]) == 0
    //     ) {
    //       return 0;
    //     }



    //     this.counts[index] = index;

    //     this.account_in_list[index] = supply_detail.store_account;
    //     this.store[index] = supply_detail.store_id;

    //   } else if (this.check_state[index] == false) {
    //     this.$delete(this.counts, index);
    //   }

    //   // console.log(this.counts, index);
    //   // console.log(this.qty, index);
    //   // console.log(this.unit, index);


    // },
    check_all_return() {




      for (let index = 0; index < this.detail.length; index++) {

        if (this.check_state_all == true) {


          this.check_state[index] = true;

        } else {

          this.check_state[index] = false;
        }

        this.detail.forEach(element => {

          this.check_one_supply(element, index);
        });





      }


      // console.log(this.counts, index);
      // console.log(this.qty, index);
      // console.log(this.unit, index);


    },

    // check_one_supply(product, index) {



    //   if (this.check_qty(
    //     this.qty[index],
    //     this.unit[index],
    //     product.availabe_qty,
    //     product.qty_remain

    //   ) == 0) {
    //     return 0;
    //   }

    //   this.handle(product, index);

    // },

    set_values() {

      this.counts[this.row_counter] = this.row_counter;
      this.storem_account[this.row_counter] = this.detail[this.row_counter].store_account_id;
      this.storem[this.row_counter] = this.detail[this.row_counter].store_id;
    },

    // check_qty(qty, unit, avilable_qty, qty_remain) {

    //   var producter_qty = 0;

    //   if (unit[2] == 1) {

    //     producter_qty = qty * unit[1];
    //   } else {

    //     producter_qty = qty;
    //   }

    //   if (producter_qty > qty_remain) {

    //     toastMessage('فشل', "الكميه المدخله اكبر من المسموحه", 'error');
    //     return 0;

    //   }

    //   if (producter_qty > avilable_qty) {

    //     toastMessage('فشل', "الكميه المدخله اكبر من المتوفره", 'error');
    //     return 0;

    //   }


    //   if (producter_qty <= 0) {

    //     toastMessage('فشل', "تأكد من الكميه المدخله", 'error');
    //     return 0;

    //   }


    //   return 1;
    // },

    onwaychange(e) {
      this.paid = 0;
      this.remaining = 0;
      if (this.Way_to_pay_selected == 2) {

        this.show = true;
        this.remaining = this.grand_total;
        this.paid = 0;

      }



      if (this.Way_to_pay_selected == 1) {

        this.show = false;
        this.show_treasury = true;
        this.show_bank = false;
        this.paid = this.grand_total;
        this.remaining = 0;

      }

      if (this.Way_to_pay_selected == 3) {

        this.show = false;
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
        .post(`/supplyreturn`, {

          count: this.counts,
          unit: this.unit,
          qty: this.qty,
          total: this.total,
          debit: {
            account_id: this.account_in_list,
            value: this.total,
            account_details: this.store,

          },
          credit: {

            account_id: $(`#SupplyReturn_account_tree_id`).val(),
            value: this.total,
            account_details: $(`#select_account_${this.type}_group`).val(),

          },
          // -----------------------------------------------------------

          type_daily: 'supplyreturn',
          type_payment: this.Way_to_pay_selected,
          daily_index: 0,
          description: this.description,
          type_refresh: this.type_refresh,
          supplier_id: this.data.id,
          treasury: this.treasury[0],
          type: this.type,
          old: this.detail,
          date: this.dateselected,
          supply_id: this.id,
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
