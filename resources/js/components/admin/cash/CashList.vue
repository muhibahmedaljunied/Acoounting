<template>
  <div>
    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">

          <div class="card-header">
            <span class="h3">اوامر الصرف</span>


            <div style="display: flex;float: left; margin: 5px">
              <!-- <router-link to="NewCash" id="agregar_productos"
              class="tn btn-info btn-sm waves-effect btn-agregar"><i class="fa fa-plus-circle"></i></router-link> -->


              <input type="search" autocomplete="on" name="search" data-toggle="dropdown" role="button"
                aria-haspopup="true" aria-expanded="true" v-model="word_search" @input="get_search()" />


              <!-- 774899393 -->

            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table text-md-nowrap" id="example1">
                <thead>
                  <tr>
                    <th class="wd-15p border-bottom-0">رقم الفاتوره</th>
                    <th class="wd-15p border-bottom-0">جهه الصرف</th>
                    <!-- <th class="wd-15p border-bottom-0">الكميه </th> -->
                    <!-- <th class="wd-15p border-bottom-0">الكميه المرتحعه</th> -->
                    <th class="wd-15p border-bottom-0">تاريخ الصرف</th>
                    <th class="wd-15p border-bottom-0"> المدفوع</th>
                    <th class="wd-15p border-bottom-0">المتبقي</th>
                    <th class="wd-15p border-bottom-0">اجمالي الفاتوره</th>
                    <th class="wd-15p border-bottom-0">حاله الفاتوره</th>

                    <th class="wd-15p border-bottom-0">العمليات</th>
                  </tr>
                </thead>
                <tbody v-if="cashes && cashes.data.length > 0">
                  <tr v-for="(cash, index) in cashes.data" :key="index">
                    <td>{{ cash.paymentable.cash_id }} </td>

                    <td v-if="cash.payment_info == '1' || cash.payment_info == '2'"> {{ cash.paymentable.customer_name
                      }}</td>
                    <td v-else>{{ cash.paymentable.text }} {{ cash.paymentable.account_id }}</td>
                    <!-- <td>{{ cash.quantity }}</td>
                  <td>{{ cash.qty_return }}</td> -->
                    <td>{{ cash.paymentable.date }}</td>
                    <td>{{ cash.paid }}</td>
                    <td>{{ cash.remaining }}</td>
                    <td>{{ cash.paymentable.grand_total }}</td>
                    <!-- <td>{{ cash.cash_status }}</td> -->
                    <td>

                      <span class="badge bg-warning" v-if="cash.payment_status == 'pendding'">غير مدفوعه</span>
                      <span class="badge bg-success" v-if="cash.payment_status == 'paiding'">مدفوعه</span>
                      <span class="badge bg-info" v-if="cash.payment_status == 'partialy'">مدفوعه جزئيا</span>

                    </td>

                    <td>

                      <div class="optionbox">
                        <select @change="changeRoute(index)" v-model="operationselected[index]" name="العمليات"
                          class="form-control">
                          <option :selected="true" class="btn btn-success"
                            v-bind:value="['/cash_details/', cash.paymentable.cash_id, 0]">
                            تفاصيل
                          </option>
                          <option class="btn btn-success" v-bind:value="['return_cash', cash.paymentable, 1]">
                            ارجاع
                          </option>
                          <option class="btn btn-success"
                            v-bind:value="['returncashlist', cash.paymentable.cash_id, 2]">
                            مرتجعات
                          </option>

                          <option class="btn btn-success" v-bind:value="['cash_invoice', cash.paymentable.cash_id, 3]">
                            عرض الفاتوره
                          </option>
                          <option class="btn btn-success"
                            v-bind:value="['ReceivableBond', cash.paymentable.cash_id, 4]">
                            قبض
                          </option>
                          <option class="btn btn-success"
                            v-bind:value="['/cash_invoice_update/', cash.paymentable.cash_id, 5]">
                            تعديل الفاتوره
                          </option>

                          <option class="btn btn-success" v-bind:value="['cash_daily', cash.paymentable.cash_id, 6]">
                            عرض القيد المحاسبي
                          </option>

                        </select>
                      </div>


                      <!-- <router-link
                      :to="`/cash_details/${cash.paymentable.cash_id}`"
                      class="btn btn-success"
                    >
                      <span><i class="fa fa-search-plus"></i></span>
                    </router-link>

                    <router-link
                      :to="`/return_cash/${cash.paymentable.cash_id}`"
                      class="btn btn-success"
                    >
                      <span> ارجاع</span>
                    </router-link>
                     <router-link
                    :to="`/cash_invoice/${cash.paymentable.cash_id}`"
                        class="btn btn-success">
                    
                      <span>فاتوره</span>
                    </router-link> -->


                    </td>
                  </tr>
                </tbody>
                <tbody v-else>
                  <tr>
                    <td align="center" colspan="8">
                      <h3>
                        لايوجد اي مبيعات
                      </h3>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <pagination align="center" :data="cashes" @pagination-change-page="list"></pagination>
          </div>
        </div>
      </div>
    </div>
    <div class="row row-sm">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <span class="h2">تفاصيل الصرف</span>


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
                    <th class="wd-15p border-bottom-0"> الكميه </th>
                    <th class="wd-15p border-bottom-0"> السعر </th>
                    <!-- <th class="wd-15p border-bottom-0"> الاجمالي </th> -->
                    <!-- <th class="wd-15p border-bottom-0">  الكميه المرتحعه</th> -->

                  </tr>
                </thead>
                <tbody v-if="cash_detail && cash_detail.length > 0">
                  <tr v-for="(cash_details, index) in cash_detail">
                    <!-- <td>{{ cash_details.id }}</td> -->
                    <td>{{ cash_details.product }}</td>

                    <td>{{ cash_details.desc }}</td>
                    <td>{{ cash_details.status }}</td>
                    <td>{{ cash_details.store }}</td>

                    <!-- <td>{{ cash_details.qty }}</td>  -->
                    <td>


                      <div v-for="temx in cash_details.qty_after_convert['qty']">



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
                      <!-- {{ cash_details.qty }} {{ cash_details.unit }} -->
                    </td>
                    <td>{{ cash_details.price }}</td>
                    <!-- <td>{{ cash_details.total }}</td> -->
                    <!-- <td>{{ cash_details.qty_return }}</td> -->

                  </tr>

                  <!-- <tr>
                    <td colspan="7" style="text-align:center;color:red;font-size:large">الاجمالي</td>
                    <td>{{ total }}</td>
                  </tr> -->
                  <!-- <a 
                      @click="$router.go(-1)"
                      class="btn btn-success"
                      ><span> تراجع</span></a
                    > -->
                </tbody>
                <tbody v-else>
                  <tr>
                    <td align="center" colspan="8">
                      <h3>
                        لايوجد اي مبيعات
                      </h3>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>
<script>
import pagination from "laravel-vue-pagination";
export default {
  components: {
    pagination,
  },
  data() {
    return {
      cashes: {
        type: Object,
        default: null,
      },
      operationselected: [],
      cash_detail: '',
      total: 0,
      word_search: "",
      table: '',
      type: '',
    };
  },
  mounted() {
    this.type = 'Cash';
    this.table = 'cash_details';
    this.list();

  },
  methods: {
    changeRoute(index) {


      if (this.operationselected[index][2] == 0) {

        this.axios
          .post(this.operationselected[index][0] + this.operationselected[index][1], {
            table: this.table,
            type: this.type,
            operation: 'OperationQty'

          })
          .then((response) => {

            console.log(response.data);
            this.cash_detail = response.data.details;
            this.cash_detail.forEach((item) => {
              this.total = parseInt(item.total) + parseInt(this.total);
            });

          })
          .catch(({ response }) => {
            console.error(response);
          });

      } else {

        // this.$router.push(this.operationselected[index][0] + this.operationselected[index][1]);
        this.$router.push({
          name: this.operationselected[index][0],
          params: { data: this.operationselected[index][1] },
        });


      }

    },

    get_search() {
      this.axios
        .post(`/listcashesearch`, { word_search: this.word_search })
        .then(({ data }) => {
          // console.log(data);
          this.cashes = data.cashes;

          // this.$root.logo = "Category";
        });
    },
    list(page = 1) {
      this.axios
        .post(`/listcash?page=${page}`, { type: this.type })
        .then(({ data }) => {
          console.log(data.cashes);
          this.cashes = data.cashes;
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },

  },
};
</script>
<style scoped>
.optionbox select {
  background: #E62968;
  color: #fff;
  padding: 10px;
  width: 120px;
  height: 30px;
  border: none;
  font-size: 20px;
  box-shadow: 0 5px 18px rgb(93, 15, 9);
  -webkit-appearance: button;
  outline: none;
}
</style>
