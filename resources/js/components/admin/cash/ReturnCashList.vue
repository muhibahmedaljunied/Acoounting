<template>
  <div>
    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header pb-0">

            <span class="h2"> مرتجع صرف</span>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table text-md-nowrap" id="example1">
                <thead>
                  <tr>
                    <th class="wd-15p border-bottom-0">رقم السند</th>
                    <th class="wd-15p border-bottom-0">العميل</th>
                    <th class="wd-15p border-bottom-0">الكميه</th>
                    <th class="wd-15p border-bottom-0">تاريخ المرتجع</th>
                    <th class="wd-15p border-bottom-0">سبب الارجاع </th>
                    <th class="wd-15p border-bottom-0">العمليات</th>
                  </tr>
                </thead>
                <tbody v-if="return_cash && return_cash.length > 0">
                  <tr v-for="return_cashs in return_cash">
                    <td>{{ return_cashs.return_id }}</td>
                    <td>{{ return_cashs.customer_name }}</td>

                    <td>{{ return_cashs.quantity_return }}</td>


                    <td>{{ return_cashs.return_date }}</td>
                    <td>{{ return_cashs.note }}</td>
                    <td>
                      <!-- <button

                    @click="supply_details(supplies.id)"
                      type="button"
    
                      class="btn btn-danger"
                    >
                      <i class="mdi mdi-account-minus"></i>
                    </button> -->

                      <!-- <router-link
                      :to="`/return_cash_details/${return_cashs.return_id}`"
                      class="btn btn-success"
                    >
                      <span><i class="fa fa-search-plus"></i></span>
                    </router-link>
                           <router-link
                    :to="`/return_cash_invoice/${return_cashs.return_id}`"
                        class="btn btn-success">
                    
                      <span>فاتوره</span>
                    </router-link> -->



                      <div class="optionbox">
                        <select @change="changeRoute(index)" v-model="operationselected[index]" name="العمليات"
                          class="form-control">
                          <option class="btn btn-success"
                            v-bind:value="['/returncash_details/', return_cashs.return_id, 0]">
                            تفاصيل
                          </option>


                          <option class="btn btn-success"
                            v-bind:value="['/return_cash_invoice/', return_cashs.return_id, 1]">
                            سند مرتجع مبيعات
                          </option>
                          <option class="btn btn-success"
                            v-bind:value="['/return_cash_recive/', return_cashs.return_id, 2]">
                            سند استلام مرتجع مبيعات
                          </option>
                          <option class="btn btn-success"
                            v-bind:value="['/return_cash_invoice_cancel/', return_cashs.cash_id, 3]">
                            الفاء الفاتوره
                          </option>
                          <option class="btn btn-success"
                            v-bind:value="['/return_cash_invoice_update/', return_cashs.cash_id, 4]">
                            تعديل الفاتوره
                          </option>
                          <option class="btn btn-success" v-bind:value="['return_cash_daily', return_cashs.return_id, 5]">
                            عرض القيد المحاسبي
                          </option>
                        </select>
                      </div>



                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

    </div>
    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header pb-0">

            <span class="h2">تفاصيل مرتجع المبيعات</span>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table text-md-nowrap" id="example1">
                <thead>
                  <tr>
                    <!-- <th class="wd-15p border-bottom-0">رقم المرتجع</th> -->
                    <th class="wd-15p border-bottom-0">المنتج</th>
                    <th class="wd-15p border-bottom-0">الحاله</th>
                    <th>المواصفات والطراز</th>
                    <th class="wd-15p border-bottom-0">الكميه</th>
                    <th class="wd-15p border-bottom-0">المخزن</th>

                  </tr>
                </thead>

                <tbody v-if="return_detail && return_detail.length > 0">
                  <tr v-for="return_details in return_detail">
                    <!-- <td>{{ return_details.supply_return_id }}</td> -->
                    <td>{{ return_details.product_name }}</td>
                    <td>{{ return_details.status }}</td>
                    <td>{{ return_details.desc }}</td>
                    <!-- <td>{{ return_details.qty_return }}</td> -->
                    <td>
                      <div v-for="temx in return_details.units">

                        <span v-if="temx.unit_type == 1">
                          {{ parseInt(return_details.qty_return / return_details.rate) }} {{ temx.name }}
                        </span>
                        <span v-if="temx.unit_type == 0">
                          <span
                            v-if="Math.floor(((return_details.qty_return / return_details.rate) - parseInt(return_details.qty_return / return_details.rate)) * return_details.rate) != 0">
                            و
                            {{
                              Math.floor(((return_details.qty_return / return_details.rate) -
                                parseInt(return_details.qty_return / return_details.rate)) * return_details.rate)
                            }}{{
  temx.name
}}
                          </span>

                        </span>
                      </div>

                    </td>

                    <td>{{ return_details.code }}</td>






                  </tr>

                </tbody>
                <tbody v-else>
                  <tr>
                    <td align="center" colspan="3">
                      <h3>لايوجد اي مرتجعات</h3>
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
export default {
  data() {
    return {
      return_cash: "yes",
      return_detail: '',
      operationselected: [],
      type: '',
      index: '',
    };
  },
  props: ['data'],

  mounted() {

    this.table = 'cash';

    this.axios.post(`/listreturn_cash/${this.data}`).then((response) => {
      this.return_cash = response.data.returns;

    });
  },
  methods: {
    changeRoute(index) {


      if (this.operationselected[index][2] == 0) {

        this.axios
          .post(this.operationselected[index][0] + this.operationselected[index][1], { table: this.table,operation:'OperationQty'
 })
          .then((response) => {

            this.return_detail = response.data.return_details;

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



