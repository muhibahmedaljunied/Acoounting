<template>
  <div>
    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header pb-0">

            <span class="h3"> اوامرالتوريد</span>
            <div style="display: flex;float: left; margin: 5px">

              <input type="search" autocomplete="on" name="search" data-toggle="dropdown" role="button"
                aria-haspopup="true" aria-expanded="true" placeholder="بحث" v-model="word_search"
                @input="get_search()" />


              <!-- 774899393 -->

            </div>

          </div>



          <div class="card-body">
            <div class="table-responsive">
              <table class="table text-md-nowrap" id="example1">
                <thead>
                  <tr>
                    <th class="wd-15p border-bottom-0">رقم الفاتوره</th>
                    <!-- <th class="wd-15p border-bottom-0">المورد</th> -->
                    <th class="wd-15p border-bottom-0">الحساب </th>
                    <!--<th class="wd-15p border-bottom-0">الكميه المرتحعه</th> -->
                    <th class="wd-15p border-bottom-0">تاريخ الشراء</th>

                    <th class="wd-15p border-bottom-0"> المدفوع</th>
                    <th class="wd-15p border-bottom-0">المتبقي</th>
                    <th class="wd-15p border-bottom-0">اجمالي الفاتوره</th>
                    <th class="wd-15p border-bottom-0">حاله الفاتوره</th>
                    <th class="wd-15p border-bottom-0">العمليات</th>
                  </tr>
                </thead>
                <tbody v-if="supplies && supplies.data.length > 0">
                  <tr v-for="(supply, index) in supplies.data" :key="index">
                    <td>{{ supply.paymentable.supply_id }}</td>
                    <td v-if="supply.payment_info == '1' || supply.payment_info == '2'"> {{
                  supply.paymentable.supplier_name }}</td>
                    <td v-else>{{ supply.paymentable.text }} {{ supply.paymentable.account_id }}</td>

                    <!-- <td>{{ supply.paymentable.supplier_name }}</td> -->
                    <!-- <td>{{ supply.paymentable.text }}</td> -->

                    <!-- <td>{{ supply.quantity }}</td>
                  <td>{{ supply.qty_return }}</td> -->
                    <td>{{ supply.paymentable.date }}</td>
                    <td>{{ supply.paid }}</td>
                    <td>{{ supply.remaining }}</td>
                    <td>{{ supply.paymentable.grand_total }}</td>
                    <td>

                      <span class="badge bg-warning" v-if="supply.payment_status == 'pendding'">غير مدفوعه</span>
                      <span class="badge bg-success" v-if="supply.payment_status == 'paiding'">مدفوعه</span>
                      <span class="badge bg-info" v-if="supply.payment_status == 'partialy'">مدفوعه جزئيا</span>

                    </td>

                    <td>
                      <div class="optionbox">
                        <select @change="changeRoute(index)" v-model="operationselected[index]" name="العمليات"
                          class="form-control">
                          <option :selected="true" class="btn btn-success" v-bind:value="[
                  '/supply_details/',
                  supply.paymentable.supply_id,
                  0
                ]">
                            تفاصيل
                          </option>

                          <option class="btn btn-success" v-bind:value="[
                  'return_supply',
                  supply.paymentable,
                  1
                ]">
                            ارجاع
                          </option>
                          <option class="btn btn-success" v-bind:value="[
                  'returnsupplylist',
                  supply.paymentable.supply_id,
                  2
                ]">
                            مرتجعات
                          </option>

                          <option class="btn btn-success" v-bind:value="[
                  'supply_invoice',
                  supply.paymentable.supply_id,
                  3
                ]">
                            عرض الفاتوره
                          </option>
                          <!-- <option v-if="supply.payment_status != 'paiding'" class="btn btn-success"
                            v-bind:value="['/PaymentBond/', supply.paymentable.supply_id, 4]">
                            دفع
                          </option> -->
                          <option v-if="supply.payment_status != 'paiding'" class="btn btn-success"
                            v-bind:value="['PaymentBond', supply.paymentable.supply_id, 4]">
                            صرف
                          </option>
                          <option class="btn btn-success"
                            v-bind:value="['/supply_invoice_update/', supply.paymentable.supply_id, 5]">
                            تعديل الفاتوره
                          </option>


                          <option class="btn btn-success"
                            v-bind:value="['supply_daily', supply.paymentable.supply_id, 6]">
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
                        لايوجد اي واردات
                      </h3>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <pagination align="center" :data="supplies" @pagination-change-page="list"></pagination>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <span class="h2">تفاصيل الوارد</span>


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

                    <th class="wd-15p border-bottom-0"> الكميه </th>
                    <!-- <th>الوحده</th> -->
                    <th class="wd-15p border-bottom-0"> السعر </th>
                    <!-- <th class="wd-15p border-bottom-0"> الاجمالي </th> -->

                    <!-- <th class="wd-15p border-bottom-0">  الكميه المرتحعه</th> -->


                  </tr>
                </thead>
                <tbody v-if="supply_detail && supply_detail.length > 0">
                  <tr v-for="(supply_details, index) in supply_detail">
                    <!-- <td>{{ supply_details.id }}</td> -->
                    <td>{{ supply_details.product }}</td>
                    <td>{{ supply_details.desc }}</td>
                    <td>{{ supply_details.status }}</td>
                    <td>{{ supply_details.store }}</td>
                    <!-- <td>{{ supply_details.qty }} {{ supply_details.unit }}</td> -->
                    <td>

                      <div v-for="temx in supply_details.qty_after_convert['qty']">



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

                    <!-- <td>{{ supply_details.unit }}</td> -->
                    <td>{{ supply_details.price }}</td>
                    <!-- <td>{{ supply_details.total }}</td> -->
                    <!-- <td>{{ supply_details.qty_return }}</td> -->



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
      supplies: {
        type: Object,
        default: null,
      },
      supply_detail: '',
      operationselected: [],
      total: 0,
      word_search: "",
      table: 'supply_details',
      type: '',
    };
  },
  mounted() {
    this.type = 'Supply';
    this.list();
  },
  methods: {

    changeRoute(index) {



      console.log(this.operationselected[index][0]);


      if (this.operationselected[index][2] == 0) {


        this.axios
          .post(this.operationselected[index][0] + this.operationselected[index][1], {
            table: this.table,
            type: this.type,
            operation: 'OperationQty'

          })
          .then((response) => {
            console.log(response);
            this.supply_detail = response.data.details;

            this.supply_detail.forEach((item) => {
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
        .post(`/listsuppliesearch`, { word_search: this.word_search })
        .then(({ data }) => {
          console.log(data);
          this.supplies = data.supplies;
        });
    },
    list(page = 1) {

      // alert('dddddddddddddddddddddddddd');

      this.axios
        .post(`/listsupply?page=${page}`, { type: this.type })
        .then(({ data }) => {
          console.log(data.supplies);
          this.supplies = data.supplies;
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
