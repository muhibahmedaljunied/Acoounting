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
            <div class="col-md-3">

              <label for="status"> الهيكل الاداري</label>

              <!-- <input v-model="debit" type="hidden" class="form-control" required /> -->
              <div class="custom-search">

                <input style="background-color: beige;" :id="'Advance_account_advance_tree'" type="text" readonly
                  class="custom-search-input">
                <input :id="'Advance_account_advance_tree_id'" type="hidden" readonly class="custom-search-input">

                <button class="custom-search-botton" type="button" data-toggle="modal"
                  data-target="#exampleModalAccountAdvance" @click="detect_index()">
                  <i class="fa fa-plus-circle"></i></button>
              </div>


            </div>

            <div class="col-md-2">
              <label for="status">اسم الموظف</label>
              <select @change="select_staff" v-model="staff_selected" name="type" id="type" class="form-control "
                required>
                <option v-for="staff in staffs" v-bind:value="staff.id">
                  {{ staff.name }}
                </option>
              </select>
            </div>


            <div class="col-md-2">

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

                        <option v-if="salary.status != 'prove'" class="btn btn-success" v-bind:value="[
                          'return_purchase',
                          salary.id,
                          1
                        ]">
                          استحقاق الراتب
                        </option>
                        <option v-if="salary.status == 'prove'" class="btn btn-success" v-bind:value="[
                          'returnpurchaselist',
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
export default {
  components: {
    pagination,
  },
  mixins: [operation],
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
      credit: '',
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
  },
  methods: {

    // salary_details(id) {

    //   this.$router.push('/salary_details/' + id);

    // },
    changeRoute(index, salary) {



      if (this.operationselected[index][2] == 1) {

        this.prove_salary(this.operationselected[index][1], salary);
      } else {

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
            credit_account_id: this.credit,
            staff: id,
            paid: salary,

          },
          debit: {

            debit_account_id: this.credit,
            paid: salary,

          },
          grand_total: salary,
          type_daily: 'hr_salary',


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
            credit_account_id: this.credit,
          },
          debit: {
            debit_account_id: this.credit,
          },
          grand_total: this.basic_salary,
          type_daily: 'hr_all_salary',


        }
        )
        .then((response) => {
          console.log(response);
          toastMessage("تم الاضافه بنجاح");
          // this.$router.go(0);
        });


    },
    paid_all_salary(id, salary) {

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
          this.credit = data.credit;
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
  font-size: 20px;
  box-shadow: 0 5px 18px rgb(93, 15, 9);
  -webkit-appearance: button;
  outline: none;
}
</style>