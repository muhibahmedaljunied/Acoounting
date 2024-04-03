<template>
    <div class="container-fluid">

        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">

                    <div class="card-header">
                        <h2> ربط المخازن </h2>
                    </div>
                    <div class="card-body">




                        <div class="row">

                            <!-- <div class="col-md-2">
                                <label for="inputAddress">المورد</label>


                            </div> -->
                            <div class="col-md-4">

                                <label for="">المخزن</label>

                                <div class="custom-search">
                                    <input style="background-color: beige;" :id="'Warehouse_store_tree'" type="text"
                                        readonly class="custom-search-input">
                                    <input style="background-color: beige;" :id="'Warehouse_store_tree_id'"
                                        type="hidden" readonly class="custom-search-input">
                                    <!-- <input style="background-color: beige;" type="hidden" readonly
        class="custom-search-input"> -->
                                    <button class="custom-search-botton" type="button" data-toggle="modal"
                                        :data-target="'#exampleModalStore'"> <i
                                            class="fa fa-plus-circle"></i></button>
                                </div>

                            </div>
                            <div class="col-md-4">

                                <label for="">الحساب</label>

                                <div class="custom-search">
                                    <input style="background-color: beige;" :id="'Warehouse_account_tree'" type="text"
                                        readonly class="custom-search-input">
                                    <input style="background-color: beige;" :id="'Warehouse_account_tree_id'"
                                        type="hidden" readonly class="custom-search-input">
                                    <!-- <input style="background-color: beige;" type="hidden" readonly
                                        class="custom-search-input"> -->
                                    <button class="custom-search-botton" type="button" data-toggle="modal"
                                        :data-target="'#exampleModalAccount'"> <i
                                            class="fa fa-plus-circle"></i></button>
                                </div>

                            </div>


                            <div class="col-md-2">


                                <button type="button" class="btn btn-primary" @click="submitForm()">حفظ
                                </button>
                            </div>



                        </div>










                    </div>

                    <div class="modal fade" :id="'exampleModalStore'" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">

                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    <div class="well" :id="'treeview_json_store'">
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal fade" :id="'exampleModalAccount'" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">

                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    <div class="well" :id="'treeview_json_account'">
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="row row-sm">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <span class="h2"> حسابات المخازن</span>


                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <!-- <th>الرقم</th> -->
                                        <th>اسم المخزن</th>
                                        <th> الحساب</th>
                                        <th>العمليات</th>

                                        <!-- <th class="wd-15p border-bottom-0"> الاجمالي </th> -->
                                        <!-- <th class="wd-15p border-bottom-0">  الكميه المرتحعه</th> -->

                                    </tr>
                                </thead>
                                <tbody v-if="store_account && store_account.length > 0">
                                    <tr v-for="store_accounts in store_account">
                                        <!-- <td>{{ store_accounts.id }}</td> -->
                                        <td>{{ store_accounts.store_name }}</td>
                                        <td>{{ store_accounts.account_name }}{{ store_accounts.account_id }}</td>
                                        <td>
                                            <button type="button" @click="delete_store(store.id)"
                                                class="btn btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            <router-link :to="{
                                        name: 'edit_store',
                                        params: { id: store.id },
                                    }" class="btn btn-success"><i class="fa fa-edit"></i></router-link>
                                        </td>
                                    </tr>

                                    <!-- <tr>
                    <td colspan="7" style="text-align:center;color:red;font-size:large">الاجمالي</td>
                    <td>{{ total }}</td>
                  </tr> -->
                                    <!-- <a 
                      @click="$router.go(-1)"
                      class="btn btn-success"
                      ><span> تراجع</span></a
                    > -->
                                </tbody>
                                <tbody v-else>
                                    <tr>
                                        <td align="center" colspan="8">
                                            <h3>
                                                لايوجد اي مبيعات
                                            </h3>
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
</template>

<script>
import tree from '../../../../tree/tree.js';
import operation from '../../../../../js/operation.js';

export default {

    mixins: [tree, operation],
    data() {
        return {
            store_account: '',

            store_groups: '',
            account: [],
            code: [],
            type_account: [],
            count_accounts: '',
            store_selected: '',
            store_account: '',




        };
    },
    mounted() {

        this.counts[0] = 1;
        this.type_of_tree = 1;
        this.type = 'Warehouse';
        this.list();
        this.showtree('account', 'tree_account');
        this.showtree('store', 'tree_store');





    },

    methods: {


        // add_new_account() {

        //     this.axios
        //         .post(`/store_account_setting`, {
        //             count: this.counts,
        //             type: this.type,
        //             name: this.account,
        //             code: this.code,
        //             type_account: this.type_account,

        //         }
        //         )
        //         .then((response) => {
        //             console.log(response);
        //             toastMessage("تم الاضافه بنجاح");
        //             // this.$router.go(0);
        //         });
        // },
        submitForm() {

            let currentObj = this;
            const config = {
                headers: {
                    "content-type": "multipart/form-data",
                },
            };
            // form data
            let formData = new FormData();

            formData.append("store_id", $(`#Warehouse_store_tree_id`).val());
            formData.append("account_id", $(`#Warehouse_account_tree_id`).val());

            this.axios
                .post("/store_store_account_setting", formData, config)
                .then(function (response) {
                    console.log("hhhhhhhhhhhhhhhhhhhhhhh");
                    console.log(response);
                    currentObj.success = response.data.success;
                    currentObj.filename = "";

                    // e.preventDefault();
                    toastMessage("تم الاضافه بنجاح");
                })
                .catch(function (error) {
                    currentObj.output = error;
                });

            // this.$router.go(0);
        },

        list() {

            this.axios
                .post(`/get_store_account_setting`)
                .then(({ data }) => {
                    console.log('muhibxcd125', data);
                    this.store_account = data.store_accounts;
           

                    // this.count_accounts = data.count_account;


                    // for (let index = 0; index < this.count_accounts; index++) {



                    //     this.showtree(this.list_data[index].code, 'tree_account');
                    //     this.showtree(this.list_data[index].code + this.list_data[index].type, 'tree_account');
                    // }

                });




        },


    },
};
//
</script>