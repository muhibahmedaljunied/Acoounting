<template>
  <!-- row opened -->
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header">

            <span class="h2"> القروض</span>
   

          <div style="display: flex;float: left; margin: 5px" >
     
            <a class="btn btn-info btn-sm waves-effect btn-agregar" data-toggle="modal" id="agregar_productos"
              data-target="#addLoan">
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
                  <th class="wd-15p border-bottom-0">التاريخ</th>
                  <th class="wd-15p border-bottom-0">المبلغ</th>
                  <th class="wd-15p border-bottom-0">اجمالي الاقساط</th>
                  <th class="wd-15p border-bottom-0">قيمه القسط</th>
                  <th class="wd-15p border-bottom-0">ملاجظه</th>

                  <th class="wd-15p border-bottom-0">العمليات</th>
                </tr>
              </thead>
              <tbody v-if="loans && loans.data.length > 0">
                <tr v-for="(loan, index) in loans.data" :key="index">
                  <td>{{ loan.staff }}</td>
                  <td>{{ loan.date }}</td>
                  <td>{{ loan.quantity }}</td>
                  <td>{{ loan.number_premium }}</td>
                  <td>{{ loan.premium }}</td>
                  <td>{{ loan.note }}</td>

                  <td>
                    <button type="button" @click="delete_loan(loan.id)" class="btn btn-danger">
                      <i class="fa fa-trash"></i>
                    </button>

                    <router-link :to="{
                      name: 'edit_loan',
                      params: { id: loan.id },
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
          <pagination align="center" :data="loans" @pagination-change-page="list"></pagination>
        </div>
        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
          aria-hidden="true" style="display: none" id="addLoan">
          <div class="modal-dialog modal-lg" style="width: 100%">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                  x
                </button>
                <div class="col-md-8">
                  <h4 class="modal-title" id="myLargeModalLabel">القروض</h4>
                </div>
                <div class="col-md-4">
                  <div class="col-sm-12">
                    <input type="text" placeholder="بحث" class="form-control" name="buscar_producto"
                      id="buscar_producto" v-model="word_search" @input="get_search()" />
                  </div>
                </div>
              </div>
              <div class="modal-body">
                <div class="row row-sm">
                  <div class="col-xl-12">
                    <div class="card">
                      <div class="card-header pb-0">
                        <!-- <div class="d-flex justify-content-between">
                          <h4 class="card-title mg-b-0">SIMPLE TABLE</h4>
                          <i class="mdi mdi-dots-horizontal text-gray"></i>
                        </div>
                        <p class="tx-12 tx-gray-500 mb-2">
                          Example of Valex Simple Table.
                          <a href="">Learn more</a>
                        </p> -->
                      </div>

                      <div class="card-body">

                        <form method="post" @submit.prevent="submitForm" enctype="multipart/form-data">

                          <div class="table-responsive">
                            <table class="table table-bordered text-right m-t-30"
                              style="width: 100%; font-size: x-small">
                              <thead>
                                <tr>

                                  <th>اسم المؤظف</th>


                                  <th> المبلغ</th>
                                  <th>التاريخ </th>

                                  <th>اجمالي الاقساط </th>

                                  <th>قيمه القسط </th>
                                  <th>اضافه</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-for="index in count" :key="index">
                                  <td>
                                    <select v-model="staffselected[index]" name="type" id="type" class="form-control" required>
                                      <option v-for="staff in staffs" v-bind:value="staff.id">
                                        {{ staff.name }}
                                      </option>
                                    </select>
                                  </td>
                                  <td>

                                    <input
                                v-model="qty[index]"
                                type="text"
                                class="form-control"
                                name="name"
                                id="name"
                                required
                              />

                                  </td>
                                  <td>




                                    <input
                                v-model="date[index]"
                                type="date"
                                class="form-control"
                                name="name"
                                id="name"
                                required
                              />


                                  </td>
                                  <td>


                                    <input
                                v-model="number_premium[index]"
                                type="text"
                                class="form-control"
                                name="name"
                                id="name"
                                required
                              />
                                  </td>
                                  <td>


                                    <input
                                v-model="value_premium[index]"
                                type="text"
                                class="form-control"
                                name="name"
                                id="name"
                                required
                              />
                                  </td>
                                
                                  <td>

                                    <div v-if="index == 1">
                                      <a class="btn btn-info btn-sm waves-effect btn-agregar"
                                        v-on:click="addComponent(count)">
                                        <i class="fa fa-plus-circle"></i></a>

                                      <a class="btn btn-info btn-sm waves-effect btn-agregar"
                                        v-on:click="disComponent(count)">
                                        <i class="fa fa-minus-circle"></i></a>


                                    </div>
                                  </td>




                                </tr>
                                <a href="javascript:void" @click="Add_newloan()" class="btn btn-success"><span>تاكيد
                                    العمليه</span></a>

                              </tbody>
                            </table>
                          </div>
                        </form>




                      </div>



                      <!-- <div class="card-body">
                        <div class="form">
                          <h3 class="text-center">أضافه </h3>
                          <form
                            method="post"
                            @submit.prevent="submitForm"
                            enctype="multipart/form-data"
                          >
                            <div class="form-group">
                              <label for="name">اسم المؤظف</label>
                              <select
                                v-model="staffselected"
                                name="type"
                                id="type"
                                class="form-control"
                                required
                              >
                                <option
                                  v-for="staff in staffs"
                                  v-bind:value="staff.id"
                                >
                                  {{ staff.name }}
                                </option>
                              </select>
                            </div>
                            <div class="form-group">
                              <label for="name">التاريخ</label>
                              <input
                                v-model="date"
                                type="date"
                                class="form-control"
                                name="name"
                                id="name"
                                required
                              />
                            </div>
                            <div class="form-group">
                              <label for="name">المبلغ</label>
                              <input
                                v-model="quantity"
                                type="text"
                                class="form-control"
                                name="name"
                                id="name"
                                required
                              />
                            </div>
                            <div class="form-group">
                              <label for="name">اجمالي الاقساط</label>
                              <input
                                v-model="number_premium"
                                type="text"
                                class="form-control"
                                name="name"
                                id="name"
                                required
                              />
                            </div>
                            <div class="form-group">
                              <label for="name">قيمه القسط</label>
                              <input
                                v-model="value_premium"
                                type="text"
                                class="form-control"
                                name="name"
                                id="name"
                                required
                              />
                            </div>
                            <div class="form-group">
                              <label for="name">ملاحظه</label>
                              <input
                                v-model="note"
                                type="text"
                                class="form-control"
                                name="name"
                                id="name"
                        
                              />
                            </div>

                            <button
                              type="submit"
                              class="btn btn-primary btn-lg btn-block"
                            >
                              حفظ
                            </button>
                          </form>
                        </div>
                      </div> -->
                    </div>
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
import operation from '../../../../../js/staff/operation.js';
export default {
  components: {
    pagination,
  },
  mixins: [operation],
  data() {
    return {
   

      loans: {
        type: Object,
        default: null,
      },
      count: 1,
      counts: {},
      staffs: "",
      staffselected: "",

      number_premium: "",
      date: "",
      qty: "",
      value_premium: "",
      note: "",
      word_search: "",
    };
  },
  mounted() {
    this.list();
  },
  methods: {
 
    get_search(word_search) {
      this.axios
        .post(`/loansearch`, { word_search: this.word_search })
        .then(({ data }) => {
          this.loans = data.loans;

          // this.$root.logo = "Category";
        });
    },
    // delete_loan(id) {
    //   this.axios
    //     .post(`delete_loan/${id}`)
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
    list(page = 1) {
      this.axios
        .post(`/loan?page=${page}`)
        .then(({ data }) => {
          this.loans = data.loans;
          this.staffs = data.staffs;
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },
    Add_newloan() {
      console.log(this.counts);
      this.axios
        .post(`/store_loan`, {
          type: this.type,
          count: this.counts,
          staff: this.staffselected,
          qty: this.qty,
          date: this.date,
          number_premium: this.number_premium,
          value_premium: this.value_premium,
       

        })
        .then((response) => {
          // ---------------------------------------------------------------
          console.log(response);


          toastMessage("تم الاضافه بنجاح");
          // this.$router.go(0);
        });

      // this.$router.go(0);

    },
   


  },
};
</script>

