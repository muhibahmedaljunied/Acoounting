<template>
  <div class="wrapper">
    <div class="container-fluid">
      <div class="row">

        <div class="card text-right">
          <div class="card-header">


            <h3>فاتوره مشتريات <span id="codigo"></span></h3>
          </div>
          <div class="card-body">


            <div class="row">



              <div class="col-md-4">
                <label for="pagoPrevio">المخزن</label>
                <div class="custom-search">

                  <input style="background-color: beige;font-size: 15px;" :id="'Purchase_store_tree'" type="text"
                    readonly class="custom-search-input">
                  <input :id="'Purchase_store_tree_id'" type="hidden" readonly class="custom-search-input">
                  <input :id="'select_account_Purchase'" type="hidden" readonly class="custom-search-input">


                  <button class="custom-search-botton" type="button" data-toggle="modal" @click="detect_index(null)"
                    data-target="#exampleModalStore">
                    <i class="fa fa-plus-circle"></i></button>
                </div>

              </div>
              <div class="col-md-4">
                <label for="pagoPrevio">المنتج</label>
                <div class="custom-search">

                  <input style="background-color: beige;font-size: 15px;" :id="'Purchase_product_tree'" type="text"
                    readonly class="custom-search-input">
                  <input :id="'Purchase_product_tree_id'" type="hidden" readonly class="custom-search-input">
                  <input :id="'select_account_Purchase'" type="hidden" readonly class="custom-search-input">


                  <button class="custom-search-botton" type="button" data-toggle="modal" @click="detect_index(null)"
                    data-target="#exampleModalProduct">
                    <i class="fa fa-plus-circle"></i></button>
                </div>

              </div>



              <!-- <div class="col-md-2"  v-if="show_treasury">
  <label for="pagoPrevio">الصندوق</label>
  <select class="form-control" style="background-color: beige;" v-model="treasury" id="supplier">
    <option v-for="tre in treasuries" v-bind:value="[tre.id, tre.name]">
      {{ tre.name }}
    </option>
  </select>

</div>

<div class="col-md-2" v-if="show_bank">
  <label for="pagoPrevio">البنك</label>
  <select class="form-control" style="background-color: beige;" v-model="bank" id="supplier">
    <option v-for="bank in banks" v-bind:value="[bank.id, bank.name]">
      {{ bank.name }}
    </option>
  </select>

</div> -->





            </div>
            <br />
            <hr>
            <div class="row">



              <div class="col-md-3">
                <label for="FormaPago">طريقه الدفع</label>
                <select class="form-control" style="background-color: beige;" name="forma_pago" id="forma_pago"
                  v-model="Way_to_pay_selected" v-on:change="onwaychange">

                  <option v-bind:value="1">نقد</option>
                  <option v-bind:value="2">أجل</option>
                  <option v-bind:value="3">بنك</option>
                </select>
              </div>

              <div class="col-md-3" v-if="Way_to_pay_selected != 2">
                <label for="cliente"> المورد</label>

                <select class="form-control" style="background-color: beige;" v-model="supplier" id="supplier">
                  <option v-for="sup in suppliers" v-bind:value="[sup.id, sup.name]">
                    {{ sup.name }}
                  </option>
                </select>
              </div>
              <div class="col-md-4">
                <h5 class="card-title"> الحساب</h5>
                <div class="custom-search">

                  <input :id="'Purchase_account_tree'" type="text" readonly class="custom-search-input">
                  <input :id="'Purchase_account_tree_id'" type="hidden" readonly class="custom-search-input">


                  <button @click="detect_index(null)" class="custom-search-botton" type="button" data-toggle="modal"
                    data-target="#exampleModalAccount">
                    <i class="fa fa-plus-circle"></i></button>
                </div>
              </div>


            </div>

            <br />
            <hr>
            <div class="row">





              <div class="col-md-3">
                <label for="cliente"> الحساب التفصيلي</label>

                <select class="form-control" style="background-color: beige;" name="forma_pago"
                  id="select_account_Purchase_group">

                </select>

              </div>


              <div class="col-md-4">
                <label for="pagoPrevio">البيان</label>


                <input class="form-control" style="background-color: beige;" type="text" v-model="description">


              </div>

              <div class="col-md-2">
                <label for="date">التاريخ</label><br />

                <input class="form-control" style="background-color: beige;" name="date" type="date" v-model="date" />
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
                      <!-- <th>المخزن</th> -->
                      <th>الوحده</th>
                      <!--<th>التكلفه</th> -->

                      <th>السعر</th>
                      <th>الكميه</th>
                      <th>الضريبه</th>
                      <th>الخصم</th>

                      <th>الاجمالي</th>
                      <th>تاريخ الانتهاء</th>

                      <!-- <th>اضافه</th> -->

                      <th>اضافه</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="index in count" :key="index">
                      <td>{{ index }}</td>
                      <td>
                        <div class="custom-search">

                          <input style="background-color: beige;font-size: 15px;" :id="'Purchase_productm_tree' + index"
                            type="text" readonly class="custom-search-input">
                          <input :id="'Purchase_productm_tree_id' + index" type="hidden" readonly
                            class="custom-search-input">

                          <button class="custom-search-botton" type="button" data-toggle="modal"
                            data-target="#exampleModalProductm" @click="detect_index(index)">
                            <i class="fa fa-plus-circle"></i></button>
                        </div>



                      </td>
                      <td>
                        <div class="custom-search">

                          <input style="background-color: beige;font-size: 15px;" :id="'Purchase_storem_tree' + index"
                            type="text" readonly class="custom-search-input">
                          <input :id="'Purchase_storem_tree_id' + index" type="hidden" readonly
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

                          <select v-on:change="calculate()" style="background-color: beige;"
                            v-model="unit[index]" name="type" :id="'select_unit' + index" class="form-control" required>

                          </select>
                        </div>
                      </td>


                      <td>
                        <input v-on:input="calculate()" style="background-color: beige;" type="number"
                          v-model="price[index]" id="qty" class="form-control" />
                      </td>
                      <td>
                        <input style="background-color: beige;" @input="calculate()" type="number"
                          v-model="qty[index]" id="qty" class="form-control" />
                      </td>
                      <td>
                        <input type="number" v-model="tax[index]" @input="calculate()" id="tax"
                          class="form-control" />
                      </td>
                      <td>
                        <input type="number" v-model="discount[index]" @input="calculate()" id="tax"
                          class="form-control" />
                      </td>

                      <td>
                        <input type="number" @input="calculate()" v-model="total[index]"
                          :id="'total_row' + index" class="form-control" />


                      </td>

                      <td>
                        <input name="expiry_date" type="date" v-model="expiry_date" class="form-control" />

                      </td>


                      <!-- <td>
                        <input v-model="check_state[index]" @change="add_one_sale(product, index)" type="checkbox"
                          class="btn btn-info waves-effect">
                      </td> -->

                      <td v-if="index == 1" rowspan="3">

                        <button class="btn btn-info btn-sm waves-effect btn-agregar" v-on:click="addComponent(count)">
                          <i class="fa fa-plus-circle"></i></button>

                        <button class="btn btn-info btn-sm waves-effect btn-agregar" v-on:click="disComponent(count)">
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
                  <div class="col-md-12">
                    <label for="pagoPrevio"> اجمالي الخصم (%)</label>
                    <input type="number" @input="take_discount" v-model="discounts" :min="0" :max="99" :step="1"
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
                    <input @input="calculate()()" type="text" id="remaining" class="form-control"
                      v-model="To_pay" />


                  </div>


                </div>


                <!-- </div> -->
                <!-- </div> -->
              </div>
              <div class="col-md-4">

                <div class="row">

                  <div class="col-md-12">
                    <label for="pagoPrevio">اجمالي الكميه</label>

                    <input @input="calculate()()" type="text" id="cantidad_total" v-model="total_quantity"
                      class="form-control" />
                  </div>


                  <div class="col-md-12">
                    <label for="subTotal">الاجمالي (بدون ضريبه) <small></small></label>
                    <input @input="calculate()()" type="text" id="subtotal_general_si" name="subtotal_general_si"
                      value="0.00" v-model="sub_total" class="form-control" />
                  </div>

                  <div class="col-md-12">
                    <label for="impuestosTotales">اجمالي الضريبه</label>
                    <input @input="calculate()()" type="text" id="impuestos_totales" v-model="total_tax"
                      class="form-control" />
                  </div>

                  <div class="col-md-12">
                    <label for="subTotal">الاجمالي (مع الضريبه) <small></small></label>

                    <input @input="calculate()()" type="text" id="subtotal_general" name="subtotal_general"
                      v-model="grand_total" class="form-control" />
                    <input type="hidden" id="subtotal_general_sf" name="subtotal_general_sf" value="0.00" />
                  </div>

                  <div class="col-md-12" v-show="show">
                    <label for="pagoPrevio">المدفوع</label>
                    <input @input="calculate()()" class="form-control" type="text" id="paid" v-on:input="credit"
                      v-model="paid" style="color: red" />
                  </div>

                  <div class="col-md-12" v-show="show">
                    <label for="pagoPrevio">المتبقي</label>
                    <input @input="calculate()()" type="text" id="remaining" class="form-control"
                      v-model="remaining" />
                  </div>
                  <div class="col-md-12">
                    <div class="text-center">
                      <a style="
                                width: 100%;
                                padding-top: 0.5em;
                                padding-bottom: 0.5em;
                                font-size: 18pt;" href="javascript:void" @click="payment('Purchase')"
                        class="btn btn-info waves-effect waves-light" id="pagar">
                        حفظ</a>
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
import operation from '../../../operation.js';
import tree from '../../../../js/tree/tree.js';
export default {

  components: {
    pagination,
  },
  mixins: [tree, operation],
  data() {
    return {

      description: '',
      store: '',
      text_message: '',
      discounts: 0,
      total_tax: 0,
      temporale: 1,
      type_payment: 0,
      show: false,
      show_treasury: true,
      show_bank: false,
      note: '',
      not_qty: true,
      seen: false,
      id: '',



    }
  },

  mounted() {
    this.list();
    this.counts[0] = 1;
    this.type = 'Purchase';
    this.type_refresh = 'increment';
    this.type_of_tree = 1;
    this.first_row = 1;

    this.showtree('store', 'tree_store');
    this.showtree('storem', 'tree_store');
    this.showtree('product', 'tree_product');
    this.showtree('productm', 'tree_product');
    this.showtree('account', 'tree_account');








  },


  methods: {





    get_search() {
      this.axios
        .post(`/purchase/newpurchasesearch`, { word_search: this.word_search })
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


      this.axios.post(`/purchase/newpurchase?page=${page}`).then(({ data }) => {
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

    payment() {


      if (this.Way_to_pay_selected == 1) { //this is default if user not detect any way

        this.paid = this.grand_total;

      }



      this.To_pay = this.grand_total;

      for (let index = 0; index < this.count; index++) {


        if (!this.qty[index + 1] || !this.unit || !this.price[index + 1]) {

          this.$delete(this.counts, index);

        }

      }


      console.log(this.unit);
      this.axios
        .post(`/payPurchase`, {
          type: 'Purchase',
          count: this.counts,
          product: this.productm,
          unit: this.unit,
          units: this.units,
          desc: this.desc,
          qty: this.qty,
          status: this.status,
          price: this.price,
          total: this.total,
          tax: this.tax,
          // store: $('#Purchase_store_tree_id').val(),
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

            account_id: $(`#Purchase_account_tree_id`).val(),
            value: this.sub_total,
            account_details: $(`#select_account_${this.type}_group`).val(),

          },
          // -----------------------------------------------------------

          type_daily: 'purchase',
          payment_type: this.Way_to_pay_selected,
          daily_index: 1,
          supplier_id: this.supplier[0],
          supplier_name: this.supplier[1],
          date: this.date,
          treasury: this.treasury[0],
          // ------------------------------------------------------------------------------
          grand_total: this.grand_total,
          sub_total: this.sub_total,
          discount: this.discounts,
          total_tax: this.total_tax,
          type_payment: this.type_payment,
          remaining: this.remaining,
          paid: this.paid,
          // ------------------------------------------------------------------------------

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
