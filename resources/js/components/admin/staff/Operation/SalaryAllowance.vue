<template>
    <div>
        <div class="row row-sm">

            <div class="col-lg-12 col-md-12">
                <div class="card" id="basic-alert">
                    <div class="card-body">
                        <div>
                            <h6 class="card-title mb-1"> الرواتب والبدلات</h6>
                            <p class="text-muted card-sub-title">It is Very Easy to Customize and it uses in your
                                website apllication.</p>
                        </div>
                        <div class="text-wrap">
                            <div class="example">

                                <div class="panel panel-primary tabs-style-1">

                                    <form action="post">
                                        <div class="card">
                                            <div class="card-header pb-0">
                                                <!-- <div class="d-flex justify-content-between">
                            <h4 class="card-title mg-b-0">
                              <span class="h2"> الرواتب والبدلات</span>
                            </h4>
                            <i class="mdi mdi-dots-horizontal text-gray"></i>
                          </div> -->
                                            </div>
                                            <div class="card-body">
                                                <div class="form-row">


                                                    <div class="form-group col-md-2">
                                                        <label for="inputState">نوع المؤظف</label>
                                                        <select v-model="staff_typeselected" id="inputState"
                                                            class="form-control">
                                                            <option v-for="staff_type in staff_types"
                                                                v-bind:value="staff_type.id">
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
                                                        <select v-model="staffselected" id="inputState"
                                                            class="form-control">
                                                            <option v-for="staff in staffs" v-bind:value="staff.id">
                                                                {{ staff.name }}
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <!-- <div class="form-group col-md-2">
                                <label for="inputState">التاريخ</label>
  
                                <input v-model="date" class="form-control" type="date" name="exampleRadios" />
                              </div> -->

                                                    <div class="form-group col-md-2">
                                                        <label for="exampleRadios">الراتب</label><br />
                                                        <input v-model="salaryselected" class="form-control" type="number"
                                                            name="exampleRadios" />
                                                    </div>
                                                    <!-- <div class="form-group col-md-2">
                              <label for="exampleRadios">البدلات</label><br />
                              <input v-model="salaryselected" class="form-control" type="number" name="exampleRadios" />
                            </div> -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="form-row">



                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                </div>




                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <div class="col-lg-12 col-md-12">
                <div class="card" id="basic-alert">
                    <div class="card-body">
                        <div>
                            <h6 class="card-title mb-1">البدلات</h6>
                            <p class="text-muted card-sub-title">It is Very Easy to Customize and it uses in your
                                website apllication.</p>
                        </div>
                        <div class="text-wrap">
                            <div class="example">

                                <div class="panel panel-primary tabs-style-1">

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
                                                                <!-- <tr v-for="(allowance, index) in allowances"
                                                                    :key="index" class="form-check">
                                                                    <div v-if="allowance.allowance_type_id == 1">
                                                                        <td> <input v-model="checkselected[index]"
                                                                                @change="
                                                                                    handleAllowance(
                                                                                        index,
                                                                                        checkselected[index],
                                                                                        allowance.id
                                                                                    )
                                                                                " class="form-check-input" type="checkbox" name="exampleRadios"
                                                                                id="exampleRadios1" /></td>

                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input v-model="allowance.name" readonly
                                                                                    type="text" name="name" id="name"
                                                                                    class="form-control" />
                                                                            </div>
                                                                        </td>
                                                                        <td><input type="number" v-model="salv1[index]"
                                                                                class="form-control input_cantidad">
                                                                        </td>
                                                                    </div>
                                                                </tr>
                                                             -->

                                                                <tr class="form-check">

                                                                    <td> <input class="form-check-input" type="checkbox"
                                                                            name="exampleRadios" id="exampleRadios1" /></td>

                                                                    <td>
                                                                        <div class="form-group">
                                                                            <input readonly type="text" name="name"
                                                                                id="name" class="form-control" />
                                                                        </div>
                                                                    </td>
                                                                    <td><input type="number"
                                                                            class="form-control input_cantidad">
                                                                    </td>

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
                                                                <tr v-for="(allowance, index) in allowances" :key="index"
                                                                    class="form-check">
                                                                    <div v-if="allowance.allowance_type_id == 2">
                                                                        <td> <input v-model="checkselected[index]" @change="
                                                                            handleAllowance(
                                                                                index,
                                                                                checkselected[index],
                                                                                allowance.id
                                                                            )
                                                                        " class="form-check-input"
                                                                                type="checkbox" name="exampleRadios">
                                                                        </td>

                                                                        <td>

                                                                            <div class="form-group">
                                                                                <input v-model="allowance.name" readonly
                                                                                    type="text" name="name" id="name"
                                                                                    class="form-control" />
                                                                            </div>

                                                                        </td>
                                                                        <td><input v-model="salv2[index]" type=" number"
                                                                                class="form-control input_cantidad">
                                                                        </td>
                                                                    </div>
                                                                </tr>
                                                            </tbody>

                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer"><button type="submit" class="btn btn-primary btn-flat pull-right"><i
                            class="fa fa-edit"></i> Update Details</button></div>
            </div>
        </div>
    </div>
</template>
<script>
import pagination from "laravel-vue-pagination";
import operation from '../../../../../js/staff/operation/operation.js';
export default {
    components: {
        pagination,
    },
    mixins: [operation],
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
            salv1: [],
            salv2: [],
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

        get_search(word_search) {
            this.axios
                .post(`/salarysearch`, { word_search: this.word_search })
                .then(({ data }) => {
                    // this.salarys = data.salarys;
                    this.staff_allowances = data.staff_allowances;
                    // this.$root.logo = "Category";
                });
        },
        // delete_salary(id) {
        //     this.axios
        //         .post(`delete_salary/${id}`)
        //         .then((response) => {
        //             toastMessage("تم الحذف بنجاح");

        //             this.list();
        //             // this.$router.push('category')
        //         })
        //         .catch((error) => {
        //             console.log(error.response);

        //             if (error.response.status == 500) {
        //                 toast.fire({
        //                     title: " فشل",
        //                     text: error.response.data.message,
        //                     button: "Close", // Text on button
        //                     icon: "error", //built in icons: success, warning, error, info
        //                     timer: 5000, //timeOut for auto-close
        //                     buttons: {
        //                         confirm: {
        //                             text: "OK",
        //                             value: true,
        //                             visible: true,
        //                             className: "",
        //                             closeModal: true,
        //                         },
        //                         cancel: {
        //                             text: "Cancel",
        //                             value: false,
        //                             visible: true,
        //                             className: "",
        //                             closeModal: true,
        //                         },
        //                     },
        //                 });
        //             }
        //         });
        // },
        // list(page = 1) {
        //     this.axios
        //         .post(`/salary?page=${page}`)
        //         .then(({ data }) => {
        //             this.staffs = data.staffs;
        //             // this.salarys = data;
        //             this.jobs = data.jobs;
        //             this.branches = data.branches;
        //             this.staff_types = data.staff_types;
        //             this.allowances = data.allowances;
        //             this.staff_allowances = data.staff_allowances;
        //         })
        //         .catch(({ response }) => {
        //             console.error(response);
        //         });
        // },
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

    },
};

</script>