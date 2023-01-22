<template>
  <!-- row opened -->
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="col-md-4" >
            <label for="status">اسم الموظف</label>
            <select v-model="staffselected" name="type" id="type" class="form-control " required>
              <option v-for="staff in staffs.data" v-bind:value="staff.id">
                {{ staff.name }}
              </option>
            </select>
          </div>
        <div class="card-header pb-0">
          <!-- <div class="d-flex justify-content-between">
            <span class="h2"> البيانات الشخصيه</span>
          </div> -->

          
       
     
           
          

       
        </div>
        <div class="card-body" id="printme">
          <div class="table-responsive">
            <table class="table table-bordered text-center">
              <thead>
                <tr>
                  <th class="wd-15p border-bottom-0">الرقم الوظيفي</th>
                  <th class="wd-15p border-bottom-0">اسم المؤظف</th>
                  <th class="wd-15p border-bottom-0">الهويه</th>
                  <th class="wd-15p border-bottom-0">الوظيفه</th>
                  <th class="wd-15p border-bottom-0">تاريخ التعين</th>
                  <!-- <th class="wd-15p border-bottom-0">تعين من قبل</th> -->
                  <th class="wd-15p border-bottom-0">الهاتف</th>
                  <th class="wd-15p border-bottom-0">الايميل</th>
                  <th class="wd-15p border-bottom-0">تاريخ الميلاد</th>
                  <!-- <th class="wd-15p border-bottom-0">تعين من قبل</th> -->
                  <th class="wd-15p border-bottom-0">المؤهلات</th>
                  <th class="wd-15p border-bottom-0">الجنسيه</th>
                  <th class="wd-15p border-bottom-0">الحنس</th>
                  <th class="wd-15p border-bottom-0">نوع المؤظف</th>
                  <th class="wd-15p border-bottom-0">الدياته</th>
                  <th class="wd-15p border-bottom-0">الحاله الاجتماعيه</th>
                  <th class="wd-15p border-bottom-0">حاله الوظيفه</th>

                  <th class="wd-15p border-bottom-0">ملاجظه</th>

                  <th class="wd-15p border-bottom-0">العمليات</th>
                </tr>
              </thead>
              <tbody v-if="staffs && staffs.data.length > 0">
                <tr v-for="(staff, index) in staffs.data" :key="index">
                  <td>{{ staff.id }}</td>
        
                  <td>{{ staff.staff }}</td>
                  <td>{{ staff.personal_card }}</td>
                  <td>{{ staff.job }}</td>
                  <td>{{ staff.date }}</td>
                  <!-- <td>{{ staff.register }}</td> -->
                  <td>{{ staff.phone }}</td>
                  <td>{{ staff.email }}</td>
                  <td>{{ staff.barth_date }}</td>

                  <td>{{ staff.gender }}</td>
                  <!-- <td>{{ staff.social_status }}</td> -->
                  <td>{{ staff.qualification }}</td>
                  <td>{{ staff.salary }}</td>
                  <td>{{ staff.branch }}</td>
                  <td>{{ staff.department }}</td>
                  <td>{{ staff.staff_type }}</td>
                  <td>{{ staff.religion }}</td>
                  <td>{{ staff.nationality }}</td>
                  <td>{{ staff.staff_type }}</td>
                  <td>{{ staff.staff_type }}</td>

                  <td>
                    <!-- <a data-toggle="modal" data-target="#modal_vaciar" class="tn btn-danger btn-lg waves-effect btn-agregar"><i class="fa fa-trash"></i></a> -->
                    <button
                      type="button"
                      @click="delete_category(staff.id)"
                      class="btn btn-danger"
                    >
                      <i class="fa fa-trash"></i>
                    </button>

                    <router-link
                      :to="{
                        name: 'edit_staff',
                        params: { id: staff.id },
                      }"
                      class="edit btn btn-success"
                    >
                      <i class="fa fa-edit"></i
                    ></router-link>
                  </td>
                </tr>
              </tbody>
              <tbody v-else>
                <tr>
                  <td align="center" colspan="3">لايوجد بياتات.</td>
                </tr>
              </tbody>
            </table>
          </div>
          <pagination
            align="center"
            :data="staffs"
            @pagination-change-page="list"
          ></pagination>
        </div>
        <div
          class="modal fade bs-example-modal-lg"
          tabindex="-1"
          role="dialog"
          aria-labelledby="myLargeModalLabel"
          aria-hidden="true"
          style="display: none"
          id="addPI"
        >
          <div class="modal-dialog modal-lg" style="max-width: 600%">
            <div class="modal-content">
              <div class="modal-header">
                <button
                  type="button"
                  class="close"
                  data-dismiss="modal"
                  aria-hidden="true"
                >
                  x
                </button>
              </div>
              <div class="modal-body">
                <div class="row row-sm">
                  <div class="col-xl-12">
                    <form method="post" @submit.prevent="submitForm">
                      <div class="card">
                        <div class="card-header pb-0">
                          <div class="d-flex justify-content-between">
                            <h4 class="modal-title" id="myLargeModalLabel">
                              البياتات الشخصيه
                            </h4>
                            <i class="mdi mdi-dots-horizontal text-gray"></i>
                          </div>
                        </div>
                        <div class="card-body">
                          <div class="form-row">
                            <div class="form-group col-md-3">
                              <label for="inputEmail4">اسم المؤظف</label>
                              <input
                                type="text"
                                class="form-control"
                                placeholder="ادخل اسم المؤظف"
                              />
                            </div>
                            <div class="form-group col-md-2">
                              <label for="inputAddress">الفرع</label>
                              <select
                                v-model="branchselected"
                                class="form-control"
                                required
                              >
                                <option
                                  v-for="branch in branches"
                                  v-bind:value="branch.id"
                                >
                                  {{ branch.name }}
                                </option>
                              </select>
                            </div>
                            <div class="form-group col-md-2">
                              <label for="inputAddress">القسم</label>
                              <select
                                v-model="departmentselected"
                                class="form-control"
                                required
                              >
                                <option
                                  v-for="department in departments"
                                  v-bind:value="department.id"
                                >
                                  {{ department.name }}
                                </option>
                              </select>
                            </div>
                            <div class="form-group col-md-2">
                              <label for="inputPassword4">الهويه</label>
                              <input
                                v-model="card"
                                type="number"
                                class="form-control"
                              />
                            </div>
                            <div class="form-group col-md-2">
                              <label for="inputPassword4">الهاتف</label>
                              <input
                                v-model="phone"
                                type="number"
                                class="form-control"
                              />
                            </div>
                            <div class="form-group col-md-2">
                              <label for="inputAddress">التعين</label>
                              <select
                                v-model="jobselected"
                                class="form-control"
                                required
                              >
                                <option
                                  v-for="job in jobs"
                                  v-bind:value="job.id"
                                >
                                  {{ job.name }}
                                </option>
                              </select>
                            </div>
                            <!-- <div class="form-group col-md-3">
                              <label for="inputAddress2">تعين من قبل</label>
                              <select
                                v-model="registerselected"
                                name="type"
                                id="type"
                                class="form-control"
                              >
                         
                              </select>
                            </div> -->

                            <div class="form-group col-md-2">
                              <label for="inputCity">تاريخ التعين</label>
                              <input
                                v-model="date"
                                type="date"
                                class="form-control"
                                id="inputCity"
                              />
                            </div>
                            <hr />
                            <div class="form-group col-md-4">
                              <label for="inputState">حاله المؤظف</label>
                              <select
                                v-model="statusselected"
                                name="type"
                                id="type"
                                class="form-control"
                                required
                              >
                                <option v-bind:value="1">بدء العمل</option>
                                <option v-bind:value="2">لم يبدء العمل</option>
                              </select>
                            </div>
                            <div class="form-group col-md-4">
                              <label for="inputZip">المؤهلات </label>
                              <select
                                v-model="qualificationselected"
                                name="type"
                                id="type"
                                class="form-control"
                                required
                              >
                                <option
                                  v-for="qualification in qualifications"
                                  v-bind:value="qualification.id"
                                >
                                  {{ qualification.name }}
                                </option>
                              </select>
                            </div>
                            <div class="form-group col-md-4">
                              <label for="inputZip">الجنسيه </label>
                              <select
                                v-model="nationalityselected"
                                name="type"
                                id="type"
                                class="form-control"
                                required
                              >
                                <option
                                  v-for="nationality in nationalities"
                                  v-bind:value="nationality.id"
                                >
                                  {{ nationality.name }}
                                </option>
                              </select>
                            </div>
                            <hr />
                            <div class="form-group col-md-2">
                              <label for="inputZip">الجنس </label>
                              <select
                                v-model="genderselected"
                                name="type"
                                id="type"
                                class="form-control"
                                required
                              >
                                <option v-bind:value="1">ذكر</option>
                                <option v-bind:value="2">انثى</option>
                              </select>
                            </div>

                            <div class="form-group col-md-4">
                              <label for="inputZip">توع المؤظف </label>
                              <select
                                v-model="social_statusselected"
                                name="type"
                                id="type"
                                class="form-control"
                                required
                              >
                                <option v-bind:value="1">متعاقد</option>
                                <option v-bind:value="2">رسمي</option>
                              </select>
                            </div>

                            <div class="form-group col-md-4">
                              <label for="inputZip">تاريخ المبلاد </label>
                              <input
                                v-model="barth_date"
                                type="date"
                                class="form-control"
                                id="inputZip"
                              />
                            </div>

                            <hr />
                            <div class="form-group col-md-6">
                              <label for="inputZip">الديانه </label>
                              <select
                                v-model="religionselected"
                                name="type"
                                id="type"
                                class="form-control"
                                required
                              >
                                <option
                                  v-for="religion in religions"
                                  v-bind:value="religion.id"
                                >
                                  {{ religion.name }}
                                </option>
                              </select>
                            </div>

                            <div class="form-group col-md-2">
                              <label for="inputZip"> الحاله الاجتماعيه </label>
                              <select
                                v-model="staff_statusselected"
                                name="type"
                                id="type"
                                class="form-control"
                                required
                              >
                                <option v-bind:value="1">عازب</option>
                                <option v-bind:value="2">متزوج</option>
                              </select>
                            </div>

                            <div class="form-group col-md-4">
                              <label for="inputZip"> البريد الالكتروني</label>
                              <input
                                v-model="email"
                                type="text"
                                class="form-control"
                                id="inputZip"
                              />
                            </div>
                          </div>
                        </div>
                        <div class="card-footer pb-0">
                          <div class="d-flex justify-content-between">
                            <i class="mdi mdi-dots-horizontal text-gray"></i>
                          </div>
                        </div>
                      </div>

                      <button
                        type="submit"
                        class="btn btn-primary btn-lg btn-block"
                      >
                        حفظ
                      </button>
                    </form>
                  </div>
                  <!--/div-->
                </div>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>

          <!-- /.modal-dialog -->
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

      staffs: {
        type: Object,
        default: null,
      },
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

      word_search: "",
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
          this.staffs = data.staffs;

          // this.$root.logo = "Category";
        });
    },
    delete_staff(id) {
      this.axios
        .post(`delete_staff/${id}`)
        .then((response) => {
          toastMessage("تم الحذف بنجاح");

          this.list();
          // this.$router.push('category')
        })
        .catch((error) => {
          console.log(error.response);

          if (error.response.status == 500) {
            toast.fire({
              title: " فشل",
              text: error.response.data.message,
              button: "Close", // Text on button
              icon: "error", //built in icons: success, warning, error, info
              timer: 5000, //timeOut for auto-close
              buttons: {
                confirm: {
                  text: "OK",
                  value: true,
                  visible: true,
                  className: "",
                  closeModal: true,
                },
                cancel: {
                  text: "Cancel",
                  value: false,
                  visible: true,
                  className: "",
                  closeModal: true,
                },
              },
            });
          }
        });
    },
    list(page = 1) {
      this.axios
        .post(`/staff?page=${page}`)
        .then(({ data }) => {
          this.staffs = data.staffs;
          this.jobs = data.jobs;
          this.qualifications = data.qualifications;
          this.nationalities = data.nationalities;
          this.religions = data.staff_religions;
          this.staff_types = data.staff_types;
          this.branches = data.branches;
          this.departments = data.departments;
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },
    submitForm(e) {
      e.preventDefault();
      let currentObj = this;
      const config = {
        headers: {
          "content-type": "multipart/form-data",
        },
      };
      // form data
      let formData = new FormData();

      formData.append("name", this.name);
      formData.append("card", this.card);
      formData.append("job", this.jobselected);
      formData.append("branch", this.branchselected);
      formData.append("department", this.departmentselected);
      formData.append("phone", this.phone);
      formData.append("register", this.registerselected);

      formData.append("date", this.date);
      formData.append("staff_status", this.staff_statusselected);
      formData.append("qualification", this.qualificationselected);
      formData.append("nationality", this.nationalityselected);
      formData.append("gender", this.genderselected);
      formData.append("staff_type", this.staff_typeselected);
      formData.append("barth_date", this.barth_date);
      formData.append("religion", this.religionselected);
      formData.append("social_status", this.social_statusselected);
      formData.append("email", this.email);

      // send upload request
      this.axios
        .post("/store_staff", formData, config)
        .then(function (response) {
          console.log("hhhhhhhhhhhhhhhhhhhhhhh");
          console.log(response);
          currentObj.success = response.data.success;
          currentObj.filename = "";

          e.preventDefault();
          toastMessage("تم الاضافه بنجاح");
        })
        .catch(function (error) {
          currentObj.output = error;
        });

      //  this.$router.go(-1);
    },
  },
};
</script>

