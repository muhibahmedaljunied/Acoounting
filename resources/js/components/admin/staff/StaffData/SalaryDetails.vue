<template>
  <!-- row opened -->
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header">


          <h2> كشف الراتب </h2>

        </div>




        <div class="card-body" id="printme">
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
            <div class="col-sm-6 col-md-3" style="margin-top: auto;">
              <a href="#"><img src="/assets/img/search.png" alt="" style="width: 10%;"> </a>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered text-center">
              <thead>

                <tr>
                  <th class="wd-15p border-bottom-0">الرقم الوظيفي</th>
                  <th class="wd-15p border-bottom-0">اسم المؤظف</th>
                  <th class="wd-15p border-bottom-0">الراتب الاساسي</th>
                  <th class="wd-15p border-bottom-0">البدلات </th>
                  <th class="wd-15p border-bottom-0"> الاضافي</th>
                  <th class="wd-15p border-bottom-0"> الخصومات</th>
                  <th class="wd-15p border-bottom-0"> السلف</th>
                  <th class="wd-15p border-bottom-0"> الصافي</th>
                  <th>العمليات</th>
                </tr>
              </thead>
              <tbody v-if="list_data && list_data.data.length > 0">
                <tr v-for="(salary, index) in list_data.data" :key="index">


                  <td>{{ salary.id }}</td>
                  <td>{{ salary.name }}</td>
                  <td>{{ salary.salary }}</td>


                  <td>{{ salary.total_allowance }}</td>


                  <td>{{ salary.total_extra }}</td>

                  <td>{{ salary.total_discount }}</td>





                  <td>{{ salary.total_advance }}</td>


                  <td>{{ salary.total }}</td>


                  <button @click="salary_details(salary.id)" class="btn btn-success"> <i class="fa fa-eye"></i></button>
                  <!-- <router-link 
                  :to="{ name: 'salary_details', params: { id: salary.id } }"
                    class="edit btn btn-success">
                    <i class="fa fa-eye"></i></router-link> -->

                  <!-- <router-link to="/salary_details" 
                 
                    class="edit btn btn-success">
                    <i class="fa fa-eye"></i></router-link> -->

                </tr>
                <tr>
                  <td colspan="2" style="color:red;font-size: x-large;">الاجمالي</td>
                  <td style="color:green;font-size: x-large;"></td>
                  <td style="color:green;font-size: x-large;"></td>
                  <td style="color:green;font-size: x-large;"></td>
                  <td style="color:green;font-size: x-large;"></td>
                  <td style="color:green;font-size: x-large;"></td>
                  <td style="color:green;font-size: x-large;"></td>
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

      salaries: "",
      jobs: "",
      branches: "",
      staff_types: "",
      allowance_types: "",
      table: 'salary',
      word_search: "",
    };
  },
  mounted() {
    this.list();
  },
  methods: {

    salary_details(id) {

      this.$router.push('/salary_details/' + id);

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
        .post(`/salary?page=${page}`)
        .then(({ data }) => {
          // console.log('muhib', data);
          this.list_data = data.list;
          this.staffs = data.staffs;
          // this.staff_details = data;
        })
        .catch(({ response }) => {
          console.error(response);
        });

    },


  },
};
//
</script>

