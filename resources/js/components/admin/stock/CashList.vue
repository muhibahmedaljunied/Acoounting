<template>
<!-- https://www.youtube.com/watch?v=hrCOD_mtl2M  طريقة عمل فاتورة خدمية و فاتورة المبيعات SMACC CLOUD 6 -->

<!--  https://www.youtube.com/watch?v=nGRxtuf2e1A   نظام نقاط البيع سماك كلاود SMACC 6 Cloud -->
<!-- https://www.youtube.com/watch?v=nmmO7BSXmIE   تجهيز المحاسبة المالية الجزء الاول   -->
<!--  https://www.youtube.com/watch?v=f6OwwM6tOFo شرح قائمة البيانات الرئيسية للمخزون سماك 6| SMACC Cloud     -->

 <!--   https://www.youtube.com/watch?v=w6su3OocKew   دليل الحسابات وادارة مراكز التكلفة -->

 <!--  https://www.youtube.com/watch?v=dinV-Cumyc4  إضافة الحسابات المالية في دليل الحسابات | حسابات عامة | دفترة  -->

 <!--   https://www.youtube.com/watch?v=nEdLKyZq6sk   التعديل على تصميم الفواتير و التقارير واضافة QR سماك كلاود - 6 SMACC CLOUD  -->

 <!--   https://www.youtube.com/watch?v=nKN0QRjL9gc   PHP Laravel Web Scraping إسحب معلومات ومحتوى المواقع من الإنترنت
 
  -->
  <!--   https://www.youtube.com/watch?v=J6IHjQtIjGQ&list=PLR7SIhyIIBKq-tVUXYvSH6i7MJVhc-TqD         Builder Design Pattern -->

  <!--    https://www.youtube.com/watch?v=CBQyJl3CxwY   #8 Laravel Facades  -->
  <!-- https://www.youtube.com/watch?v=auXQRUT2NIg&list=PLGO8ntvxgiZP6DoN0WXlq220NFQ-BqkzL     Laravel Organizer -->

  <!-- https://www.youtube.com/watch?v=YO4MGNu2xvI  Dependency injection  -->
<!--  https://www.youtube.com/watch?v=7BCy2p4ds6o  PHP Payroll System - Online Payroll Script - phppayroll.com  -->
 <!--  https://www.youtube.com/watch?v=JRXeTFmbuX4&list=PLguzlA4bjhE_XSDdeCwxbTxya5oVvNdji   انتظروا سلسلة افهم لشرح البرامج المحاسبية على قناة صنايعي حسابات  -->
  <div>
    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
              <span class="h2"> الصرف</span>
            </div>
            <p class="tx-12 tx-gray-500 mb-2">
            
            </p>
            <div class="d-flex justify-content-between"></div>
            <input
              type="search"
              autocomplete="on"
              name="search"
              data-toggle="dropdown"
              role="button"
              aria-haspopup="true"
              aria-expanded="true"
              placeholder="بحث"
              v-model="word_search"
              @input="get_search()"
            />
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table text-md-nowrap" id="example1">
                <thead>
                  <tr>
                    <!-- <th class="wd-15p border-bottom-0">#</th> -->
                    <th class="wd-15p border-bottom-0">رقم السند</th>
                    <th class="wd-15p border-bottom-0">العميل</th>
                    <!-- <th class="wd-15p border-bottom-0">الكميه الصرفه</th> -->
                    <!-- <th class="wd-15p border-bottom-0">الكميه المرتحعه</th> -->
                    <th class="wd-15p border-bottom-0">تاريخ الصرف</th>

                    <th class="wd-15p border-bottom-0">العمليات</th>
                  </tr>
                </thead>
                <tbody v-if="cash && cash.data.length > 0">
                  <tr v-for="(cashes, index) in cash.data" :key="index">
                    <!-- <td>{{ index + 1 }}</td> -->
                    <td>{{ cashes.id }}</td>
                    <td>{{ cashes.customer_name }}</td>
                    <!-- <td>{{ cashes.quantity }}</td> -->
                    <!-- <td>{{ cashes.qty_return }}</td> -->
                    <td>{{ cashes.date }}</td>

                    <td>
                      <div class="optionbox">
                        <select
                          @change="changeRoute(index)"
                          v-model="operationselected[index]"
                          name="العمليات"
                          class="form-control"
                        >
                          <option
                            :selected="true"
                            class="btn btn-success"
                            v-bind:value="['/cash_details/', cashes.id,0]"
                          >
                            تفاصيل
                          </option>
                          <option
                            class="btn btn-success"
                            v-bind:value="['/returncash/', cashes.id,1]"
                          >
                            ارجاع
                          </option>
                          <option
                            class="btn btn-success"
                            v-bind:value="['/returncashlist/', cashes.id,2]"
                          >
                            مرتجعات
                          </option>
                          <option
                            class="btn btn-success"
                            v-bind:value="['/cash_invoice/', cashes.id,3]"
                          >
                            سند صرف
                          </option>
                          <option
                            class="btn btn-success"
                            v-bind:value="['/cash_recive/', cashes.id,4]"
                          >
                            سند استلام
                          </option>
                           <option
                            :selected="true"
                            class="btn btn-success"
                            v-bind:value="['/cash_invoice_cancel/', cashes.id,5]"
                          >
                             الغاء السند
                          </option>
                                  <option  class="btn btn-success"  v-bind:value="['/cash_invoice_update/',cashes.id,6]">
                   تعديل السند
                   </option>
                        </select>
                      </div>

                     
                    </td>
                  </tr>
                </tbody>
                 <tbody v-else>
                <tr>
                  <td align="center" colspan="4"><h3>  لايوجد مصروفات </h3></td>
                </tr>
              </tbody>
              </table>
            </div>
            <!-- <pagination
              align="center"
              :data="cash"
              @pagination-change-page="list"
            ></pagination> -->
          </div>
        </div>
      </div>
    </div>
    <div class="row">
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
                  <th>#</th>
                  <th>اسم المنتج</th>
                  <th>الحاله</th>
                  <th>المواصفات والطراز</th>
                  <th>الكميه المصروفه</th>
                  <!-- <th>الكميه المرتجعه</th> -->

                  <th>المخزن</th>

                  <!-- <th>الرف</th> -->
                </tr>
              </thead>
              <tbody v-if="cash_detail && cash_detail.length > 0">
                <tr v-for="(cash_details, index) in cash_detail" :key="index">
                  <td>{{ index + 1 }}</td>
                  <td>{{ cash_details.product }}</td>
                  <td>{{ cash_details.status }}</td>
                  <td>{{ cash_details.desc }}</td>
                  <td>{{ cash_details.qty }}</td>
                  <!-- <td>{{ cash_details.qty_return }}</td> -->

                  <td>{{ cash_details.store }}</td>
                  <!-- <td>{{ cash_details.shelve_name }}</td> -->
                </tr>
              </tbody>
                <tbody v-else>
                <tr>
                  <td align="center" colspan="7"><h3>  لايوجد بيانات </h3></td>
                </tr>
              </tbody>
              <!-- <tfoot>
                    <tr>
                      <th>Order no.</th>
                      <th>Order Total</th>
                      <th>Order Status</th>
                      <th>Date Order</th>
                    </tr>
                  </tfoot> -->
            </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
//  import pagination from "laravel-vue-pagination";
  export default {
    // components: {
    //   pagination,
    // },
    data() {
      return {
        cash: "yes",
        // cash: {
        //   type: Object,
        //   default: null,
        // },
        operationselected: [],
        word_search: "",
        cash_detail: "",
        table:'cash_details',
      };
    },
    mounted() {
      // this.list();
      this.axios.post("/listcash").then((response) => {
        this.cash = response.data.cashes;

    
      });
    },
    methods: {
      changeRoute(index) {
        if(this.operationselected[index][2] == 0 || this.operationselected[index][2] == 5){

        this.axios
          .post(
            this.operationselected[index][0] + this.operationselected[index][1],{ table: this.table }
          )
          .then((response) => {
            this.cash_detail = response.data.cash_details;
          })
          .catch(({ response }) => {
            console.error(response);
          });

        }else{

            this.$router.push(this.operationselected[index][0]+this.operationselected[index][1]);
        }
      },
    },
    get_search(word_search) {
      this.axios
        .post(`/listcashsearch?page=${page}`, { word_search: this.word_search })
        .then(({ data }) => {
          this.supplies = data.supplies;

          // this.$root.logo = "Category";
        });
    },
    // list(page = 1) {
     
    //   this.axios
    //     .post(`/listcash?page=${page}`)
    //     .then(({ data }) => {
    //       console.log(data);
    //       this.cash = data.cashes;
    //     })
    //     .catch(({ response }) => {
    //       console.error(response);
    //     });
    // },
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



