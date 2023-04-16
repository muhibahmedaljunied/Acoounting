<template>
  <div>
    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header pb-0">

            <div class="d-flex justify-content-right">
              <span class="h2"> مرتجع المشتريات</span>
            </div>
          </div>


          <div class="d-flex justify-content-right">


            <div class="form-group">
              <input type="search" autocomplete="on" name="search" role="button" placeholder="بحث  بالرقم"
                v-model="word_search" @input="get_search()" />
            </div>
          </div>

          <div class="card-body">
            <div class="table-responsive">
              <table class="table text-md-nowrap" id="example1">
                <thead>
                  <tr>
                    <!-- <th class="wd-15p border-bottom-0">رقم التوريد</th> -->
                    <th class="wd-15p border-bottom-0">رقم السند</th>
                    <th class="wd-15p border-bottom-0">المورد</th>
                    <!-- <th class="wd-15p border-bottom-0"> الكميه المرتجعه</th> -->
                    <th class="wd-15p border-bottom-0">تاريخ المرتجع</th>
                    <th class="wd-15p border-bottom-0">سبب الارجاع </th>

                    <th class="wd-15p border-bottom-0">العمليات</th>
                  </tr>
                </thead>
                <tbody v-if="return_purchases && return_purchases.data.length > 0">
                  <tr v-for="(return_purchase, index) in return_purchases.data" :key="index">
                    <!-- <td>{{ return_purchase.supply_id }}</td> -->
                    <td>{{ return_purchase.return_id }}</td>
                    <td>{{ return_purchase.supplier_name }}</td>
                    <!-- <td>{{ return_purchase.qty_return }}</td> -->
                    <td>{{ return_purchase.return_date }}</td>
                    <td>{{ return_purchase.note }}</td>
                    <td>
                      <!-- <button

                    @click="supply_details(supplies.id)"
                      type="button"
    
                      class="btn btn-danger"
                    >
                      <i class="mdi mdi-account-minus"></i>
                    </button> -->

                      <!-- <router-link
                      :to="`/return_purchase_details/${return_purchase.return_id}`"
                      class="btn btn-success"
                    >
                      <span><i class="fa fa-search-plus"></i></span>
                    </router-link>
                     <router-link
                    :to="`/return_purchase_invoice/${return_purchase.return_id}`"
                        class="btn btn-success">
                    
                      <span>فاتوره</span>
                    </router-link> -->


                      <div class="optionbox">

                        <select @change="changeRoute(index)" v-model="operationselected[index]" name="العمليات"
                          class="form-control">
                          <option class="btn btn-success"
                            v-bind:value="['/returnpurchase_details/', return_purchase.return_id, 0]">
                            تفاصيل
                          </option>


                          <option class="btn btn-success"
                            v-bind:value="['/return_purchase_invoice/', return_purchase.return_id, 1]">
                            سند مرتجع شراء
                          </option>
                          <option class="btn btn-success"
                            v-bind:value="['/return_purchase_recive/', return_purchase.return_id, 2]">
                            سند استلام مرتجع شراء
                          </option>
                          <option class="btn btn-success"
                            v-bind:value="['/return_purchase_invoice_cancel/', return_purchase.purchase_id, 3]">
                            الفاء الفاتوره
                          </option>
                          <option class="btn btn-success"
                            v-bind:value="['/return_purchase_invoice_update/', return_purchase.purchase_id, 3]">
                            تعديل الفاتوره
                          </option>


                        </select>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <pagination align="center" :data="return_purchases" @pagination-change-page="list"></pagination>
          </div>
        </div>
      </div>
    </div>
    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header pb-0">

            <span class="h2">تفاصيل مرتجع الشراء</span>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table text-md-nowrap" id="example1">
                <thead>
                  <tr>
                    <th class="wd-15p border-bottom-0">#</th>
                    <!-- <th class="wd-15p border-bottom-0">رقم المرتجع</th> -->
                    <th class="wd-15p border-bottom-0">المنتج</th>
                    <th class="wd-15p border-bottom-0">الحاله</th>
                    <th>المواصفات والطراز</th>
                    <th class="wd-15p border-bottom-0"> الكميه المرتجعه</th>
                    <th class="wd-15p border-bottom-0">المخزن</th>



                  </tr>
                </thead>
                <tbody v-if="return_detail && return_detail.length > 0">
                  <tr v-for="(return_details, index) in return_detail" :key="index">
                    <td>{{ index+ 1}}</td>
                    <!-- <td>{{ return_details.supply_return_id }}</td> -->
                    <td>{{ return_details.product_name }}</td>
                    <td>{{ return_details.status }}</td>
                    <td>{{ return_details.desc }}</td>
                    <!-- <td>{{ return_details.qty_return }}</td> -->

                    <td>

                      <div v-for="temx in return_details.units">

                        <span v-if="temx.name == return_details.unit">

                          <span v-if="temx.unit_type == 1">

                            {{ return_details.qty_return }} {{ temx.name }}

                          </span>

                          <span v-if="temx.unit_type == 0">

                            <span v-if="return_details.qty_return / return_details.rate >= 1">
                              {{ Math.floor((return_details.qty_return / return_details.rate)) }}{{
                                return_details.units[0].name
                              }}
                            </span>

                            <span v-if="return_details.qty_return % return_details.rate >= 1">
                              و
                              {{ Math.floor((return_details.qty_return % return_details.rate)) }}{{
                                return_details.units[1].name
                              }}
                            </span>
                          </span>

                        </span>



                      </div>

                    </td>

                    <!-- <td>
                      <div v-for="temx in return_details.units">

                        <span v-if="temx.unit_type == 1">
                          {{ parseInt(return_details.qty_return / return_details.rate) }} {{ temx.name }}
                        </span>
                        <span v-if="temx.unit_type == 0">
                          <span
                            v-if="Math.floor(((return_details.qty_return / return_details.rate) - parseInt(return_details.qty_return / return_details.rate)) * return_details.rate) != 0">
                            و
                            {{ Math.floor(((return_details.qty_return / return_details.rate) - parseInt(return_details.qty_return / return_details.rate)) * return_details.rate) }}{{
                              temx.name
                            }}
                          </span>

                        </span>
                      </div>

                    </td> -->
                    <td>{{ return_details.text }}</td>






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
import pagination from "laravel-vue-pagination";
export default {
  components: {
    pagination,
  },
  data() {
    return {
      // return_purchase: "yes",

      return_purchases: {
        type: Object,
        default: null,
      },
      word_search: "",
      operationselected: [],
      return_detail: '',
      table:'',


    };
  },
  mounted() {

    this.table = 'purchase';
    this.list();
  },
  methods: {
    changeRoute(index) {


      // alert(index);
      console.log(this.operationselected[index][0]);


      if (this.operationselected[index][2] == 0) {

        this.axios
          .post(this.operationselected[index][0] + this.operationselected[index][1],{ table: this.table })
          .then((response) => {
            console.log(response.data.return_details);
            this.return_detail = response.data.return_details;

          })
          .catch(({ response }) => {
            console.error(response);
          });

      } else {

        this.$router.push(this.operationselected[index][0] + this.operationselected[index][1]);
      }

    },
    get_search(word_search) {
      this.axios
        .post(`/listreturn_purchasesearch`, { word_search: this.word_search })
        .then(({ data }) => {
          this.return_purchases = data.return_purchases;

          // this.$root.logo = "Category";
        });
    },
    list(page = 1) {
      this.axios
        .post(`/listreturn_purchase/${this.$route.params.id}`)
        .then(({ data }) => {
          console.log(data.returns);
          this.return_purchases = data.returns;

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

