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
              <div class="text-center">
                <span v-if="message_check" class="alert alert-warning" role="alert">
                  ادخل كمبه اكبر من 0 و اقل من {{ text_message }}
                </span>
              </div>

              <div class="card-body">
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
                        <th> السعر </th>
                        <th> الوحده </th>


                        <th>الكميه المسموح ارجاعها</th>
                        <th>اضافه</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(sale_details, index) in detail" :key="index">
                        <input v-model="id = sale_details.sale_id" readonly type="hidden" name="name" id="name"
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

                            <span v-if="temx.name == sale_details.unit">

                              <span v-if="temx.unit_type == 1">

                                {{ sale_details.qty }} {{ temx.name }}

                              </span>

                              <span v-if="temx.unit_type == 0">

                                <span v-if="sale_details.qty / sale_details.rate >= 1">
                                  {{ Math.floor((sale_details.qty / sale_details.rate)) }}{{
                                    sale_details.units[0].name
                                  }}
                                </span>

                                <span v-if="sale_details.qty % sale_details.rate >= 1">
                                  و
                                  {{ Math.floor((sale_details.qty % sale_details.rate)) }}{{
                                    sale_details.units[1].name
                                  }}
                                </span>
                              </span>

                            </span>



                          </div>

                        </td>

                        <!-- <td>
                          <div v-for="temx in sale_details.units">

                            <span v-if="temx.unit_type == 0">
                              {{ parseInt(sale_details.qty / sale_details.rate) }} {{ temx.name }}
                            </span>
                            <span v-if="temx.unit_type == 1">
                              <span
                                v-if="Math.floor(((sale_details.qty / sale_details.rate) - parseInt(sale_details.qty / sale_details.rate)) * sale_details.rate) != 0">
                                و
                                {{
                                  Math.floor(((sale_details.qty / sale_details.rate) -
                                    parseInt(sale_details.qty / sale_details.rate)) * sale_details.rate)
                                }}{{
  temx.name
}}
                              </span>

                            </span>
                          </div>

                        </td> -->

                        <td>
                          <div class="form-group">
                            <input v-model="sale_details.price" readonly type="text" name="name" class="form-control" />
                          </div>
                        </td>
                        <td>
                          <div class="form-group">
                            <input v-model="sale_details.unit" readonly type="text" name="name" class="form-control" />
                          </div>
                        </td>

                        <td>
                          <div class="form-group">
                            <input v-model="sale_details.qty_remain" type="number" min="1"
                              :max="sale_details.qty_remain" step="1" class="form-control" />
                          </div>

                        </td>
                        <!-- <td>
                          <div v-for="temx in sale_details.units">

                            <span v-if="temx.unit_type == 1">
                              {{ parseInt(sale_details.qty_remain / sale_details.rate) }} {{ temx.name }}
                            </span>
                            <span v-if="temx.unit_type == 0">
                              <span
                                v-if="Math.floor(((sale_details.qty_remain / sale_details.rate) - parseInt(sale_details.qty_remain / sale_details.rate)) * sale_details.rate) != 0">
                                و
                                {{
                                  Math.floor(((sale_details.qty_remain / sale_details.rate) -
                                    parseInt(sale_details.qty_remain / sale_details.rate)) * sale_details.rate)
                                }}{{
  temx.name
}}
                              </span>

                            </span>
                          </div>

                        </td> -->


                        <td>
                          <input v-if="
                            sale_details.qty_return != sale_details.quantity
                          " v-model="check_state[index]" @change="
  add_one_return(
    sale_details.qty_remain,
    index,
    sale_details.product_id,
    sale_details.store_id,
    sale_details.status_id,
    sale_details.desc,
    [
      sale_details.unit_id,
      sale_details.rate,
      sale_details.unit_type
    ],
  )
" type="checkbox" class="btn btn-info waves-effect">
                        </td>
                      </tr>

                      <tr>
                        <td colspan="10">
                          <div class="m-t-30 col-md-12">
                            <label for="date">الاجمالي</label><br />
                            <input name="number" type="number" class="form-control" />


                          </div>
                        </td>
                      </tr>
                      <tr>

                        <td colspan="10">
                          <div class="m-t-30 col-md-12">
                            <label for="date">طريقه الدفع</label><br />


                            <select name="forma_pago" class="form-control" id="forma_pago">


                              <option v-bind:value="1">نقد</option>
                              <option v-bind:value="2">أجل</option>
                            </select>
                          </div>
                        </td>
                      </tr>
                      <tr>

                        <td colspan="10">
                          <div class="m-t-30 col-md-12">
                            <label for="date">التاريخ</label><br />

                            <input name="date" type="date" v-model="dateselected" class="form-control" />
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="10">
                          <div class="m-t-30 col-md-12">
                            <label for="date">ملاحظات</label><br />
                            <input v-model="note" type="text" name="name" id="name" class="form-control" />
                          </div>
                        </td>
                      </tr>

                      <a v-if="not_qty" @click="Add_return()" class="btn btn-success"><span>تاكيد العمليه</span></a>
                      <div v-if="seen" class="alert alert-warning" role="alert">
                        قم باضافه الكميه المرتجعه
                      </div>
                    </tbody>
                  </table>
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
      // detail: '',
      // sale_id: "",
      // seen: false,
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
      this.detail = response.data.sale_details;
      console.log(response);
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


    add_one_return(qty_return, index, product, store, status, desc, unit) {




      console.log(product, index);
      console.log(qty_return, index);
      console.log(unit, index);
      console.log(desc, index);
      console.log(store, index);
      console.log(status, index);

      if (this.check_state[index] == true) {


        this.counts[index] = index;
        this.product[index] = product;
        this.qty[index] = qty_return;
        this.unit[index] = unit;
        this.desc[index] = desc;
        this.store[index] = store;
        this.status[index] = status;





        // console.log(this.return_qty);

      } else if (this.check_state[index] == false) {

        this.$delete(this.counts, index);
        this.$delete(this.product, index);
        this.$delete(this.qty, index);
        this.$delete(this.unit, index);
        this.$delete(this.desc, index);
        this.$delete(this.store, index);
        this.$delete(this.status, index);

        // console.log(this.return_qty);
      }

    },

  },
  computed: {},
};
</script>

