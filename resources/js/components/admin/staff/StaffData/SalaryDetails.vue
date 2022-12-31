<template>
  <!-- row opened -->
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header pb-0">

          <!-- <div class="d-flex justify-content-between">
            <span class="h2"> تفاصيل الراتب </span>
          </div> -->
          <div class="col-md-4" >
            <label for="status">اسم الموظف</label>
            <select name="status" id="status" class="form-control">


              <option >
           muhib
              </option>

            </select>
          </div>

          <div class="col-md-4" >
            <label for="status">الفرع</label>
            <select name="status" id="status" class="form-control">


              <option >
           muhib
              </option>

            </select>
          </div>

          
          <div class="col-md-4" >
            <label for="status">نوع الوظيفه</label>
            <select name="status" id="status" class="form-control">


              <option >
           muhib
              </option>

            </select>
          </div>
        </div>
        <div class="card-body" id="printme">
          <div class="table-responsive">
            <table class="table table-bordered text-center">
              <thead>
                <tr>
                  <th class="wd-15p border-bottom-0">الرقم الوظيفي</th>
                  <th class="wd-15p border-bottom-0">اسم المؤظف</th>
                  <th class="wd-15p border-bottom-0">الراتب الاساسي</th>
                  <th class="wd-15p border-bottom-0">بدلات الراتب</th>
                  <th class="wd-15p border-bottom-0"> خصومات</th>

                  <th class="wd-15p border-bottom-0"> ساعات اضافيه</th>
                  <th class="wd-15p border-bottom-0">ثافي قبض</th>
                  <th class="wd-15p border-bottom-0">المبلغ المستحق</th>
                  <th class="wd-15p border-bottom-0">العمليات</th>
                </tr>
              </thead>
              <tbody v-if="salaries && salaries.data.length > 0">
                <tr v-for="(salary, index) in salaries.data" :key="index">


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
                   
                   <div v-for="(extra, index) in salary.extra" :key="index" style="color:blue;">
                     {{ extra.extra_type.name }} : {{ extra.number_hours }}
                   </div>
                   </td>

                   
                 

               
               
                  <td>{{ salary.name }}</td>
           
                  <td>
                   
                   <div v-for="(pay, index) in salary.payroll" :key="index" style="color:blue;">
                     {{ pay.net_salary }} 
                   </div>
                   </td>
                  <td>
                    <button type="button" class="btn btn-danger">
                      <i class="fa fa-trash"></i>
                    </button>
                    <router-link :to="{
                      name: 'edit_advance',
                    
                    }" class="edit btn btn-success">
                      <i class="fa fa-eye"></i>
                    </router-link>
                  </td>
                </tr>
              </tbody>
              <tbody v-else>
                <tr>
                  <td align="center" colspan="9">لايوجد بياتات.</td>
                </tr>
              </tbody>
            </table>
          </div>
          <pagination align="center" :data="staff_allowances" @pagination-change-page="list"></pagination>
        </div>
      
      </div>
    </div>
    <!--/div-->
  </div>
  <!-- /row -->
</template>

<script>
import pagination from "laravel-vue-pagination";

export default {
  components: {
    pagination,
  },

  data() {
    return {
      // category: "yes",
      // sum_extra:0,
      // sum_allowance:0,
      // sum_discount:0,

      salarys: {
        type: Object,
        default: null,
      },
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

    list() {
  
      this.axios
        .post(`/salary_details`)
        .then(({ data }) => {
          console.log('muhib',data);
          this.salaries = data.salaries;
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

