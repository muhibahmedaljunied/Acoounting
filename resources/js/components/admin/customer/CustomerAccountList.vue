<template>
  <div class="container-fluid">



    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header">
            <!-- <span class="h2"> المخزون</span> -->

            <div class="pull-right">
              <h1>كشف حساب عميل <span id="codigo"></span></h1>
            </div>


          </div>
          <div class="card-body">


            <div class="row">


              <div class="col-md-4">
                <label for="cliente">اختر عميل</label>

                <select v-model="customer" id="supplier" class="form-control">
                  <option v-for="sup in customers" v-bind:value="[sup.id, sup.name]">
                    {{ sup.name }}
                  </option>
                </select>
              </div>

              <div class="col-md-2">
                <label for="date"> من تاريخ </label><br />

                <input name="date" type="date" v-model="date" class="form-control" />
              </div>
              <div class="col-md-2">
                <label for="date"> الي تاريخ </label><br />

                <input name="date" type="date" v-model="date" class="form-control" />
              </div>
              <div class="col-sm-2 col-md-3" style="margin-top: auto;">
                <a @click="onwaychange()" href="#"><img src="/assets/img/search.png" alt="" style="width: 10%;"> </a>
              </div>

            </div>
            <br>
            <hr />
            <div class="row" style="font-size: 10pt">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table class="table table-bordered text-right m-t-30" style="width: 100%; font-size: x-small"
                    id="lista_productos_temporal">
                    <thead>
                      <tr>


                        <th>التاريخ</th>
                        <th>البيات</th>
                        <th>داين</th>
                        <th>مدين</th>

                        <th>الرصيد</th>




                        <!-- <th>الاجمالي<small> مع الضريبه </small></th> -->
                        <!-- <th style="width: 60px">العمليات</th> -->
                      </tr>
                    </thead>
                    <tbody>


                      <tr v-for="temporales in sales">

                        <td>{{ temporales.date }}</td>
                        <td> <span style="color:red">فاتوره بيع رقم </span> {{
                          temporales.id
                        }}</td>
                        <td v-for="tes in temporales.payment_sales">{{ tes.paid }}</td>
                        <td v-for="tes in temporales.payment_sales">{{ tes.remaining }}
                        </td>

                        <td v-for="tes in temporales.payment_sales">
                          {{ tes.remaining - tes.paid }}
                          <input type="hidden" v-model="xx = tes.remaining - tes.paid">
                        </td>

                      </tr>

                      <template v-for="temporales in sales">
                        <tr v-for="tem in temporales.payable_notes">
                          <td>
                            {{ tem.date }}

                          </td>
                          <td>
                            سند دفع

                          </td>
                          <td>
                            {{ tem.paid }}

                          </td>
                          <td>
                            0

                          </td>

                          <td>
                            {{ xx - tem.paid }}
                            <input type="hidden" v-model="xx = xx - tem.paid">


                          </td>

                        </tr>


                      </template>

                      <tr>
                        <td colspan="4" style="color:red;font-size:30px;">
                          الاجمالي
                        </td>
                        <td>


                          <span style="color:green;font-size:30px;">{{ xx }}</span>

                        </td>
                      </tr>
                      <!-- <tr v-for="tem in purchases.payable_notes">

    <td>
        {{ tem.date }}
    </td>
   <td v-for="te in tem.payable_notes">
            {{ te.date}}
        </td>
        <td v-for="te in tem.payable_notes">
            <span style="color:red">سند قبض رقم </span>{{ te.id}}
        </td>

        <td v-for="te in tem.payable_notes">
            {{ te.paid}}
        </td>

        <td v-for="te in tem.payable_notes">
          0
        </td>

        <td v-for="te in tem.payable_notes">
            {{ te.paid - xx}}
        </td> 








</tr> -->






                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--/div-->
    </div>















  </div>
</template>
<script>
import pagination from "laravel-vue-pagination";
import operation from '../../../../js/operation.js';
export default {

  components: {
    pagination,
  },
  mixins: [operation],
  data() {
    return {

      text_message: '',
      type: '',
      type_refresh: '',
      count: 1,
      counts: {},
      intostore: [],
      intostore_id: [],
      product_name: [],
      product: [],
      products: '',
      word_search: '',
      check_state: [],
      qty: [],
      availabe_qty: [],
      price: [],
      tax: [],
      desc: [],
      stores: '',
      statuses: '',
      total_quantity: 0,
      grand_total: 0,
      sub_total: 0,
      To_pay: 0,
      discount: 0,
      total_tax: 0,
      customer: [],
      supplier: [],
      suppliers: '',
      customers: '',
      date: new Date().toISOString().substr(0, 10),
      status: [],
      store: [],
      temporale: 1,
      type_payment: 0,
      Way_to_pay_selected: 1,
      show: false,
      paid: 0,
      remaining: 0,
      return_qty: [],
      note: '',
      not_qty: true,
      seen: false,
      detail: '',
      id: '',
      sales: '',


      // ----------------------------
      // supply_detail: "",
      // supply_id: "",
      //---------------------------- 
      // cash_detail: 0,
      // cash_id: "",
      // ---------------------------------------------------
      // purchase_detail: 0,
      // purchase_id: "",
      // -----------------------------------
      // sale_detail: 0,
      // sale_id: "",
      // ---------------------------------

      // dateselected: new Date().toISOString().substr(0, 10),



    }
    // return data;
  },

  mounted() {
    this.list();
    this.counts[0] = 0;
    this.type = 'Purchase';
    this.type_refresh = 'increment';


  },

  methods: {
    //   show_modal(id) {
    //     $("#vaciar1").val(id);
    //   },


    //   take_discount() {

    //     if (this.discount != 0) {

    //       this.sub_total = (parseInt(this.discount) * this.sub_total) / 100;
    //     }


    //   },

    //   get_search() {
    //     this.axios
    //       .post(`/purchase/newpurchasesearch`, { word_search: this.word_search })
    //       .then(({ data }) => {
    //         this.temporales = data.temporales;

    //         this.temporale.forEach((item) => {
    //           this.total_quantity = item.tem_qty + this.total_quantity;
    //         });

    //         this.products = data.products;
    //         this.suppliers = data.suppliers;

    //         // this.stores = data;
    //       });
    //   },
    list(page = 1) {
      this.axios
        .post(`/sale/newsale?page=${page}`)
        .then(({ data }) => {
          this.customers = data.customers;
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },

    onwaychange() {


      this.axios.post(`/customer/customer_account_list/${this.customer[0]}`).then(({ data }) => {
        console.log(data)
        console.log(this.customer);




        this.sales = Object.values(data.sales.data);
        // console.log(this.sales);




      });


    },

    //   onwaychange(e) {
    //     let input = e.target;
    //     this.type_payment = input.value;
    //     if (input.value == 2) {
    //       this.show = true;
    //     } else {
    //       this.show = false;
    //     }
    //   },
    //   credit(e) {
    //     this.remaining = this.grand_total - this.paid;
    //     this.To_pay = this.paid;
    //   },



  },
};
</script>


