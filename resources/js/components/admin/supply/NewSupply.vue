<template>
  <div class="wrapper">
    <div class="container-fluid">
      <div class="row">

        <div class="card text-right">
          <div class="card-header">


            <h3>امر توريد مخزني <span id="codigo"></span></h3>
          </div>
          <div class="card-body">



            <div class="row">


              <div class="col-md-4">
                <label for="pagoPrevio">المخزن</label>
                <div class="custom-search">

                  <input style="background-color: beige;" :id="'Supply_store_tree'" type="text" readonly
                    class="custom-search-input">
                  <input :id="'Supply_store_tree_id'" type="hidden" readonly>
                  <input :id="'select_account_Supply'" type="hidden">

                  <button class="custom-search-botton" type="button" data-toggle="modal" @click="detect_index(null)"
                    data-target="#exampleModalStore">
                    <i class="fa fa-plus-circle"></i></button>
                </div>

              </div>

              <div class="col-md-4">
                <label for="pagoPrevio">المنتج</label>
                <div class="custom-search">

                  <input style="background-color: beige;font-size: 15px;" :id="'Supply_product_tree'" type="text"
                    readonly class="custom-search-input">
                  <input :id="'Supply_product_tree_id'" type="hidden" readonly class="custom-search-input">
                  <input :id="'select_account_Supply'" type="hidden" readonly class="custom-search-input">


                  <button class="custom-search-botton" type="button" data-toggle="modal" @click="detect_index(null)"
                    data-target="#exampleModalProduct">
                    <i class="fa fa-plus-circle"></i></button>
                </div>

              </div>








            </div>

            <br />
            <hr>

            <div class="row">

              <div class="col-md-2">
                <label for="FormaPago">طريقه الدفع</label>
                <select class="form-control" style="background-color: beige;" name="forma_pago" id="forma_pago"
                  v-model="Way_to_pay_selected" v-on:change="onwaychange">

                  <option v-bind:value="1">نقد</option>
                  <option v-bind:value="2">أجل</option>
                  <option v-bind:value="3">بنك</option>
                </select>
              </div>
              <div class="col-md-4">
                <label for="pagoPrevio">الحساب</label>
                <div class="custom-search">

                  <input :id="'Supply_account_tree'" type="text" readonly class="custom-search-input">
                  <input :id="'Supply_account_tree_id'" type="hidden" readonly class="custom-search-input">


                  <button @click="detect_index(null)" class="custom-search-botton" type="button" data-toggle="modal"
                    data-target="#exampleModalAccount">
                    <i class="fa fa-plus-circle"></i></button>
                </div>

              </div>


              <div class="col-md-3">
                <label for="cliente"> الحساب التفصيلي</label>

                <select class="form-control" style="background-color: beige;" name="forma_pago"
                  id="select_account_Supply_group">

                </select>
              </div>






            </div>

            <br />
            <hr>
            <div class="row">


              <!-- <div class="col-md-2">
                <label for="FormaPago">طريقه الدفع</label>
                <select class="form-control" style="background-color: beige;" name="forma_pago" id="forma_pago"
                  v-model="Way_to_pay_selected" v-on:change="onwaychange">

                  <option v-bind:value="1">نقد</option>
                  <option v-bind:value="2">أجل</option>
                  <option v-bind:value="3">بنك</option>
                </select>
              </div>

              
              <div class="col-md-2">
                <label for="cliente"> المورد</label>

                <select class="form-control" style="background-color: beige;" v-model="supplier" id="supplier">
                  <option v-for="sup in suppliers" v-bind:value="[sup.id, sup.name, sup.account_id]">
                    {{ sup.name }}
                  </option>
                </select>
              </div>

              <div class="col-md-2" v-if="show_treasury == true">
                <label for="pagoPrevio">الصندوق</label>
                <select class="form-control" style="background-color: beige;" v-model="treasury" id="supplier">
                  <option v-for="tre in treasuries" v-bind:value="[tre.id, tre.name, tre.account_id]">
                    {{ tre.name }}
                  </option>
                </select>

              </div>

              <div class="col-md-2" v-if="show_bank == true">
                <label for="pagoPrevio">البنك</label>
                <select class="form-control" style="background-color: beige;" v-model="treasury" id="supplier">
                  <option v-for="tre in treasuries" v-bind:value="[tre.id, tre.name, tre.account_id]">
                    {{ tre.name }}
                  </option>
                </select>

              </div> -->




              <div class="col-md-2" v-if="Way_to_pay_selected != 2">
                <label for="cliente"> المورد</label>

                <select class="form-control" style="background-color: beige;" v-model="supplier" id="supplier">
                  <option v-for="sup in suppliers" v-bind:value="[sup.id, sup.name]">
                    {{ sup.name }}
                  </option>
                </select>
              </div>
              <div class="col-md-2">
                <label for="date">التاريخ</label><br />

                <input class="form-control" style="background-color: beige;" name="date" type="date" v-model="date" />
              </div>


              <div class="col-md-6">
                <label for="pagoPrevio">البيان</label>


                <input class="form-control" style="background-color: beige;" type="text" v-model="description">


              </div>
            </div>
            <br />
            <hr>
            <div class="row">
              <div class="table-responsive">
                <table class="table table-bordered text-right" style="width: 100%; font-size: x-large">
                  <thead>
                    <tr>
                      <th>الرقم التسلسلي</th>
                      <th>المنتج</th>
                      <th>المخزن</th>

                      <th>الحاله</th>
                      <th>الموصفات والطراز</th>
                      <th>الوحده</th>
                      <th>التكلفه</th>

                      <!-- <th>السعر</th> -->
                      <th>الكميه</th>
                      <!-- <th>الضريبه</th> -->
                      <th>الاجمالي</th>
                      <th>تاريخ الانتهاء</th>


                      <th>اضافه</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="index in count" :key="index">
                      <td>{{ index }}</td>
                      <td>
                        <div class="custom-search">

                          <input style="background-color: beige;font-size: 15px;" :id="'Supply_productm_tree' + index"
                            type="text" readonly class="custom-search-input">
                          <input :id="'Supply_productm_tree_id' + index" type="hidden" readonly
                            class="custom-search-input">

                          <button class="custom-search-botton" type="button" data-toggle="modal"
                            data-target="#exampleModalProductm" @click="detect_index(index)">
                            <i class="fa fa-plus-circle"></i></button>
                        </div>



                      </td>
                      <td>
                        <div class="custom-search">

                          <input style="background-color: beige;font-size: 15px;" :id="'Supply_storem_tree' + index"
                            type="text" readonly class="custom-search-input">
                          <input :id="'Supply_storem_tree_id' + index" type="hidden" readonly
                            class="custom-search-input">


                          <button class="custom-search-botton" type="button" data-toggle="modal"
                            data-target="#exampleModalStorem" @click="detect_index(index)">
                            <i class="fa fa-plus-circle"></i>
                          </button>
                        </div>



                      </td>

                      <td>
                        <div id="factura_producto">
                          <select v-model="status[index]" name="type" id="type" class="form-control" required>

                            <option v-for="status in statuses" v-bind:value="status.id">
                              {{ status.name }}
                            </option>
                          </select>
                        </div>
                      </td>

                      <td>
                        <div id="factura_producto">
                          <input type="text" v-model="desc[index]" id="desc" class="form-control" />
                        </div>
                      </td>



                      <td>
                        <div id="factura_producto">

                          <select v-on:change="calculate_price(index)" style="background-color: beige;"
                            v-model="unit[index]" name="type" :id="'select_unit' + index" class="form-control" required>

                          </select>
                        </div>
                      </td>


                      <td>
                        <input v-on:input="calculate_price(index)" style="background-color: beige;" type="number"
                          v-model="price[index]" id="qty" class="form-control" required />
                      </td>
                      <td>
                        <input style="background-color: beige;" @input="calculate_price(index)" type="number"
                          v-model="qty[index]" id="qty" class="form-control" />
                      </td>


                      <td>
                        <input type="number" v-model="total[index]" :id="'total_row' + index" class="form-control"
                          readonly />


                      </td>

                      <td>
                        <input name="expiry_date" type="date" v-model="expiry_date" class="form-control" />

                      </td>




                      <td v-if="index == 1">

                        <button class="tn btn-info btn-sm waves-effect btn-agregar" v-on:click="addComponent(count)">
                          <i class="fa fa-plus-circle"></i></button>

                        <button class="tn btn-info btn-sm waves-effect btn-agregar" v-on:click="disComponent(count)">
                          <i class="fa fa-minus-circle"></i></button>



                      </td>
                    </tr>


                  </tbody>
                </table>
              </div>
            </div>

            <br />
            <!-- <hr> -->
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
                  <!-- <div class="col-md-12">
                    <label for="pagoPrevio">الخصم (%)</label>
                    <input type="number" @input="take_discount" v-model="discount" :min="0" :max="99" :step="1"
                      oninput="validity.valid||(value='');" class="form-control input_cantidad"
                      onkeypress="return valida(event)" />

                  </div> -->
                  <!-- <div class="col-md-12">
                    <label for="pagoPrevio">مصروفات مباشره</label>
                    <input type="number" :min="0" :max="99" :step="1" oninput="validity.valid||(value='');"
                      class="form-control input_cantidad" onkeypress="return valida(event)" />

                  </div> -->

                  <div class="col-md-12">
                    <label for="pagoPrevio">تاريخ الاستحقاق</label>
                    <input type="date" class="form-control" />

                  </div>
                  <div class="col-md-3">&nbsp;</div>
                  <div class="col-md-12">

                    <label for="total" class="text-left">المبلغ المستحق</label>
                    <input type="text" readonly="readonly" class="form-control" v-model="To_pay" />



                  </div>


                </div>


                <!-- </div> -->
                <!-- </div> -->
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
                    <label for="subTotal">الاجمالي <small></small></label>
                    <input type="text" readonly id="subtotal_general_si" name="subtotal_general_si" value="0.00"
                      v-model="grand_total" class="form-control" />
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

                  </div>
                  <div class="col-md-12">
                    <div class="text-center">
                      <a style="
                                width: 100%;
                                padding-top: 0.5em;
                                padding-bottom: 0.5em;
                                font-size: 18pt;" href="javascript:void" @click="payment('Supply')"
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

      <div class="modal fade" id="exampleModalProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">

              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <div class="well" id="treeview_json_product"></div>

            </div>

          </div>
        </div>
      </div>


      <div class="modal fade" id="exampleModalProductm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">

              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <div class="well" id="treeview_json_productm"></div>

            </div>

          </div>
        </div>
      </div>

      <div class="modal fade" id="exampleModalAccount" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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



    </div>
  </div>
</template>
<script>
import pagination from "laravel-vue-pagination";
import operation from '../../../operation1.js';
import tree from '../../../tree/tree.js';
export default {

  components: {
    pagination,
  },
  mixins: [tree, operation],
  data() {
    return {


      description: '',
      store: '',
    
      // treasury: [],
      text_message: '',

      treasuries: '',
      discount: 0,
      // customer: [],
      suppliers: '',
      customers: '',
      temporale: 1,
      type_payment: 0,
      Way_to_pay_selected: 1,
      show: false,
      show_treasury: true,
      show_bank: false,
      return_qty: [],
      note: '',
      not_qty: true,
      seen: false,
      id: '',



    }
    // return data;
  },

  mounted() {
    this.list();
    this.counts[0] = 1;
    this.type = 'Supply';
    this.type_refresh = 'increment';

    this.type_of_tree = 1;

    this.showtree('store', 'tree_store');
    this.showtree('storem', 'tree_store');
    this.showtree('product', 'tree_product');
    this.showtree('productm', 'tree_product');
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


    calculate_price(index) {



      this.init();
      this.check_data(index);
      this.calculate_qty();
      this.calculate_tax();
      this.calculate_grand_total();
      this.credit();
      this.calc_remaining();



    },

    check_data(index) {

      if (this.unit[index] && this.qty[index] && this.price[index]) {



        if (this.qty[index] <= 0 || this.price[index] <= 0) {

          this.total[index] = 0;
          toastMessage('فشل', "تأكد من البيانات المدخله", 'error');
          return 0;

        }



        this.total[index] = this.price[index] * this.qty[index]*JSON.parse(this.unit[index])[1];

        // alert('zanam',this.total[index]);
      } else {

        toastMessage('فشل', "قم بأدخال الوحده", 'error');

        // this.row_removed[index] = index;
        this.total[index] = 0;
      }

      

    },
    init() {

      this.grand_total = 0;
      this.total_tax = 0;
      this.total_quantity = 0;
    },
    calc_remaining() {


      if (this.Way_to_pay_selected == 2) {

        this.remaining = this.grand_total;

      } else {

        this.remaining = 0;

      }

    },
    calculate_grand_total() {




      for (let i = 1; i <= this.count; i++) {


        if (this.total[i]) {

          this.grand_total = parseInt(this.total[i]) + parseInt(this.grand_total);

        } else {

          this.grand_total = parseInt(0) + parseInt(this.grand_total);
        }

        console.log('calculate_grand_total', i, this.grand_total);

      }
      this.To_pay = this.grand_total;

    },

    calculate_qty() {

      for (let i = 1; i <= this.count; i++) {

        if (this.qty[i] && this.unit[i] && this.price[i]) {

          this.total_quantity = parseInt(this.qty[i]) + parseInt(this.total_quantity);

        } else {

          this.total_quantity = parseInt(0) + parseInt(this.total_quantity);
        }
        console.log('calculate_qty', i, this.grand_total);

      }
    },
    calculate_tax() {

      for (let i = 1; i <= this.count; i++) {



        // this.calc_tax(i);

        if (this.tax[i]) {

          this.total_tax = parseInt(this.tax[i]) + parseInt(this.total_tax);

        } else {

          this.total_tax = parseInt(0) + parseInt(this.total_tax);
        }

        // console.log(total_quantity);

      }
    },

    take_discount() {

      if (this.discount != 0) {

        this.sub_total = (parseInt(this.discount) * this.sub_total) / 100;
      }


    },

    get_search() {
      this.axios
        .post(`/supply/newsupplysearch`, { word_search: this.word_search })
        .then(({ data }) => {
          this.temporales = data.temporales;

          this.temporale.forEach((item) => {
            this.total_quantity = item.tem_qty + this.total_quantity;
          });

          this.products = data.products;
          this.suppliers = data.suppliers;

          // this.stores = data;
        });
    },

    list(page = 1) {


      this.axios.post(`/supply/newsupply?page=${page}`).then(({ data }) => {
        console.log(data.suppliers);
        this.temporale = data.temporales;



        this.products = data.products;
        this.suppliers = data.suppliers;

        this.stores = data.stores;
        this.statuses = data.statuses;
        this.treasuries = data.treasuries;
      });

    },

    onwaychange(e) {
      //this.paid = 0;
      //this.remaining = 0;
      let input = e.target;
      this.type_payment = input.value;
      if (input.value == 2) {
        this.show = true;
        this.remaining = this.grand_total;
        this.paid = 0;
      } else {
        this.show = false;
      }


      if (input.value == 1) {
        this.show_treasury = true;
        this.show_bank = false;
        this.paid = this.grand_total;
        this.remaining = 0;
      }

      if (input.value == 3) {
        this.show_bank = true;
        this.show_treasury = false;
        this.paid = this.grand_total;
        this.remaining = 0;
      }
    },


    payment() {


      if (this.Way_to_pay_selected == 1) { //this is default if user not detect any way

        this.paid = this.grand_total;

      }
      this.To_pay = this.grand_total;


      // ----------------------------------------------------


      for (let index = 0; index < this.count; index++) {


        if (!this.qty[index + 1] || this.qty[index + 1] == 0 || !this.unit || !this.price[index + 1]) {


          if (this.qty[index + 1] == 0 || !this.qty[index + 1]) {

            toastMessage('فشل', " لايوجد كميه مدخله", 'error');
          }
          this.$delete(this.counts, index);


        }

      }
      // ----------------------------------------------------

      this.axios
        .post(`/paySupply`, {
          type: 'Supply',
          count: this.counts,
          product: this.productm,
          unit: this.unit,
          units: this.units,
          desc: this.desc,
          qty: this.qty,
          status: this.status,
          price: this.price,
          total: this.total,

          payment_type: this.Way_to_pay_selected,
          // store: $('#Supply_store_tree_id').val(),
          store: this.storem,

          description: this.description,
          type_refresh: this.type_refresh,
          // -------------this for dailies----------------------------------------------
          debit: {
            account_id: this.storem_account,
            value: this.total,
            account_details: this.storem,
          },
          credit: {

            account_id: $(`#Supply_account_tree_id`).val(),
            value: this.grand_total,
            account_details: $(`#select_account_${this.type}_group`).val(),
          },
          // -----------------------------------------------------------
          type_daily: 'supply',
          payment_type: this.Way_to_pay_selected,
          daily_index: 1,
          supplier_id: this.supplier[0],
          supplier_name: this.supplier[1],
          date: this.date,
          treasury: this.treasury[0],
          // ------------------------------------------------------------------------------
          grand_total: this.grand_total,
          sub_total: this.sub_total,
          discount: this.discount,

          type_payment: this.type_payment,
          remaining: this.remaining,
          paid: this.paid,

          total_quantity: this.total_quantity,


        })
        .then((response) => {

          console.log(response);

          if (response.data.status == "success") {
            toastMessage("تم اتمام عمليه الشراء");

          }

          // this.$router.go(0);
        }).catch(error => {

          toastMessage("فشل", error.response.data.message.message, 'error');



        });
    },


  },
};
</script>
