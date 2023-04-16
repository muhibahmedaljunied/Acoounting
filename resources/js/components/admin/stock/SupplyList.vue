<template>
  <div>
    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
              <span class="h2"> الوارد</span>
            </div>
            <p class="tx-12 tx-gray-500 mb-2">

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
                    <!-- <th class="wd-15p border-bottom-0">#</th> -->
                    <th class="wd-15p border-bottom-0">رقم السند</th>
                    <th class="wd-15p border-bottom-0">المورد</th>
                    <!-- <th class="wd-15p border-bottom-0">الكميه الوارده</th> -->
                    <!-- <th class="wd-15p border-bottom-0">الكميه المرتحعه</th> -->
                    <th class="wd-15p border-bottom-0">تاريخ التوريد</th>
                    <th class="wd-15p border-bottom-0">العمليات</th>
                  </tr>
                </thead>
                <tbody v-if="supplies && supplies.data.length > 0">
                  <tr v-for="(supply, index) in supplies.data" :key="index">
                    <!-- <td>{{ index + 1 }}</td> -->
                    <td>{{ supply.supply_id }}</td>
                    <td>
                      {{ supply.supplier_name }} <br />
                      {{ supply.last_name }}
                    </td>

                    <!-- <td>{{ supply.quantity }}</td> -->
                    <!-- <td>{{ supply.qty_return }}</td> -->
                    <td>{{ supply.date }}</td>

                    <td>
                      <!-- 
                      <div class="optionbox">

           <select   @change="changeRoute(index)"  v-model="operationselected[index]"  name="العمليات"  class="form-control" >
      <option   class="btn btn-success"   v-bind:value="['/returnsupply_details/',return_supply.return_id,0]">
                      تفاصيل
                    </option>
   
 
      <option   class="btn btn-success" v-bind:value="['/return_supply_invoice/',return_supply.return_id,1]">
                      سند مرتجع توريد
                 </option>
      <option  class="btn btn-success"  v-bind:value="['/return_supply_recive/',return_supply.return_id,2]">
                      سند استلام
                   </option>
    
  </select>
  </div> -->

                      <div class="optionbox">
                        <select @change="changeRoute(index)" v-model="operationselected[index]" name="العمليات"
                          class="form-control">
                          <option :selected="true" class="btn btn-success" v-bind:value="[
                            '/supply_details/',
                            supply.supply_id,
                            0
                          ]">
                            تفاصيل
                          </option>
                          <option class="btn btn-success" v-bind:value="['/returnsupply/', supply.supply_id, 1]">
                            ارجاع
                          </option>
                          <option class="btn btn-success" v-bind:value="[
                            '/returnsupplylist/',
                            supply.supply_id,
                            2
                          ]">
                            مرتجعات
                          </option>
                          <option class="btn btn-success" v-bind:value="[
                            '/supply_invoice/',
                            supply.supply_id,
                            3
                          ]">
                            سند توريد
                          </option>
                          <option class="btn btn-success" v-bind:value="['/supply_recive/', supply.supply_id, 4]">
                            سند استلام
                          </option>
                        <option :selected="true" class="btn btn-success" v-bind:value="[
                            '/supply_invoice_cancel/',
                            supply.supply_id,
                            5
                          ]">
                            الغاء السند
                          </option>
                          <option class="btn btn-success"
                            v-bind:value="['/supply_invoice_update/', supply.supply_id, 6]">
                            تعديل السند
                          </option>

                        </select>
                      </div>

                      <!-- 
                    <router-link
                      :to="`/supply_details/${supply.supply_id}`"
                      class="btn btn-success"
                    >
                      تفاصيل
                    </router-link> 

                    <router-link v-if="supply.quantity != supply.qty_return"
                      :to="`/returnsupply/${supply.supply_id}`"
                      class="btn btn-success"
                    >
                      <span>ارجاع</span>
                    </router-link>
                     <router-link
                   :to="`/return_supply_details/${supply.supply_id}`"
                      class="btn btn-success"
                    >
                      <span>المرتجعات</span>
                    </router-link>
                    <router-link
                      :to="`/supply_invoice/${supply.supply_id}`"
                      class="btn btn-success"
                    >
                      <span>سند توريد</span>
                    </router-link>
                    <router-link
                      :to="`/supply_recive/${supply.supply_id}`"
                      class="btn btn-success"
                    >
                      <span>سند استلام</span>
                    </router-link> -->
                    </td>
                  </tr>
                </tbody>
                <tbody v-else>
                  <tr>
                    <td align="center" colspan="4">
                      <h3> لايوجد واردات </h3>
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
    <div id="dialog-modal" class="row">
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
                    <th>#</th>
                    <th>اسم المنتج</th>
                    <th>الصوره</th>
                    <th>الحاله</th>
                    <th>المواصفات والطراز</th>
                    <th class="wd-15p border-bottom-0">الكميه الوارده</th>
                    <!-- <th class="wd-15p border-bottom-0">الكميه المرتحعه</th> -->
                    <th>المخزن</th>
                    <!-- <th>الرف</th> -->
                  </tr>
                </thead>
                <tbody v-if="supply_detail && supply_detail.length > 0">
                  <tr v-for="(supply_details, index) in supply_detail" :key="index">
                    <td>{{ index + 1 }}</td>
                    <td>{{ supply_details.product }}</td>
                    <td>
                      <img :src="`assets/upload/` + supply_details.image" height="50px" alt="products image" />
                    </td>
                    <td>{{ supply_details.status }}</td>
                    <td>{{ supply_details.desc }}</td>
                    <td>{{ supply_details.qty }}</td>
                    <!-- <td>{{ supply_details.qty_return }}</td> -->
                    <td>{{ supply_details.store }}</td>
                    <!-- <td>{{ supply_details.shelve_name }}</td> -->
                  </tr>
                </tbody>
                <tbody v-else>
                  <tr>
                    <td align="center" colspan="8">
                      <h3> لايوجد بيانات </h3>
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
      // supply: "yes",

      supplies: {
        type: Object,
        default: null,
      },
      supply_detail: '',

      operationselected: [],
      word_search: "",
      table:'supply_details',
    };
  },
  mounted() {
    this.list();
  },
  methods: {
    //  changeRoute(index) {
    //    console.log(this.operationselected[index][0]);
    //              this.$router.push(this.operationselected[index][0]+ this.operationselected[index][1]);
    //         },
    changeRoute(index) {
      // alert(index);
      console.log(this.operationselected[index][0]);

      if (this.operationselected[index][2] == 0 || this.operationselected[index][2] == 5 ) {
        this.axios
          .post(
            this.operationselected[index][0] + this.operationselected[index][1],{ table: this.table }
          )
          .then((response) => {
            this.supply_detail = response.data.supply_details;
          })
          .catch(({ response }) => {
            console.error(response);
          });
      } else {
        this.$router.push(
          this.operationselected[index][0] + this.operationselected[index][1]
        );
      }
    },

    get_search(word_search) {
      this.axios
        .post(`/listsupplysearch`, { word_search: this.word_search })
        .then(({ data }) => {
          this.supplies = data.supplies;

          // this.$root.logo = "Category";
        });
    },
    list(page = 1) {
      this.axios
        .post(`/listsupply?page=${page}`)
        .then(({ data }) => {
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
th,td{
  text-align: center;
}
.optionbox select {
  background: #e62968;
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



