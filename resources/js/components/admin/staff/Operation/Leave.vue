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
                      {{ vacation_number.vacation_type.duration }}
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
                                      <select v-model="staffselected[index]" id="inputState" class="form-control">
                                        <option v-for="staff in staffs" v-bind:value="staff.id">
                                          {{ staff.name }}
                                        </option>
                                      </select>
                                    </td>
                                    <td>

                                      <select v-model="leave_typeselected[index]" id="inputState" class="form-control">
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



                                      <input @keypress="calc_days(index)" v-model="days[index]" type="number"
                                        id="num_days" name="exampleRadios" class="form-control" />

                                    </td>
                                    <td>


                                      <input type="number" id="numddd_days" name="exampleRadios" class="form-control" />

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
                <button type="button" class="btn btn-primary" @click="Add_new()">حفظ </button>

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              </div>

            </div>
          </div>

        </div>
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

      value_list: {
        type: Object,
        default: null,
      },

      leave_typeselected: [],
      leaveselected: [],
      leavepartselected: [],
      start_date: [],
      end_date: [],
      days: [],

      word_search: "",
    };
  },
  mounted() {
    this.list();
    this.counts[0] = 1;
    this.type = 'leave';
  },
  methods: {
    Add_new() {

      this.Add(
        {
          type: this.type,
          count: this.counts,
          staff: this.staffselected,
          leave_type: this.leave_typeselected,
          leave: this.leaveselected,
          leave_part: this.leavepartselected,
          start_date: this.start_date,
          end_date: this.end_date,
          days: this.days,

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

    calc_days(index) {


      var start_date = this.start_date[index].split("-");
      var end_date = this.end_date[index].split("-");

      var date1 = new Date(`${start_date[0]}/${start_date[1]}/${start_date[2]}`);
      var date2 = new Date(`${end_date[0]}/${end_date[1]}/${end_date[2]}`);

      // To calculate the time difference of two dates
      var Difference_In_Time = date2.getTime() - date1.getTime();

      // To calculate the no. of days between two dates
      var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);

      //To display the final no. of days (result)
      console.log("Total number of days between dates <br>"
        + date1 + "<br> and <br>"
        + date2 + " is: <br> "
        + Difference_In_Days);

      this.days[index] = Difference_In_Days;
      $(`#num_days`).val(Difference_In_Days);



    },

    list(page = 1) {
      this.axios
        .post(`/vacation?page=${page}`,{ type: 'vacation'})
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


  },
};
</script>

