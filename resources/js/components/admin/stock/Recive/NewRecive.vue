<template>
  <div class="wrapper">
    <div class="container-fluid">
      <div class="card text-right">
        <div class="card-header">
          <h3>استلام تحويل مخزني<span id="codigo"></span></h3>
        </div>
        <div class="card-body">
          <div class="row">


            <div class="col-md-4">
              <label for="pagoPrevio">المخزن المحول اليه</label>
              <div class="custom-search">

                <input style="background-color: beige;" :id="'Cash_store_tree'" type="text" readonly
                  class="custom-search-input">
                <input :id="'Supply_store_tree_id'" type="hidden" readonly>
                <input :id="'select_account_Cash'" type="hidden" readonly>

                <button class="custom-search-botton" type="button" data-toggle="modal" @click="detect_index(index)"
                  data-target="#exampleModalStore">
                  <i class="fa fa-plus-circle"></i></button>
              </div>

            </div>


            <!-- <div class="col-md-3">
              <label for="desde"> المخزن المحول منه</label>
              <input class="form-control" style="background-color: beige;" type="text" v-model="transfer_from" readonly>









            </div> -->

          </div>
          <br />
          <hr>

          <div class="row">

            <!-- <div class="col-md-2">
              <label for="FormaPago">طريقه الدفع</label>
              <select style="background-color: beige;" name="forma_pago" class="form-control" id="forma_pago"
                v-model="Way_to_pay_selected" v-on:change="onwaychange">
                text

                <option v-bind:value="1">نقد</option>
                <option v-bind:value="2">أجل</option>
                <option v-bind:value="3">بنك</option>
              </select>
            </div> -->
            <div class="col-md-4">
              <h5 class="card-title"> الحساب</h5>
              <div class="custom-search">

                <input :id="'Cash_account_tree'" type="text" readonly class="custom-search-input">
                <input :id="'Cash_account_tree_id'" type="hidden" readonly class="custom-search-input">

                <button class="custom-search-botton" type="button" data-toggle="modal"
                  data-target="#exampleModalAccount">
                  <i class="fa fa-plus-circle"></i></button>
              </div>
            </div>

            <div class="col-md-3">
              <label for="desde"> رقم التحويل</label>
              <input class="form-control" style="background-color: beige;" type="text" v-model="transfer_id"
                @input="get_product_for_transfer">









            </div>
            <!-- <div class="col-md-2" v-if="Way_to_pay_selected != 2">
              <label for="cliente"> العميل</label>

              <select class="form-control" style="background-color: beige;" v-model="customer" id="customer">

                <option v-for="cus in customers" v-bind:value="[cus.id, cus.name]">
                  {{ cus.name }}
                </option>
              </select>
            </div>

            <div class="col-md-3">
              <label for="cliente"> الحساب التفصيلي</label>


              <select class="form-control" style="background-color: beige;" name="forma_pago"
                id="select_account_Cash_group">

              </select>
            </div> -->





          </div>


          <br />
          <hr>
          <div class="row">


            <!-- <div class="col-md-2">
              <label for="FormaPago">طريقه تكلفه الصرف</label>
              <select style="background-color: beige;" name="forma_pago" class="form-control" id="forma_pago"
                v-model="Way_to_pay_selected" v-on:change="onwaychange">
                text

                <option v-bind:value="1">تكلفه </option>
                <option v-bind:value="2">سعر البيع</option>
                <option v-bind:value="3">سعر التوريد</option>
              </select>
            </div> -->


            <div class="col-md-4">
              <label for="pagoPrevio">البيان</label>


              <input class="form-control" style="background-color: beige;" type="text" v-model="description">


            </div>

            <div class="col-md-2">
              <label for="date">التاريخ</label><br />

              <input style="background-color: beige;" name="date" type="date" v-model="date" class="form-control" />
            </div>

            <div class="col-md-2">
              <button @click="addTransfer()" type="button" class="tn btn-info btn-lg waves-effect btn-agregar">
                استلام
              </button>
            </div>


          </div>

          <br />
          <hr>


          <div class="row">
            <div class="col-md-12">
              <div class="table-responsive">
                <table class="table table-bordered text-center">
                  <thead>
                    <tr>
                      <th>#</th>
                      <!-- <th class="wd-15p border-bottom-0">رقم الحساب</th> -->
                      <th class="wd-15p border-bottom-0" rowspan="">
                        اسم المنتج
                      </th>
                      <th class="wd-15p border-bottom-0" rowspan="">الحاله</th>
                      <th class="wd-15p border-bottom-0" rowspan="">الطراز</th>

                      <th class="wd-15p border-bottom-0" colspan="">المخزن المحول منه</th>
                      <!-- <th class="wd-15p border-bottom-0" colspan="">المخزن المحول اليه</th> -->

                      <th class="wd-15p border-bottom-0" rowspan="">
                        الكميه المحوله
                      </th>
                      <th class="wd-15p border-bottom-0" rowspan="">
                          الكميه المستلمه
                        </th>
                      <th class="wd-15p border-bottom-0" colspan="">الوحده</th>

                      <th>اضافه</th>
                      <!-- <th>+</th> -->
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(data_product, index) in transfers" :key="index">
                      <td>{{ index + 1 }}</td>
                      <td>
                        <div id="factura_producto" class="input_nombre">
                          {{ data_product.product
                          }}
                          <!-- <input type="hidden" v-model="data_product.product_id" id="id" /> -->
                        </div>
                      </td>

                      <td>
                        <div id="factura_producto" class="input_nombre">
                          {{ data_product.status
                          }}
                          <!-- <input type="hidden" v-model="data_product.status_id" id="id" /> -->
                        </div>
                      </td>
                      <td>
                        <div id="factura_producto" class="input_nombre">
                          {{ data_product.desc
                          }}
                          <!-- <input type="hidden" v-model="data_product.desc" id="id" /> -->
                        </div>
                      </td>

                      <td>
                        <div id="factura_producto" class="input_nombre">
                          {{ data_product.store
                          }}
                          <!-- <input type="hidden" v-model="data_product.store_id" id="id" /> -->
                        </div>
                      </td>
                      <!-- <td>
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

700273808

                      </td> -->

                      <td>
                        <input style="background-color: beige;" v-model="data_product.qty" type="number"
                          class="form-control input_cantidad" onkeypress="return valida(event)" readonly />
                      </td>
                      <td>
                        <input style="background-color: beige;" v-model="qty" type="number"
                          class="form-control input_cantidad" onkeypress="return valida(event)" readonly />
                      </td>
                      <td>
                        <input style="background-color: beige;" v-model="data_product.unit" type="text"
                          class="form-control input_cantidad" onkeypress="return valida(event)" readonly />


                      </td>
                      <td>
                        <input @change="
                  add_one_transfer(
                    index,
                    data_product

                  )
                  " type="checkbox" v-model="check_state[index]" class="btn btn-info waves-effect" />
                      </td>

                    </tr>
                  </tbody>
                </table>

              </div>
            </div>
          </div>
          <br />
          <hr>




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
  </div>
</template>



<script>
import operation from '../../../../operation1.js';
import tree from '../../../../tree/tree.js';
export default {
  mixins: [operation, tree],
  data() {
    // return data;
    return {

      account: '',
      transfers: '',
      // product: [],
      transfer_id: [],
      transfer_from: [],
      qty: [],
      unit: [],
      account_in_list: [],
      // desc: [],
      store: [],
      // status: [],
      store_product_id: [],
      counts: {},
      count: 1,
      date: new Date().toISOString().substr(0, 10),
      dateselected: new Date().toISOString().substr(0, 10),
      expiry_date: new Date().toISOString().substr(0, 10),
      table: '',
      type: '',
      type_refresh: '',
      note: "",
      detail: '',
      Total_quantity: 0,
      total_quantity: 0,
      check_state: [],
      return_qty: [],
      price: [],

      stores: '',
      statuses: '',
      units: '',

      availabe_qty: [],
      word_search: '',
      total: [],




      seen: false,
      id: '',

      index: 0,
      all_products: '',
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
      typeselected: [],
      checkselected: '',
      // ------------------------------------------------------------

      description: '',

      all_products: '',











      show: false,




      return_qty: [],
      credit: '',

    }
  },
  created() {

  },
  mounted() {
    this.list();

    this.type = 'Cash';
    this.type_refresh = 'decrement';

    this.type_of_tree = 1;

    this.showtree('store', 'tree_store');
    this.showtree('product', 'tree_product');
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

    get_product_for_transfer() {


      let uri = `/get_transfer_for_recive/${this.transfer_id}`;
      axios
        .post(uri)
        .then((responce) => {
          this.transfers = responce.data.transfer_details;

        })
        .catch(({ response }) => {
          console.error(response);
        });
    },


    take_discount() {

      this.sub_total *= parseInt(this.discount) / 100;
      // this.sub_total = this.sub_total/100;
    },
    calculate_price(index) {

      var unit = $(`#select_unit${index}`).val();
      unit = unit.split(",");



      if (unit[2] == 0) {

        this.total[index] = this.all_products[index].price * this.qty[index];

      }

      if (unit[2] == 1) {

        this.total[index] = this.all_products[index].price * unit[1] * this.qty[index];

      }


      // console.log(this.total);

      if (this.qty[index] == 0) {
        this.total[index] = 0;

      }




    },

    calc_grand_total(index) {


      this.grand_total = 0;

      for (let i = 0; i <= index; i++) {


        if (this.total[i]) {

          this.grand_total = parseInt(this.total[i]) + parseInt(this.grand_total);

        } else {

          this.grand_total = parseInt(0) + parseInt(this.grand_total);
        }



      }

    },


    calc_qty(index) {

      this.total_quantity = 0;
      for (let i = 0; i <= index; i++) {



        if (this.qty[i]) {

          this.total_quantity = parseInt(this.qty[i]) + parseInt(this.total_quantity);

        } else {

          this.total_quantity = parseInt(0) + parseInt(this.total_quantity);
        }



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
    add_one_cash(product, index) {


      // var total = this.total;


      if (this.check_state[index] == true) {


        if (this.check_qty(this.qty[index], this.unit[index], product.availabe_qty) == 0) { return 0; }

        this.calc_grand_total(index);

        this.calc_qty(index);

        this.To_pay = this.grand_total;
        this.sub_total = parseInt(this.grand_total)

        this.counts[index] = index;

        this.store_product_id[index] = product.id;
        this.account_in_list[index] = product.store_account_id;
        this.store[index] = product.store_id;




      }
      else if (this.check_state[index] == false) {


        if (!this.total[index]) { this.total[index] = 0; }
        if (!this.qty[index]) { this.qty[index] = 0; }

        this.$delete(this.counts, index);
        this.grand_total = parseInt(this.grand_total) - parseInt(this.total[index]);
        this.sub_total = parseInt(this.grand_total);
        this.total_quantity = parseInt(this.total_quantity);

        this.total[index] = 0;
        this.qty[index] = 0;





      }

    },
    // on_input(qty, availabe_qty) {
    //   if (qty <= availabe_qty) {

    //     this.text_message = 'هذه الكميه غير متوفره ';
    //   }

    // },


    check_qty(qty, unit, availabe_qty) {

      var producter_qty = 0;

      if (unit[2] == 1) {

        producter_qty = qty * unit[1];
      } else {

        producter_qty = qty;
      }

      if (producter_qty > availabe_qty) {

        toastMessage('فشل', "الكميه المدخله اكبر من المتوفره", 'error');
        return 0;

      }

      if (qty <= 0) {

        toastMessage('فشل', "تأكد من الكميه المدخله", 'error');
        return 0;

      }


      return 1;
    },
    payment() {


      if (this.Way_to_pay_selected == 1) { //this is default if user not detect any way

        this.paid = this.grand_total;

      }

      this.axios
        .post(`/store_recive`, {
          type: 'Cash',
          count: this.counts,
          unit: this.unit,
          qty: this.qty,
          price: this.price,
          total: this.total,
          old: this.all_products,


          // -------------this for dailies----------------------------------------------

          debit: {
            account_id: $(`#Cash_account_tree_id`).val(),
            value: this.sub_total,
            account_details: $(`#select_account_${this.type}_group`).val(),

          },
          credit: {
            // credit_account_id: $(`#select_account_${this.type}`).val(),
            account_id: this.account_in_list,
            value: this.total,
            account_details: this.store,

          },

          // -----------------------------------------------------------
          type_daily: 'cash',

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
          sub_total: this.sub_total,
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
