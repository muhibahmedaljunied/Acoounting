<template>
    <div class="container-fluid">

        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">

                    <div class="card-header">
                        <h2>ترميز الحسابات </h2>
                    </div>
                    <div class="card-body">
                        <div class="row row-sm">
                            <div class="col-xl-12">
                                <div class="card">


                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col-md-12">
                                                <form method="post" enctype="multipart/form-data">

                                                    <div class="table-responsive">
                                                        <table class="table table-bordered text-right m-t-30"
                                                            style="width: 100%; font-size: x-small">
                                                            <thead>
                                                                <tr>

                                                                    <th> الحساب </th>

                                                                    <th> الرمز </th>
                                                                    <th> النوع </th>


                                                                    <!-- <th>رقم الحساب </th> -->

                                                                    <th>اضافه</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr v-for="index in count" :key="index">

                                                                    <td>
                                                                        <input v-model="account[index]" type="text"
                                                                            class="form-control" name="name" id="name"
                                                                            required />

                                                                    </td>



                                                                    <td>

                                                                        <input v-model="code[index]" type="text"
                                                                            class="form-control" name="name" id="name"
                                                                            required />


                                                                    </td>

                                                                    <td>

                                                                        <input v-model="type_account[index]" type="text"
                                                                            class="form-control" name="name" id="name"
                                                                            required />


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
                                                                        <button type="button" class="btn btn-primary"
                                                                            @click="add_new_account()">حفظ
                                                                        </button>


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

                    </div>
                </div>
                <div class="card">

                
                    <div class="card-body">

                        <div class="row">

                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table class="table text-md-nowrap" id="example1">
                                        <thead>
                                            <tr>
                                                <th class="wd-15p border-bottom-0">#</th>
                                                <th class="wd-15p border-bottom-0"> الحساب</th>
                                                <th class="wd-15p border-bottom-0">  الرمز</th>
                                                <th class="wd-15p border-bottom-0"> النوع </th>
                                         


                                                <!-- <th class="wd-15p border-bottom-0">العمليات</th> -->
                                            </tr>
                                        </thead>
                                        <tbody v-if="value_list && value_list.data.length > 0">
                                            <tr v-for="(daily, index) in value_list.data" :key="index">

                                                <td>{{ index + 1 }}</td>
                                                <td>{{ daily.account_id }}</td>
                                                <td>{{ daily.text }}</td>
                                                <td>{{ daily.text }}</td>
                                           

                                            </tr>
                                            <tr>
                                                <td colspan="5">الاجمالي</td>
                                                <td>
                                                    <span style="color:green">{{ sum_debit }}</span>

                                                </td>

                                                <td>

                                                    <span style="color:green">{{ sum_credit }}</span>
                                                </td>

                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr>
                                                <td align="center" colspan="7">
                                                    <h3> لايوجد بيانات </h3>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                        <pagination align="center" :data="value_list" @pagination-change-page="list"></pagination>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
  
<script>

import operation from '../../../../js/operation.js';
export default {

    mixins: [operation],
    data() {
        return {
            list_data: '',
            account: [],
            code: [],
            type_account: [],
            count_accounts: '',




        };
    },
    mounted() {

        this.counts[0] = 1;
        this.type_of_tree = 1;
        this.type = 'Structure';
        this.list();



    },

    methods: {


        add_new_account() {

            this.axios
                .post(`/store_account_setting`, {
                    count: this.counts,
                    type: this.type,
                    name: this.account,
                    code: this.code,
                    type_account: this.type_account,

                }
                )
                .then((response) => {
                    console.log(response);
                    toastMessage("تم الاضافه بنجاح");
                    // this.$router.go(0);
                });
        },
        // submitForm() {

        //     let currentObj = this;
        //     const config = {
        //         headers: {
        //             "content-type": "multipart/form-data",
        //         },
        //     };
        //     // form data
        //     let formData = new FormData();

        //     for (let index = 0; index < this.count_accounts; index++) {


        //         // alert(this.accounts.code);
        //         formData.append(`staff_${this.list_data[index].code}_account_id`,
        //             $(`#Structure_${this.list_data[index].code}_tree_id`).val()

        //         );
        //         formData.append(`staff_${this.list_data[index].code}_account_hraccount_id`,
        //             $(`#Structure_${this.list_data[index].code}_tree_hraccount_id`).val(),

        //         );
        //         formData.append(`staff_${this.list_data[index].code}_account_name`, [
        //             $(`#Structure_${this.list_data[index].code}_tree`).val(),

        //         ]);

        //         // ----------------
        //         formData.append(`staff_${this.list_data[index].code + this.list_data[index].type}_second_account_id`,
        //             $(`#Structure_${this.list_data[index].code + this.list_data[index].type}_tree_id`).val()
        //         );
        //         formData.append(`staff_${this.list_data[index].code + this.list_data[index].type}_second_account_hraccount_id`,
        //             $(`#Structure_${this.list_data[index].code + this.list_data[index].type}_tree_hraccount_id`).val()

        //         );
        //         formData.append(`staff_${this.list_data[index].code + this.list_data[index].type}_second_account_name`,
        //             $(`#Structure_${this.list_data[index].code + this.list_data[index].type}_tree`).val()

        //         );

        //     }

        //     // for (let index = 0; index < this.count_accounts; index++) {


        //     // alert(this.accounts.code);
        //     // formData.append(`staff_${this.list_data[index].code}_second_account_id`, $(`#Structure_${this.list_data[index].code+this.list_data[index].type}_tree_id`).val());
        //     // formData.append(`staff_${this.list_data[index].code}_second_account_hraccount_id`, $(`#Structure_${this.list_data[index].code+this.list_data[index].type}_tree_hraccount_id`).val());
        //     // formData.append(`staff_${this.list_data[index].code}_second_account_name`, $(`#Structure_${this.list_data[index].code+this.list_data[index].type}_tree`).val());

        //     // }


        //     // send upload request
        //     this.axios
        //         .post("/store_staff_account_setting", formData, config)
        //         .then(function (response) {
        //             console.log("hhhhhhhhhhhhhhhhhhhhhhh");
        //             console.log(response);
        //             currentObj.success = response.data.success;
        //             currentObj.filename = "";

        //             // e.preventDefault();
        //             toastMessage("تم الاضافه بنجاح");
        //         })
        //         .catch(function (error) {
        //             currentObj.output = error;
        //         });

        //     // this.$router.go(0);
        // },

        // list() {

        //     this.axios
        //         .post(`/get_staff_account_setting`)
        //         .then(({ data }) => {
        //             console.log('muhibxcd', data.count_account);
        //             this.list_data = data.accounts;
        //             this.count_accounts = data.count_account;


        //             for (let index = 0; index < this.count_accounts; index++) {

        //                 // console.log('reeeewwwppppwpppwpppwppwppwp', this.list_data[0].code);
        //                 // this.showtree(this.accounts.code);

        //                 this.showtree(this.list_data[index].code, 'tree_account');
        //                 this.showtree(this.list_data[index].code + this.list_data[index].type, 'tree_account');
        //             }

        //         });




        // },


    },
};
//
</script>
  
  