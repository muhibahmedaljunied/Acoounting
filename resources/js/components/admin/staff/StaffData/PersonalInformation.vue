<template>
  <!-- row opened -->
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">

        <div class="card-header pb-0">

          <h2> بيانات الموظف</h2>

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
                  <th class="wd-15p border-bottom-0">الرقم الوظيفي</th>
                  <th class="wd-15p border-bottom-0">اسم المؤظف</th>
                  <th class="wd-15p border-bottom-0">الهويه</th>
                  <th class="wd-15p border-bottom-0">الهيكل الاداري</th>
                  <th class="wd-15p border-bottom-0">الوظيفه</th>
                  <th class="wd-15p border-bottom-0">تاريخ التعين</th>
                  <th class="wd-15p border-bottom-0">الهاتف</th>
                  <th class="wd-15p border-bottom-0">الايميل</th>
                  <th class="wd-15p border-bottom-0">تاريخ الميلاد</th>
                  <th class="wd-15p border-bottom-0">المؤهلات</th>
                  <th class="wd-15p border-bottom-0">الجنسيه</th>
                  <th class="wd-15p border-bottom-0">الحنس</th>
                  <th class="wd-15p border-bottom-0">نوع المؤظف</th>
                  <th class="wd-15p border-bottom-0">الدياته</th>
                  <th class="wd-15p border-bottom-0">نظام العمل</th>
                  <!-- <th class="wd-15p border-bottom-0">الحاله الاجتماعيه</th>
                  <th class="wd-15p border-bottom-0">حاله الوظيفه</th> -->

                  <th class="wd-15p border-bottom-0">ملاجظه</th>

                  <!-- <th class="wd-15p border-bottom-0">العمليات</th> -->
                </tr>
              </thead>
              <tbody v-if="list_data && list_data.data.length > 0">
                <tr v-for="(staff, index) in list_data.data" :key="index">
                  <td>{{ staff.id }}</td>

                  <td>{{ staff.name }}</td>
                  <td>{{ staff.personal_card }}</td>
                  <td>{{ staff.department.text }}
                  
                   

                  </td>
                      
                  <td>{{ staff.job.text }}</td>
                  <td>{{ staff.date }}</td>
                  <!-- <td>{{ staff.register }}</td> -->
                  <td>{{ staff.phone }}</td>
                  <td>{{ staff.email }}</td>
                  <td>{{ staff.barth_date }}</td>
                  <td>{{ staff.qualification.name }}</td>
                  <td>{{ staff.nationality.name }}</td>
                  <td>{{ staff.gender.name }}</td>
                  <td>{{ staff.staff_type.name }}</td>
                  <td></td>

                  <td>{{ staff.work_type.name }}</td>

                  <!-- <td>{{ staff.salary }}</td>
                  <td>{{ staff.branch }}</td> -->
                  <!-- <td>{{ staff.department }}</td> -->
            
                  <!-- <td>{{ staff.staff_type }}</td>
                  <td>{{ staff.staff_type }}</td> -->

                  <!-- <td>
                    <button type="button" @click="delete_category(staff.id)" class="btn btn-danger">
                      <i class="fa fa-trash"></i>
                    </button>

                    <router-link :to="{
                      name: 'edit_staff',
                      params: { id: staff.id },
                    }" class="edit btn btn-success">
                      <i class="fa fa-edit"></i></router-link>
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
      staffs: '',
      card: 234242424,
      email: "muhib@gmail.com",
      name: "fsdfsfsf",
      date: "asdadada",
      barth_date: "asdadad",
      phone: 1231313,
      social_statusselected: 1,
      genderselected: 1,
      statusselected: 1,
      staffselected: "adadad",
      staff_statusselected: 1,
      jobselected: 1,
      qualificationselected: 1,
      nationalityselected: 1,
      religionselected: 1,
      staff_typeselected: 1,
      registerselected: 1,
      branchselected: 1,
      departmentselected: 1,
      registers: "",
      branches: "",
      departments: "",
      qualifications: "",
      jobs: "",
      nationalities: "",
      religions: "",
      staff_types: "",
      table: 'staff',
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
        .post(`/staffsearch`, { word_search: this.word_search })
        .then(({ data }) => {
          this.list_data = data.staffs;

          // this.$root.logo = "Category";
        });
    },

    list(page = 1) {
      this.axios
        .post(`/staff?page=${page}`)
        .then(({ data }) => {
          this.staffs = data.staffs;
          this.list_data = data.list;

        })
        .catch(({ response }) => {
          console.error(response);
        });
    },

  },
};
</script>

