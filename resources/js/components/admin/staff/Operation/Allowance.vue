<template>
  <!-- row opened -->
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header">
          <span class="h2"> الرواتب والبدلات</span>
          <div style="display: flex;float: left; margin: 5px">


            <a class="btn btn-info btn-sm waves-effect" data-toggle="modal" data-target="#addsalary">
              <i class="fa fa-plus-circle"></i></a>
            <input autocomplete="on" v-model="word_search" type="text" class="form-control input-text"
              placeholder="بحث ...." aria-label="Recipient's username" aria-describedby="basic-addon2"
              @input="get_search()">

          </div>

        </div>
        <div class="card-body">

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
        </div>
      </div>

















      <pagination align="center" :data="staff_allowances" @pagination-change-page="list"></pagination>

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
                      <!-- <div class="card-body">
                        <div class="form-row">
                        

                          <div class="form-group col-md-2">
                            <label for="inputState">اسم المؤظف</label>
                            <select v-model="staffselected" id="inputState" class="form-control">
                              <option v-for="staff in staffs" v-bind:value="staff.id">
                                {{ staff.name }}
                              </option>
                            </select>
                          </div>

                    

                          <div class="form-group col-md-2">
                            <label for="exampleRadios">الراتب</label><br />
                            <input v-model="salaryselected" class="form-control" type="number" name="exampleRadios" />
                          </div>
                          <div class="form-group col-md-2">
                            <label for="exampleRadios">البدلات</label><br />
                            <input class="form-control" type="number" name="exampleRadios" />
                          </div>
                        </div>
                      </div> -->
                    </div>
                    <div class="card">
                      <div class="card-body">
                        <div class="form-row">




                          <div class="form-group col-md-12" style="text-align: center">
                            <!-- <h5>البدلات الشهريه</h5> -->



                            <div class="table-responsive">
                              <table class="table table-bordered text-right">
                                <thead>
                                  <tr>

                                    <th>اسم المؤظف</th>
                                    <th>اسم البدل</th>
                                    <th>نوع البدل</th>
                                    <th>المبلغ</th>
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

                                      <input v-model="allow[index]" type="text" name="name" id="name"
                                        class="form-control" />

                                    </td>

                                    <td> <select v-model="allowance_type[index]" id="inputState" class="form-control">
                                        <option v-for="allowance_type in allowance_types" v-bind:value="allowance_type.id">
                                          {{ allowance_type.name }}
                                        </option>
                                      </select></td>
                                    <td><input v-model="qty[index]" type="number"
                                        class="form-control input_cantidad"></td>

                                    <td v-if="index == 1">

                                      <a class="tn btn-info btn-sm waves-effect btn-agregar"
                                        v-on:click="addComponent(count, 0)">
                                        <i class="fa fa-plus-circle"></i></a>

                                      <a class="tn btn-info btn-sm waves-effect btn-agregar"
                                        v-on:click="disComponent(count, 0)">
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

      staff_allowances: {
        type: Object,
        default: null,
      },


      count: 1,
      counts: {},

      staff_id: '',
      salary: '',
      allow: [],
      qty: [],
      branchselected: "",
      staff_allowances: "",
      salaryselected: 0,
      date: "",
      allowances: "",
      allowance_type: [],
      allowance: [],
      checkselected: [],
      staffselected: [],
      jobselected: 1,
      brancheselected: 1,
      staff_typeselected: 1,

      staffs: "",
      // jobs: "",
      // branches: "",
      staff_types: "",
      allowance_types: "",
      // allowance_type: '',

      word_search: "",
    };
  },
  mounted() {
    this.list();
    this.counts[0] = 1;
    this.type = 'allowance';
    
   

  },
  methods: {
    addComponent(index) {
      addComponent(this,index);
    },
    disComponent(index) {
      disComponent(this,index);
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
          type: this.type,
          staff: this.staffselected,
          allowance_type: this.allowance_type,
          // salary: this.salaryselected,
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
        .post(`/allowance?page=${page}`)
        .then(({ data }) => {
          console.log(data);
          this.staffs = data.staffs;
          this.allowance_types = data.allowance_types
          this.staff_allowances = data.staff_allowances
  
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },
    // handleAllowance(index, valueselected, allowance_id) {
    //   this.allowance[index] = {
    //     id: allowance_id,
    //     qty: 1,
    //     check: valueselected,
    //     name: this.staffselected,

    //   };

    //   console.log(this.allowance);
    // },


  },
};
       //
</script>
<style scoped>
.btn:hover {
  color: #fff;
}

.input-text:focus {


  box-shadow: 0px 0px 0px;
  border-color: #f8c146;
  outline: 0px;
}
</style>

