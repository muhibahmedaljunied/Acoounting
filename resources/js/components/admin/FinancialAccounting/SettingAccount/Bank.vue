<template>
    <div class="container-fluid">

        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card-body">


                    <div class="row row-sm">
                        <div class="col-xl-12">
                            <div class="card">

                                <div class="card-header">
                                    <h2>  البنوك </h2>
                                </div>
                                <div class="card-body">






                                    <div class="row">
<!-- 
                                        <div class="col-md-2">
                                            <label for="inputAddress">البنك</label>


                                        </div> -->
                                        <div class="col-md-2">
                                            <label for="">التصنيف</label>
                                            <select style="background-color: beige;" name="forma_pago"
                                                class="form-control" id="forma_pago" v-model="group"
                                                v-on:change="onwaychange">
                                                text

                                                <option v-bind:value="1">الكل</option>
                                                <option v-for="bank in bank_groups" v-bind:value="bank.id">{{ bank.name
                                                    }}
                                                </option>

                                            </select>
                                        </div>
                                        <div class="col-md-4">

                                            <label for="">الحساب</label>
                                            <div class="custom-search">
                                                <input style="background-color:  beige;"  :id="'BT_bank_tree'" type="text" readonly
                                                    class="custom-search-input">
                                                <input style="background-color: beige;" :id="'BT_bank_tree_id'" type="hidden" readonly
                                                    class="custom-search-input">
                                                <input style="background-color: beige;" type="hidden" readonly
                                                    class="custom-search-input">
                                                <button class="custom-search-botton" type="button" data-toggle="modal"
                                                    :data-target="'#exampleModalBank'"> <i
                                                        class="fa fa-plus-circle"></i></button>
                                            </div>

                                        </div>

                                        <div class="col-md-2">
                                            
                                            <button type="button" class="btn btn-primary" @click="submitForm()">حفظ
                                            </button>
        
        
        
                                                </div>
        
        

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
                        <span class="h2"> حسابات لبنوك</span>


                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <!-- <th>الرقم</th> -->
                                        <th>اسم التصنيف</th>
                                        <th> الحساب</th>

                                        <th>العمليات</th>


                                    </tr>
                                </thead>
                                <tbody v-if="bank_accounts && bank_accounts.length > 0">
                                    <tr v-for="bank_account in bank_accounts">
                                        <!-- <td>{{ bank_account.id }}</td> -->
                                        <td>{{ bank_account.name }}</td>
                                        <td>{{ bank_account.text }}{{ bank_account.account_id }}</td>
                                        <td>
                                            <button type="button" @click="delete_group(bank_account.id)"
                                                class="btn btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            <router-link :to="{ name: 'edit_group', params: { id: bank_account.id } }"
                                                class="btn btn-success"><i class="fa fa-edit"></i></router-link>
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

        <div class="modal fade" :id="'exampleModalBank'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="well" :id="'treeview_json_bank'">
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </div>
</template>

<script>
import tree from '../../../../tree/tree.js';
import operation from '../../../../operation.js';

export default {

    mixins: [tree, operation],
    data() {
        return {
            list_data: '',
            banks: '',
            bank_groups: '',
            bank_accounts:'',
            treasury: '',
            account: '',
            code: [],
            type_account: [],
            count_accounts: '',
            group:'',




        };
    },
    mounted() {

        this.counts[0] = 1;
        this.type_of_tree = 1;
        this.type = 'BT';
        this.list();
        this.showtree('treasury', 'tree_account');
        this.showtree('bank', 'tree_account');




    },

    methods: {


        submitForm() {

            // let currentObj = this;
            // const config = {
            //     headers: {
            //         "content-type": "multipart/form-data",
            //     },
            // };
            // form data
            // let formData = new FormData();


            this.axios
                .post("/store_account_account_setting",{
                    count: this.counts,
                    type: this.type,
                    group_id:this.group,
                    account_id: $('#BT_bank_tree_id').val(),



                })
                .then(function (response) {

                    // e.preventDefault();
                    toastMessage("تم الاضافه بنجاح");
                })
                .catch(function (error) {
                    // currentObj.output = error;
                });

            // this.$router.go(0);
        },

        list() {

            this.axios
                .post(`/get_bank_accounts`)
                .then(({ data }) => {
                    // console.log('muhibxcd', data.count_account);
                    this.list_data = data.accounts;
                    this.bank_groups = data.bank_groups;
                    this.bank_accounts = data.bank_accounts;
                    // this.treasury_bank_accounts = data.treasury_bank_accounts;




                });




        },


    },
};
//
</script>