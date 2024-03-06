<template>
    <!-- row opened -->
    <div class="container-fluid">


        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">

                    <div class="card-header">
                    
                        <span class="h4"> اضافه بنك</span>

                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-xl-2">
                                <label for="">الحساب المرتبط </label>

                                <div class="custom-search">

                                    <input id="Bank_account_tree" type="text" class="custom-search-input">

                                    <button class="custom-search-botton" type="button" data-toggle="modal"
                                        data-target="#exampleModalBank"> <i class="fa fa-plus-circle"></i></button>



                                </div>



                            </div>
                            <div class="col-xl-2">
                                <label for="">رقم الحساب </label>

                                <input type="text" name="status" id="Bank_account_tree_id" class="form-control" />
                            </div>

                        </div>
                        <br>

                        <div class="row">

                            <div class="col-md-12">
                                <form method="post" enctype="multipart/form-data">

                                    <div class="table-responsive">
                                        <table class="table table-bordered text-right m-t-30"
                                            style="width: 100%; font-size: x-small">
                                            <thead>
                                                <tr>

                                                    <th> البنك </th>

                                                    <th> العمله </th>



                                                    <!-- <th>رقم الحساب </th> -->

                                                    <th>اضافه</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="index in count" :key="index">

                                                    <td>
                                                        <input v-model="bank[index]" type="text" class="form-control"
                                                            name="name" id="name" required />

                                                    </td>



                                                    <td>

                                                        <input v-model="currency[index]" type="text" class="form-control"
                                                            name="name" id="name" required />


                                                    </td>



                                                    <td v-if="index == 1">
                                                        <a class="tn btn-info btn-sm waves-effect btn-agregar"
                                                            v-on:click="addComponent(count)">
                                                            <i class="fa fa-plus-circle"></i></a>

                                                        <a class="tn btn-info btn-sm waves-effect btn-agregar"
                                                            v-on:click="disComponent(count)">
                                                            <i class="fa fa-minus-circle"></i></a>
                                                    </td>



                                                </tr>
                                                <tr>
                                                    <td colspan="2"></td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary" @click="Add_new()">حفظ
                                                        </button>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>

                                                    </td>
                                                </tr>


                                            </tbody>
                                        </table>
                                    </div>
                                </form>
                            </div>
                        </div>



                    </div>







                </div>
            </div>

        </div>
        <div class="row row-sm">



            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">

                        <h4 class="modal-title" id="myLargeModalLabel">البنوك </h4>


                    </div>
                    <div class="card-body" id="printme">
                        <div class="table-responsive">
                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <!-- <th class="wd-15p border-bottom-0">الرقم الوظيفي</th> -->
                                        <th class="wd-15p border-bottom-0">اسم البنك</th>
                                        <th class="wd-15p border-bottom-0"> الحساب</th>
                                        <!-- <th class="wd-15p border-bottom-0"> ملاجظه</th> -->


                                        <th class="wd-15p border-bottom-0">العمليات</th>
                                    </tr>
                                </thead>

                                <tbody v-if="banks && banks.data.length > 0">
                                    <tr v-for="(bank, index) in banks.data" :key="index">
                                        <td>
                                            {{ bank.name }}
                                        </td>
                                        <td>
                                            {{ bank.text }} <span style="color:g;">{{ bank.account_id }}</span>
                                        </td>
                                        <td>
                                            <button data-toggle="modal"
                                                class="tn btn-danger btn-sm waves-effect btn-agregar">
                                                <i class="fa fa-trash"></i></button>


                                        </td>






                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr>
                                        <td align="center" colspan="3">
                                            <h3> لايوجد بيانات </h3>
                                        </td>
                                    </tr>
                                </tbody>

                            </table>
                        </div>
                    </div>


                </div>
            </div>



        </div>


        <div class="modal fade" id="exampleModalBank" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="well" id="treeview_json_account"></div>

                    </div>

                </div>
            </div>
        </div>

    </div>
    <!-- /row -->
</template>
<script>
import pagination from "laravel-vue-pagination";
import tree from '../../../../../js/tree/tree.js';
import operation from '../../../../../js/operation.js';
export default {
    mixins: [
        tree,
        operation

    ],
    components: {
        pagination,
    },
    data() {

        return {
            banks: {
                type: Object,
                default: null,
            },
            account: [],
            bank: [],
            currency: [],

            // indexselectedbank: 0,
            type: '',
            type_of_tree: 0,
            jsonTreeData: '',
        }

    },
    mounted() {
        this.list();
        this.counts[0] = 1;
        this.type = 'Bank';
        this.type_of_tree == 1
        this.showtree('account','tree_account');


    },

    methods: {


        Add_new() {

            this.axios
                .post(`/store_bank`, {
                    count: this.counts,
                    type: this.type,
                    name: this.bank,
                    account: this.account,

                }
                )
                .then((response) => {
                    console.log(response);
                    toastMessage("تم الاضافه بنجاح");
                    // this.$router.go(0);
                });




        },


        list(page = 1) {
            this.axios
                .post(`/banks?page=${page}`)
                .then(({ data }) => {
                    console.log(data.banks);

                    this.banks = data.banks;

                })
                .catch(({ response }) => {
                    console.error(response);
                });
        },


    },
};
</script>

