<template>
  <!-- row opened -->
  <div class="container-fluid">
    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header ">

            <span class="h2"> الخصميات</span>


            <div style="display: flex;float: left; margin: 5px">

              <a class="btn btn-info btn-sm waves-effect btn-agregar" data-toggle="modal" id="agregar_productos"
                data-target="#addDiscount">
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
                    <th class="wd-15p border-bottom-0"> نوع الخصم</th>
                    <th class="wd-15p border-bottom-0">قيمه الخصم</th>
                    <th class="wd-15p border-bottom-0">طريقه الخصم</th>

                    <th class="wd-15p border-bottom-0">التاريخ</th>

                    <th class="wd-15p border-bottom-0"> ملاجظه</th>


                    <th class="wd-15p border-bottom-0">العمليات</th>
                  </tr>
                </thead>
                <tbody v-if="value_list && value_list.data.length > 0">
                  <tr v-for="(discount, index) in value_list.data" :key="index">

                    <td>{{ discount.name }}</td>

                    <td>

                      <div v-for="(discount_names, index) in discount.discount" :key="index">
                        {{ discount_names.discount_type.name }}
                        <hr>
                      </div>
                    </td>

                    <td>

                      <div v-for="(discount_qty, index) in discount.discount" :key="index">
                        {{ discount_qty.quantity }}
                        <hr>
                      </div>
                    </td>

                    <td></td>
                    <td>

                      <div v-for="(discount_qty, index) in discount.discount" :key="index">
                        {{ discount_qty.date }}
                        <hr>
                      </div>
                    </td>

                    <!-- <td>{{ discount.date }}</td> -->
                    <td>{{ discount.note }}</td>


                    <td>
                      <!-- <a data-toggle="modal" data-target="#modal_vaciar" class="btn btn-danger btn-lg waves-effect btn-agregar"><i class="fa fa-trash"></i></a> -->
                      <button type="button" @click="delete_discount(discount.id)"
                        class="btn btn-danger btn-sm waves-effect">
                        <i class="fa fa-trash"></i>
                      </button>

                      <a class="btn btn-info btn-sm waves-effect btn-agregar" data-target="#updateDiscount"
                        data-toggle="modal" id="agregar_productos">
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
          <!-- <div class="modal fade" id="updateDiscount" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <form method="post">
            <div class="modal-dialog modal-fullscreen">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>


                <div class="modal-body">
                  <div class="row row-sm">
                    <div class="col-xl-12">
              
                      <div class="card">
                        <div class="card-header pb-0">
                          <div class="d-flex justify-content-between">
                            <h4 class="modal-title" id="myLargeModalLabel">الخصومات</h4>
                            <i class="mdi mdi-dots-horizontal text-gray"></i>
                          </div>
                        </div>

                        <div class="card-body">
                          <div class="form">

                            <form method="post">
                              <div class="table-responsive">
                                <table class="table table-bordered text-right">
                                  <thead>
                                    <tr>


                                      <th>اسم المؤظف</th>

                                      <th>المبلغ</th>

                                      <th>التاريخ</th>

                                      <th>اضافه</th>


                                    </tr>
                                  </thead>
                                  <tbody>


                                    <tr v-for="index in count" :key="index">



                                      <td>

                                        <select v-model="staffselected[index]" name="type" id="type" class="form-control"
                                          required>
                                          <option v-for="staff in staffs" v-bind:value="staff.id">
                                            {{ staff.name }}
                                          </option>
                                        </select>

                                      </td>


                                      <td>


                                        <input v-model="quantity[index]" type="number" class="form-control" name="name"
                                          id="name" required />
                                      </td>

                                      <td>

                                        <input v-model="date[index]" type="date" class="form-control" name="name"
                                          id="name" required />

                                      </td>

                                      <td v-if="index == 1">
                                        <a class="btn btn-info btn-sm waves-effect btn-agregar"
                                          v-on:click="addComponent(count)">
                                          <i class="fa fa-plus-circle"></i></a>

                                        <a class="btn btn-info btn-sm waves-effect btn-agregar"
                                          v-on:click="disComponent(count)">
                                          <i class="fa fa-minus-circle"></i></a>
                                      </td>


                                    </tr>

                                  </tbody>

                                </table>
                              </div>




                            </form>
                          </div>


                          <div class="card-footer pb-0">
                            <div class="d-flex justify-content-between">
                              <i class="mdi mdi-dots-horizontal text-gray"></i>
                            </div>
                          </div>
                        </div>


                   
                      </div>
                    </div>
                  </div>

                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary" @click="Add_newdiscount()">حفظ </button>
                    
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div> -->
          <div class="modal fade" id="addDiscount" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                              <h4 class="modal-title" id="myLargeModalLabel">الخصومات</h4>
                              <i class="mdi mdi-dots-horizontal text-gray"></i>
                            </div>
                          </div>

                          <div class="card-body">

                            <!-- <div class="row">
                              <div class="col-md-2">
                                <label for="FormaPago">طريقه الدفع</label>
                                <select class="form-control" style="background-color: beige;" name="forma_pago"
                                  id="forma_pago" v-model="Way_to_pay_selected" v-on:change="onwaychange">

                                  <option v-bind:value="1">نقد</option>
                                  <option v-bind:value="2">أجل</option>
                                  <option v-bind:value="3">بنك</option>
                                </select>
                              </div>

                              <div class="col-md-2">
                                <label for="">رقم الحساب</label>
                                <div class="custom-search">

                                  <input style="background-color: beige;" :id="'Purchase_product_tree' + index"
                                    type="text" readonly class="custom-search-input">
                                  <input :id="'Purchase_product_tree_id' + index" type="hidden" readonly
                                    class="custom-search-input">

                                  <button class="custom-search-botton" type="button" data-toggle="modal"
                                    data-target="#exampleModalAccount" @click="detect_index(index)">
                                    <i class="fa fa-plus-circle"></i></button>
                                </div>
                              </div>

                            </div>

                            <br> -->

                            <!-- <div class="row">
                              <div class="col-md-4">

                                <label for="">التاريخ</label>
                                <input v-model="date" type="date" class="form-control" name="name" id="name"
                                  required />
                              </div>
                            </div>
                            <br> -->
                            <div class="row">
                              <div class="form">

                                <form method="post">
                                  <div class="table-responsive">
                                    <table class="table table-bordered text-right">
                                      <thead>
                                        <tr>


                                          <th>اسم المؤظف</th>

                                          <!-- <th>الحساب</th> -->
                                          <th> نوع الخصم</th>

                                          <th>ظريقه الخصم</th>

                                          <th>المبلغ</th>

                                          <th>التاريخ</th>

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
                                          <!-- 
                                          <td>

                                            <div class="custom-search">

                                              <input style="background-color: beige;"
                                                :id="'Discount_account_discount_tree' + index" type="text" readonly
                                                class="custom-search-input">
                                              <input :id="'Discount_account_discount_tree_id' + index" type="hidden" readonly
                                                class="custom-search-input">

                                              <button class="custom-search-botton" type="button" data-toggle="modal"
                                                data-target="#exampleModalAccountDiscount" @click="detect_index(index)">
                                                <i class="fa fa-plus-circle"></i></button>
                                            </div>
                                          </td> -->
                                          <td>

                                            <select v-model="discounttypeselected[index]" name="type" id="type"
                                              class="form-control" required>
                                              <option v-for="discount_type in discount_types"
                                                v-bind:value="discount_type.id">
                                                {{ discount_type.name }}
                                              </option>
                                            </select>

                                          </td>
                                          <td>



                                            <label for="">من الراتب</label>
                                            <input type="checkbox" name="" id="">
                                          </td>
                                          <td>


                                            <input v-model="quantity[index]" type="number" class="form-control"
                                              name="name" id="name" required />
                                          </td>

                                          <td>

                                            <input v-model="date[index]" type="date" class="form-control" name="name"
                                              id="name" required />

                                          </td>

                                          <td v-if="index == 1">
                                            <a class="btn btn-info btn-sm waves-effect btn-agregar"
                                              v-on:click="addComponent(count)">
                                              <i class="fa fa-plus-circle"></i></a>

                                            <a class="btn btn-info btn-sm waves-effect btn-agregar"
                                              v-on:click="disComponent(count)">
                                              <i class="fa fa-minus-circle"></i></a>
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

                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                  </div>
                  <div class="modal fade" id="exampleModalAccountDiscount" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">

                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">

                          <div class="well" id="treeview_json_account_discount"></div>

                        </div>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>

        </div>
      </div>
      <!--/div-->
    </div>
  </div>
  <!-- /row -->
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
      discounttypeselected: [],
      quantity: [],
      date: [],
      word_search: "",
    };
  },
  mounted() {
    this.list();
    this.type_of_tree = 1;
    this.type = 'Discount';
    this.showtree('account_discount', 'tree_account');
    this.counts[0] = 1;
  },
  methods: {

    Add_new() {

      this.axios
        .post(`/store_discount`, {
          type: this.type,
          count: this.counts,
          staff: this.staffselected,
          discount_type: this.discounttypeselected,
          qty: this.quantity,
          date: this.date,
          // credit: {
          //   credit_account_id: this.account,
          //   paid: this.quantity,

          // },
          // debit: {

          //   debit_account_id: this.debit,
          //   staff: this.staffselected,
          //   paid: this.quantity,

          // },
          // paid: this.quantity,
          // type_daily: 'hr',

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
        .post(`/discountsearch`, { word_search: this.word_search })
        .then(({ data }) => {
          this.discounts = data;

        });
    },

    list(page = 1) {
      this.axios
        .post(`/discount?page=${page}`, { type: 'discount' })
        .then(({ data }) => {
          this.value_list = data.list;
          this.discount_types = data.discount_types;
          this.staffs = data.staffs;
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },


  },
};
</script>

