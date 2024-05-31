<template>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">

          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <span class="h3"> فاتوره مردود مبيعات</span>

              </div>


              <div class="card-body">


                <div class="row">

                  <div class="col-md-2">


                    <label for="date">رقم الفاتوره</label><br />


                    <div>{{ data.sale_id }}</div>


                  </div>
                  <div class="col-md-2">


                    <label for="cliente"> العميل</label>



                    <div>{{ data.customer_name }}</div>

                  </div>
                  <div class="col-md-4">
                    <label for="pagoPrevio">اجمالي الفاتوره</label>

                    <div>{{ data.grand_total }}</div>



                  </div>


                </div>

                <hr>
                <br>
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

                      <input :id="'SaleReturn_account_tree'" type="text" readonly class="custom-search-input">
                      <input :id="'SaleReturn_account_tree_id'" type="hidden" readonly class="custom-search-input">
                      <!-- <input :id="'SaleReturn_store_tree_id'" type="hidden" readonly class="custom-search-input"> -->


                      <button class="custom-search-botton" type="button" data-toggle="modal"
                        data-target="#exampleModalAcoount">
                        <i class="fa fa-plus-circle"></i></button>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <label for="cliente"> الحساب التفصيلي</label>


                    <select class="form-control" style="background-color: beige;" name="forma_pago"
                      id="select_account_SaleReturn_group">

                    </select>

                  </div>







                </div>
                <hr>
                <br>

                <div class="row">



                  <div class="col-md-4">
                    <label for="cliente">المخزن المرتجع البه</label>

                    <div class="custom-search">

                      <input style="background-color: beige;" :id="'SaleReturn_store_tree'" type="text" readonly
                        class="custom-search-input">
                      <input :id="'SaleReturn_store_tree_id'" type="hidden" readonly>
                      <input :id="'select_account_SaleReturn'" type="hidden" readonly class="custom-search-input">
                      <button class="custom-search-botton" type="button" data-toggle="modal"
                        data-target="#exampleModalStore">
                        <i class="fa fa-plus-circle"></i></button>
                    </div>

                  </div>

                  <!-- <div class="col-md-2" v-if="show_treasury == true">

                    <label for="pagoPrevio">الصندوق</label>
                    <select style="background-color: beige;" v-model="treasury" id="supplier" class="form-control">
                      <option v-for="tre in treasuries" v-bind:value="[tre.id, tre.name, tre.account_id]">
                        {{ tre.name }}
                      </option>
                    </select>


                  </div>
                  <div class="col-md-2" v-if="show_bank == true">

                    <label for="pagoPrevio">البنك</label>
                    <select style="background-color: beige;" v-model="treasury" id="supplier" class="form-control">
                      <option v-for="tre in treasuries" v-bind:value="[tre.id, tre.name, tre.account_id]">
                        {{ tre.name }}
                      </option>
                    </select>


                  </div> -->

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
                <hr>
                <br>

                <div class="row">
                  <div class="col-md-12">
                    <div class="table-responsive">
                      <table class="table table-bordered">
                        <thead>
                          <tr>
                            <!-- <th>الرقم</th> -->
                            <th>اسم المنتج</th>

                            <th> المواصفات والطراز</th>
                            <th>الحاله</th>
                            <th>المخزن</th>
                            <th>المخزن المرتجع البه</th>
                            <!-- <th>الكميه المتوفره</th> -->
                            <th>الكميه المباعه</th>
                            <!-- <th> السعر </th> -->
                            <th>الكميه المسموح ارجاعها</th>

                            <th> الوحده </th>


                            <th>الكميه المرتجعه الفعليه </th>
                            <th>قيمه المرتجع</th>

                            <th>اضافه</th>
                          </tr>
                        </thead>
                        <tbody v-if="detail && detail.length > 0">
                          <tr v-for="(sale_details, index) in detail" :key="index">
                            <input v-model="id = sale_details.sale_id" type="hidden" name="name" id="name"
                              class="form-control" />

                            <td>
                              <div class="form-group">
                                <!-- <input v-model="sale_details.product" readonly type="text" name="name" id="name"
                                  class="form-control" /> -->
                                {{ sale_details.product }}
                              </div>
                            </td>
                            <td>{{ sale_details.desc }}</td>
                            <td>{{ sale_details.status }}</td>
                            <td>{{ sale_details.store }}
                              <input :id="'select_account_SaleReturn' + index" type="hidden">
                            </td>

                            <td>
                              <div class="custom-search">

                                <input style="background-color: beige;" :id="'SaleReturn_storem_tree' + index"
                                  type="text" readonly class="custom-search-input">
                                <input :id="'SaleReturn_storem_tree_id' + index" type="hidden" readonly>

                                <button class="custom-search-botton" type="button" data-toggle="modal"
                                  @click="detect_index(index)" data-target="#exampleModalStorem">
                                  <i class="fa fa-plus-circle"></i></button>
                              </div>
                            </td>
                            <!-- <td>

                              <div v-for="temx in sale_details.units">



                                <span v-if="temx.unit_type == 0">

                                  <span v-if="sale_details.avilable_qty / sale_details.rate >= 1">
                                    {{ Math.floor((sale_details.avilable_qty / sale_details.rate)) }}{{
                                      sale_details.units[0].name
                                    }}
                                  </span>

                                  <span v-if="sale_details.avilable_qty % sale_details.rate >= 1">
                                    {{ Math.floor((sale_details.avilable_qty % sale_details.rate)) }}{{
                                      sale_details.units[1].name
                                    }}
                                  </span>

                                  <span v-if="sale_details.avilable_qty == 0">
                                    0
                                  </span>

                                </span>

                              </div>

                            </td> -->
                            <!-- <td>
                          <div class="form-group">
                            <input v-model="sale_details.qty" readonly type="text" name="name" class="form-control" />
                          </div>
                        </td> -->
                            <td>

                             
                              <div v-for="temx in sale_details.units">


<span v-if="temx.unit_type == 0">

  <span v-if="sale_details.qty_remain / sale_details.rate >= 1">
    {{ Math.floor((sale_details.qty_remain / sale_details.rate)) }}{{
sale_details.units[0].name
}}
  </span>

  <span v-if="sale_details.qty_remain % sale_details.rate >= 1">
    {{ Math.floor((sale_details.qty_remain % sale_details.rate)) }}{{
sale_details.units[1].name
}}
  </span>

  <span v-if="sale_details.qty_remain == 0">
    0
  </span>
</span>


</div>

                            </td>

                            <td>

                              <div v-for="temx in sale_details.units">


                                <span v-if="temx.unit_type == 0">

                                  <span v-if="sale_details.qty_remain / sale_details.rate >= 1">
                                    {{ Math.floor((sale_details.qty_remain / sale_details.rate)) }}{{
                      sale_details.units[0].name
                    }}
                                  </span>

                                  <span v-if="sale_details.qty_remain % sale_details.rate >= 1">
                                    {{ Math.floor((sale_details.qty_remain % sale_details.rate)) }}{{
                      sale_details.units[1].name
                    }}
                                  </span>

                                  <span v-if="sale_details.qty_remain == 0">
                                    0
                                  </span>
                                </span>


                              </div>

                            </td>
                            <td>

                              <select v-on:change="calculate_price(index, sale_details)"
                                style="background-color: beige;" :id="'select_unit' + index" v-model="unit[index]"
                                name="type" class="form-control" required>

                                <option v-for="unit in sale_details.units"
                                  v-bind:value="[unit.id, unit.rate, unit.unit_type]">
                                  {{ unit.name }}
                                </option>


                              </select>
                            </td>


                            <td>
                              <div class="form-group">
                                <input @input="calculate_price(index, sale_details)" style="background-color: beige;"
                                  v-model="qty[index]" type="number" min="1" step="1" class="form-control" />

                              </div>
                            </td>
                            <td>
                              <input v-model="total[index]" readonly name="number" type="number" class="form-control" />

                            </td>
                            <td v-if="sale_details.qty_remain != 0">

                              <input v-model="check_state[index]" @change="check_one_return_sale(sale_details, index)"
                                type="checkbox" class="btn btn-info waves-effect">

                            </td>


                            <td v-else>

                              <input v-model="check_state[index]" @change="
                      check_one_return_sale(sale_details, index)
                      " type="checkbox" disabled class="btn btn-info waves-effect">

                            </td>

                          </tr>

                          <!-- <tr>
                            <td colspan="10">
                              <div class="col-md-12">
                                <label for="date">الاجمالي</label><br />
                                <input v-model="grand_total" readonly name="number" type="number" class="form-control" />


                              </div>
                            </td>

                            <td>

                              <div class="col-md-4">

                                <button type="button" v-if="not_qty" @click="Add_return()"
                                  class="btn btn-info"><span>تاكيد العمليه</span></button>

                              </div>

                            </td>
                          </tr>
 -->






                        </tbody>
                        <tbody v-else>
                          <tr>
                            <td align="center" colspan="3">
                              <h3>
                                لايوجد كمبه متوفره في المخزن
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
                  <div class="col-md-8">







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
                        <label for="total" class="text-left">المبلغ المستحق</label>
                        <input type="text" readonly="readonly" id="remaining" class="form-control" v-model="To_pay" />

                      </div>


                    </div>

                  </div>
                  <div class="col-md-4">

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
        </div>
      </div>
    </section>

    <div class="modal fade" id="exampleModalAcoount" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
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

    <div class="modal fade" id="exampleModalStore" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <div class="well" id="treeview_json_store"></div>

          </div>

        </div>
      </div>
    </div>

    <div class="modal fade" id="exampleModalStorem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <div class="well" id="treeview_json_storem"></div>

          </div>

        </div>
      </div>
    </div>
  </div>
</template>
<script>
import operation from '../../../operation.js';
import tree from '../../../tree/tree.js';
export default {
  mixins: [operation, tree],
  data() {


    return {


      check_state_all: '',
      qty: [],
      unit: [],
      counts: {},
      treasury: [],
      count: 1,
      account_in_list: [],
      store: [],
      description: '',
      customer: [],
      treasury: [],
      customers: '',
      show_treasury: true,
      show_bank: false,
      not_qty: true,
      message_check: false,
      text_message: 0,

    };
  },
  props: ['data'],

  mounted() {
    this.table = 'sale_details';
    this.type = 'SaleReturn';
    this.type_refresh = 'increment';


    this.type_of_tree = 1;
    // let uri = `/sale_details/${this.$route.params.id}`;
    let uri = `/sale_details_in_return/${this.data.sale_id}`;

    this.axios.post(uri, { table: this.table }).then((response) => {
      console.log(response);
      this.detail = response.data.details;
      // this.customers = response.data.customers;
      // this.treasuries = response.data.treasuries;

      // this.$root.logo = "CashDetails";
    });

    // -------------------------------
    this.showtree('store', 'tree_store');
    this.showtree('storem', 'tree_store');
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
    check_qty(qty, unit, qty_remain) {

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



      if (producter_qty <= 0) {

        toastMessage('فشل', "تأكد من الكميه المدخله", 'error');
        return 0;

      }


      return 1;
    },
    set_values(sale_details, index) {

      this.counts[index] = index;
      this.storem[index] = sale_details.store_id;

    },
    check_one_return_sale(sale_details, index) {


      if (this.check_qty(
        this.qty[index],
        this.unit[index],
        sale_details.qty_remain
      ) == 0) {

        return 0;
      }
      this.handle(product, index);
    
    },

    check_all_return() {




      for (let index = 0; index < this.detail.length; index++) {

        if (this.check_state_all == true) {


          this.check_state[index] = true;

        } else {

          this.check_state[index] = false;
        }

        this.detail.forEach(element => {

          this.check_one_return_sale(element, index);
        });





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
        .post(`/salereturn`, {


          type: this.type,
          count: this.counts,
          unit: this.unit,
          qty: this.qty,

          debit: {
            account_id: this.storem_account,
            value: this.total,
            account_details: this.storem,

          },
          credit: {
            account_id: $(`#SaleReturn_account_tree_id`).val(),
            value: this.grand_total,
            account_details: $(`#select_account_${this.type}_group`).val(),

          },
          type_daily: 'salereturn',
          payment_type: this.Way_to_pay_selected,
          daily_index:0,
          description: this.description,
          type_refresh: this.type_refresh,
          customer_id: this.customer[0],
          customer_name: this.customer[1],
          treasury: this.treasury[0],
          type: this.type,
          // type_refresh: this.type_refresh,
          old: this.detail,
          date: this.dateselected,
          sale_id: this.id,
          grand_total: this.grand_total,
          remaining: this.remaining,
          paid: this.paid,





        })
        .then((response) => {
          console.log(response);

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
    calculate_price(index, sale_details) {



      // this.grand_total = 0;


      var unit = $(`#select_unit${index}`).val();
      unit = unit.split(",");

      console.log(unit);

      if (unit[2] == 0) {

        this.total[index] = sale_details.price * this.qty[index];
      }

      if (unit[2] == 1) {

        this.total[index] = sale_details.price * unit[1] * this.qty[index];

      }



      if (this.qty[index] == 0) {
        this.total[index] = 0;
        // this.tax[index] = 0
      }
      // this.calc_grand_total();



      if (sale_details.qty <= 0 || sale_details.price <= 0) {

        toastMessage('فشل', "تأكد من البيانات المدخله", 'error');
        return 0;

      }



    },
  



  }
};
</script>
