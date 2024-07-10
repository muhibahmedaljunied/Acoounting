<template>
  <!-- row opened -->
  <div class="container-fluid">
    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header">

            <span class="h2"> السلف</span>


            <div style="display: flex;float: left; margin: 5px">

              <a class="btn btn-info btn-sm waves-effect btn-agregar" data-toggle="modal" id="agregar_accountos"
                data-target="#addAd">
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
                    <!-- <th class="wd-15p border-bottom-0">الرقم الوظيفي</th> -->
                    <th class="wd-15p border-bottom-0">اسم المؤظف</th>
                    <th class="wd-15p border-bottom-0">المبلغ</th>
                    <th class="wd-15p border-bottom-0">طريقه الخصم</th>

                    <th class="wd-15p border-bottom-0">التاريخ</th>
                    <th class="wd-15p border-bottom-0">الحاله</th>

                    <th class="wd-15p border-bottom-0"> ملاجظه</th>


                    <th class="wd-15p border-bottom-0">العمليات</th>
                  </tr>
                </thead>
                <tbody v-if="value_list && value_list.data.length > 0">
                  <tr v-for="(advance, index) in value_list.data" :key="index">
                    <td>{{ advance.name }}</td>

                    <td>

                      <div v-for="(adv, index) in advance.advance" :key="index">
                        {{ adv.quantity }}
                        <hr>
                      </div>
                    </td>

                    <td></td>
                    <td>

                      <div v-for="(adv, index) in advance.advance" :key="index">
                        {{ adv.date }}
                        <hr>
                      </div>
                    </td>

                    <td>

                      <div v-for="(adv, index) in advance.advance" :key="index">
                        {{ adv.note }}
                        <hr>
                      </div>
                    </td>


                    <td></td>


                    <td>
                      <!-- <a data-toggle="modal" data-target="#modal_vaciar" class="btn btn-danger btn-lg waves-effect btn-agregar"><i class="fa fa-trash"></i></a> -->
                      <button type="button" @click="delete_advance(advance.id)"
                        class="btn btn-danger btn-sm waves-effect">
                        <i class="fa fa-trash"></i>
                      </button>

                      <a class="btn btn-info btn-sm waves-effect btn-agregar" data-target="#updateAd" data-toggle="modal"
                        id="agregar_accountos">
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
            <!-- <pagination align="center" :data="advances" @pagination-change-page="list"></pagination> -->
          </div>
          <div class="modal fade" id="addAd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <form method="post">
              <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>


                  <div class="modal-body">


                    <div class="row row-sm">
                      <div class="col-xl-12">
                        <!-- <form method="post"> -->
                        <div class="card">
                          <div class="card-header pb-0">
                            <div class="d-flex justify-content-between">
                              <h4 class="modal-title" id="myLargeModalLabel">السلف</h4>
                              <i class="mdi mdi-dots-horizontal text-gray"></i>
                            </div>
                          </div>

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

                                <form method="post">
                                  <div class="table-responsive">
                                    <table class="table table-bordered text-right">
                                      <thead>
                                        <tr>




                                          <th>اسم الموظف</th>
                                          <th>الحساب </th>

                                          <th>المبلغ</th>
                                          <th>ظريقه الخصم</th>
                                          <!-- <th>التاريخ</th> -->

                                          <th>اضافه</th>


                                        </tr>

                                      </thead>
                                      <tbody>


                                        <tr v-for="index in count" :key="index">



                                          <td>

                                            <select v-model="staffselected[index]" name="type" id="type"
                                              class="form-control" required>
                                              <option v-for="staff in staffs" v-bind:value="staff.id">
                                                {{ staff.name }}
                                              </option>
                                            </select>

                                          </td>

                                          <td>
                                            <input v-model="debit" type="hidden" class="form-control" required />
                                            <div class="custom-search">

                                              <input style="background-color: beige;"
                                                :id="'Advance_account_advance_tree' + index" type="text" readonly
                                                class="custom-search-input">
                                              <input :id="'Advance_account_advance_tree_id' + index" type="hidden"
                                                readonly class="custom-search-input" v-model="account[index]">

                                              <button class="custom-search-botton" type="button" data-toggle="modal"
                                                data-target="#exampleModalAccountAdvance" @click="detect_index(index)">
                                                <i class="fa fa-plus-circle"></i></button>
                                            </div>


                                          </td>


                                          <td>


                                            <input @input="calc_grand_total(index)" v-model="quantity[index]"
                                              type="number" class="form-control" required />
                                          </td>
                                          <td>


                            
                                            <label for="">من الراتب</label>
                                            <input type="checkbox" name="" id="">
                                          </td>
                      

                                          <!-- <td>

                                            <input v-model="date[index]" type="date" class="form-control" name="name"
                                              id="name" required />

                                          </td> -->

                                          <td v-if="index == 1">
                                            <a class="btn btn-info btn-sm waves-effect btn-agregar"
                                              v-on:click="addComponent(count)">
                                              <i class="fa fa-plus-circle"></i></a>

                                            <a class="btn btn-info btn-sm waves-effect btn-agregar"
                                              v-on:click="disComponent(count)">
                                              <i class="fa fa-minus-circle"></i></a>
                                          </td>


                                        </tr>
                                        <tr>
                                          <td colspan="2">الاجمالي</td>
                                          <td colspan="2">


                                            <input v-model="grand_total" type="number" class="form-control" name="name"
                                              id="name" readonly />
                                          </td>

                                        </tr>

                                      </tbody>

                                    </table>
                                  </div>




                                </form>
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
                      <button type="button" class="btn btn-primary" @click="Add_new()">حفظ </button>
                      <!-- <button type="button" class="btn btn-primary btn-lg btn-block" @click="submitForm()"@click="submitForm()">
                        حفظ
                      </button> -->
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>

          <div class="modal fade" id="exampleModalAccountAdvance" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">

                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">

                  <div class="well" id="treeview_json_account_advance"></div>

                </div>

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
import tree from '../../../../../js/tree/tree.js';

export default {
  components: {
    pagination,
  },
  mixins: [operation, tree],
  data() {
    return {

      value_list: {
        type: Object,
        default: null,
      },

      debit: '',
      grand_total: '',
      quantity: [],
      account: [],
      date: '',
      word_search: "",

    };
  },
  mounted() {
    this.list();
    this.type_of_tree = 1;
    this.type = 'Advance';
    this.showtree('account_advance', 'tree_account');
    this.counts[0] = 1;

  },
  methods: {


    calc_grand_total(count) {

      var quantity = 0;

      for (let index = 0; index < count; index++) {

        quantity = parseInt(quantity) + parseInt(this.quantity[index + 1]);

      }

      this.grand_total = quantity;


    },

    Add_new() {

      this.axios
        .post(`/store_advance`, {
          type: this.type,
          count: this.counts,
          staff: this.staffselected,
          qty: this.quantity,
          date: this.date,
          credit: {
            credit_account_id: this.account,
            paid: this.quantity,

          },
          debit: {

            debit_account_id: this.debit,
            staff: this.staffselected,
            paid: this.quantity,

          },
          grand_total: this.grand_total,
          type_daily: 'hr_advance',


        }
        )
        .then((response) => {
          console.log(response);
          toastMessage("تم الاضافه بنجاح");
          // this.$router.go(0);
        });




    },


    get_search(word_search) {
      this.axios
        .post(`/advancesearch`, { word_search: this.word_search })
        .then(({ data }) => {
          this.branches = data;
        });
    },
    list(page = 1) {
      this.axios
        .post(`/advance?page=${page}`, { type: 'advance' })
        .then(({ data }) => {
          this.value_list = data.list;
          // console.log('jhdjshjsdssssssssssss',data);
          this.staffs = data.staffs;
          this.debit = data.debit;

        })
        .catch(({ response }) => {
          // console.error(response);
        });
    },





  },
};
</script>

