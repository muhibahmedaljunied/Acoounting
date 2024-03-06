<template>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">

        <div class="row row-sm">


          <div class="col-xl-12">
            <div class="card">
              <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                  <span class="h2"> المصروفات والايرادات</span>
                </div>



              </div>
              <div class="card-body">

                <div class="row">


                  <div class="col-md-2">
                    <label for="FormaPago"> نوع السند</label>
                    <select class="form-control" style="background-color: beige;" name="forma_pago" id="forma_pago"
                      v-model="Way_to_note_selected" >

                      <option v-bind:value="1">صرف</option>
                      <option v-bind:value="2">ايراد</option>
                    </select>
                  </div>
                  <div class="col-md-2">
                    <label for="FormaPago">طريقه الدفع</label>
                    <select class="form-control" style="background-color: beige;" name="forma_pago" id="forma_pago"
                      v-model="Way_to_pay_selected" v-on:change="onwaychange">

                      <option v-bind:value="1">نقد</option>
                      <option v-bind:value="2">بنك</option>
                    </select>
                  </div>
                  <div class="col-md-3">
                    <h5 class="card-title">رقم الحساب</h5>
                    <div class="custom-search">


                      <input :id="'Expence_payment_tree_id'" type="hidden" readonly class="custom-search-input">

                      <input style="background-color: beige;" :id="'Expence_payment_tree'" type="text" readonly
                        class="custom-search-input">

                      <button class="custom-search-botton" type="button" data-toggle="modal"
                        data-target="#exampleModalPayment">
                        <i class="fa fa-plus-circle"></i></button>
                    </div>
                  </div>
                  <!-- <div class="col-md-3">
          <h5 class="card-title">اسم الحساب</h5>
          <div class="custom-search">

            <input style="background-color: beige;" :id="'Expence_payment_tree'" type="text" readonly
              class="custom-search-input">

          </div>
        </div> -->

                  <div class="m-t-30 col-md-2">
                    <label for="date">العمله</label><br />

                    <input style="text-align: center;color:red" v-model="currency" name="date" type="number"
                      class="form-control" />
                    <!-- {{ showshowOrderDetailsOrderDetails }} -->

                  </div>

                  <div class="m-t-30 col-md-2">
                    <label for="date">التأريخ</label><br />

                    <input style="text-align: center;color:red" v-model="date" name="date" type="date"
                      class="form-control" />
                    <!-- {{ showshowOrderDetailsOrderDetails }} -->

                  </div>








                </div>


                <br>
                <hr>
                <div class="row">
                  <div class="table-responsive">
                    <table class="table table-bordered text-right" style="width: 100%; font-size: x-large">

                      <thead>
                        <tr>

                          <th>الحساب</th>
                          <th>البيان</th>

                          <th> المبلغ</th>

                          <th> رقم المرجع</th>

                          <th>اضافه</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="index in count" :key="index">

                          <td>



                            <div class="custom-search">


                              <input :id="'Expence_expence_tree' + index" type="text" readonly
                                class="custom-search-input">

                              <input :id="'Expence_expence_tree_id' + index" type="hidden" readonly
                                class="custom-search-input">

                              <button class="custom-search-botton" type="button" @click="detect_index(index)"
                                data-toggle="modal" data-target="#exampleModalExpence">
                                <i class="fa fa-plus-circle"></i></button>
                            </div>



                          </td>



                          <td>
                            <input type="number" id="paid" v-model="description[index]"
                              class="form-control input_cantidad" /><span style="color:red;font-size: 15px;">{{
                                error_paid[0] }}</span>
                          </td>

                          <td>
                            <input @input="calculate_total()" type="number" v-model="paid[index]"
                              class="form-control input_cantidad" /><span style="color:red;font-size: 15px;">{{
                                error_paid[0] }}</span>
                          </td>
                          <td>
                            <input type="number" class="form-control input_cantidad" />
                          </td>

                          <td v-if="index == 1">

                            <button class="tn btn-info btn-sm waves-effect btn-agregar" v-on:click="addComponent(count)">
                              <i class="fa fa-plus-circle"></i></button>

                            <button class="tn btn-info btn-sm waves-effect btn-agregar" v-on:click="disComponent(count)">
                              <i class="fa fa-minus-circle"></i></button>




                          </td>
                        </tr>


                        <tr>

                          <td colspan="2">
                            <label for="date">الاجمالي</label><br />



                          </td>
                          <td colspan="1">
                            <div class="m-t-30 col-md-6">

                              <input style="text-align: center;color:red" v-model="total" name="date" type="number"
                                class="form-control" readonly />
                            </div>
                          </td>

                          <td colspan="1">
                            <a href="javascript:void" @click="Add_newexpence()" class="btn btn-success"><span>تاكيد
                                العمليه</span></a>
                          </td>
                        </tr>




                      </tbody>
                    </table>

                  </div>
                  <!-- <pagination align="center" :data="sales" @pagination-change-page="list"></pagination> -->

                </div>

              </div>
            </div>
          </div>
        </div>

      </div>
    </section>

    <div class="modal fade" id="exampleModalPayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <div class="well" id="treeview_json_payment"></div>

          </div>

        </div>
      </div>
    </div>


    <div class="modal fade" id="exampleModalExpence" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <div class="well" id="treeview_json_expence"></div>

          </div>

        </div>
      </div>
    </div>

  </div>
</template>
<script>
import pagination from "laravel-vue-pagination";
import operation from '../../../../../js/operation.js';
import tree from '../../../../../js/tree/tree.js';
export default {
  components: {
    pagination,
  },
  mixins: [operation, tree],
  data() {

    return {
      paid_type: [],
      total: 0,
      error_paid: '',
      expence_type: [],
      paid: [],
      currency: '',

      counts: {},
      description: [],
      indexselected: '',
      expence: [],
      type: '',
      type_refresh: '',
      count: 1,
      word_search: '',
      jsonTreeData: '',
      type_of_tree: 1,
      Way_to_note_selected:'',
      date: new Date().toISOString().substr(0, 10),



    }
    // return data;
  },
  mounted() {
    this.list();

    this.counts[0] = 1;
    this.type = 'Expence';
    this.showtree('payment','tree_account');
    this.showtree('expence','tree_account');

  },

  methods: {


    list(page = 1) {
      this.axios
        .post(`/expence/newexpence?page=${page}`)
        .then(({ data }) => {
          console.log(data);



          this.expence_types = data.expence_types;
          console.log(this.expence_types);

          // this.stores = data;
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },
    Add_newexpence() {
      //   e.preventDefault();

      this.axios
        .post("store_expence", {
          counts: this.counts,
          date: this.date,
          description: this.description,
          grand_total: this.total,
          credit: { //دائن

            credit_account_id: $('#Expence_payment_tree_id').val(),
          },
          debit: {
            debit_account_id: this.expence,
            paid: this.paid,
          },
          // total: this.total,



        })
        .then(function (response) {

        })
        .catch(error => {
          //    console.error(error)

          //    this.error_expence_type = error.response.data.error.expence_type
          this.error_paid = error.response.data.error.paid

        });

      // this.$router.go(-1);
    },
    calculate_total(index) {


      this.total = 0;

      this.calc_total();


      if (this.paid[index] <= 0) {

        toastMessage('فشل', "تأكد من البيانات المدخله", 'error');
        return 0;

      }



    },

    calc_total() {




      for (let i = 1; i <= this.count; i++) {


        if (this.paid[i]) {

          this.total = parseInt(this.paid[i]) + parseInt(this.total);

        } else {

          this.total = parseInt(0) + parseInt(this.total);
        }



        // this.paid = this.total;
      }
    },



  },
};
</script>