<template>
  <div>
    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
              <span class="h2"> المشتريات</span>
            </div>

            <div class="d-flex justify-content-between"></div>
            <input type="search" autocomplete="on" name="search" data-toggle="dropdown" role="button"
              aria-haspopup="true" aria-expanded="true" placeholder="بحث" v-model="word_search" @input="get_search()" />
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table text-md-nowrap" id="example1">
                <thead>
                  <tr>
                    <th class="wd-15p border-bottom-0">رقم الفاتوره</th>
                    <th class="wd-15p border-bottom-0">المورد</th>
                    <!-- <th class="wd-15p border-bottom-0">الكميه </th>
                  <th class="wd-15p border-bottom-0">الكميه المرتحعه</th> -->
                    <th class="wd-15p border-bottom-0">تاريخ الشراء</th>

                    <th class="wd-15p border-bottom-0"> المدفوع</th>
                    <th class="wd-15p border-bottom-0">المتبقي</th>
                    <th class="wd-15p border-bottom-0">اجمالي الفاتوره</th>
                    <th class="wd-15p border-bottom-0">حاله الفاتوره</th>
                    <th class="wd-15p border-bottom-0">العمليات</th>
                  </tr>
                </thead>
                <tbody v-if="purchases && purchases.data.length > 0">
                  <tr v-for="(purchase, index) in purchases.data" :key="index">
                    <td>{{ purchase.paymentable.purchase_id }}</td>
                    <td>{{ purchase.paymentable.supplier_name }}</td>
                    <!-- <td>{{ purchase.quantity }}</td>
                  <td>{{ purchase.qty_return }}</td> -->
                    <td>{{ purchase.paymentable.date }}</td>
                    <td>{{ purchase.paid }}</td>
                    <td>{{ purchase.remaining }}</td>
                    <td>{{ purchase.paymentable.grand_total }}</td>
                    <td>

                      <span class="badge bg-warning" v-if="purchase.payment_status == 'pendding'">غير مدفوعه</span>
                      <span class="badge bg-success" v-if="purchase.payment_status == 'paiding'">مدفوعه</span>
                      <span class="badge bg-info" v-if="purchase.payment_status == 'partialy'">مدفوعه جزئيا</span>

                    </td>

                    <td>
                      <div class="optionbox">
                        <select @change="changeRoute(index)" v-model="operationselected[index]" name="العمليات"
                          class="form-control">
                          <option :selected="true" class="btn btn-success" v-bind:value="[
                '/purchase_details/',
                purchase.paymentable.purchase_id,
                0
              ]">
                            تفاصيل
                          </option>

                          <option class="btn btn-success" v-bind:value="[
                'return_purchase',
                purchase.paymentable,
                1
              ]">
                            ارجاع
                          </option>
                          <option class="btn btn-success" v-bind:value="[
                'returnpurchaselist',
                purchase.paymentable.purchase_id,
                2
              ]">
                            مرتجعات
                          </option>

                          <option class="btn btn-success" v-bind:value="[
                'purchase_invoice',
                purchase.paymentable.purchase_id,
                3
              ]">
                            عرض الفاتوره
                          </option>
                          <!-- <option v-if="purchase.payment_status != 'paiding'" class="btn btn-success"
                            v-bind:value="['/PaymentBond/', purchase.paymentable.purchase_id, 4]">
                            دفع
                          </option> -->
                          <option v-if="purchase.payment_status != 'paiding'" class="btn btn-success"
                            v-bind:value="['PaymentBond', purchase.paymentable.purchase_id, 4]">
                            صرف
                          </option>
                          <option class="btn btn-success"
                            v-bind:value="['/purchase_invoice_update/', purchase.paymentable.purchase_id, 5]">
                            تعديل الفاتوره
                          </option>


                          <option class="btn btn-success"
                            v-bind:value="['purchase_daily', purchase.paymentable.purchase_id, 6]">
                            عرض القيد المحاسبي
                          </option>
                        </select>
                      </div>


                    </td>
                  </tr>
                </tbody>
                <tbody v-else>
                  <tr>
                    <td align="center" colspan="8">
                      <h3>
                        لايوجد اي مشتريات
                      </h3>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <pagination align="center" :data="purchases" @pagination-change-page="list"></pagination>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <span class="h2">تفاصيل الشراء</span>


          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <!-- <th>  رقم الفاتوره </th> -->
                    <th>اسم المنتج</th>
                    <th> المواصفات والطراز</th>
                    <th>الحاله</th>
                    <th>المخزن</th>

                    <th class="wd-15p border-bottom-0"> كميه الشراء</th>
                    <!-- <th>الوحده</th> -->
                    <th class="wd-15p border-bottom-0"> السعر </th>
                    <!-- <th class="wd-15p border-bottom-0"> الاجمالي </th> -->

                    <!-- <th class="wd-15p border-bottom-0">  الكميه المرتحعه</th> -->


                  </tr>
                </thead>
                <tbody v-if="purchase_detail && purchase_detail.length > 0">
                  <tr v-for="purchase_details in purchase_detail">
                    <!-- <td>{{ purchase_details.id }}</td> -->
                    <td>{{ purchase_details.product }}</td>
                    <td>{{ purchase_details.desc }}</td>
                    <td>{{ purchase_details.status }}</td>
                    <td>{{ purchase_details.store }}</td>
                    <!-- <td>{{ purchase_details.qty }} {{ purchase_details.unit }}</td> -->
                    <td>


                      <div v-for="temx in purchase_details.qty_after_convert['qty']">



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


                    </td>

                    <!-- <td>{{ purchase_details.unit }}</td> -->
                    <td>{{ purchase_details.price }}</td>
                    <!-- <td>{{ purchase_details.total }}</td> -->
                    <!-- <td>{{ purchase_details.qty_return }}</td> -->



                  </tr>
                  <!-- <tr>

                    <td colspan="7" style="text-align:center;color:red;font-size:large">الاجمالي</td>
                    <td>{{ total }}</td>
                  </tr> -->

                </tbody>
                <tbody v-else>
                  <tr>
                    <td align="center" colspan="8">
                      <h3>
                        لايوجد اي مشتريات
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
      purchases: {
        type: Object,
        default: null,
      },
      purchase_detail: '',
      operationselected: [],
      total: 0,
      word_search: "",
      table: 'purchase_details',
      type: '',
    };
  },
  mounted() {
    this.type = 'Purchase';
    this.list();
  },
  methods: {

    changeRoute(index) {



      console.log(this.operationselected[index][0]);


      if (this.operationselected[index][2] == 0) {


        this.axios
          .post(this.operationselected[index][0] + this.operationselected[index][1], { table: this.table,
            type: this.type,
            operation:'OperationQty'
           })
          .then((response) => {
            console.log(response);
            this.purchase_detail = response.data.details;

            this.purchase_detail.forEach((item) => {
              this.total = parseInt(item.total) + parseInt(this.total);
            });

          })
          .catch(({ response }) => {
            console.error(response);
          });

      } else {

        // console.log(this.operationselected[index][0]);
        // this.$router.push(this.operationselected[index][0] + this.operationselected[index][1]);
        this.$router.push({
          name: this.operationselected[index][0],
          params: { data: this.operationselected[index][1] },
        });

      }

    },
    get_search() {
      this.axios
        .post(`/listpurchasesearch`, { word_search: this.word_search })
        .then(({ data }) => {
          console.log(data);
          this.purchases = data.purchases;
        });
    },
    list(page = 1) {

      // alert('dddddddddddddddddddddddddd');

      this.axios
        .post(`/listpurchase?page=${page}`, { type: this.type })
        .then(({ data }) => {
          console.log(data.purchases);
          this.purchases = data.purchases;
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
