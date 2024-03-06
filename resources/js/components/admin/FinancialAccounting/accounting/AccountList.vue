<template>
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header pb-0">
          <div class="d-flex justify-content-between">
            <span class="h2">دفتر الاستاذ العام</span>
          </div>
          <p class="tx-12 tx-gray-500 mb-2">

          </p>
          <!-- <div class="d-flex justify-content-between">

            <input type="search" autocomplete="on" name="search" data-toggle="dropdown" role="button" aria-haspopup="true"
              aria-expanded="true" placeholder="بحث" v-model="word_search" @input="get_search()" />
          </div> -->
        </div>
        <div class="card-body">

          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <div class="row">

                  <div class="col-xl-3">
                    <label for="">الحساب </label>

                    <div class="custom-search">

                      <input id="AccountReport_account_tree" type="text" class="custom-search-input">

                      <button class="custom-search-botton" type="button" data-toggle="modal"
                        data-target="#exampleModalAccountReport"> <i class="fa fa-plus-circle"></i></button>



                    </div>

                    <input type="hidden" name="status" id="AccountReport_account_tree_id" class="form-control" />


                  </div>
            

                  <div class="col-md-3">
                    <label for="desde">من تاريخ </label>
                    <input type="date" class="form-control hasDatepicker" id="modal_reporte_venta_inicio"
                      name="modal_reporte_venta_inicio" v-model="daily_date" onkeypress="return controltag(event)"
                      style="background-color: white" />
                  </div>

                  <div class="col-md-3">
                    <label for="desde">الي تاريخ </label>
                    <input type="date" class="form-control hasDatepicker" id="modal_reporte_venta_inicio"
                      name="modal_reporte_venta_inicio" v-model="daily_date" onkeypress="return controltag(event)"
                      style="background-color: white" />
                  </div>
                  <div class="col-sm-2 col-md-3" style="margin-top: auto;">
                                <a @click="onwaychange()" href="#"><img src="/assets/img/search.png" alt=""
                                        style="width: 10%;"> </a>
                            </div>

                </div>
              </div>
            </div>
          </div>


          <br>
          <hr>
          <div class="row">

            <div class="col-sm-12">
              <div class="table-responsive">
                <table class="table text-md-nowrap" id="example1">
                  <thead>
                    <tr>
                      <th class="wd-15p border-bottom-0">#</th>
                      <th class="wd-15p border-bottom-0">رقم الحساب</th>
                      <th class="wd-15p border-bottom-0"> اسم الحساب</th>
                      <th class="wd-15p border-bottom-0"> نوع الحركه</th>
                      <th class="wd-15p border-bottom-0">التاريخ</th>

                      <th> مدين</th>
                      <th class="wd-15p border-bottom-0"> داين</th>


                      <!-- <th class="wd-15p border-bottom-0">العمليات</th> -->
                    </tr>
                  </thead>
                  <tbody v-if="value_list && value_list.data.length > 0">
                    <tr v-for="(daily, index) in value_list.data" :key="index">

                      <td>{{ index + 1 }}</td>
                      <td>{{ daily.account_id }}</td>
                      <td>{{ daily.text }}</td>
                      <td>{{ daily.text }}</td>
                      <td>{{ daily.text }}</td>

                      <td>{{ daily.debit }}</td>
                      <td>{{ daily.credit }}</td>

                    </tr>
                    <tr>
                      <td colspan="5">الاجمالي</td>
                      <td>
                        <span style="color:green">{{ sum_debit }}</span>
                        
                      </td>

                      <td>
                  
                        <span style="color:green">{{ sum_credit }}</span>
                      </td>

                    </tr>
                  </tbody>
                  <tbody v-else>
                    <tr>
                      <td align="center" colspan="7">
                        <h3> لايوجد بيانات </h3>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>


          <pagination align="center" :data="value_list" @pagination-change-page="list"></pagination>
        </div>
      </div>
    </div>

    <div class="modal fade" id="exampleModalAccountReport" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <div class="well" id="treeview_json_account"></div>

          </div>

        </div>
      </div>
    </div>

    <!--/div-->
  </div>
</template>
<script>

import pagination from "laravel-vue-pagination";
import operation from '../../../../../js/operation.js';
import tree from '../../../../../js/tree/tree.js';
export default {

  components: {
    pagination,
  },
  mixins: [tree, operation],

  data() {
    return {
      // stock:'yes',

      value_list: {
        type: Object,
        default: null,
      },
      sum_debit:'',
      sum_credit:'',
      word_search: "",


    }
  },
  mounted() {
    this.list();
    this.type = 'AccountReport';
    this.type_of_tree = 1;
    this.showtree('account','tree_account');

  },
  methods: {

    // get_search(word_search) {
    //   this.axios.post(`/stocksearch`, { word_search: this.word_search }).then(({ data }) => {


    //     this.stocks = data;

    //   });
    // },
    onwaychange(){

      var account_id = $('#AccountReport_account_tree_id').val();
      let uri = `/account_report/${account_id}`;

      this.axios
        .post(uri)
        .then(({ data }) => {
          console.log(data.account_details);
          this.value_list = data.account_details;
          this.sum_debit = data.sum_debit;
          this.sum_credit = data.sum_credit

        })
        .catch(({ response }) => {
          console.error(response);
        });
    },
    list(page = 1) {
      this.axios
        .post(`/account_list?page=${page}`)
        .then(({ data }) => {
          console.log(data.daily_details);
          this.value_list = data.daily_details;
          this.sum_debit = data.sum_debit;
          this.sum_credit = data.sum_credit
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },

  }
}
</script>
  
  
  