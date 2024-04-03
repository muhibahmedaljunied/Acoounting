<template>
  <!-- row opened -->
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header">


          <h2> الراتب </h2>

        </div>




        <div class="card-body" id="printme">
          <div class="row">
            <div class="col-md-6">

              <label for="status"> الهيكل الاداري</label>

              <!-- <input v-model="debit" type="hidden" class="form-control" required /> -->
              <div class="custom-search">

                <input style="background-color: beige;" :id="'Advance_account_advance_tree'" type="text" readonly
                  class="custom-search-input">
                <input :id="'Advance_account_advance_tree_id'" type="hidden" readonly class="custom-search-input">

                <button class="custom-search-botton" type="button" data-toggle="modal"
                  data-target="#exampleModalAccountAdvance">
                  <i class="fa fa-plus-circle"></i></button>
              </div>


            </div>

            <div class="col-md-6">

              <label for="status"> الحساب</label>

              <!-- <input v-model="debit" type="hidden" class="form-control" required /> -->
              <div class="custom-search">

                <input style="background-color: beige;" :id="'Salary_account_tree'" type="text" readonly
                  class="custom-search-input">
                <input :id="'Salary_account_tree_id'" type="hidden" readonly class="custom-search-input">

                <button class="custom-search-botton" type="button" data-toggle="modal"
                  data-target="#exampleModalAccountSalary">
                  <i class="fa fa-plus-circle"></i></button>
              </div>


            </div>



          </div>
          <br>

          <div class="row">




            <div class="col-md-4">
              <label for="status">اسم الموظف</label>
              <select @change="select_staff" v-model="staff_selected" name="type" id="type" class="form-control "
                required>
                <option v-for="staff in staffs" v-bind:value="staff.id">
                  {{ staff.name }}
                </option>
              </select>
            </div>



            <div class="col-md-4">

              <label for="">التاريخ</label>
              <input v-model="date" type="date" class="form-control" name="name" id="name" required />

            </div>

            <div class="col-sm-6 col-md-3" style="margin-top: auto;">
              <a href="#"><img src="/assets/img/search.png" alt="" style="width: 10%;"> </a>
            </div>
          </div>
          <br>

          <div class="table-responsive">
            <table class="table table-bordered text-center">
              <thead>

                <tr>
                  <th class="wd-15p border-bottom-0">الرقم الوظيفي</th>
                  <th class="wd-15p border-bottom-0">اسم المؤظف</th>
                  <th class="wd-15p border-bottom-0">الراتب الاساسي</th>
                  <!-- <th class="wd-15p border-bottom-0">بدلات </th> -->
                  <!-- <th class="wd-15p border-bottom-0"> اضافي</th> -->
                  <!-- <th class="wd-15p border-bottom-0"> خصومات</th> -->
                  <!-- <th class="wd-15p border-bottom-0"> جزاءات</th> -->

                  <!-- <th class="wd-15p border-bottom-0"> السلف</th> -->
                  <th class="wd-15p border-bottom-0"> الصافي</th>
                  <th class="wd-15p border-bottom-0"> الحاله</th>

                  <th>العمليات</th>
                </tr>
              </thead>
              <tbody v-if="list_data && list_data.data.length > 0">
                <tr v-for="(salary, index) in list_data.data" :key="index">


                  <td>{{ salary.id }}</td>
                  <td> <a @click="salary_details(salary.id)">{{ salary.name }} </a></td>

                  <td>{{ salary.salary }}</td>


                  <!--<td>{{ salary.total_allowance }}</td>


                  <td>{{ salary.total_extra }}</td>

                  <td>{{ salary.all_discount }}</td>





                  <td>{{ salary.total_sanction }}</td>
 -->

                  <td>{{ salary.total }}</td>
                  <td>
                    <template>
                      <div>
                        <span class="badge bg-warning" v-if="salary.status == 'init'">معلق </span>
                        <span class="badge bg-info" v-if="salary.status == 'prove'">مستحق </span>
                        <span class="badge bg-success" v-if="salary.status == 'paid'">مدفوع </span>

                      </div>
                    </template>
                  </td>


                  <!-- 
                  <td>
                    <button @click="salary_details(salary.id)" data-toggle="tooltip" data-placement="top"
                      class="tn btn-success btn-sm waves-effect btn-agregar"> <i class="fa fa-eye"></i></button>
                    <button class="tn btn-info btn-sm waves-effect btn-agregar"> <i class="fa fa-plus"></i> </button>

                  </td> -->
                  <td>
                    <div class="optionbox">
                      <select @change="changeRoute(index, salary.salary)" v-model="operationselected[index]"
                        class="form-control">
                        <option :selected="true" class="btn btn-success" v-bind:value="[
                          'salary_details',
                          salary.id,
                          0
                        ]">
                          تفاصيل
                        </option>

                        <option v-if="salary.status != 'prove' && salary.status != 'paid' " class="btn btn-success" v-bind:value="[
                          'prove_salary',
                          salary.id,
                          1
                        ]">
                          استحقاق الراتب
                        </option>
                        <option v-if="salary.status == 'prove'" class="btn btn-success" v-bind:value="[
                          'paid_salary',
                          salary.id,
                          2
                        ]">
                          صرف الراتب
                        </option>


                      </select>
                    </div>


                  </td>



                </tr>
                <tr>
                  <td colspan="2" style="color:red;font-size: x-large;">الاجمالي</td>

                  <td style="color:red;">{{ basic_salary }}</td>
                  <td style="color:red;">{{ net_salary }}</td>

                  <td colspan="2" style="color:green;font-size: x-large;">
                    <button @click="paid_all_salary()" class="tn btn-info btn-sm waves-effect btn-agregar"> صرف جميع
                      الرواتب </button>
                    <button @click="prove_all_salary()" class="tn btn-info btn-sm waves-effect btn-agregar"> اثبات استحقاق
                      جميع الرواتب </button>

                  </td>

                </tr>
              </tbody>



              <!-- <tbody v-else>
                <tr>
                  <td align="center" colspan="9">لايوجد بياتات.</td>
                </tr>
              </tbody> -->
            </table>
          </div>

          <div class="modal fade" id="addAd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <form method="post">
              <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>


                  <div class="modal-body">


                    <div class="row row-sm">
                      <div class="col-xl-12">
                        <!-- <form method="post"> -->
                        <div class="card">
                          <div class="card-header pb-0">
                            <div class="d-flex justify-content-between">
                              <h4 class="modal-title" id="myLargeModalLabel">السلف</h4>
                              <i class="mdi mdi-dots-horizontal text-gray"></i>
                            </div>
                          </div>

                          <div class="card-body">


                            <div class="row">
                              <div class="col-md-4">

                                <label for="">التاريخ</label>
                                <input v-model="date" type="date" class="form-control" name="name" id="name" required />
                              </div>
                            </div>
                            <br>
                            <div class="row">
                              <div class="form">

                                <form method="post">
                                  <div class="table-responsive">
                                    <table class="table table-bordered text-right">
                                      <thead>
                                        <tr>




                                          <th>اسم الموظف</th>
                                          <th>الحساب </th>

                                          <th>المبلغ</th>
                                          <th>ظريقه الخصم</th>
                                          <!-- <th>التاريخ</th> -->

                                          <th>اضافه</th>


                                        </tr>

                                      </thead>
                                      <tbody>


                                        <tr v-for="index in count" :key="index">



                                          <td>

                                            <select v-model="staffselected[index]" name="type" id="type"
                                              class="form-control" required>
                                              <option v-for="staff in staffs" v-bind:value="staff.id">
                                                {{ staff.name }}
                                              </option>
                                            </select>

                                          </td>

                                          <td>
                                            <input v-model="debit" type="hidden" class="form-control" required />
                                            <div class="custom-search">

                                              <input style="background-color: beige;"
                                                :id="'Advance_account_advance_tree' + index" type="text" readonly
                                                class="custom-search-input">
                                              <input :id="'Advance_account_advance_tree_id' + index" type="hidden"
                                                readonly class="custom-search-input" v-model="account[index]">

                                              <button class="custom-search-botton" type="button" data-toggle="modal"
                                                data-target="#exampleModalAccountAdvance" @click="detect_index(index)">
                                                <i class="fa fa-plus-circle"></i></button>
                                            </div>


                                          </td>


                                          <td>


                                            <input @input="calc_grand_total(index)" v-model="quantity[index]"
                                              type="number" class="form-control" required />
                                          </td>
                                          <td>



                                            <label for="">من الراتب</label>
                                            <input type="checkbox" name="" id="">
                                          </td>


                                          <!-- <td>

                                            <input v-model="date[index]" type="date" class="form-control" name="name"
                                              id="name" required />

                                          </td> -->

                                          <td v-if="index == 1">
                                            <a class="btn btn-info btn-sm waves-effect btn-agregar"
                                              v-on:click="addComponent(count)">
                                              <i class="fa fa-plus-circle"></i></a>

                                            <a class="btn btn-info btn-sm waves-effect btn-agregar"
                                              v-on:click="disComponent(count)">
                                              <i class="fa fa-minus-circle"></i></a>
                                          </td>


                                        </tr>
                                        <tr>
                                          <td colspan="2">الاجمالي</td>
                                          <td colspan="2">


                                            <input v-model="grand_total" type="number" class="form-control" name="name"
                                              id="name" readonly />
                                          </td>

                                        </tr>

                                      </tbody>

                                    </table>
                                  </div>




                                </form>
                              </div>
                            </div>



                            <div class="card-footer pb-0">
                              <div class="d-flex justify-content-between">
                                <i class="mdi mdi-dots-horizontal text-gray"></i>
                              </div>
                            </div>
                          </div>


                          <!-- </form> -->
                        </div>
                      </div>
                    </div>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" @click="Add_new()">حفظ </button>
                      <!-- <button type="button" class="btn btn-primary btn-lg btn-block" @click="submitForm()"@click="submitForm()">
                        حفظ
                      </button> -->
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="modal fade" id="exampleModalAccountSalary" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
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
          <pagination align="center" :data="list_data" @pagination-change-page="list"></pagination>
        </div>

      </div>
    </div>
    <!--/div-->
  </div>
  <!-- /row -->
</template>

<script>
import pagination from "laravel-vue-pagination";
import operation from '../../../../../js/staff/StaffData/staff_data.js';
import tree from '../../../../../js/tree/tree.js';

export default {
  components: {
    pagination,
  },
  mixins: [operation, tree],
  data() {
    return {
      // category: "yes",
      // sum_extra:0,
      // sum_allowance:0,
      // sum_discount:0,

      list_data: {
        type: Object,
        default: null,
      },
      operationselected: [],

      table: '',
      staff_selected: 1,
      staffs: '',
      branchselected: "",
      staff_allowances: "",
      salaryselected: "",
      date: "",
      allowances: "",
      allowance: [],
      checkselected: [],
      staffselected: 1,
      jobselected: 1,
      brancheselected: 1,
      staff_typeselected: 1,
      prove_account: '',
      // paid_account: '',
      // paid_account: '',
      salaries: "",
      jobs: "",
      branches: "",
      staff_types: "",
      allowance_types: "",
      table: 'salary',
      word_search: "",
      net_salary: '',
      basic_salary: '',

    };
  },
  mounted() {
    this.list();
    this.type_of_tree = 1;
    this.type = 'Salary';
    this.showtree('account', 'tree_account');
  },
  methods: {

    // salary_details(id) {

    //   this.$router.push('/salary_details/' + id);

    // },
    changeRoute(index, salary) {



      if (this.operationselected[index][2] == 1) {

        this.prove_salary(this.operationselected[index][1], salary);
      }
      if (this.operationselected[index][2] == 2) {

        this.paid_salary(this.operationselected[index][1], salary);
      }

      if (this.operationselected[index][2] == 0) {

        this.$router.push({
          name: this.operationselected[index][0],
          params: { data: this.operationselected[index][1] },
        });
      }

      // console.log(this.operationselected[index][0],this.operationselected[index][1]);




    },
    prove_salary(id, salary) {

      this.axios
        .post(`/prove_salary/${id}`, {
          type: this.type,
          date: this.date,
          credit: {
            credit_account_id: this.prove_account,
            staff: id,
            paid: salary,

          },
          debit: {

            debit_account_id: this.prove_account,
            paid: salary,

          },
          grand_total: salary,
          type_daily: 'hr_prove_salary',


        }
        )
        .then((response) => {
          console.log(response);
          toastMessage("تم الاضافه بنجاح");
          // this.$router.go(0);
        });


    },
    prove_all_salary() {


      this.axios
        .post(`/prove_all_salary`, {
          data_staff: this.staffs,
          type: this.type,
          date: this.date,
          credit: {
            credit_account_id: this.prove_account,
          },
          debit: {
            debit_account_id: this.prove_account,
          },
          grand_total: this.basic_salary,
          type_daily: 'hr_all_prove_salary',


        }
        )
        .then((response) => {
          console.log(response);
          toastMessage("تم الاضافه بنجاح");
          // this.$router.go(0);
        });


    },
    paid_salary(id, salary) {

      this.axios
        .post(`/paid_salary/${id}`, {
          type: this.type,
          date: this.date,
          staff: id,
          account_id: $(`#Salary_account_tree_id`).val(),
          grand_total: 0,
          type_daily: 'hr_paid_salary',



        }
        )
        .then((response) => {
          console.log(response);
          toastMessage("تم الاضافه بنجاح");
          // this.$router.go(0);
        });


    },
    paid_all_salary() {


      this.axios
        .post(`/paid_all_salary`, {
          data_staff: this.staffs,
          type: this.type,
          date: this.date,
          account_id: $(`#Salary_account_tree_id`).val(),
          grand_total: 0,
          type_daily: 'hr_all_paid_salary',


        }
        )
        .then((response) => {
          console.log(response);
          toastMessage("تم الاضافه بنجاح");
          // this.$router.go(0);
        });


    },

    get_search(word_search) {
      this.axios
        .post(`/salary_detailssearch`, { word_search: this.word_search })
        .then(({ data }) => {

          this.salaries = data.salaries;

        });
    },

    list(page = 1) {




      this.axios
        .post(`/salary_details?page=${page}`)
        .then(({ data }) => {
          // console.log('muhib', data);
          this.list_data = data.list;
          this.staffs = data.staffs;
          this.net_salary = data.net_salary;
          this.basic_salary = data.basic_salary;
          this.prove_account = data.prove_account;
          // this.paid_account = data.paid_account;
          // this.paid_account = data.paid_account;

          this.staffs = data.staff;


        })
        .catch(({ response }) => {
          console.error(response);
        });

    },


  },
};
//
</script>

<style scoped>
.optionbox select {
  background: #E62968;
  color: #fff;
  padding: 10px;
  width: 120px;
  height: 30px;
  border: none;
  font-size: 15px;
  box-shadow: 0 5px 18px rgb(93, 15, 9);
  /* -webkit-appearance: button; */
  outline: none;
}
</style>