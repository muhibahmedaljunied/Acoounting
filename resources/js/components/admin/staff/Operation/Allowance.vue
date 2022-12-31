<template>
  <!-- row opened -->
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header pb-0">
          <div class="d-flex justify-content-between">
            <span class="h2"> الرواتب والبدلات</span>
          </div>

          <div class="d-flex justify-content-right">
            <!-- <router-link
                to="create_category"
                id="agregar_productos"
                class="tn btn-info btn-lg waves-effect btn-agregar"
                ><i class="fa fa-plus-circle"></i
              ></router-link> -->
            <a class="tn btn-info btn-lg waves-effect btn-agregar" data-toggle="modal" id="agregar_productos"
              data-target="#addsalary">
              <i class="fa fa-plus-circle"></i></a>


            <input type="search" autocomplete="on" name="search" data-toggle="dropdown" role="button"
              aria-haspopup="true" aria-expanded="true" placeholder="بحث عن صنف" v-model="word_search"
              @input="get_search()" />

            <div></div>
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

                  <th class="wd-15p border-bottom-0"> البدلات</th>
                  <th class="wd-15p border-bottom-0">العمليات</th>
                </tr>
              </thead>
              <tbody v-if="staff_allowances && staff_allowances.data.length > 0">
                <tr v-for="(staff_allowance, index) in staff_allowances.data" :key="index">


                  <td>{{ staff_allowance.staff }}</td>
                  <!-- <td>{{ staff_allowance.personal_card }}</td>
                    <td>{{ staff_allowance.job }}</td> -->
                  <td>{{ staff_allowance.salary }}</td>
                  <td>{{ staff_allowance.allowance }}</td>
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
          <div class="modal-dialog modal-lg" style="max-width: 1000%">
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
                            <!-- <div class="form-group col-md-2">
                                <label for="inputState">الفرع</label>
                                <select v-model="branchselected" id="inputState" class="form-control">
                                  <option v-for="branch in branches" v-bind:value="branch.id">
                                    {{ branch.name }}
                                  </option>
                                </select>
                              </div> -->

                            <!-- <div class="form-group col-md-2">
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
                            </div> -->

                            <div class="form-group col-md-2">
                              <label for="inputState">اسم المؤظف</label>
                              <select v-model="staffselected" id="inputState" class="form-control">
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
                              <input v-model="salaryselected" class="form-control" type="number" name="exampleRadios" />
                            </div>
                            <div class="form-group col-md-2">
                              <label for="exampleRadios">البدلات</label><br />
                              <input  class="form-control" type="number" name="exampleRadios" />
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="card">
                        <div class="card-body">
                          <div class="form-row">

                            <div class="form-group col-md-6" style="text-align: center">
                              <h5>البدلات الشهريه</h5>



                              <div class="table-responsive">
                                <table class="table table-bordered text-right">
                                  <thead>
                                    <tr>


                                      <th>اسم البدل</th>
                                      <th>المبلغ</th>
                                      <th>اضافه</th>


                                    </tr>
                                  </thead>
                                  <tbody>
                                   

                                    <tr v-for="index in count_" :key="index">



                                      <td>

                                        <input v-model="allow.allow_1[index - 1]" type="text" name="name" id="name"
                                          class="form-control" />

                                      </td>
                                      <td><input v-model="qty.qty_1[index - 1]" type="number"
                                          class="form-control input_cantidad"></td>

                                      <td v-if="index == 1">

                                        <a class="tn btn-info btn-sm waves-effect btn-agregar"
                                          v-on:click="addComponent(count.count_monthly, 0)">
                                          <i class="fa fa-plus-circle"></i></a>

                                        <a class="tn btn-info btn-sm waves-effect btn-agregar"
                                          v-on:click="disComponent(count.count_monthly, 0)">
                                          <i class="fa fa-minus-circle"></i></a>



                                      </td>


                                    </tr>

                                  </tbody>

                                </table>
                              </div>
                            </div>


                            <div class="form-group col-md-6" style="text-align: center">
                              <h5>البدلات الشهريه</h5>



                              <div class="table-responsive">
                                <table class="table table-bordered text-right">
                                  <thead>
                                    <tr>


                                      <th>اسم البدل</th>
                                      <th>المبلغ</th>
                                      <th>اضافه</th>


                                    </tr>
                                  </thead>
                                  <tbody>
                                   

                                    <tr v-for="index in count.count_monthly" :key="index">



                                      <td>

                                        <input v-model="allow.allow_1[index - 1]" type="text" name="name" id="name"
                                          class="form-control" />

                                      </td>
                                      <td><input v-model="qty.qty_1[index - 1]" type="number"
                                          class="form-control input_cantidad"></td>

                                      <td v-if="index == 1">

                                        <a class="tn btn-info btn-sm waves-effect btn-agregar"
                                          v-on:click="addComponent(count.count_monthly, 0)">
                                          <i class="fa fa-plus-circle"></i></a>

                                        <a class="tn btn-info btn-sm waves-effect btn-agregar"
                                          v-on:click="disComponent(count.count_monthly, 0)">
                                          <i class="fa fa-minus-circle"></i></a>



                                      </td>


                                    </tr>

                                  </tbody>

                                </table>
                              </div>
                            </div>

                            <div class="form-group col-md-6" style="text-align: center">
                              <h5>البدلات الغير الشهريه</h5>



                              <div class="table-responsive">
                                <table class="table table-bordered text-right">
                                  <thead>
                                    <tr>

                                      <th>اسم البدل</th>
                                      <th>المبلغ</th>
                                      <th>اضافه</th>

                                    </tr>
                                  </thead>
                                  <tbody>
                                 
                                    <tr v-for="index in count.count_not_monthly" :key="index">


                                      <td>


                                        <input v-model="allow.allow_2[index - 1]" type="text" name="name" id="name"
                                          class="form-control" />


                                      </td>
                                      <td><input v-model="qty.qty_2[index - 1]" type=" number"
                                          class="form-control input_cantidad"></td>


                                      <td v-if="index == 1">

                                        <a class="tn btn-info btn-sm waves-effect btn-agregar"
                                          v-on:click="addComponent(count.count_not_monthly, 1)">
                                          <i class="fa fa-plus-circle"></i></a>

                                        <a class="tn btn-info btn-sm waves-effect btn-agregar"
                                          v-on:click="disComponent(count.count_not_monthly, 1)">
                                          <i class="fa fa-minus-circle"></i></a>



                                      </td>
                                    </tr>
                                  </tbody>

                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <a href="javascript:void" @click="Add_new()" class="btn btn-success"><span>تاكيد
                          العمليه</span></a>
                    </form>
                  </div>
                  <!--/div-->
                </div>
              </div>
            </div>
          </div>


        </div>
      </div>
    </div>

    <!-- ================================== -->


    <!-- ================================== -->

  </div>

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
      allow: {
        allow_1: [],
        allow_2: []

      },
      qty: {
        qty_1: [],
        qty_2: []

      },
      count: {
        count_monthly: 1,
        count_not_monthly: 1

      },
      counts: {
        counts_monthly: [],
        counts_not_monthly: []

      },

      staff_id: '',
      salary: '',

      branchselected: "",
      staff_allowances: "",
      salaryselected:0,
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
      allowance_type:'',

      word_search: "",
    };
  },
  mounted() {
    this.list();
    this.counts.counts_monthly[0] = 0;
    this.counts.counts_not_monthly[0] = 0;

  },
  methods: {
    addComponent(index, type) {
      // alert(index);
      if (type == 0) {
        this.count.count_monthly += 1;
        this.counts.counts_monthly[index] = this.count.count_monthly;
      } else {
        this.count.count_not_monthly += 1;
        this.counts.counts_not_monthly[index] = this.count.count_not_monthly;
      }

    },
    disComponent(index, type) {
      // this.count -= 1;
      // this.$delete(this.counts, index);

      if (type == 0) {
        this.count.count_monthly -= 1;
        this.$delete(this.counts.counts_monthly, index);
      } else {
        this.count.count_not_monthly -= 1;
        this.$delete(this.counts.counts_not_monthly, index);
      }


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
    Add_new(vm) {


      axios
        .post(`/store_allowance`, {
          staff: this.staffselected,
          allowance_type:this.allowance_type,
          salary: this.salaryselected,
          count: this.counts,
          allow: this.allow,
          qty: this.qty,
          


        })
        .then((response) => {
          // ---------------------------------------------------------------
          console.log(response);


          // this.temporale = response.data;
          // this.temporale.forEach((item) => {
          //   this.total_quantity = item.tem_qty + this.total_quantity;
          // });

          toastMessage("تم الاضافه بنجاح");
          vm.$router.go(0);
        });

      // }
    },
   
    list(page = 1) {
    
      this.axios
        .post(`/salary?page=${page}`)
        .then(({ data }) => {
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


  },
};
         //
</script>
  
  