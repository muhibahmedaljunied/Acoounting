<template>
  <div class='container-fluid'>
    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <!-- <form method="post" @submit.prevent="submitForm"> -->

          <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
              <span class="h2"> اقفال الارباح والخسائر</span>
            </div>
          </div>
          <div class="card-body" id="printme">


            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <div class="row">


                    <div class="col-md-3">
                      <label for="desde"> رقم الحساب</label>

                      <div class="custom-search">
                        <!-- <input id='product_tree' type="text" class="custom-search-input" readonly> -->

                        <input :id="'Transfer_store_tree'" type="text" readonly class="custom-search-input" />
                        <input :id="'Transfer_store_tree_id'" type="hidden" readonly class="custom-search-input" />

                        <button class="custom-search-botton" type="button" data-toggle="modal"
                          data-target="#exampleModalStore">
                          <i class="fa fa-plus-circle"></i>
                        </button>
                      </div>
                    </div>



                    <div class="col-md-3">
                      <label for="desde">اسم الحساب </label>
                      <input style="background-color: beige;" type="text" class="form-control hasDatepicker"
                        id="modal_reporte_venta_inicio" name="modal_reporte_venta_inicio" v-model="date"
                        onkeypress="return controltag(event)" />
                    </div>

                    <div class="col-md-6">

                      <a href="javascript:void" @click="addDaily()" class="btn btn-primary"><span>اقفال الارباح والخسائر
                        </span></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

    </div>
    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <!-- <form method="post" @submit.prevent="submitForm"> -->

          <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
              <span class="h2"> اقفال المخزون</span>
            </div>
          </div>
          <div class="card-body" id="printme">

            <div class="row">
              <div class="col-md-4">
                <h5 class="card-title"> طريقه الاقفال</h5>
                <div class="custom-search">

                  <select class="form-control" style="background-color: beige;" name="forma_pago"
                    id="select_account_Sale">

                  </select>

                </div>
              </div>
              <div class="col-md-6">

                <a href="javascript:void" @click="addDaily()" class="btn btn-primary"><span>اقفال المخزون
                  </span></a>
              </div>
            </div>


          </div>
        </div>
      </div>

    </div>
    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <!-- <form method="post" @submit.prevent="submitForm"> -->

          <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
              <span class="h2"> اقفال الحسابات</span>
            </div>
          </div>
          <div class="card-body" id="printme">

            <div class="row row-sm">
              <div class="col-xl-12">
                <div class="card">

                  <!-- <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
              <span class="h2"> الفترات الماليه</span>
            </div>
          </div> -->
                  <div class="card-body" id="printme">


                    <div class="col-sm-12">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" value="">
                          <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                          نقل الادخالات الاساسيه من الفترات السابقه
                        </label>
                      </div>

                      <div class="checkbox">
                        <label>
                          <input type="checkbox" value="">
                          <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                          المحاسبه الماليه
                        </label>
                      </div>
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" value="" checked>
                          <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                          الاصول الثابته </label>
                      </div>
                      <div class="checkbox disabled">
                        <label>
                          <input type="checkbox" value="" disabled>
                          <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                          المخزون </label>
                      </div>
                    </div>


                    <div class="col-sm-12">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" value="">
                          <span class="cr"><i class="cr-icon glyphicon glyphicon-arrow-right"></i></span>
                          الموظفين </label>
                      </div>

                    </div>

                  </div>


                  <!-- <div class="table-responsive">
              <table class="table table-bordered text-center">
                <thead>
                  <tr>
                    <th class="wd-15p border-bottom-0">رقم الفتره</th>
                    <th class="wd-15p border-bottom-0">اسم الفتره</th>

                    <th class="wd-15p border-bottom-0"> تأريخ البدء</th>
                    <th class="wd-15p border-bottom-0">تأريخ الانتهاء</th>

                  </tr>
                </thead>
                <tbody v-if="value_list && value_list.data.length > 0">
                  <tr v-for="(daily, index) in value_list.data" :key="index">
                    <td>
                      {{ daily.id }}
                    </td>
                    <td>

                      {{ daily.text }}

                    </td>
                    <td>

                      {{ daily.text }}

                    </td>
                    <td>

                      {{ daily.description }}
                    </td>



                  </tr>

                </tbody>
                <tbody v-else>
                  <tr>
                    <td align="center" colspan="5">
                      <h3> لايوجد بيانات </h3>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div> -->

                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

    </div>




  </div>
</template>
<script>
import tree from '../../../../tree/tree.js';

export default {
  mixins: [tree],
  data() {
    return {


      value_list: {
        type: Object,
        default: null,
      },
      counts: {},

      date: new Date().toISOString().substr(0, 10),

      table: '',
      type: '',



      // -----------------------------------------
      count: 1,
      daily_date: "2021-11-24",
      daily_id: '',
      trees: "",
      account: [],
      account_name: [],
      description: [],
      debit: [],
      credit: [],
      jsonTreeData: '',
      type_of_tree: 1,
      indexselected: '',
      indexselectedaccount: '',

      last_nodes: '',

      index: 0,


    };
  },
  mounted() {
    this.list();
    this.type = 'Daily';
    this.counts[0] = 1;
    this.type_of_tree = 1;
    this.showtree('account','tree_account');




  },

  methods: {

    list() {

      this.axios
        .post(`/daily`)
        .then(({ data }) => {
          console.log('daily', data.daily_details.data);
          this.value_list = data.daily_details;
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },
    addComponent(index) {
      // alert(index);
      this.count += 1;
      this.counts[index] = this.count;
    },
    disComponent(index) {
      this.count -= 1;
      this.$delete(this.counts, index);
    },

    addDaily() {

      this.axios
        .post("store_daily", {

          count: this.counts,
          daily_date: this.daily_date,
          total: this.total,
          account_id: this.account,
          description: this.description,
          // account_name: this.account_name,
          debit: this.debit,
          credit: this.credit,
        })
        .then(function (response) {
          console.log(response);
          currentObj.success = response.data.success;
          currentObj.filename = "";


          toastMessage("تم الاضافه بنجاح");
        })
        .catch(function (error) {
          currentObj.output = error;
        });

      // this.$router.go(-1);
    },
  },
};
</script>




