<template>
  <!-- row opened -->
  <div class="container-fluid">
    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header">
            <span class="h2"> البدلات</span>
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
                    <!-- <th class="wd-15p border-bottom-0">الراتب الاساسي</th> -->

                    <th class="wd-15p border-bottom-0"> البدل</th>
                    <th class="wd-15p border-bottom-0"> نوع البدل</th>
                    <th class="wd-15p border-bottom-0"> المبلغ</th>
                    <th class="wd-15p border-bottom-0">العمليات</th>
                  </tr>
                </thead>
                <tbody v-if="value_list && value_list.data.length > 0">
                  <tr v-for="(staff_allowance, index) in value_list.data" :key="index">


                    <td>{{ staff_allowance.name }}</td>
                    <!-- <td>{{ staff_allowance.personal_card }}</td>
                  <td>{{ staff_allowance.job }}</td> -->
                    <!-- <td>{{ staff_allowance.salary }}</td>
                  <td>{{ staff_allowance.name }}</td> -->

                    <td>

                      <div v-for="(allowance, index) in staff_allowance.allowance" :key="index" style="color:green;">




                        {{ allowance.allowance_type.name }}
                        <hr>
                      </div>
                    </td>

                    <td>

                      <div v-for="(allowance, index) in staff_allowance.allowance" :key="index" style="color:green;">


                        <span v-if="allowance.status == 1">شهري</span>
                        <span v-else>غير شهري</span>



                        <hr>
                      </div>
                    </td>
                    <td>

                      <div v-for="(allowance, index) in staff_allowance.allowance" :key="index" style="color:red;">
                        {{ allowance.quantity }}
                        <hr>
                      </div>
                    </td>

                    <td>
                      <button type="button" class="btn btn-danger btn-sm waves-effect">
                        <i class="fa fa-trash"></i>
                      </button>


                      <a class="btn btn-info btn-sm waves-effect btn-agregar" data-target="#updateAd" data-toggle="modal"
                        id="agregar_productos">
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
          </div>

        </div>

















        <pagination align="center" :data="value_list" @pagination-change-page="list"></pagination>

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
                              <span class="h2"> البدلات</span>
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

                          <div class="row">
                            <div class="col-md-4">

                              <label for="">التاريخ</label>
                              <input v-model="date" type="date" class="form-control" name="name" id="name" required />
                            </div>
                          </div>
                          <br>
                          <div class="row">
                            <div class="form">




                              <div class="form-group col-md-12" style="text-align: center">
                                <!-- <h5>البدلات الشهريه</h5> -->



                                <div class="table-responsive">
                                  <table class="table table-bordered text-right">
                                    <thead>
                                      <tr>

                                        <th>اسم المؤظف</th>
                                        <th>نوع البدل</th>
                                        <th> البدل</th>
                                        <th> الحساب</th>

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


                                        <td> <select v-model="allowance_status[index]" id="inputState"
                                            class="form-control">
                                            <option v-bind:value="1">
                                              بدلات شهريه
                                            </option>
                                            <option v-bind:value="2">
                                              بدلات غير شهريه
                                            </option>
                                          </select></td>

                                        <td> <select v-model="allowance_type[index]" id="inputState" class="form-control">
                                            <option v-for="allowance_type in allowance_types"
                                              v-bind:value="allowance_type.id">
                                              {{ allowance_type.name }}
                                            </option>
                                          </select>

                                        </td>

                                        <td> <select @change="set_account(index)" v-model="selected_account[index]"
                                            class="form-control">
                                            <option v-for="account in accounts"
                                              v-bind:value="[account.id,account.account_id,account.account_second_id]">
                                              {{ account.name }}
                                            </option>
                                          </select>
                                          <!-- <input  type="text"
                                            class="form-control input_cantidad" :value="accounts[0].id"> -->
                                        </td>


                                        <td><input  @input="calc_grand_total(index)" v-model="quantity[index]" type="number"
                                            class="form-control input_cantidad">
                                        </td>

                                        <td v-if="index == 1">

                                          <a class="btn btn-info btn-sm waves-effect btn-agregar"
                                            v-on:click="addComponent(count, 0)">
                                            <i class="fa fa-plus-circle"></i></a>

                                          <a class="btn btn-info btn-sm waves-effect btn-agregar"
                                            v-on:click="disComponent(count, 0)">
                                            <i class="fa fa-minus-circle"></i></a>



                                        </td>


                                      </tr>
                                      <tr>
                                        <td colspan="4">الاجمالي</td>
                                        <td colspan="1">


                                          <input v-model="grand_total" type="number" class="form-control" name="name"
                                            id="name" readonly />
                                        </td>

                                      </tr>

                                    </tbody>

                                  </table>
                                </div>
                              </div>


                            </div>
                          </div>

                        </div>
                      </div>


                      <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="Add_new()">حفظ </button>

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      </div>

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

      value_list: {
        type: Object,
        default: null,
      },

      allowance_types: "",
      allowance_type: [],
      allowance_status: [],
      quantity: [],
      accounts: '',
      grand_total: '',
      selected_account: [[]],
      account: {
        id:[],
        account_id: [],
        account_second_id: []
      },
      date: '',
      word_search: "",
    };
  },
  mounted() {
    this.list();
    this.counts[0] = 1;
    this.type = 'allowance';



  },
  methods: {
    calc_grand_total(count) {

      var quantity = 0;

      for (let index = 0; index < count; index++) {

        quantity = parseInt(quantity) + parseInt(this.quantity[index + 1]);

      }

      this.grand_total = quantity;


    },

    set_account(index) {

   
      this.account.id[index] = this.selected_account[index][0];
      this.account.account_id[index] = this.selected_account[index][1];
      this.account.account_second_id[index] = this.selected_account[index][2];

    
    },
    Add_new() {

      // if (this.Way_to_pay_selected == 1) { //this is default if user not detect any way

      //   this.paid = this.grand_total;

      // }
      // var credit_account_id = 0;
      // if (this.Way_to_pay_selected == 1) {

      //   credit_account_id = this.treasury[2];

      // } 
      // if (this.Way_to_pay_selected == 2) {

      //   credit_account_id = this.supplier[2];

      // }

      this.Add(
        {
          type: this.type,
          count: this.counts,
          staff: this.staffselected,
          allowance_status: this.allowance_status,
          allowance_type: this.allowance_type,
          qty: this.quantity,
          date: this.date,
          debit: {
            debit_account_id: this.account.account_id,
            hr_account_id:this.account.id,
            staff: this.staffselected,
            paid: this.quantity,

          },
          credit: {
            credit_account_id: this.account.account_second_id,
            paid: this.quantity,
          },
          grand_total: this.grand_total,
          type_daily: 'hr_allowance',




        });


    },

    get_search(word_search) {
      this.axios
        .post(`/salarysearch`, { word_search: this.word_search })
        .then(({ data }) => {
          this.staff_allowances = data.staff_allowances;
        });
    },

    list(page = 1) {

      this.axios
        .post(`/allowance?page=${page}`, { type: 'allowance' })
        .then(({ data }) => {
          console.log(data);
          this.staffs = data.staffs;
          this.accounts = data.accounts;
          // this.value_list = data.list;
          this.allowance_types = data.allowance_types
          this.value_list = data.list

        })
        .catch(({ response }) => {
          console.error(response);
        });
    },



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

