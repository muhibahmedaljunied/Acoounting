<template>
  <!-- row opened -->
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header ">

          <span class="h2"> الاجازات</span>








          <div style="display: flex;float: left; margin: 5px">
            <a class="tn btn-info btn-sm waves-effect btn-agregar" data-toggle="modal" id="agregar_productos"
              data-target="#addholiday">
              <i class="fa fa-plus-circle"></i></a>

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
                  <th class="wd-15p border-bottom-0">اسم المؤظف</th>

                  <th class="wd-15p border-bottom-0">نوع الاجازه</th>

                  <th class="wd-15p border-bottom-0">عدد الايام</th>
                  <th class="wd-15p border-bottom-0">تاريخ بدء الاجازه</th>
                  <th class="wd-15p border-bottom-0">تاريخ انتهاء الاجازه</th>

                  <th class="wd-15p border-bottom-0">العمليات</th>
                </tr>
              </thead>
              <tbody v-if="value_list && value_list.data.length > 0">
                <tr v-for="(vacation, index) in value_list.data" :key="index">
                  <td>{{ vacation.name }}</td>

                  <td>

                    <div v-for="(vacation_names, index) in vacation.vacation" :key="index">
                      {{ vacation_names.vacation_type.name }}
                      <hr>
                    </div>
                  </td>

                  <td>

                    <div v-for="(vacation_number, index) in vacation.vacation" :key="index">
                      {{ vacation_number.total_days }}
                      <hr>
                    </div>
                  </td>

                  <td>

                    <div v-for="(vacation_start_date, index) in vacation.vacation" :key="index">
                      {{ vacation_start_date.start_date }}
                      <hr>
                    </div>
                  </td>


                  <td>

                    <div v-for="(vacation_end_date, index) in vacation.vacation" :key="index">
                      {{ vacation_end_date.end_date }}
                      <hr>
                    </div>
                  </td>



                  <!-- <td>{{ vacation.type }}</td> -->
                  <!--                 
                  <td>{{ vacation.start_date }}</td>
                  <td>{{ vacation.end_date }}</td> -->
                  <!-- <td>{{ vacation.total_days }}</td> -->




                  <td>
                    <!-- <a data-toggle="modal" data-target="#modal_vaciar" class="tn btn-danger btn-lg waves-effect btn-agregar"><i class="fa fa-trash"></i></a> -->
                    <button type="button" @click="delete_holiday(vacation.id)" class="btn btn-danger btn-sm waves-effect">
                      <i class="fa fa-trash"></i>
                    </button>

                    <a class="tn btn-info btn-sm waves-effect btn-agregar" data-toggle="modal" id="agregar_productos"
              data-target="#addExtra">
              <i class="fa fa-edit"></i></a>
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

                          <form method="post" @submit.prevent="submitForm" enctype="multipart/form-data">

                            <div class="table-responsive">
                              <table class="table table-bordered text-right m-t-30"
                                style="width: 100%; font-size: x-small">
                                <thead>
                                  <tr>

                                    <th>اسم المؤظف</th>


                                    <th>نوع الاجازه</th>
                                    <th> تاريخ بدء الاجازه </th>

                                    <th> تاريخ اتتها الاجازه </th>

                                    <th> عدد الايام </th>
                                    <th> رصيد الاجازات</th>
                                    <th>اضافه</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr v-for="index in count" :key="index">
                                    <td>
                                      <select v-model="staff_selected[index]" id="inputState" class="form-control">
                                        <option v-for="staff in staffs" v-bind:value="staff.id">
                                          {{ staff.name }}
                                        </option>
                                      </select>
                                    </td>
                                    <td>

                                      <select v-model="vacation_typeselected[index]" id="inputState" class="form-control">
                                        <option v-for="vacation_type in vacation_types" v-bind:value="vacation_type.id">
                                          {{ vacation_type.name }}
                                        </option>
                                      </select>

                                    </td>
                                    <td>




                                      <input v-model="start_date[index]" type="date" class="form-control"
                                        name="exampleRadios" />



                                    </td>
                                    <td>


                                      <input v-model="end_date[index]" type="date" name="exampleRadios"
                                        class="form-control" />

                                    </td>
                                    <td>


                                      <input readonly @change="on_change_date()" v-model="days" type="number" name="exampleRadios"
                                        class="form-control" />

                                    </td>
                                    <td>


                                      <input readonly v-model="days" type="number" name="exampleRadios" class="form-control" />

                                    </td>
                                    <td>

                                      <div v-if="index == 1">
                                        <a class="tn btn-info btn-sm waves-effect btn-agregar"
                                          v-on:click="addComponent(count)">
                                          <i class="fa fa-plus-circle"></i></a>

                                        <a class="tn btn-info btn-sm waves-effect btn-agregar"
                                          v-on:click="disComponent(count)">
                                          <i class="fa fa-minus-circle"></i></a>


                                      </div>
                                    </td>




                                  </tr>
                                 

                                </tbody>
                              </table>
                            </div>
                          </form>




                        </div>
                      </div>



                    </form>
                  </div>
                  <!--/div-->
                </div>
              </div>

              <div class="modal-footer">
                <a href="javascript:void" @click="Add_newleave()" class="btn btn-success"><span>تاكيد
                                      العمليه</span></a>
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
import operation from '../../../../../js/staff/operation/operation.js';
export default {
  components: {
    pagination,
  },
  mixins: [operation],
  data() {
    return {
      // category: "yes",

      value_list: {
        type: Object,
        default: null,
      },
      count: 1,
      counts: {},
      staff_selected: [],
      start_date: [],
      end_date: [],
      days: 2,
      name: "",

      staffs: "",
      jobselected: 1,
      branchselected: 1,
      staff_typeselected: 1,
      vacation_typeselected: [],
      // staffselected: 1,

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
    this.counts[0] = 1;
    this.type = 'leave';
  },
  methods: {
    data_list() {

      return {
        type: this.type,
        count: this.counts,
        staff: this.staff_selected,
        leave_type: this.vacation_typeselected,
        start_date: this.start_date,
        end_date: this.end_date,
        days: this.days,
      }
    },
    get_search(word_search) {
      this.axios
        .post(`/vacationsearch`, { word_search: this.word_search })
        .then(({ data }) => {
          this.vacations = data;

          // this.$root.logo = "Category";
        });
    },
    // delete_vaction(id) {
    //   this.axios
    //     .post(`delete_vacation/${id}`)
    //     .then((response) => {
    //       toastMessage("تم الحذف بنجاح");

    //       this.list();
    //       // this.$router.push('category')
    //     })
    //     .catch((error) => {
    //       console.log(error.response);

    //       if (error.response.status == 500) {
    //         toast.fire({
    //           title: " فشل",
    //           text: error.response.data.message,
    //           button: "Close", // Text on button
    //           icon: "error", //built in icons: success, warning, error, info
    //           timer: 5000, //timeOut for auto-close
    //           buttons: {
    //             confirm: {
    //               text: "OK",
    //               value: true,
    //               visible: true,
    //               className: "",
    //               closeModal: true,
    //             },
    //             cancel: {
    //               text: "Cancel",
    //               value: false,
    //               visible: true,
    //               className: "",
    //               closeModal: true,
    //             },
    //           },
    //         });
    //       }
    //     });
    // },
    // select_staff() {
    //   this.axios
    //     .post(`/select_staff`, {
    //       branch: this.branchselected,
    //       staff_type: this.staff_typeselected,
    //       job: this.jobselected,
    //     })
    //     .then((response) => {
    //       console.log(response);
    //       this.staff_on_change = response;
    //     });
    // },
    list(page = 1) {
      this.axios
        .post(`/vacation?page=${page}`)
        .then(({ data }) => {
          this.value_list = data.list;
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

    on_change_date() {

      alert('fdfdf');
      // var date1 = new Date("06/30/2019");
      // var date2 = new Date("07/30/2019");

      // // To calculate the time difference of two dates
      // var Difference_In_Time = date2.getTime() - date1.getTime();

      // // To calculate the no. of days between two dates
      // var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);

      // //To display the final no. of days (result)
      // console.log("Total number of days between dates  <br>"
      //   + date1 + "<br> and <br>"
      //   + date2 + " is: <br> "
      //   + Difference_In_Days);


    },
    Add_newleave() {
      console.log(this.counts);
      this.axios
        .post(`/store_leave`, {
          type: this.type,
          count: this.counts,
          staff: this.staff_selected,
          leave_type: this.vacation_typeselected,
          start_date: this.start_date,
          end_date: this.end_date,
          days: this.days,

        })
        .then((response) => {
          // ---------------------------------------------------------------
          console.log(response);

          // this.temporale = response.data;
          // this.temporale.forEach((item) => {
          //   this.total_quantity = item.tem_qty + this.total_quantity;

          //   this.grand_total = item.subtotal + this.grand_total;
          //   this.To_pay = item.subtotal + this.To_pay;

          //   this.total_tax = item.tax + this.total_tax;

          //  console.log(this.total_tax);


          // });

          toastMessage("تم الاضافه بنجاح");
          // this.$router.go(0);
        });

      // this.$router.go(0);

    },


  },
};
</script>

