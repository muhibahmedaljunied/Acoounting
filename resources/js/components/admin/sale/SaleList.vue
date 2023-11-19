<template>
  <div>
    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
              <span class="h2"> المبيعات</span>
            </div>
            <p class="tx-12 tx-gray-500 mb-2">
              Example of Valex Simple Table. <a href="">Learn more</a>
            </p>
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
                    <th class="wd-15p border-bottom-0">العميل</th>
                    <!-- <th class="wd-15p border-bottom-0">الكميه </th> -->
                    <!-- <th class="wd-15p border-bottom-0">الكميه المرتحعه</th> -->
                    <th class="wd-15p border-bottom-0">تاريخ البيع</th>
                    <th class="wd-15p border-bottom-0"> المدفوع</th>
                    <th class="wd-15p border-bottom-0">المتبقي</th>
                    <th class="wd-15p border-bottom-0">اجمالي الفاتوره</th>
                    <th class="wd-15p border-bottom-0">حاله الفاتوره</th>

                    <th class="wd-15p border-bottom-0">العمليات</th>
                  </tr>
                </thead>
                <tbody v-if="sales && sales.data.length > 0">
                  <tr v-for="(sale, index) in sales.data" :key="index">
                    <td>{{ sale.sale_id }}</td>
                    <td>{{ sale.customer_name }}</td>
                    <!-- <td>{{ sale.quantity }}</td>
                  <td>{{ sale.qty_return }}</td> -->
                    <td>{{ sale.sale_date }}</td>
                    <td>{{ sale.paid }}</td>
                    <td>{{ sale.remaining }}</td>
                    <td>{{ sale.grand_total }}</td>
                    <!-- <td>{{ sale.sale_status }}</td> -->
                    <td>

                      <span class="badge bg-warning" v-if="sale.payment_status == 'pendding'">معلقه</span>
                      <span class="badge bg-success" v-if="sale.payment_status == 'paiding'">مدفوعه</span>
                      <span class="badge bg-info" v-if="sale.payment_status == 'Partially'">مدفوعه جزئيا</span>

                    </td>

                    <td>

                      <div class="optionbox">
                        <select @change="changeRoute(index)" v-model="operationselected[index]" name="العمليات"
                          class="form-control">
                          <option :selected="true" class="btn btn-success"
                            v-bind:value="['/sale_details/', sale.sale_id, 0]">
                            تفاصيل
                          </option>
                          <option class="btn btn-success" v-bind:value="['/return_sale/', sale.sale_id, 1]">
                            ارجاع
                          </option>
                          <option class="btn btn-success" v-bind:value="['/returnsalelist/', sale.sale_id, 2]">
                            مرتجعات
                          </option>

                          <option class="btn btn-success" v-bind:value="['/sale_invoice/', sale.sale_id, 3]">
                            عرض الفاتوره
                          </option>
                          <option class="btn btn-success" v-bind:value="['/ReceivableBond/', sale.sale_id, 4]">
                            دفع
                          </option>
                          <option class="btn btn-success" v-bind:value="['/sale_invoice_update/', sale.sale_id, 5]">
                            تعديل الفاتوره
                          </option>

                          <option class="btn btn-success" v-bind:value="['/sale_invoice_update/', sale.sale_id, 6]">
                            عرض القيد المحاسبي
                          </option>

                        </select>
                      </div>


                      <!-- <router-link
                      :to="`/sale_details/${sale.sale_id}`"
                      class="btn btn-success"
                    >
                      <span><i class="fa fa-search-plus"></i></span>
                    </router-link>

                    <router-link
                      :to="`/return_sale/${sale.sale_id}`"
                      class="btn btn-success"
                    >
                      <span> ارجاع</span>
                    </router-link>
                     <router-link
                    :to="`/sale_invoice/${sale.sale_id}`"
                        class="btn btn-success">
                    
                      <span>فاتوره</span>
                    </router-link> -->


                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <pagination align="center" :data="sales" @pagination-change-page="list"></pagination>
          </div>
        </div>
      </div>
    </div>
    <div class="row row-sm">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <span class="h2">تفاصيل لبيع</span>


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
                    <th class="wd-15p border-bottom-0"> الكميه المباعه</th>
                    <th class="wd-15p border-bottom-0"> السعر </th>
                    <th class="wd-15p border-bottom-0"> الاجمالي </th>
                    <!-- <th class="wd-15p border-bottom-0">  الكميه المرتحعه</th> -->

                  </tr>
                </thead>
                <tbody>
                  <tr v-for="sale_details in sale_detail">
                    <!-- <td>{{ sale_details.id }}</td> -->
                    <td>{{ sale_details.product }}</td>

                    <td>{{ sale_details.desc }}</td>
                    <td>{{ sale_details.status }}</td>
                    <td>{{ sale_details.store }}</td>

                    <!-- <td>{{ sale_details.qty }}</td>  -->
                    <td>{{ sale_details.qty }} {{ sale_details.unit }}</td>
                    <td>{{ sale_details.price }}</td>
                    <td>{{ sale_details.total }}</td>
                    <!-- <td>{{ sale_details.qty_return }}</td> -->

                  </tr>

                  <tr>
                    <td colspan="7" style="text-align:center;color:red;font-size:large">الاجمالي</td>
                    <td>{{ total }}</td>
                  </tr>
                  <!-- <a 
                      @click="$router.go(-1)"
                      class="btn btn-success"
                      ><span> تراجع</span></a
                    > -->
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
      sales: {
        type: Object,
        default: null,
      },
      operationselected: [],
      sale_detail: '',
      total: 0,
      word_search: "",
      table: '',
      type:'',
    };
  },
  mounted() {
    this.type = 'Purchase';
    this.table = 'sale_details';
    this.list();

  },
  methods: {
    changeRoute(index) {


      if (this.operationselected[index][2] == 0) {

        this.axios
          .post(this.operationselected[index][0] + this.operationselected[index][1], { table: this.table })
          .then((response) => {

            console.log(response.data);
            this.sale_detail = response.data.details;
            this.sale_detail.forEach((item) => {
              this.total = parseInt(item.total) + parseInt(this.total);
            });

          })
          .catch(({ response }) => {
            console.error(response);
          });

      } else {

        this.$router.push(this.operationselected[index][0] + this.operationselected[index][1]);
      }

    },

    get_search() {
      this.axios
        .post(`/listsalesearch`, { word_search: this.word_search })
        .then(({ data }) => {
          // console.log(data);
          this.sales = data.sales;

          // this.$root.logo = "Category";
        });
    },
    list(page = 1) {
      this.axios
        .post(`/listsale?page=${page}`,{ type: this.type })
        .then(({ data }) => {
          //  console.log(data.sales);
          this.sales = data.sales;
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


