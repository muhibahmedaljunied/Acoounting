<template>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <span class="h3"> مرتجع شراء</span>
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

                    <div>{{ data.name }}</div>


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





                  <div class="col-md-2" v-if="show_treasury == true">

                    <label for="pagoPrevio">الصندوق</label>
                    <select class="form-control" style="background-color: beige;" v-model="treasury">
                      <option v-for="tre in treasuries" v-bind:value="[tre.id, tre.name, tre.account_id]">
                        {{ tre.name }}
                      </option>
                    </select>


                  </div>


                  <div class="col-md-2" v-if="show_bank == true">

                    <label for="pagoPrevio">البنك</label>
                    <select class="form-control" style="background-color: beige;" v-model="treasury">
                      <option v-for="tre in treasuries" v-bind:value="[tre.id, tre.name, tre.account_id]">
                        {{ tre.name }}
                      </option>
                    </select>


                  </div>

                  <div class="col-md-4">
                    <label for="pagoPrevio">البيان</label>


                    <input class="form-control" style="background-color: beige;" type="text" v-model="description">


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
                          


                              <div v-for="temx in purchase_details.units">



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


                              </div>
                            </td>




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
                            <td>{{ purchase_details.store }} <input id="select_account_PurchaseReturn" type="hidden"
                                v-model="purchase_details.store_account"></td>

                            <td>

                              <div v-for="temx in purchase_details.units">

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



                              </div>



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


                              <select v-on:change="calculate_price(index,purchase_details)" v-else style="background-color: beige;" :id="'select_unit' + index"
                                v-model="unit[index]" name="type" class="form-control" required>

                                <option v-for="unit in purchase_details.units"
                                  v-bind:value="[unit.id, unit.rate, unit.unit_type]">
                                  {{ unit.name }}
                                </option>


                              </select>
                            </td>
                            <td>
                              <div class="form-group">
                                <input @input="calculate_price(index, purchase_details)" style="background-color: beige;"
                                  v-model="qty[index]" type="number" min="1" step="1" class="form-control" />

                              </div>

                            </td>

                            <td>
                              <input v-model="total[index]" readonly name="number" type="number" class="form-control" />

                            </td>

                            <td v-if="purchase_details.qty_remain != 0">
                              <input v-model="check_state[index]" @change="

                                add_one_return(purchase_details, index)

                                " type="checkbox" class="btn btn-info waves-effect">
                            </td>

                            <td v-else>
                              <input v-model="check_state[index]" @change="

                                add_one_return(purchase_details, index)
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
                        <label for="total" class="text-left">اجمالي المرتجع:</label>
                        <div class="col-md-12 letra_calculator_total text-center" id="div_total">
                          {{ grand_total }}
                        </div>
                        <input type="hidden" name="total" id="total" v-model="grand_total" />
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
                  <!-- <div class="col-md-4">

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
                        <input type="text" readonly="readonly" id="remaining" class="form-control" v-model="remaining" />
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




                  </div> -->
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
      qty: [],
      unit: [],
      counts: {},
      description: '',
      count: 1,
      supplier: [],
      treasury: [],
      purchase_detail: 0,
      Way_to_pay_selected: 1,
      purchase_id: "",
      suppliers: '',
      treasuries: '',
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
      // type_payment: 0,


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
      this.treasuries = response.data.treasuries;


    });
  },

  methods: {
    // add_one_return(avilable_qty, qty_remain, index, qty, unit) {
    add_one_return(purchase_detail, index) {



      if (this.check_state[index] == true) {



        if (this.check_qty(
          purchase_detail.avilable_qty,
          purchase_detail.qty_remain,
          this.qty[index],
          this.unit[index]) == 0
        ) {
          return 0;
        }



        this.counts[index] = index;

      } else if (this.check_state[index] == false) {
        this.$delete(this.counts, index);
      }

      // console.log(this.counts, index);
      // console.log(this.qty, index);
      // console.log(this.unit, index);


    },
    check_qty(avilable_qty, qty_remain, qty, unit) {

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

      if (this.Way_to_pay_selected == 1) { //this is default if user not detect any way

        this.paid = this.grand_total;

      }

      var url = this.type.toLowerCase();

      var debit_account_id = 0;
      if (this.Way_to_pay_selected == 1) {

        debit_account_id = this.treasury[2];
        this.paid = this.grand_total;

      }
      if (this.Way_to_pay_selected == 2) {

        debit_account_id = this.data.account_id;
        this.paid = this.grand_total;
        this.remaining = this.data.grand_total - this.paid;

      }




      this.axios
        .post(`/${url}`, {

          count: this.counts,
          unit: this.unit,
          qty: this.qty,
          debit: {
            debit_account_id: debit_account_id,
          },
          credit: {
            credit_account_id: $(`#select_account_${this.type}`).val(),
          },

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
      this.calc_grand_total();



      if (purchase_details.qty <= 0 || purchase_details.price <= 0) {

        toastMessage('فشل', "تأكد من البيانات المدخله", 'error');
        return 0;

      }



    },

    calc_grand_total() {



      this.grand_total = 0;
      for (let i = 0; i <= this.count; i++) {


        if (this.total[i]) {

          this.grand_total = parseInt(this.total[i]) + parseInt(this.grand_total);

        } else {

          this.grand_total = parseInt(0) + parseInt(this.grand_total);
        }


        // alert(this.grand_total);
        // this.paid = this.grand_total;
      }
    },

    // calc_tax() {

    //   for (let i = 1; i <= this.count; i++) {



    //     if (this.tax[i]) {

    //       this.total_tax = parseInt(this.tax[i]) + parseInt(this.total_tax);

    //     } else {

    //       this.total_tax = parseInt(0) + parseInt(this.total_tax);
    //     }

    //     // console.log(total_quantity);

    //   }
    // },
    // calc_qty() {

    //   for (let i = 1; i <= this.count; i++) {



    //     if (this.qty[i]) {

    //       this.total_quantity = parseInt(this.qty[i]) + parseInt(this.total_quantity);

    //     } else {

    //       this.total_quantity = parseInt(0) + parseInt(this.total_quantity);
    //     }



    //   }
    // },
  },


};
</script>

