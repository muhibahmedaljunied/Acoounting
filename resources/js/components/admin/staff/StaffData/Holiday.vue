<template>
  <!-- row opened -->
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header pb-0">
          <!-- <div class="d-flex justify-content-between">
            <span class="h2"> الاجازات</span>
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


          <!-- <div class="d-flex justify-content-right">
            <a
              class="tn btn-info btn-lg waves-effect btn-agregar"
              data-toggle="modal"
              id="agregar_productos"
              data-target="#addholiday"
            >
              <i class="fa fa-plus-circle"></i
            ></a>

            <input
              type="search"
              autocomplete="on"
              name="search"
              data-toggle="dropdown"
              role="button"
              aria-haspopup="true"
              aria-expanded="true"
              placeholder="بحث عن صنف"
              v-model="word_search"
              @input="get_search()"
            />

            <div></div>
          </div> -->
        </div>
        <div class="card-body" id="printme">
          <div class="table-responsive">
            <table class="table table-bordered text-center">
              <thead>
                <tr>
                  <th class="wd-15p border-bottom-0">اسم المؤظف</th>

                  <th class="wd-15p border-bottom-0">نوع الاجازه</th>

                  <th class="wd-15p border-bottom-0">عدد الايام</th>
                  <th class="wd-15p border-bottom-0">تاريخ بدء الاجازه</th>
                  <th class="wd-15p border-bottom-0">تاريخ انتهاء الاجازه</th>
              
                  <th class="wd-15p border-bottom-0">العمليات</th>
                </tr>
              </thead>
              <tbody v-if="vacations && vacations.data.length > 0">
                <tr v-for="(vacation, index) in vacations.data" :key="index">
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




                  <td>
                    <!-- <a data-toggle="modal" data-target="#modal_vaciar" class="tn btn-danger btn-lg waves-effect btn-agregar"><i class="fa fa-trash"></i></a> -->
                    <button type="button" @click="delete_holiday(vacation.id)" class="btn btn-danger">
                      <i class="fa fa-trash"></i>
                    </button>

                    <router-link :to="{
                      name: 'edit_holiday',
                      params: { id: vacation.id },
                    }" class="edit btn btn-success">
                      <i class="fa fa-edit"></i></router-link>
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
          <pagination align="center" :data="vacations" @pagination-change-page="list"></pagination>
        </div>
        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
          aria-hidden="true" style="display: none" id="addholiday">
          <div class="modal-dialog modal-lg" style="max-width: 600%">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
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
                            <h4 class="card-title mg-b-0">
                              <span class="h2"> الاجازات</span>
                            </h4>
                            <i class="mdi mdi-dots-horizontal text-gray"></i>
                          </div>
                        </div>

                        <div class="card-body">
                          <form>
                            <div class="form-row">
                              <div class="form-group col-md-2">
                                <label for="inputState">الفرع</label>
                                <select v-model="branchselected" id="inputState" class="form-control">
                                  <option v-for="branch in branches" v-bind:value="branch.id">
                                    {{ branch.name }}
                                  </option>
                                </select>
                              </div>

                              <div class="form-group col-md-2">
                                <label for="inputState">نوع المؤظف</label>
                                <select v-model="staff_typeselected" id="inputState" class="form-control">
                                  <option v-for="staff_type in staff_types" v-bind:value="staff_type.id">
                                    {{ staff_type.name }}
                                  </option>
                                </select>
                              </div>

                              <div class="form-group col-md-2">
                                <label for="inputState">الوظيفه</label>
                                <select @change="select_staff" v-model="jobselected" id="inputState"
                                  class="form-control">
                                  <option v-for="job in jobs" v-bind:value="job.id">
                                    {{ job.name }}
                                  </option>
                                </select>
                              </div>

                              <div class="form-group col-md-4">
                                <label for="inputState">اسم المؤظف</label>
                                <select v-model="staff_selected" id="inputState" class="form-control">
                                  <option v-for="staff in staffs" v-bind:value="staff.id">
                                    {{ staff.name }}
                                  </option>
                                </select>
                              </div>

                              <div class="form-group col-md-2">
                                <label for="inputState">نوع الاجازه</label>
                                <select v-model="vacation_typeselected" id="inputState" class="form-control">
                                  <option v-for="vacation_type in vacation_types" v-bind:value="vacation_type.id">
                                    {{ vacation_type.name }}
                                  </option>
                                </select>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                      <div class="card">
                        <div class="card-body">
                          <div class="form-row">
                            <div class="form-group col-md-4" style="text-align: center">
                              <div class="form-check">
                                <div>
                                  <label class="form-check-label" for="exampleRadios1">
                                    تاريخ بدء الاجازه
                                  </label>
                                  <input v-model="start_date" type="date" class="form-control" name="exampleRadios" />
                                </div>
                              </div>
                            </div>
                            <div class="form-group col-md-4" style="text-align: center">
                              <div class="form-check">
                                <div>
                                  <label class="form-check-label" for="exampleRadios1">
                                    تاريخ اتتها الاجازه
                                  </label>
                                  <input v-model="end_date" type="date" name="exampleRadios" class="form-control" />
                                </div>
                              </div>
                            </div>
                            <div class="form-group col-md-4" style="text-align: center">
                              <div class="form-check">
                                <div>
                                  <label class="form-check-label" for="exampleRadios1">
                                    عدد الايام
                                  </label>
                                  <input v-model="days" type="number" name="exampleRadios" class="form-control" />
                                </div>
                              </div>
                            </div>
                            <div class="form-group col-md-4" style="text-align: center">
                              <div class="form-check">
                                <div>
                                  <label class="form-check-label" for="exampleRadios1">
                                    رصيد الاجازات
                                  </label>
                                  <input v-model="days" type="number" name="exampleRadios" class="form-control" />
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <button type="submit" class="btn btn-primary btn-lg btn-block">
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

      vacations: {
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

      staff_on_change: "",
      vactions: "",
      jobs: "",
      branches: "",
      staff_types: "",
      vacation_types: "",
      word_search: "",
    };
  },
  mounted() {
    this.list();
  },
  methods: {
    Import() {
      this.axios.post(`/CategoryImport`).then(({ data }) => {
        console.log(data);

        this.list();
        toast.fire({
          title: "تم الاستيراد بنجاح",
          text: "Products are successfully exported.",
          button: "Close", // Text on button
          icon: "success", //built in icons: success, warning, error, info
          timer: 3000, //timeOut for auto-close
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
      });
    },
    Export() {
      this.axios.post(`/CategoryExport`).then((response) => {
        toast.fire({
          title: "تم التصدير بنجاح",
          text: "Products are successfully exported.",
          button: "Close", // Text on button
          icon: "success", //built in icons: success, warning, error, info
          timer: 3000, //timeOut for auto-close
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
        console.log(response.data.data);
      });
    },
    get_search(word_search) {
      this.axios
        .post(`/vacationsearch`, { word_search: this.word_search })
        .then(({ data }) => {
          this.vacations = data;

          // this.$root.logo = "Category";
        });
    },
    delete_vaction(id) {
      this.axios
        .post(`delete_vacation/${id}`)
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
    select_staff() {
      this.axios
        .post(`/select_staff`, {
          branch: this.branchselected,
          staff_type: this.staff_typeselected,
          job: this.jobselected,
        })
        .then((response) => {
          console.log(response);
          this.staff_on_change = response;
        });
    },
    list(page = 1) {
      this.axios
        .post(`/vacation?page=${page}`)
        .then(({ data }) => {
          this.vacations = data.vacations;
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

      formData.append("name", this.staff_selected);
      formData.append("vacation_type", this.vacation_typeselected);
      formData.append("start_date", this.start_date);
      formData.append("end_date", this.end_date);
      formData.append("days", this.days);

      // send upload request
      this.axios
        .post("/store_vacation", formData, config)
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

    printDiv(printme) {
      var printContents = document.getElementById(printme).innerHTML;
      var originalContents = document.body.innerHTML;

      document.body.innerHTML = printContents;

      window.print();

      document.body.innerHTML = originalContents;
    },
  },
};
</script>

