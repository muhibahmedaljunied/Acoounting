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
            <input type="search" autocomplete="on" name="search" data-toggle="dropdown" role="button" aria-haspopup="true"
              aria-expanded="true" placeholder="بحث" v-model="word_search" @input="get_search()" />
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
                <tbody v-if="supplys && supplys.data.length > 0">
                  <tr v-for="(supply, index) in supplys.data" :key="index">
                    <td>{{ supply.supplys_id }}</td>
                    <td>{{ supply.supplier_name }}</td>
                    <!-- <td>{{ supply.quantity }}</td>
                  <td>{{ supply.qty_return }}</td> -->
                    <td>{{ supply.date }}</td>
                    <td>{{ supply.paid }}</td>
                    <td>{{ supply.remaining }}</td>
                    <td>{{ supply.grand_total }}</td>
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
                            supply.supplys_id,
                            0
                          ]">
                            تفاصيل
                          </option>
                          
                          <option class="btn btn-success" v-bind:value="[
                            'return_supply',
                            supply,
                            1
                          ]">
                            ارجاع
                          </option>
                          <option class="btn btn-success" v-bind:value="[
                            'returnsupplylist',
                            supply.supplys_id,
                            2
                          ]">
                            مرتجعات
                          </option>

                          <option class="btn btn-success" v-bind:value="[
                            '/supply_invoice/',
                            supply.supplys_id,
                            3
                          ]">
                            عرض الفاتوره
                          </option>
                          <!-- <option v-if="supply.payment_status != 'paiding'" class="btn btn-success"
                            v-bind:value="['/PaymentBond/', supply.supply_id, 4]">
                            دفع
                          </option> -->
                          <option class="btn btn-success" v-bind:value="['PaymentBond', supply.supply_id, 4]">
                            صرف
                          </option>
                          <option class="btn btn-success"
                            v-bind:value="['/supply_invoice_update/', supply.supply_id, 5]">
                            تعديل الفاتوره
                          </option>


                          <option class="btn btn-success" v-bind:value="['supply_daily', supply.supply_id, 6]">
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
            <pagination align="center" :data="supplys" @pagination-change-page="list"></pagination>
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
                <tbody v-if="supply_detail && supply_detail.length > 0">
                  <tr v-for="supply_details in supply_detail">
                    <!-- <td>{{ supply_details.id }}</td> -->
                    <td>{{ supply_details.product }}</td>
                    <td>{{ supply_details.desc }}</td>
                    <td>{{ supply_details.status }}</td>
                    <td>{{ supply_details.store }}</td>
                    <!-- <td>{{ supply_details.qty }} {{ supply_details.unit }}</td> -->
                    <td>

                      <div v-for="temx in supply_details.units">



                        <span v-if="temx.unit_type == 0">

                          <span v-if="supply_details.qty / supply_details.rate >= 1">
                            {{ Math.floor((supply_details.qty / supply_details.rate)) }}{{
                              supply_details.units[0].name
                            }}
                          </span>

                          <span v-if="supply_details.qty % supply_details.rate >= 1">
                            {{ Math.floor((supply_details.qty % supply_details.rate)) }}{{
                              supply_details.units[1].name
                            }}
                          </span>
                        </span>


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
      supplys: {
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
          .post(this.operationselected[index][0] + this.operationselected[index][1], { table: this.table })
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
        .post(`/listsupplysearch`, { word_search: this.word_search })
        .then(({ data }) => {
          console.log(data);
          this.supplys = data.supplys;
        });
    },
    list(page = 1) {

      // alert('dddddddddddddddddddddddddd');

      this.axios
        .post(`/listsupply?page=${page}`, { type: this.type })
        .then(({ data }) => {
          this.supplys = data.supplys;
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


