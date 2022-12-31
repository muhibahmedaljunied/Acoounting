<template>
  <!-- row opened -->
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header pb-0">
          <!-- <div class="d-flex justify-content-between">
            <span class="h2">بيانات الراتب</span>
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
                  <!-- <th class="wd-15p border-bottom-0">الرقم الوظيفي</th> -->
                  <th class="wd-15p border-bottom-0">اسم المؤظف</th>
                  <!-- <th class="wd-15p border-bottom-0">الفرع</th>
                  <th class="wd-15p border-bottom-0">القسم</th> -->
                  <th class="wd-15p border-bottom-0">الراتب الاساسي</th>
                  <th class="wd-15p border-bottom-0"> اضافي</th>
                  <th class="wd-15p border-bottom-0">بدل</th>
                   <th class="wd-15p border-bottom-0">خصم</th>
                   <th class="wd-15p border-bottom-0">سلفه</th>
                   <th class="wd-15p border-bottom-0"> الاجمالي</th>
                    
                  <th class="wd-15p border-bottom-0">العمليات</th>
                </tr>
              </thead>
              <tbody v-if="staff_allowances && staff_allowances.data.length > 0">
                <tr v-for="(staff_allowance, index) in staff_allowances.data" :key="index">


                  <td>{{ staff_allowance.staff }}</td>
                  <!-- <td>{{ staff_allowance.personal_card }}</td>
                  <td>{{ staff_allowance.job }}</td> -->
                  <td>{{ staff_allowance.net_salary }}</td>
                   <td>{{ staff_allowance.total_extra }}</td>
                   <td>{{ staff_allowance.total_allowance }}</td>
                  <td>{{ staff_allowance.total_discount }}</td>
                  <td>{{ staff_allowance.total_discount }}</td>
                  <td>{{ staff_allowance.total_discount+staff_allowance.net_salary+staff_allowance.total_extra+staff_allowance.total_allowance }}</td>
                  <td>
                    <button type="button" class="btn btn-danger">
                      <i class="fa fa-trash"></i>
                    </button>

                    <!-- <router-link
                      :to="{
                        name: 'edit_staff',
                        params: { id: staff.id },
                      }"
                      class="edit btn btn-success"
                    >
                      <i class="fa fa-edit"></i
                    ></router-link> -->
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
          <pagination align="center" :data="staff_allowances" @pagination-change-page="list"></pagination>
        </div>
        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
          aria-hidden="true" style="display: none" id="addsalary">
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
                    <form action="post">
                      <div class="card">
                        <div class="card-header pb-0">
                          <div class="d-flex justify-content-between">
                            <h4 class="card-title mg-b-0">
                              <span class="h2"> الرواتب والبدلات</span>
                            </h4>
                            <i class="mdi mdi-dots-horizontal text-gray"></i>
                          </div>
                        </div>
                        <div class="card-body">
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
                              <select v-model="jobselected" id="inputState" class="form-control">
                                <option v-for="job in jobs" v-bind:value="job.id">
                                  {{ job.name }}
                                </option>
                              </select>
                            </div>

                            <div class="form-group col-md-2">
                              <label for="inputState">اسم المؤظف</label>
                              <select v-model="staffselected" id="inputState" class="form-control">
                                <option v-for="staff in staffs" v-bind:value="staff.id">
                                  {{ staff.name }}
                                </option>
                              </select>
                            </div>

                            <div class="form-group col-md-2">
                              <label for="inputState">التاريخ</label>

                              <input v-model="date" class="form-control" type="date" name="exampleRadios" />
                            </div>

                            <div class="form-group col-md-2">
                              <label for="exampleRadios">الراتب</label><br />
                              <input v-model="salaryselected" class="form-control" type="number" name="exampleRadios" />
                            </div>
                            <div class="form-group col-md-2">
                              <label for="exampleRadios">البدلات</label><br />
                              <input v-model="salaryselected" class="form-control" type="number" name="exampleRadios" />
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="card">
                        <div class="card-body">
                          <div class="form-row">
                            <div class="form-group col-md-6" style="text-align: center">
                              <h5>البدلات الشهريه</h5>

                              <!-- <div
                                v-for="(allowance, index) in allowances"
                                :key="index"
                                class="form-check"
                              >
                                <div v-if="allowance.allowance_type_id == 1">
                                  <label
                                    class="form-check-label"
                                    for="exampleRadios1"
                                  >
                                    {{ allowance.name }}
                                  </label>
                                  <input
                                    v-model="checkselected[index]"
                                    @change="
                                      handleAllowance(
                                        index,
                                        checkselected[index],
                                        allowance.id
                                      )
                                    "
                                    class="form-check-input"
                                    type="checkbox"
                                    name="exampleRadios"
                                    id="exampleRadios1"
                                  
                                  />
                                </div>
                              </div> -->

                              <div class="table-responsive">
                                <table class="table table-bordered text-right">
                                  <thead>
                                    <tr>

                                      <th>#</th>
                                      <th>اسم البدل</th>
                                      <th>المبلغ</th>


                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr v-for="(allowance, index) in allowances" :key="index" class="form-check">
                                      <div v-if="allowance.allowance_type_id == 1">
                                        <td> <input v-model="checkselected[index]" @change="
                                          handleAllowance(
                                            index,
                                            checkselected[index],
                                            allowance.id
                                          )
                                        " class="form-check-input" type="checkbox" name="exampleRadios"
                                            id="exampleRadios1" /></td>

                                        <td>
                                          <div class="form-group">
                                            <input v-model="allowance.name" readonly type="text" name="name" id="name"
                                              class="form-control" />
                                          </div>
                                        </td>
                                        <td><input type="number" v-model="salv1[index]"
                                            class="form-control input_cantidad"></td>
                                      </div>
                                    </tr>
                                  </tbody>

                                </table>
                              </div>
                            </div>

                            <div class="form-group col-md-6" style="text-align: center">
                              <h5>البدلات الغير الشهريه</h5>
                              <!-- <div v-for="(allowance, index) in allowances" :key="index" class="form-check">
                                <div v-if="allowance.allowance_type_id == 2">
                                  <label class="form-check-label" for="exampleRadios1">
                                    {{ allowance.name }}
                                  </label>
                                  <input v-model="checkselected[index]" @change="
                                    handleAllowance(
                                      index,
                                      checkselected[index],
                                      allowance.id
                                    )
                                  " class="form-check-input" type="checkbox" name="exampleRadios"
                                    id="exampleRadios1" />
                                </div>
                              </div> -->


                              <div class="table-responsive">
                                <table class="table table-bordered text-right">
                                  <thead>
                                    <tr>
                                      <th>#</th>
                                      <th>اسم البدل</th>
                                      <th>المبلغ</th>


                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr v-for="(allowance, index) in allowances" :key="index" class="form-check">
                                      <div v-if="allowance.allowance_type_id == 2">
                                        <td> <input v-model="checkselected[index]" @change="
                                          handleAllowance(
                                            index,
                                            checkselected[index],
                                            allowance.id
                                          )
                                        " class="form-check-input" type="checkbox" name="exampleRadios">
                                        </td>

                                        <td>

                                          <div class="form-group">
                                            <input v-model="allowance.name" readonly type="text" name="name" id="name"
                                              class="form-control" />
                                          </div>

                                        </td>
                                        <td><input v-model="salv2[index]" type=" number"
                                            class="form-control input_cantidad"></td>
                                      </div>
                                    </tr>
                                  </tbody>

                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <a href="javascript:void" @click="submitForm()" class="btn btn-success"><span>تاكيد
                          العمليه</span></a>
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
 
       salarys: {
         type: Object,
         default: null,
       },
       branchselected: "",
       staff_allowances: "",
       salaryselected: "",
       date: "",
       allowances: "",
       salv1:[],
       salv2:[],
       allowance: [],
       checkselected: [],
       staffselected: 1,
       jobselected: 1,
       brancheselected: 1,
       staff_typeselected: 1,
 
       staffs: "",
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
         .post(`/salarysearch`, { word_search: this.word_search })
         .then(({ data }) => {
           // this.salarys = data.salarys;
           this.staff_allowances = data.staff_allowances;
           // this.$root.logo = "Category";
         });
     },
     delete_salary(id) {
       this.axios
         .post(`delete_salary/${id}`)
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
         .post(`/salary?page=${page}`)
         .then(({ data }) => {

          console.log(data.staff_allowances);
           this.staffs = data.staffs;
           // this.salarys = data;
           this.jobs = data.jobs;
           this.branches = data.branches;
           this.staff_types = data.staff_types;
           this.allowances = data.allowances;
           this.staff_allowances = data.staff_allowances;
         })
         .catch(({ response }) => {
           console.error(response);
         });
     },
     handleAllowance(index, valueselected, allowance_id) {
       this.allowance[index] = {
         id: allowance_id,
         qty: 1,
         check: valueselected,
         name: this.staffselected,
 
       };
 
       console.log(this.allowance);
     },
     submitForm() {
       //  console.log(this.allowance);
       this.axios
         .post("/store_salary", {
           allowance: this.allowance,
           staff_id: this.staffselected,
           date: this.date,
           salary: this.salaryselected,
 
         })
         .then(function (response) {
           console.log("hhhhhhhhhhhhhhhhhhhhhhh");
           console.log(response);
 
           toastMessage("تم الاضافه بنجاح");
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
       //
 </script>

