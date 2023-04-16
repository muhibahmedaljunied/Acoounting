<template>
  <!-- row opened -->
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header">


          <h2> الحضور والغياب </h2>

        </div>




        <div class="card-body" id="printme">
          <div class="row">
            <!-- <div class="col-md-3">
              <label for="status">اسم الموظف</label>
              <select @change="select_staff" v-model="staff_selected" name="type" id="type" class="form-control "
                required>
                <option v-for="staff in staffs" v-bind:value="staff.id">
                  {{ staff.name }}
                </option>
              </select>
            </div> -->

            <div class="col-md-2">
              <label for="status">نظام العمل</label>
              <select v-model="work_selected" name="type" class="form-control " required
                @change="get_period(work_selected)">
                <option v-for="work_system in work_systems" v-bind:value="work_system.id">
                  {{ work_system.name }}
                </option>
              </select>
            </div>

            <div class="col-md-2">
              <label for="status"> الفتره</label>
              <select id='select_period' v-model="period_selected" name="type" class="form-control " required>

              </select>
            </div>
            <div class="col-md-2">
              <label for="status"> الموظف</label>
              <select id='select_staff' v-model="staff_selected" name="type" class="form-control " required>

              </select>
            </div>

            <div class="col-md-2">
              <label for="status"> من تأريخ</label>
              <input v-model="from_date" type="date" name="" id="" class="form-control">
            </div>

            <div class="col-md-2">
              <label for="status"> الي تأريخ</label>
              <input v-model="into_date" type="date" name="" id="" class="form-control">
            </div>

            <!-- <div class="col-md-2">
              <label for="status"> الشهر</label>
              <select @change="select_staff" v-model="staff_selected" name="type" id="type" class="form-control "
                required>
                <option v-for="staff in staffs" v-bind:value="staff.id">
                  {{ staff.name }}
                </option>
              </select>
            </div> -->

            <div class="col-sm-2 col-md-2" style="margin-top: auto;">
              <a @click="search()" href="#"><img src="/assets/img/search.png" alt="" style="width: 15%;"> </a>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered text-center">
              <thead>

                <tr>
                  <th class="wd-15p border-bottom-0">الرقم الوظيفي</th>
                  <th class="wd-15p border-bottom-0">اسم المؤظف</th>
                  <th class="wd-15p border-bottom-0">التأريخ</th>
                  <th class="wd-15p border-bottom-0">اليوم</th>
                  <th class="wd-15p border-bottom-0"> حضور</th>
                  <th class="wd-15p border-bottom-0">غياب </th>
                  <th class="wd-15p border-bottom-0"> تأخير</th>
                  <th class="wd-15p border-bottom-0"> انصراف مبكر</th>



                </tr>
              </thead>
              <tbody v-if="list_data && list_data.data.length > 0">
                <tr v-for="(attendance, index) in list_data.data" :key="index">

                  <td>

                    {{ attendance.id }}
                  </td>

                  <td>

                    {{ attendance.staff.name }}
                  </td>
                  <td>

                    {{ attendance.attendance_date }}
                  </td>

                  <td>

                    {{ attendance.date }}
                  </td>

                  <td>


                    <!-- {{ attendance.total_present }} -->
                    <span v-if="attendance.total_present == 1" style="color:red" class="fa fa-check"></span>

                  </td>


                  <td>

                    <!-- {{ attendance.total_apsence }} -->
                    <span v-if="attendance.total_apsence == 1" style="color:red" class="fa fa-check"></span>

                  </td>

                  <td>

                    {{ attendance.total_delay }}
                  </td>


                  <td>

                    {{ attendance.total_leave }}
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
// import operation from '../../../../../js/staff/StaffData/staff_data.js';
import operation from '../../../../../js/staff/operation.js';
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
      // table: '',
      // staff_selected: 1,
      // staffs: '',
      // branchselected: "",
      // staff_allowances: "",
      // salaryselected: "",
      // date: "",
      // allowances: "",
      // allowance: [],
      // checkselected: [],
      // staffselected: 1,
      // jobselected: 1,
      // brancheselected: 1,
      // staff_typeselected: 1,

      // salaries: "",
      // jobs: "",
      // branches: "",
      // staff_types: "",
      // allowance_types: "",
      // table: 'salary',
      // word_search: "",
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

          this.salaries = data.salaries;

        });
    },
    search() {
      axios.post(`/attendance_report/search`, {

        work_system: this.work_selected,
        period: this.period_selected,
        staff: this.staff_selected,
        from_date: this.from_date,
        into_date: this.into_date,



      }).then(({ data }) => {
        console.log(data);
        this.list_data = data.attendances;
      });

    },
    get_period(id) {


      axios.post(`/attendance/get_period/${id}`).then((response) => {


        // console.log('muhib',response.data.periods[0] );
        var arrayLength = response.data.periods.length
        var arrayLength2 = response.data.staffs.length
        var html = '';
        var html2 = '';


        for (var i = 0; i < arrayLength; i++) {
          console.log('muhib', response.data.periods[i].name);

          html = html + `<option data-period-${id}= ${response.data.periods[i].id}   value= ${response.data.periods[i].id} >${response.data.periods[i].name}</option>`

        }

        for (var i = 0; i < arrayLength2; i++) {
          console.log('muhib', response.data.staffs[i].name);

          html2 = html2 + `<option data-staff-${id}= ${response.data.staffs[i].id}   value= ${response.data.staffs[i].id} >${response.data.staffs[i].name}</option>`

        }


        $(`#select_period`).html(html);
        $(`#select_staff`).html(html2);


      });




    },
    list(page = 1) {




      this.axios
        .post(`/attendance_report?page=${page}`)
        .then(({ data }) => {
          console.log('muhibx', data);
          this.list_data = data.attendances;
          this.staffs = data.staffs;
          this.work_systems = data.work_systems;
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

