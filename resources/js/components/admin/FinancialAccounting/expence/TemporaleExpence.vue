<template>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">


                <div class="row row-sm">


                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header pb-0">
                                <div class="d-flex justify-content-between">
                                    <span class="h2"> سند صرف</span>
                                </div>



                            </div>
                            <div class="card-body">

                                <div class="row">



                                    <div class="col-md-4">
                                        <h5 class="card-title">رقم الحساب</h5>
                                        <div class="custom-search">


                                            <input :id="'Expence_payment_tree_id'" type="text" readonly
                                                class="custom-search-input">

                                            <button class="custom-search-botton" type="button" data-toggle="modal"
                                                data-target="#exampleModalPayment">
                                                <i class="fa fa-plus-circle"></i></button>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <h5 class="card-title">اسم الحساب</h5>
                                        <div class="custom-search">

                                            <input style="background-color: beige;" :id="'Expence_payment_tree'" type="text"
                                                readonly class="custom-search-input">

                                        </div>
                                    </div>

                                    <div class="m-t-30 col-md-3">
                                        <label for="date">العمله</label><br />

                                        <input style="text-align: center;color:red" v-model="total" name="date"
                                            type="number" class="form-control" />
                                        <!-- {{ showshowOrderDetailsOrderDetails }} -->

                                    </div>







                                </div>

                                <br>
                                <hr>
                                <div class="row">
                                    <div class="table-responsive">
                                        <table class="table table-bordered text-right"
                                            style="width: 100%; font-size: x-large">

                                            <thead>
                                                <tr>

                                                    <th>المصروف</th>
                                                    <th>البيان</th>

                                                    <th> المبلغ</th>


                                                    <th>اضافه</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="index in count" :key="index">

                                                    <td>


                                                     
                                                            <div class="custom-search">


                                                                <input :id="'Expence_expence_tree' + index"  type="text" readonly
                                                                    class="custom-search-input">

                                                                    <input :id="'Expence_expence_tree_id' + index"  type="hidden" readonly
                                                                    class="custom-search-input">
                                                                    
                                                                <button class="custom-search-botton" type="button" @click="detect_index(index)"
                                                                    data-toggle="modal" data-target="#exampleModalExpence">
                                                                    <i class="fa fa-plus-circle"></i></button>
                                                            </div>
                                                  


                                                    </td>



                                                    <td>
                                                        <input type="number" id="qty" v-model="qty[index]"
                                                            class="form-control input_cantidad"
                                                            onkeypress="return valida(event)" /><span
                                                            style="color:red;font-size: 15px;">{{
                                                                error_qty[0] }}</span>
                                                    </td>

                                                    <td>
                                                        <input type="number" v-model="description[index]"
                                                            class="form-control input_cantidad"
                                                            onkeypress="return valida(event)" /><span
                                                            style="color:red;font-size: 15px;">{{
                                                                error_qty[0] }}</span>
                                                    </td>


                                                    <td v-if="index == 1">

                                                        <button class="tn btn-info btn-sm waves-effect btn-agregar"
                                                            v-on:click="addComponent(count)">
                                                            <i class="fa fa-plus-circle"></i></button>

                                                        <button class="tn btn-info btn-sm waves-effect btn-agregar"
                                                            v-on:click="disComponent(count)">
                                                            <i class="fa fa-minus-circle"></i></button>




                                                    </td>
                                                </tr>


                                                <tr>

                                                    <td colspan="2">
                                                        <label for="date">الاجمالي</label><br />



                                                    </td>
                                                    <td colspan="1">
                                                        <div class="m-t-30 col-md-6">

                                                            <input style="text-align: center;color:red" v-model="total"
                                                                name="date" type="number" class="form-control" readonly />
                                                        </div>
                                                    </td>

                                                    <td colspan="1">
                                                        <a href="javascript:void" @click="Add_newexpence()"
                                                            class="btn btn-success"><span>تاكيد
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
            error_qty: '',
            expence_type: [],
            qty: [],
            counts: {},
            description: [],
            indexselected: '',
            expence_types: '',
            expence_type: [],
            type: '',
            type_refresh: '',
            count: 1,
            word_search: '',
            jsonTreeData: '',
            type_of_tree: 1,

            date: new Date().toISOString().substr(0, 10),



        }
        // return data;
    },
    mounted() {
        this.list();

        this.counts[0] = 1;
        this.type = 'Expence';
        this.showtree('payment');
        this.showtree('expence');

    },
    computed: {

        showshowOrderDetailsOrderDetails: function () {



            for (let index = 1; index <= this.count; index++) {

                // this.total = this.qty[index];
                if (this.qty[index]) {
                    this.total = parseInt(this.qty[index]);
                    if (index == 2) {
                        this.total = parseInt(this.total) + parseInt(this.qty[index]);
                    }
                }

            }

            return this.total;
        },

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
                    // counts: this.counts,
                    // // transfer_id:this.transfer_id,
                    date: this.date,
                    count: this.counts,
                    expence_type: this.expence_type,

                    qty: this.qty,

                    // qty_avilable: this.qty_avilable,


                })
                .then(function (response) {

                })
                .catch(error => {
                    //    console.error(error)

                    //    this.error_expence_type = error.response.data.error.expence_type
                    this.error_qty = error.response.data.error.qty

                });

            // this.$router.go(-1);
        },

    },
};
</script>