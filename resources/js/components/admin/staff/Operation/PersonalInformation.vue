<template>
  <!-- row opened -->
  <div class="container-fluid">
    <div class="row row-sm">

      <div class="col-xl-12">
        <div class="card">
          <div class="card-header">

            <span class="h2"> البيانات الشخصيه</span>



            <div style="display: flex;float: left; margin: 5px">

              <!-- <a class="btn btn-info btn-sm waves-effect btn-agregar" data-toggle="modal" id="agregar_productos"
            data-target="#addPI">
            <i class="fa fa-plus-circle"></i></a> -->
              <a class="btn btn-info btn-sm waves-effect btn-agregar" data-toggle="modal" id="agregar_productos"
                data-target="#exampleModal">
                <i class="fa fa-plus-circle"></i>
              </a>


              <input autocomplete="on" v-model="word_search" type="text" class="form-control input-text"
                placeholder="بحث ...." aria-label="Recipient's username" aria-describedby="basic-addon2"
                @input="get_search()">

              <div></div>
            </div>
          </div>
          <div class="card-body" id="printme">
            <div class="table-responsive">
              <table class="table table-bordered text-center">
                <thead>
                  <tr>
                    <th class="wd-15p border-bottom-0">الرقم الوظيفي</th>
                    <th class="wd-15p border-bottom-0">اسم المؤظف</th>
                    <th class="wd-15p border-bottom-0">الهويه</th>
                    <th class="wd-15p border-bottom-0">تاريخ الميلاد</th>
                    <th class="wd-15p border-bottom-0">الهاتف</th>


                    <!-- <th class="wd-15p border-bottom-0">القسم</th> -->

                    <th class="wd-15p border-bottom-0">الوظيفه</th>
                    <th class="wd-15p border-bottom-0">الفرع</th>

                    <!-- <th class="wd-15p border-bottom-0">تاريخ التعين</th> -->
                    <th class="wd-15p border-bottom-0">الايميل</th>
                    <th class="wd-15p border-bottom-0">المؤهلات</th>
                    <th class="wd-15p border-bottom-0">الجنسيه</th>
                    <th class="wd-15p border-bottom-0">الحنس</th>
                    <!-- <th class="wd-15p border-bottom-0">نظام العمل</th> -->

                    <!-- <th class="wd-15p border-bottom-0">نوع المؤظف</th> -->
                    <!-- <th class="wd-15p border-bottom-0">الدياته</th> -->
                    <!-- <th class="wd-15p border-bottom-0">الحاله الاجتماعيه</th>
                <th class="wd-15p border-bottom-0">حاله الوظيفه</th> -->
                    <!-- <th class="wd-15p border-bottom-0">الراتب الاساسي</th> -->


                    <!-- <th class="wd-15p border-bottom-0">ملاجظه</th> -->

                    <th class="wd-15p border-bottom-0">العمليات</th>
                  </tr>
                </thead>
                <tbody v-if="value_list && value_list.data.length > 0">
                  <tr v-for="(staff, index) in value_list.data" :key="index">
                    <td>{{ staff.id }}</td>

                    <td>{{ staff.name }}</td>
                    <td>{{ staff.personal_card }}</td>
                    <td>{{ staff.barth_date }}</td>
                    <td>{{ staff.phone }}</td>

                    <td>{{ staff.department.text }}</td>
                    <td>{{ staff.job.text }}</td>
                    <td>{{ staff.branch.name }}</td>
                    <!-- <td>{{ staff.date }}</td> -->
                    <!-- <td>{{ staff.phone }}</td> -->
                    <td>{{ staff.email }}</td>
                    <!-- <td>{{ staff.barth_date }}</td> -->
                    <td>{{ staff.qualification.name }}</td>
                    <td>{{ staff.nationality.name }}</td>

                    <td v-if="staff.gender == 1">ذكر</td>
                    <td v-if="staff.gender == 0">انثي</td>



                    <td>
                      <!-- <a data-toggle="modal" data-target="#modal_vaciar" class="btn btn-danger btn-lg waves-effect btn-agregar"><i class="fa fa-trash"></i></a> -->
                      <button type="button" @click="delete_staff(staff.id)" class="btn btn-danger btn-sm waves-effect">
                        <i class="fa fa-trash"></i>
                      </button>

                      <!--  -->

                      <a class="btn btn-info btn-sm waves-effect btn-agregar" data-toggle="modal" id="agregar_productos"
                        @click="update_modal(staff)" data-target="#exampleModalupdate">
                        <i class="fa fa-edit"></i>
                      </a>

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
            <pagination align="center" :data="value_list" @pagination-change-page="list"></pagination>
          </div>

          <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <form method="post">
              <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                  <!-- <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                    اضافه
                  </div> -->


                  <div class="modal-body">
                    <div class="row row-sm">
                      <div class="col-xl-12">
                        <!-- <form method="post"> -->
                        <div class="card">
                          <div class="card-header pb-0">
                            <div class="d-flex justify-content-between">
                              <h4 class="modal-title" id="myLargeModalLabel">
                                بياتات الموظف
                              </h4>
                              <i class="mdi mdi-dots-horizontal text-gray"></i>
                            </div>
                          </div>
                          <div class="card-body">

                            <div class="row">
                              <fieldset class="scheduler-border">
                                <legend style="float: right;" class="scheduler-border"> البياتات الشخصيه
                                </legend>
                                <div class="row" style="line-height: 44px;">
                                  <div class="col-md-2">
                                    <label for="inputEmail4">اسم المؤظف</label>
                                    <input style="background-color: beige;" v-model="name" type="text"
                                      class="form-control" placeholder="ادخل اسم المؤظف" />
                                  </div>
                                  <div class="col-md-2">
                                    <label for="inputAddress">الفرع</label>
                                    <select style="background-color: beige;" v-model="branchselected" class="form-control"
                                      required>
                                      <option v-for="branch in branches" v-bind:value="branch.id">
                                        {{ branch.name }}
                                      </option>
                                    </select>
                                  </div>
                                  <div class="col-md-2">
                                    <label for="inputPassword4">الهويه</label>
                                    <input v-model="card" type="number" class="form-control" />
                                  </div>
                                  <div class="col-md-2">
                                    <label for="inputPassword4">الهاتف</label>
                                    <input v-model="phone" type="number" class="form-control" />
                                  </div>
                                  <div class="col-md-2">
                                    <label for="inputZip">تاريخ المبلاد </label>
                                    <input v-model="barth_date" type="date" class="form-control" id="inputZip" />
                                  </div>
                                  <div class="col-md-3">
                                    <label for="inputZip">المؤهلات </label>
                                    <select v-model="qualificationselected" name="type" id="type" class="form-control"
                                      required>
                                      <option v-for="qualification in qualifications" v-bind:value="qualification.id">
                                        {{ qualification.name }}
                                      </option>
                                    </select>
                                  </div>
                                  <div class="col-md-3">
                                    <label for="inputZip">الجنسيه </label>
                                    <select style="background-color: beige;" v-model="nationalityselected" name="type"
                                      id="type" class="form-control" required>
                                      <option v-for="nationality in nationalities" v-bind:value="nationality.id">
                                        {{ nationality.name }}
                                      </option>
                                    </select>
                                  </div>

                                  <div class="col-md-3">
                                    <label for="inputZip">الجنس </label>
                                    <select style="background-color: beige;" v-model="genderselected" name="type"
                                      id="type" class="form-control" required>
                                      <option v-bind:value="1">ذكر</option>
                                      <option v-bind:value="2">انثى</option>
                                    </select>
                                  </div>

                                  <div class="col-md-3">
                                    <label for="inputZip">توع المؤظف </label>
                                    <select v-model="social_statusselected" name="type" id="type" class="form-control"
                                      required>
                                      <option v-bind:value="1">متعاقد</option>
                                      <option v-bind:value="2">رسمي</option>
                                    </select>
                                  </div>
                                  <div class="col-md-2">
                                    <label for="inputZip">الديانه </label>
                                    <select style="background-color: beige;" v-model="religionselected" name="type"
                                      id="type" class="form-control" required>
                                      <option v-for="religion in religions" v-bind:value="religion.id">
                                        {{ religion.name }}
                                      </option>
                                    </select>
                                  </div>
                                  <div class="col-md-2">
                                    <label for="inputZip"> الحاله الاجتماعيه </label>
                                    <select style="background-color: beige;" v-model="staff_statusselected" name="type"
                                      id="type" class="form-control" required>
                                      <option v-bind:value="1">عازب</option>
                                      <option v-bind:value="2">متزوج</option>
                                    </select>
                                  </div>

                                  <div class="col-md-4">
                                    <label for="inputZip"> البريد الالكتروني</label>
                                    <input style="background-color: beige;" v-model="email" type="text"
                                      class="form-control" id="inputZip" />
                                  </div>
                                  <!-- 
                          <div class="col-md-2">
                            <label for="inputZip"> الراتب الاساسي</label>
                            <input v-model="salary" type="text" class="form-control" id="inputZip" />
                          </div> -->
                                </div>

                              </fieldset>




                            </div>
                            <!--  <div class="row">

                              <fieldset class="scheduler-border">
                                <legend class="scheduler-border">Technical Ameen</legend>

                                <div class="row">
                                 <div class="col-md-3">
                            <label for="inputAddress">القسم</label>
                            <select v-model="departmentselected" class="form-control" required>
                              <option v-for="department in departments" v-bind:value="department.id">
                                {{ department.name }}
                              </option>
                            </select>
                          </div> -->



                            <!-- <div class="col-md-3">
                            <label for="inputZip">نظام الدوام </label>


                            <select v-model="work_selected" name="type" class="form-control " required>
                              <option v-for="work_system in work_systems" v-bind:value="work_system.id">
                                {{ work_system.name }}
                              </option>
                            </select>
                          </div> 
                                </div>
                              </fieldset>






                            </div>-->
                            <div class="row">

                              <fieldset class="scheduler-border">
                                <legend style="float: right;" class="scheduler-border">بيانات التوظيف</legend>
                                <div class="row" style="line-height: 44px;">
                                  <div class="col-md-3">
                                    <label for="inputAddress">الهيكل الاداري</label>

                                    <div class="custom-search">
                                      <input style="background-color: beige;" :id="'Structure_structure_tree'" type="text"
                                        readonly class="custom-search-input">
                                      <input style="background-color: beige;" :id="'Structure_structure_tree_id'"
                                        type="hidden" readonly class="custom-search-input">

                                      <button class="custom-search-botton" type="button" data-toggle="modal"
                                        data-target="#exampleModalStructure"> <i class="fa fa-plus-circle"></i></button>
                                    </div>
                                  </div>
                                  <div class="col-md-3">
                                    <label for="inputAddress"> الوظيفه</label>

                                    <div class="custom-search">
                                      <select style="background-color: beige;" v-model="jobselected" id="select_structure"
                                        class="form-control" required>

                                      </select>

                                    </div>


                                  </div>
                                  <div class="col-md-3">
                                    <label for="inputCity">تاريخ التعين</label>
                                    <input v-model="date" type="date" class="form-control" />
                                  </div>

                                  <div class="col-md-2">
                                    <label for="inputCity">الراتب</label>
                                    <input v-model="salary" type="number" class="form-control" />
                                  </div>

                                  <div class="col-md-3">
                                    <label for="inputState">حاله المؤظف</label>
                                    <select v-model="statusselected" name="type" id="type" class="form-control" required>
                                      <option v-bind:value="1">بدء العمل</option>
                                      <option v-bind:value="2">لم يبدء العمل</option>
                                    </select>
                                  </div>
                                  <!-- <div class="col-md-3">
                                    <label for="inputAddress"> ح/راتب الموظف</label>

                                    <div class="custom-search">
                                      <input style="background-color: beige;" :id="'Structure_salary_tree'"
                                        type="text" readonly class="custom-search-input">
                                      <input style="background-color: beige;" :id="'Structure_salary_tree_id'"
                                        type="hidden" readonly class="custom-search-input">

                                      <button class="custom-search-botton" type="button" data-toggle="modal"
                                        data-target="#exampleModalSalary"  > <i
                                          class="fa fa-plus-circle"></i></button>
                                    </div>
                                  </div>

                                  <div class="col-md-3">
                                    <label for="inputAddress">ح/سلف الموظف </label>

                                    <div class="custom-search">
                                      <input style="background-color: beige;" :id="'Structure_advance_tree'"
                                        type="text" readonly class="custom-search-input">
                                      <input style="background-color: beige;" :id="'Structure_advance_tree_id'"
                                        type="hidden" readonly class="custom-search-input">

                                      <button class="custom-search-botton" type="button" data-toggle="modal"
                                        data-target="#exampleModalAdvance"> <i
                                          class="fa fa-plus-circle"></i></button>
                                    </div>
                                  </div> -->
                                </div>
                              </fieldset>




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
                    <button type="button" class="btn btn-primary" @click="submitForm()">حفظ </button>
                    <!-- <button type="button" class="btn btn-primary btn-lg btn-block" @click="submitForm()"@click="submitForm()">
                      حفظ
                    </button> -->
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </form>
          </div>

          <div class="modal fade" id="exampleModalStructure" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">

                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">

                  <div class="well" id="treeview_json_structure"></div>

                </div>

              </div>
            </div>
          </div>
          <!-- <div class="modal fade" id="exampleModalSalary" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">

                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">

                  <div class="well" id="treeview_json_salary"></div>

                </div>

              </div>
            </div>
          </div>
          <div class="modal fade" id="exampleModalAdvance" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">

                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">

                  <div class="well" id="treeview_json_advance"></div>

                </div>

              </div>
            </div>
          </div> -->
          <!-- <div class="modal fade" id="exampleModalStructureupdate" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">

                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">

                  <div class="well" id="treeview_json_structureupdate"></div>

                </div>

              </div>
            </div>
          </div> -->
          <!-- <div class="modal fade" id="exampleModalJob" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">

                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">

                  <div class="well" id="treeview_json_job"></div>

                </div>

              </div>
            </div>
          </div> -->
        </div>
      </div>
      <!--/div-->
    </div>
  </div>
  <!-- /row -->
</template>

<script>
import pagination from "laravel-vue-pagination";
import tree from '../../../../../js/tree/tree.js';

export default {
  components: {
    pagination,
  },
  mixins: [tree],
  data() {
    return {
      // category: "yes",

      value_list: {
        type: Object,
        default: null,
      },




      value_list_update: '',

      indexselectedstructure: '',
      indexselectedjob: '',
      structureselected: '',
      structureselectedname: '',
      jobselected: 1,
      jobselectedname: '',
      // -----------------------------------------------------------
      card: 234242424,
      email: "muhib@gmail.com",
      name: "fsdfsfsf",
      salary: '',
      // date: "asdadada",
      date: new Date().toISOString().substr(0, 10),
      // barth_date: "asdadad",
      barth_date: new Date().toISOString().substr(0, 10),
      phone: 1231313,
      social_statusselected: 1,
      genderselected: 1,
      statusselected: 1,
      staffselected: "adadad",
      staff_statusselected: 1,

      qualificationselected: 1,
      nationalityselected: 1,
      religionselected: 1,
      staff_typeselected: 1,
      registerselected: '',
      branchselected: '',

      registers: "",
      branches: "",
      departments: "",
      qualifications: "",
      jobs: "",
      nationalities: "",
      religions: "",
      staff_types: "",
      work_systems: '',
      word_search: "",
      work_selected: '',
      data_update: '',
    };
  },
  mounted() {
    this.list();
    this.type_of_tree = 1;
    this.type = 'Structure';
    this.showtree('structure','tree_structure');
    // this.showtree('job');
    // this.showtree('salary');
    // this.showtree('advance');
 
  },
  methods: {

    update_modal(data) {
      this.type = 'Structureupdate';
      this.data_update = data;
      this.branchselected = data.branch.id;
      this.jobselected = data.job.id;
      this.qualificationselected = data.qualification.id;
      this.staff_typeselected = data.staff_type.id;
      this.nationalityselected = data.nationality.id;
      this.work_selected = data.work_type.id;



    },
    detect_index_structure(index) {

      this.indexselectedstructure = index;
    },
    // detect_index_job(index) {

    //   this.indexselectedjob = index;
    // },
    get_search(word_search) {
      this.axios
        .post(`/staffsearch`, { word_search: this.word_search })
        .then(({ data }) => {
          this.staffs = data.staffs;

          // this.$root.logo = "Category";
        });
    },

    list(page = 1) {
      this.axios
        .post(`/staff?page=${page}`)
        .then(({ data }) => {
          console.log(data);
          this.value_list = data.list;
          // this.jobs = data.jobs;
          this.qualifications = data.qualifications;
          this.nationalities = data.nationalities;
          this.religions = data.staff_religions;
          this.staff_types = data.staff_types;
          this.branches = data.branches;
          // this.departments = data.departments;
          this.work_systems = data.work_systems;
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },
    submitForm() {

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
      formData.append("department", this.structureselected);
      formData.append("phone", this.phone);
      formData.append("register", this.registerselected);
      formData.append("work", this.work_selected);
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
      formData.append("salary", this.salary);


      // send upload request
      this.axios
        .post("/store_staff", formData, config)
        .then(function (response) {
          console.log("hhhhhhhhhhhhhhhhhhhhhhh");
          console.log(response);
          currentObj.success = response.data.success;
          currentObj.filename = "";

          // e.preventDefault();
          toastMessage("تم الاضافه بنجاح");
        })
        .catch(function (error) {
          currentObj.output = error;
        });

      // this.$router.go(0);
    },

    delete_staff(id) {

      this.axios.post(`/delete_staff/${id}`).then((response) => { });

      // toastMessage("تم الحذف", error.response.data.message.message, 'نجاح');


    },
  },
};
</script>

<style scoped>
fieldset.scheduler-border {
  border: 1px groove #ddd !important;
  padding: 0 1.4em 1.4em 1.4em !important;
  margin: 0 0 1.5em 0 !important;
  -webkit-box-shadow: 0px 0px 0px 0px #000;
  box-shadow: 0px 0px 0px 0px #000;
  margin-top: 30px !important;
}

legend.scheduler-border {
  font-size: 1.2em !important;
  font-weight: bold !important;
  text-align: center !important;
  width: auto;
  padding: 0 10px;
  border-bottom: none;
  margin-top: -15px;
  background-color: white;
  color: black;
}
</style>

