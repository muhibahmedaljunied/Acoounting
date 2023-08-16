<template>
  <!-- row opened -->
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header">


          <h2> تفاصيل الراتب </h2>

        </div>

        <div class="card-body" id="printme">

          <div class="table-responsive">
            <table class="table table-bordered text-center">
              <thead>
                <tr>
                  <th class="wd-15p border-bottom-0">الرقم الوظيفي</th>
                  <th class="wd-15p border-bottom-0">اسم المؤظف</th>
                  <th class="wd-15p border-bottom-0">الراتب الاساسي</th>
                  <th class="wd-15p border-bottom-0"> بدلات</th>
                  <th class="wd-15p border-bottom-0"> خصومات</th>
                  <th class="wd-15p border-bottom-0"> جزاءات</th>
                  <th class="wd-15p border-bottom-0"> اضافي</th>
                  <th class="wd-15p border-bottom-0"> الصافي</th>
                </tr>
              </thead>
              <tbody v-if="list_data && list_data.data.length > 0">
                <tr v-for="(salary, index) in list_data.data" :key="index">


                  <td>{{ salary.id }}</td>
                  <td>{{ salary.name }}</td>
                  <td>{{ salary.salary }}</td>


                  <td>

                    <div v-for="(allowance, index) in salary.allowance" :key="index" style="color:green;">
                      {{ allowance.allowance_type.name }} : {{ allowance.qty }}
                    </div>
                  </td>


                  <td>

                    <div v-for="(discount, index) in salary.discount" :key="index" style="color:red;">
                      {{ discount.discount_type.name }} : {{ discount.quantity }}
                    </div>
                  </td>

                  <td>

                    <div v-for="(sanction, index) in salary.staff_sanction" :key="index" style="color:red;">
                      <!-- {{ sanction.sanctionable.sanction }} : -->
                      <span v-if="!sanction.sanctionable.extra_type_id">
                        <span v-if="sanction.sanctionable.sanction != 0">
                          {{ sanction.sanctionable.sanction }}

                        </span>

                      </span>


                    </div>
                  </td>

                  <td>

                    <div v-for="(extra, index) in salary.extra" :key="index" style="color:blue;">
                      <div v-for="(extra_sanc, index) in extra.extra_detail" :key="index">
                        <!-- {{ extra_sanc.extra_sanction.sanction }} :  -->
                        <span v-if="extra_sanc.extra_sanction.sanction != 0">
                          {{ extra_sanc.extra_sanction.sanction }}

                        </span>
                       

                      </div>
                    </div>
                    <div v-for="(sanction, index) in salary.staff_sanction" :key="index" style="color:blue;">
                          <!-- {{ sanction.sanctionable.sanction }} : -->
                          <span v-if="sanction.sanctionable.extra_type_id">
                            <span v-if="sanction.sanctionable.sanction != 0">
                              {{ sanction.sanctionable.sanction }}

                            </span>

                          </span>


                        </div>
                  </td>








                  <td>

                    <div v-for="(pay, index) in salary.payroll" :key="index" style="color:blue;">
                      {{ pay.net_salary }}
                    </div>
                  </td>

                </tr>
                <tr v-for="(salary, index) in list_data.data" :key="index">
                  <td colspan="2" style="color:red;font-size: x-large;">الاجمالي</td>

                  <td style="color:green;font-size: x-large;">{{ salary.salary }}</td>
                  <td style="color:green;font-size: x-large;">{{ salary.sum_allowance }}</td>
                  <td style="color:green;font-size: x-large;">{{ salary.sum_discount }}</td>
                  <td style="color:green;font-size: x-large;">{{ salary.sum_sanction }}</td>

                  <td style="color:green;font-size: x-large;">{{ salary.sum_extra }}</td>
                  <td style="color:green;font-size: x-large;">{{ salary.salary }}</td>

                </tr>
              </tbody>
              <tbody v-else>
                <tr>
                  <td align="center" colspan="9">لايوجد بياتات.</td>
                </tr>
              </tbody>
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
import operation from '../../../../js/staff/StaffData/staff_data.js';
export default {
  components: {
    pagination,
  },
  mixins: [operation],
  data() {
    return {


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

    get_search(word_search) {
      this.axios
        .post(`/salary_detailssearch`, { word_search: this.word_search })
        .then(({ data }) => {
          // this.salarys = data.salarys;

          this.salaries = data.salaries;
          // this.$root.logo = "Category";
        });
    },

    list(page = 1) {

      this.axios
        .post(`/salary_details/${this.$route.params.id}`)
        .then(({ data }) => {
          console.log('muhib', data);
          this.list_data = data.list;
          this.staffs = data.staffs;
        })
        .catch(({ response }) => {
          console.error(response);
        });




    },


  },
};
//
</script>

