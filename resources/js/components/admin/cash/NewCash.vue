<template>
  <div class="wrapper">
    <div class="container-fluid">
      <div class="card text-right">
        <div class="card-header">
          <h3>امر صرف مخزني<span id="codigo"></span></h3>
        </div>
        <div class="card-body">
          <div class="row">

            <div class="col-md-4">
              <h5 class="card-title"> المنتج</h5>
              <div class="custom-search">

                <input :id="'Cash_product_tree'" type="text" readonly class="custom-search-input">
                <input :id="'Cash_product_tree_id'" type="hidden" readonly class="custom-search-input">

                <button @click="detect_index(null)" class="custom-search-botton" type="button" data-toggle="modal"
                  data-target="#exampleModalProduct">
                  <i class="fa fa-plus-circle"></i></button>
              </div>
            </div>
            <div class="col-md-4">
              <label for="pagoPrevio">المخزن</label>
              <div class="custom-search">

                <input style="background-color: beige;" :id="'Cash_store_tree'" type="text" readonly
                  class="custom-search-input">
                <input :id="'Supply_store_tree_id'" type="hidden" readonly>
                <input :id="'select_account_Cash'" type="hidden" readonly>

                <button @click="detect_index(null)" class="custom-search-botton" type="button" data-toggle="modal"
                  data-target="#exampleModalStore">
                  <i class="fa fa-plus-circle"></i></button>
              </div>

            </div>









          </div>


          <br />
          <hr>

          <div class="row">

            <div class="col-md-2">
              <label for="FormaPago">طريقه الدفع</label>
              <select style="background-color: beige;" name="forma_pago" class="form-control" id="forma_pago"
                v-model="Way_to_pay_selected" v-on:change="onwaychange">
                text

                <option v-bind:value="1">نقد</option>
                <option v-bind:value="2">أجل</option>
                <option v-bind:value="3">بنك</option>
              </select>
            </div>

            <div class="col-md-2" v-if="Way_to_pay_selected == 1">
              <label for="cliente"> العميل</label>

              <select class="form-control" style="background-color: beige;" v-model="customer" id="customer">

                <option v-for="cus in customers" v-bind:value="[cus.id, cus.name]">
                  {{ cus.name }}
                </option>
              </select>
            </div>
            <div class="col-md-4">
              <h5 class="card-title"> الحساب</h5>
              <div class="custom-search">

                <input :id="'Cash_account_tree'" type="text" readonly class="custom-search-input">
                <input :id="'Cash_account_tree_id'" type="hidden" readonly class="custom-search-input">

                <button @click="detect_index(null)" class="custom-search-botton" type="button" data-toggle="modal"
                  data-target="#exampleModalAccount">
                  <i class="fa fa-plus-circle"></i></button>
              </div>
            </div>


            <div class="col-md-2">
              <label for="cliente"> الحساب التفصيلي</label>


              <select class="form-control" style="background-color: beige;" name="forma_pago"
                id="select_account_Cash_group">

              </select>
            </div>


            <div class="col-md-2">
              <label for="pagoPrevio">نوع العمله</label>
              <select name="forma_pago" class="form-control" id="forma_pago">
                <option v-bind:value="2">ريال يمني </option>
                <option v-bind:value="1">دولار امريكي</option>
                <option v-bind:value="2">ريال سعودي </option>
              </select>
            </div>


          </div>


          <br />
          <hr>
          <div class="row">


            <div class="col-md-2">
              <label for="FormaPago">طريقه تكلفه الصرف</label>
              <select style="background-color: beige;" name="forma_pago" class="form-control" id="forma_pago"
                v-model="Way_to_pay_selected" v-on:change="onwaychange">
                text

                <option v-bind:value="1">تكلفه </option>
                <option v-bind:value="2">سعر البيع</option>
                <option v-bind:value="3">سعر التوريد</option>
              </select>
            </div>


            <div class="col-md-4">
              <label for="pagoPrevio">البيان</label>


              <input class="form-control" style="background-color: beige;" type="text" v-model="description">


            </div>

            <div class="col-md-2">
              <label for="date">التاريخ</label><br />

              <input style="background-color: beige;" name="date" type="date" v-model="date" class="form-control" />
            </div>
            <div class="col-md-2">
              <label for="pagoPrevio">تاريخ الاستحقاق</label>
              <input type="date" class="form-control" />

            </div>
          </div>

          <br />
          <hr>


          <div class="row">
            <div class="col-md-12">
              <table class="table table-bordered text-right" style="width: 100%; font-size: x-large">
                <thead>
                  <tr>
                    <th>الرقم التسلسلي</th>

                    <th>المنتج</th>

                    <th>المخزن</th>
                    <th>الحاله</th>
                    <th> المواصفات والطراز</th>
                    <th>الكميه المنوفره</th>
                    <th>الوحده</th>
                    <th>التكلفه</th>
                    <th>الكميه</th>
                    <th>الاجمالي</th>
                    <th>اضافه</th>
                  </tr>
                </thead>
                <tbody v-if="detail && detail.length > 0">
                  <!-- <tr v-for="(products, index) in product"> -->
                  <tr v-for="(product, index) in detail" :key="index">
                    <td>{{ index + 1 }}</td>
                    <td>
                      <div id="factura_producto" class="input_nombre">
                        {{
                  product.product
                }}<input type="hidden" v-model="product.id" id="id" />
                      </div>
                    </td>



                    <td>
                      <div id="factura_producto" class="input_nombre">
                        {{
                  product.store
                }}<input type="hidden" v-model="product.store_id" id="store_temporale" />
                      </div>
                    </td>

                    <td>
                      <div id="factura_producto" class="input_nombre">
                        {{ product.status }}
                      </div>
                    </td>
                    <td>
                      <div id="factura_producto" class="input_nombre">
                        {{ product.desc }}
                      </div>
                    </td>
                    <td>
                      <div id="factura_producto" class="input_nombre" v-if="product.availabe_qty">


                        <div v-for="temx in product.qty_after_convert['quantity']">



                          <span v-for="temx2 in temx">


                            <span style="float: right;">
                              {{ temx2[0] }}
                              <span style="color: red;">
                                {{ temx2[1] }}
                              </span>

                            </span>



                          </span>

     

                        </div>

                      </div>

                    </td>


                    <td>
                      <div id="factura_producto" class="input_nombre">





                        <select v-if="check_state[index] == true" style="background-color: beige;"
                          :id="'select_unit' + index" v-model="unit[index]" name="type" class="form-control" required>

                          <option disabled v-for="unit in product.units" v-bind:value="[unit.unit_id, unit.rate]">
                            {{ unit.name }}
                          </option>


                        </select>


                        <select v-on:change="calculate_total(index,product.price)" v-else
                          style="background-color: beige;" :id="'select_unit' + index" v-model="unit[index]" name="type"
                          class="form-control" required>

                          <option v-for="unit in product.units" v-bind:value="[unit.unit_id, unit.rate]">
                            {{ unit.name }}
                          </option>


                        </select>





                      </div>
                    </td>
                    <td>
               
                        {{ product.cost }}
                    </td>

                
                    <td>
                      <!-- <input style="background-color: beige;" type="number" @input="on_input(qty[index], product.availabe_qty), calculate(product.price, qty[index],
                    index)" v-model="qty[index]" id="qty" class="form-control input_cantidad" onkeypress="return " /> -->


                      <input v-if="check_state[index] == true" readonly style="background-color: beige;" type="number"
                       v-model="qty[index]" id="qty"
                        class="form-control input_cantidad" onkeypress="return " />

                      <input v-else style="background-color: beige;" type="number"
                        @input="calculate_total(index,product.price)" v-model="qty[index]" id="qty"
                        class="form-control input_cantidad" onkeypress="return " />
                    </td>


                    <td>


                      <input v-if="check_state[index] == true" readonly type="number" v-model="total[index]" :id="'total_row' + index" class="form-control"
                       />

                        <input @input="calculate_total(index,product.price)" v-else type="number" v-model="total[index]" :id="'total_row' + index" class="form-control"
                         />

                    </td>

                    <td>
                      <input v-model="check_state[index]" @change="calculate()" type="checkbox"
                        class="btn btn-info waves-effect">
                    </td>

                  </tr>



                </tbody>
                <tbody v-else>
                  <tr>
                    <td align="center" colspan="10">
                      <h3> لايوجد بيانات </h3>
                    </td>
                  </tr>
                </tbody>

             

              </table>
            </div>
          </div>
          <br />
          <hr>


          <div class="row">

            <div class="col-md-8">
              <div class="row">





                <div class="col-md-12" v-show="show">
                  <label for="pagoPrevio">المدفوع</label>
                  <input @input="calculate()" type="text"   class="form-control" v-model="paid"
                    style="color: red" />

                </div>
                <div class="col-md-12" v-show="show">
                  <label for="pagoPrevio">المتبقي</label>
                  <input @input="calculate()" type="text"  class="form-control" v-model="remaining" />

                </div>



                <div class="col-md-12">
                  <label for="total" class="text-left">المبلغ المستحق</label>
                  <input @input="calculate()" type="text"  class="form-control" v-model="To_pay" />

                  <!-- <div class="col-md-12 letra_calculator_total text-center" id="div_total">
                    {{ To_pay }}
                  </div>
                  <input type="hidden" name="total" id="total" v-model="To_pay" /> -->
                </div>

              </div>
            </div>
            <div class="col-md-4">

              <div class="row">

                <div class="col-md-12">
                  <label for="pagoPrevio">اجمالي الكميه</label>
                  <input @input="calculate()" type="text"  id="cantidad_total" class="form-control"
                    v-model="total_quantity" />
                </div>





                <div class="col-md-12">

                  <label for="subTotal">الاجمالي <small></small></label>
                  <input @input="calculate()" type="text"  id="subtotal_general_si" name="subtotal_general_si" class="form-control"
                    value="0.00" v-model="grand_total" />

                </div>

                <div class="col-md-12">
                  <div class="text-center">
                    <a style="
width: 100%;
padding-top: 0.5em;
padding-bottom: 0.5em;
font-size: 18pt;
" href="javascript:void" @click="payment()" class="btn btn-info waves-effect waves-light" id="pagar">
                      <i class="fa fa-credit-card"></i></a>
                  </div>
                </div>
              </div>
            </div>

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



  </div>
</template>



<script>
import operation from '../../../operation.js';
import tree from '../../../tree/tree.js';
export default {
  mixins: [operation, tree],
  data() {
    // return data;
    return {
      account: '',
      count: 1,
      table: '',
      type: '',
      type_refresh: '',
      note: "",
      detail: '',
      Total_quantity: 0,
      total_quantity: 0,
      products: '',
      statuses: '',
      stores: '',
      statuses: '',
      units: '',
      opening: '',
      word_search: '',
      suppliers: '',
      customers: '',
      seen: false,
      id: '',
      index: 0,
      detail: '',
      jsonTreeData: '',
      type_of_tree: 1,
      indexselected: '',
      last_nodes: '',
      statusselected: 0,
      unitselected: 0,
      unitselectedname: '',
      productselected: 0,
      productselectedname: "",
      storeselectedname: "",
      storeselected: 0,
      descselected: "",
      operationselected: 0,
      dateselected: 0,
      checkselected: '',
      // ------------------------------------------------------------
      description: '',
      detail: '',
      temporale: 1,
      suppliers: '',
      discount: 0,
      type_payment: 0,
      show: false,
      show_treasury: true,
      show_bank: false,
      credit: '',

    }
  },
 
  mounted() {
    this.list();
    this.type = 'Cash';
    this.type_refresh = 'decrement';
    this.type_of_tree = 1;
    this.first_row = 0;
    this.showtree('store', 'tree_store');
    this.showtree('product', 'tree_product');
    this.showtree('account', 'tree_account');


  },


  methods: {


 
    list(page = 1) {
      this.axios
        .post(`/cash/newcash?page=${page}`)
        .then(({ data }) => {

          this.products = data.products;
          this.customers = data.customers;
          this.treasuries = data.treasuries;



        })
        .catch(({ response }) => {
          console.error(response);
        });
    },


    // take_discount() {

    //   this.grand_total *= parseInt(this.discount) / 100;
    //   // this.grand_total = this.grand_total/100;
    // },

    // calculate(index,price) {



    //   if (this.unit[index] && this.qty[index]) {


    //     this.total[index] = price* this.qty[index] * this.unit[index][1];

    //   } else {

    //     toastMessage('فشل', "قم بأدخال الوحده", 'error');

    //     this.total[index] = 0;
    //   }




    // },

  





    onwaychange(e) {

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

        this.paid = this.grand_total;
        this.remaining = 0;

      }

      if (input.value == 3) {

        this.paid = this.grand_total;
        this.remaining = 0;

      }

    },
    set_values() {

      this.counts[this.row_counter] = this.row_counter;
      this.store_product_id[this.row_counter] = this.detail[this.row_counter].id;
      this.storem_account[this.row_counter] = this.detail[this.row_counter].store_account_id;
      this.storem[this.row_counter] = this.detail[this.row_counter].store_id;


    },
    // add_one_cash(product, index) {


    //   // var total = this.total;



    //   if (this.check_qty(
    //     this.qty[index],
    //     this.unit[index],
    //     product.availabe_qty
    //   ) == 0) {
    //     return 0;
    //   }


    //   console.log();
    //   this.handle(product, index);



    // },
    // on_input(qty, availabe_qty) {
    //   if (qty <= availabe_qty) {

    //     this.text_message = 'هذه الكميه غير متوفره ';
    //   }

    // },


    // check_qty(qty, unit, availabe_qty) {

    //   var producter_qty = 0;



    //   if (producter_qty > availabe_qty) {

    //     toastMessage('فشل', "الكميه المدخله اكبر من المتوفره", 'error');
    //     return 0;

    //   }

    //   if (qty <= 0) {

    //     toastMessage('فشل', "تأكد من الكميه المدخله", 'error');
    //     return 0;

    //   }


    //   return 1;
    // },
    payment() {


      if (this.Way_to_pay_selected == 1) { //this is default if user not detect any way

        this.paid = this.grand_total;

      }

      this.axios
        .post(`/payCash`, {
          type: 'Cash',
          count: this.counts,
          unit: this.unit,
          qty: this.qty,
          price: this.price,
          total: this.total,
          old: this.detail,


          // -------------this for dailies----------------------------------------------

          debit: {
            account_id: $(`#Cash_account_tree_id`).val(),
            value: this.grand_total,
            account_details: $(`#select_account_${this.type}_group`).val(),

          },
          credit: {
            // credit_account_id: $(`#select_account_${this.type}`).val(),
            account_id: this.storem_account,
            value: this.total,
            account_details: this.storem,

          },

          // -----------------------------------------------------------
          type_daily: 'cash',
          payment_type: this.Way_to_pay_selected,
          daily_index: 0,
          // store_account: $(`#select_account_${this.type}`).val(),
          description: this.description,
          type_refresh: this.type_refresh,
          // customer_account: this.customer[2],
          customer_id: this.customer[0],
          customer_name: this.customer[1],
          date: this.date,
          // treasury_account: this.treasury[2],
          treasury: this.treasury[0],
          // -------------------
          grand_total: this.grand_total,
          grand_total: this.grand_total,
          discount: this.discount,
          type_payment: this.type_payment,
          remaining: this.remaining,
          paid: this.paid,
          // -------------------

          total_quantity: this.total_quantity,
        })
        .then((response) => {

          console.log(response);

          if (response.data.message == "success") {
            toast.fire({
              title: "تم البيع!",
              text: "Your product has been deleted.",
              button: "Close", // Text on button
              icon: "success", //built in icons: success, warning, error, info
              timer: 3000, //timeOut for auto-close
              buttons: {
                confirm: {
                  text: "OK",
                  value: true,
                  visible: true,
                  className: "",
                  closeModal: true,
                },
                cancel: {
                  text: "Cancel",
                  value: false,
                  visible: true,
                  className: "",
                  closeModal: true,
                },
              },
            });
          }
          // this.$router.go(0);
        });
    },

  },
};
</script>
