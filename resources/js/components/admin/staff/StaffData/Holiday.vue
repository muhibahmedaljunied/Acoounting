<template>
  <!-- row opened -->
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">

        <div class="card-header pb-0">

          <h2> الاجازات</h2>

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
            <div class="col-md-2">
              <label for="status"> من تأريخ</label>
             <input v-model="from_date" type="date" name="" id="" class="form-control">
            </div>

            <div class="col-md-2">
              <label for="status">الي تأريخ</label>
              <input v-model="from_date" type="date" name="" id="" class="form-control">
            </div>
            <div class="col-sm-6 col-md-3" style="margin-top: auto;">
              <a href="#"><img src="/assets/img/search.png" alt="" style="width: 10%;"> </a>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered text-center">
              <thead>
                <tr>
                  <th class="wd-15p border-bottom-0">اسم المؤظف</th>

                  <th class="wd-15p border-bottom-0">نوع الاجازه</th>

                  <th class="wd-15p border-bottom-0">عدد الايام</th>
                  <th class="wd-15p border-bottom-0">تاريخ بدء الاجازه</th>
                  <th class="wd-15p border-bottom-0">تاريخ انتهاء الاجازه</th>

                  <!-- <th class="wd-15p border-bottom-0">العمليات</th> -->
                </tr>
              </thead>
              <tbody v-if="list_data && list_data.data.length > 0">
                <tr v-for="(vacation, index) in list_data.data" :key="index">
                  <td>{{ vacation.name }}</td>

                  <td>

                    <div v-for="(vacation_names, index) in vacation.vacation" :key="index">
                      {{ vacation_names.vacation_type.name }}
                    </div>
                  </td>

                  <td>

                    <div v-for="(vacation_number, index) in vacation.vacation" :key="index">
                      {{ vacation_number.total_days }}
                    </div>
                  </td>

                  <td>

                    <div v-for="(vacation_start_date, index) in vacation.vacation" :key="index">
                      {{ vacation_start_date.start_date }}
                    </div>
                  </td>


                  <td>

                    <div v-for="(vacation_end_date, index) in vacation.vacation" :key="index">
                      {{ vacation_end_date.end_date }}
                    </div>
                  </td>



                  <!-- <td>{{ vacation.type }}</td> -->
                  <!--                 
                  <td>{{ vacation.start_date }}</td>
                  <td>{{ vacation.end_date }}</td> -->
                  <!-- <td>{{ vacation.total_days }}</td> -->




                  <!-- <td>
                    <button type="button" @click="delete_holiday(vacation.id)" class="btn btn-danger">
                      <i class="fa fa-trash"></i>
                    </button>


                  </td> -->
                </tr>
              </tbody>
              <tbody v-else>
                <tr>
                  <td align="center" colspan="3">لايوجد بياتات.</td>
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
import operation from '../../../../../js/staff/StaffData/staff_data.js';

export default {
  components: {
    pagination,
  },
  mixins: [operation],
  data() {
    return {
      // category: "yes",

      list_data: {
        type: Object,
        default: null,
      },

      staff_selected: 1,
      start_date: "",
      end_date: "",
      days: 2,
      name: "",

      staffs: "",
      jobselected: 1,
      branchselected: 1,
      staff_typeselected: 1,
      vacation_typeselected: 1,
      staffselected: 1,
      table: 'vacation',
      staff_on_change: "",
      vactions: "",
      jobs: "",
      branches: "",
      staff_types: "",
      vacation_types: "",
      word_search: "",
      from_date: new Date().toISOString().substr(0, 10),
      into_date: new Date().toISOString().substr(0, 10),
    };
  },
  mounted() {
    this.list();
  },
  methods: {

    get_search(word_search) {
      this.axios
        .post(`/vacationsearch`, { word_search: this.word_search })
        .then(({ data }) => {
          this.list_data = data;

          // this.$root.logo = "Category";
        });
    },


    list(page = 1) {
      this.axios
        .post(`/vacation?page=${page}`)
        .then(({ data }) => {
          this.list_data = data.list;
          this.vacation_types = data.vacation_types;
          this.staffs = data.staffs;
          this.jobs = data.jobs;
          this.branches = data.branches;
          this.staff_types = data.staff_types;
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },



  },
};
</script>

