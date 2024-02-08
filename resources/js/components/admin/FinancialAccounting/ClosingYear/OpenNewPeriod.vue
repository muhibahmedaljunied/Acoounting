<template>
  <div class='container-fluid'>
    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <!-- <form method="post" @submit.prevent="submitForm"> -->

          <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
              <span class="h2"> فتح سنه ماليه جديده</span>
            </div>
          </div>
          <div class="card-body" id="printme">


            <div class="table-responsive">
              <table class="table table-bordered text-center">
                <thead>
                  <tr>
                    <th class="wd-15p border-bottom-0">اسم الفتره</th>
                    <th class="wd-15p border-bottom-0"> تأريخ البدء</th>
                    <th class="wd-15p border-bottom-0">تأريخ الانتهاء</th>

                    <!-- <th>اضافه</th> -->
                  </tr>
                </thead>
                <tbody>

                  <tr v-for="index in count" :key="index">

                    <td>
                      <input v-model="year" type="number" min="1900" max="2099" step="1" />
                    </td>
                    <td>
                      <input required type="date" v-model="start_date" class="form-control input_cantidad" />
                    </td>

                    <td>
                      <input type="date" v-model="end_date" class="form-control input_cantidad"
                        onkeypress="return valida(event)" />
                    </td>


                    <td colspan="4"> <a href="javascript:void" @click="create_period()" class="btn btn-primary"><span>بدء
                          فتره
                          ماليه جديده
                        </span></a>
                    </td>





                  </tr>

                  <!-- <tr v-for="index in count" :key="index">

                    <td>
                      <input v-model="year" type="number" min="1900" max="2099" step="1" />
                    </td>
                    <td>
                      <input required type="date" :id="'Daily_account_tree_id' + index" name="account_id"
                        class="form-control input_cantidad" />
                    </td>

                    <td>
                      <input v-model="credit[index]" type="date" style="width: 150px" id="qty"
                        class="form-control input_cantidad" onkeypress="return valida(event)" />
                    </td>
                    <td>

                    <td colspan="4"> <a href="javascript:void" @click="create_period()" class="btn btn-primary"><span>بدء فتره
                          ماليه جديده
                        </span></a></td>
                    </td>



              
                  </tr> -->

                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>



      <!-- </form> -->
    </div>

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
                  <input @change="set_val(account, 'accounts')" type="checkbox" v-model="account">
                  <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                  المحاسبه الماليه
                </label>
              </div>
              <div class="checkbox">
                <label>
                  <input @change="set_val(asset, 'assets')" type="checkbox" checked v-model="asset">
                  <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                  الاصول الثابته </label>
              </div>
              <div class="checkbox disabled">
                <label>
                  <input @change="set_val(store, 'stores')" type="checkbox" v-model="store">
                  <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                  المخزون </label>
              </div>
            </div>


            <div class="col-sm-12">
              <div class="checkbox">
                <label>
                  <input @change="set_val(staff, 'staff')" type="checkbox" v-model="staff">
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

    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <!-- <form method="post" @submit.prevent="submitForm"> -->

          <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
              <span class="h2"> الفترات الماليه</span>
            </div>
          </div>
          <div class="card-body" id="printme">


            <div class="table-responsive">
              <table class="table table-bordered text-center">
                <thead>
                  <tr>
                    <th class="wd-15p border-bottom-0">اسم الفتره</th>
                    <th class="wd-15p border-bottom-0"> تأريخ البدء</th>
                    <th class="wd-15p border-bottom-0">تأريخ الانتهاء</th>

                    <th>العمليات</th>
                  </tr>
                </thead>
                <tbody v-if="value_list && value_list.length > 0">
                  <tr v-for="(period, index) in value_list" :key="index">

                    <td>{{ period.name }}</td>
                    <td>{{ period.start_date }}</td>
                    <td>{{ period.end_date }}</td>


                  </tr>

                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>



      <!-- </form> -->
    </div>

  </div>
</template>
<script>
import tree from '../../../../../js/tree/tree.js';

export default {
  mixins: [tree],
  data() {
    return {


      // value_list: {
      //   type: Object,
      //   default: null,
      // },
      value_list: '',
      counts: {},

      // date: new Date().toISOString().substr(0, 10),

      // table: '',
      // type: '',


      year: 2024,
      start_date: '',
      end_date: '',
      account: '',
      store: '',
      asset: '',
      staff: '',
      // -----------------------------------------
      count: 1,
      // daily_date: "2021-11-24",
      // daily_id: '',
      // trees: "",
      // account: [],
      // account_name: [],
      // description: [],
      // debit: [],
      // credit: [],
      // jsonTreeData: '',
      // type_of_tree: 1,
      // indexselected: '',
      // indexselectedaccount: '',
      // last_nodes: '',

      index: 0,

      data_check: [],

      data_for_initial: '',


    };
  },
  mounted() {
    this.list();


    // this.type = 'Daily';
    // this.counts[0] = 1;
    // this.type_of_tree = 1;
    // this.showtree('account');




  },

  methods: {

    list() {

      this.axios
        .post(`/account_year`)
        .then(({ data }) => {
          console.log('dailydd', data.account_years);
          this.value_list = data.account_years;
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },

    set_val(v, value) {


      if (v == true) {

        this.data_check.push(value);
      } else {

        this.data_check.pop(value);
      }
    },
    // addComponent(index) {
    //   // alert(index);
    //   this.count += 1;
    //   this.counts[index] = this.count;
    // },
    // disComponent(index) {
    //   this.count -= 1;
    //   this.$delete(this.counts, index);
    // },

    create_period() {
      this.data_for_initial = [

        'accounts',
        'banks',
        'treasuries',
        'units',
        'branches',
        'stores',


      ]


      this.axios
        .post("store_account_period", {

          // count: this.counts,
          year: this.year,
          start_date: this.start_date,
          end_date: this.end_date,
          data: this.data_for_initial,

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




