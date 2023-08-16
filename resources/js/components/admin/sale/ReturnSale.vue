<template>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">

          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <span class="h2">اضافه مرتجع بيع</span>
              </div>
              <!-- <div class="text-center">
                <span v-if="message_check" class="alert alert-warning" role="alert">
                  ادخل كمبه اكبر من 0 و اقل من {{ text_message }}
                </span>
              </div> -->

              <div class="card-body">

                <div class="row">

                  <div class="col-md-4">


                    <label for="date">رقم الفاتوره</label><br />

                    <input  v-model="id" style="background-color: beige;" class="form-control" />



                  </div>
                  <div class="col-md-4">


                    <label for="date">التاريخ</label><br />

                    <input style="background-color: beige;" name="date" type="date" v-model="dateselected"
                      class="form-control" />



                  </div>
                  <div class="col-md-4">

                    <label for="date">طريقه الدفع</label><br />


                    <select style="background-color: beige;" name="forma_pago" class="form-control" id="forma_pago">


                      <option v-bind:value="1">نقد</option>
                      <option v-bind:value="2">أجل</option>
                    </select>



                  </div>
                  <div class="col-md-6">


                    <label for="cliente"> العميل</label>

                    <select style="background-color: beige;" v-model="customer" id="customer" class="form-control">
                      <option v-for="cust in customers" v-bind:value="[cust.id, cust.name, cust.account_id]">
                        {{ cust.name }}
                      </option>
                    </select>


                  </div>
                  <div class="col-md-6">

                    <label for="pagoPrevio">الصندوق</label>
                    <select style="background-color: beige;" v-model="treasury" id="supplier" class="form-control">
                      <option v-for="tre in treasuries" v-bind:value="[tre.id, tre.name, tre.account_id]">
                        {{ tre.name }}
                      </option>
                    </select>


                  </div>

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
                            <th>الكميه المتوفره</th>
                            <th>الكميه المباعه</th>
                            <!-- <th> السعر </th> -->
                            <th> الوحده </th>


                            <th>الكميه المسموح ارجاعها</th>
                            <th>الكميه المرتجعه الفعليه </th>

                            <th>اضافه</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="(sale_details, index) in detail" :key="index">
                            <input v-model="id = sale_details.sale_id" type="hidden" name="name" id="name"
                              class="form-control" />

                            <td>
                              <div class="form-group">
                                <input v-model="sale_details.product" readonly type="text" name="name" id="name"
                                  class="form-control" />
                              </div>
                            </td>
                            <td>{{ sale_details.desc }}</td>
                            <td>{{ sale_details.status }}</td>
                            <td>{{ sale_details.store }}</td>
                            <td>

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

                            </td>
                            <!-- <td>
                          <div class="form-group">
                            <input v-model="sale_details.qty" readonly type="text" name="name" class="form-control" />
                          </div>
                        </td> -->
                            <td>

                              <div v-for="temx in sale_details.units">


                                <span v-if="sale_details.unit_id == temx.id">
                                  <span v-if="temx.unit_type == 0">

                                    <span v-if="sale_details.qty / sale_details.rate >= 1">
                                      {{ Math.floor((sale_details.qty / sale_details.rate)) }}{{
                                        sale_details.units[0].name
                                      }}
                                    </span>

                                    <span v-if="sale_details.qty % sale_details.rate >= 1">
                                      {{ Math.floor((sale_details.qty % sale_details.rate)) }}{{
                                        sale_details.units[1].name
                                      }}
                                    </span>

                                    <span v-if="sale_details.qty == 0">
                                      0
                                    </span>



                                  </span>

                                  <span v-if="temx.unit_type == 1">
                                    {{ sale_details.qty }} {{ temx.name }}
                                  </span>

                                </span>
                              </div>

                            </td>


                            <td>
                              <!-- <div class="form-group">
                            <input v-model="sale_details.unit" readonly type="text" name="name" class="form-control" />
                          </div> -->
                              <select style="background-color: beige;" v-model="sale_details.unit_selected" name="" id=""
                                class="form-control">
                                <option v-for="unit in sale_details.units" :value="[unit.id, unit.rate, unit.unit_type]">

                                  {{ unit.name }}
                                </option>

                              </select>
                            </td>

                            <td>

                              <div v-for="temx in sale_details.units">


                                <span v-if="sale_details.unit_id == temx.id">
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
                                  <span v-if="temx.unit_type == 1">
                                    {{ sale_details.qty_remain }} {{ temx.name }}
                                  </span>

                                </span>
                              </div>

                            </td>
                            <td>
                              <div class="form-group">
                                <input @input="calculate_price(index)" style="background-color: beige;"
                                  v-model="sale_details.qty_return_now" type="number" min="1" step="1"
                                  class="form-control" />

                              </div>
                            </td>

                            <td>

                              <input v-model="check_state[index]" @change="
                                add_one_return_sale(

                                  // purchase_details.qty_remain,
                                  index,
                                  sale_details.qty_return_now,
                                  sale_details.unit_selected


                                )
                                " type="checkbox" class="btn btn-info waves-effect">
                            </td>
                          </tr>

                          <tr>
                            <td colspan="10">
                              <div class="m-t-30 col-md-12">
                                <label for="date">الاجمالي</label><br />
                                <input readonly name="number" type="number" class="form-control" />


                              </div>
                            </td>
                          </tr>





                          <tr>
                            <td colspan="10">
                              <div class="m-t-30 col-md-12">
                                <label for="date">البيان</label><br />
                                <input v-model="note" type="text" name="name" id="name" class="form-control" />
                              </div>
                            </td>
                          </tr>

                          <a v-if="not_qty" @click="Add_return()" class="btn btn-success"><span>تاكيد العمليه</span></a>
                          <!-- <div v-if="seen" class="alert alert-warning" role="alert">
                        قم باضافه الكميه المرتجعه
                      </div> -->
                        </tbody>
                      </table>
                    </div>
                  </div>
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


    return {

      qty: [],
      unit: [],
      counts: {},
      treasury: [],
      count: 1,

      
      description: '',

      customer: [],
      treasury: [],
      
    
      not_qty: true,
      message_check: false,
      text_message: 0,
    };
  },
  mounted() {
    this.table = 'sale_details';
    this.type = 'SaleReturn';
    this.type_refresh = 'increment';



    let uri = `/sale_details/${this.$route.params.id}`;
    this.axios.post(uri, { table: this.table }).then((response) => {
      console.log(response);
      this.detail = response.data.sale_details;
      this.customers = response.data.customers;
      this.treasuries = response.data.treasuries;

      // this.$root.logo = "CashDetails";
    });
  },
  methods: {
    check_qty(sale_id = 0, qty_return, quantity) {
      if (qty_return > quantity || qty_return == 0) {
        this.text_message = quantity;
        this.message_check = true;
      } else {
        this.message_check = false;
      }


    },
    add_one_return_sale(index, qty, unit) {



      var result;

      if (this.check_state[index] == true) {


        // result = this.check_qty(qty, unit, availabe_qty);

        // if (result == 0) { return 0; }

        this.counts[index] = index;
        this.qty[index] = qty;
        this.unit[index] = unit;
      } else {
        this.$delete(this.counts, index);
      }

      console.log(this.counts, index);
      console.log(this.qty, index);
      console.log(this.unit, index);


    },
    Add_return() {


      // if (this.return_qty.length != 0) {

      var url = this.type.toLowerCase();
      // alert(url);
      this.axios
        .post(`/${url}`, {

      
          type: this.type,
          count: this.counts,
          unit: this.unit,

          // store_account: $(`#select_account_${this.type}`).val(),
          description: this.description,
          type_refresh: this.type_refresh,
          customer_account: this.customer[2],
          customer_id: this.customer[0],
          customer_name: this.customer[1],
          treasury_account: this.treasury[2],
          treasury: this.treasury[0],
          type: this.type,
          // type_refresh: this.type_refresh,
          old: this.detail,
          date: this.dateselected,
          // note: this.note,
          sale_id: this.id,




        })
        .then((response) => {
          console.log(response);

          if (response.data.message != 0) {

            // console.log(response)

            this.seen = false;
            toastMessage("تم الارجاع بنجاح");
            // this.$router.go(-1);

          } else {

            toastMessage("فشل", response.data.text);




          }


        });
      // }


    },
    calculate_price(index) {



    },


  }
};
</script>

