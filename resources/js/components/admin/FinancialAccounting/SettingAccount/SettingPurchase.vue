<template>
    <div class="container-fluid">

        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">

                    <div class="card-header">
                        <h2> المشتريات </h2>
                    </div>
                    <div class="card-body">



                            <div v-for="(accounts, index) in list_data" :key="index" class="row"
                                v-if="accounts.type == 'purchase'">

                                <div class="col-md-2">
                                    <label for="inputAddress">{{ accounts.account_name }}</label>


                                </div>
                                <div class="col-md-4">


                                    <div class="custom-search" v-if="accounts.account_id">
                                        <input style="background-color: beige;" :id="'Purchase_' + accounts.code + '_tree'"
                                            type="text" readonly class="custom-search-input"
                                            :value="accounts.account_id + accounts.account.first_name">
                                        <input style="background-color: beige;"
                                            :id="'Purchase_' + accounts.code + '_tree_id'" type="hidden" readonly
                                            class="custom-search-input" :value="accounts.account_id">
                                        <input style="background-color: beige;"
                                            :id="'Purchase_' + accounts.code + '_tree_hraccount_id'" type="hidden" readonly
                                            class="custom-search-input" :value="accounts.id">
                                        <button class="custom-search-botton" type="button" data-toggle="modal"
                                            :data-target="'#exampleModal' + accounts.code"> <i
                                                class="fa fa-plus-circle"></i></button>
                                    </div>
                                    <div class="custom-search" v-else>
                                        <input style="background-color: beige;" :id="'Purchase_' + accounts.code + '_tree'"
                                            type="text" readonly class="custom-search-input">
                                        <input style="background-color: beige;"
                                            :id="'Purchase_' + accounts.code + '_tree_id'" type="hidden" readonly
                                            class="custom-search-input">
                                        <input style="background-color: beige;"
                                            :id="'Purchase_' + accounts.code + '_tree_hraccount_id'" type="hidden" readonly
                                            class="custom-search-input" :value="accounts.id">

                                        <button class="custom-search-botton" type="button" data-toggle="modal"
                                            :data-target="'#exampleModal' + accounts.code"> <i
                                                class="fa fa-plus-circle"></i></button>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <label for="inputAddress">الحساب المقابل</label>
                                </div>
                                <div class="col-md-4">


                                    <div class="custom-search" v-if="accounts.account_second_id">
                                        <input style="background-color: beige;"
                                            :id="'Purchase_' + accounts.code + accounts.type + '_tree'" type="text" readonly
                                            class="custom-search-input"
                                            :value="accounts.account_second_id + accounts.account_second.second_name">
                                        <input style="background-color: beige;"
                                            :id="'Purchase_' + accounts.code + accounts.type + '_tree_id'" type="hidden"
                                            readonly class="custom-search-input" :value="accounts.account_second_id">
                                        <input style="background-color: beige;"
                                            :id="'Purchase_' + accounts.code + accounts.type + '_tree_hraccount_id'"
                                            type="hidden" readonly class="custom-search-input" :value="accounts.id">
                                        <button class="custom-search-botton" type="button" data-toggle="modal"
                                            :data-target="'#exampleModal' + accounts.code + accounts.type">
                                            <i class="fa fa-plus-circle"></i></button>
                                    </div>
                                    <div class="custom-search" v-else>
                                        <input style="background-color: beige;"
                                            :id="'Purchase_' + accounts.code + accounts.type + '_tree'" type="text" readonly
                                            class="custom-search-input">
                                        <input style="background-color: beige;"
                                            :id="'Purchase_' + accounts.code + accounts.type + '_tree_id'" type="hidden"
                                            readonly class="custom-search-input">
                                        <input style="background-color: beige;"
                                            :id="'Purchase_' + accounts.code + accounts.type + '_tree_hraccount_id'"
                                            type="hidden" readonly class="custom-search-input" :value="accounts.id">

                                        <button class="custom-search-botton" type="button" data-toggle="modal"
                                            :data-target="'#exampleModal' + accounts.code + accounts.type">
                                            <i class="fa fa-plus-circle"></i></button>
                                    </div>
                                </div>

                                <div v-for="(accounts, index) in list_data" :key="index" class="modal fade"
                                    :id="'exampleModal' + accounts.code" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">

                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                <div class="well" :id="'treeview_json_' + accounts.code">
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" :id="'exampleModal' + accounts.code + accounts.type" tabindex="-1"
                                    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">

                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                <div class="well" :id="'treeview_json_' + accounts.code + accounts.type">
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>



                 


                        <button type="button" class="btn btn-primary" @click="submitForm()">حفظ
                        </button>




                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
  
<script>
import tree from '../../../../tree/tree.js';
import operation from '../../../../operation1.js';

export default {

    mixins: [tree, operation],
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
        this.type = 'Purchase';
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
        submitForm() {

            let currentObj = this;
            const config = {
                headers: {
                    "content-type": "multipart/form-data",
                },
            };
            // form data
            let formData = new FormData();

            for (let index = 0; index < this.count_accounts; index++) {


                // alert(this.accounts.code);
                formData.append(`purchase_${this.list_data[index].code}_account_id`,
                    $(`#Purchase_${this.list_data[index].code}_tree_id`).val()

                );
                formData.append(`purchase_${this.list_data[index].code}_account_hraccount_id`,
                    $(`#Purchase_${this.list_data[index].code}_tree_hraccount_id`).val(),

                );
                formData.append(`purchase_${this.list_data[index].code}_account_name`, [
                    $(`#Purchase_${this.list_data[index].code}_tree`).val(),

                ]);

                // ----------------
                formData.append(`purchase_${this.list_data[index].code + this.list_data[index].type}_second_account_id`,
                    $(`#Purchase_${this.list_data[index].code + this.list_data[index].type}_tree_id`).val()
                );
                formData.append(`purchase_${this.list_data[index].code + this.list_data[index].type}_second_account_hraccount_id`,
                    $(`#Purchase_${this.list_data[index].code + this.list_data[index].type}_tree_hraccount_id`).val()

                );
                formData.append(`purchase_${this.list_data[index].code + this.list_data[index].type}_second_account_name`,
                    $(`#Purchase_${this.list_data[index].code + this.list_data[index].type}_tree`).val()

                );

            }

            // for (let index = 0; index < this.count_accounts; index++) {


            // alert(this.accounts.code);
            // formData.append(`purchase_${this.list_data[index].code}_second_account_id`, $(`#Purchase_${this.list_data[index].code+this.list_data[index].type}_tree_id`).val());
            // formData.append(`purchase_${this.list_data[index].code}_second_account_hraccount_id`, $(`#Purchase_${this.list_data[index].code+this.list_data[index].type}_tree_hraccount_id`).val());
            // formData.append(`purchase_${this.list_data[index].code}_second_account_name`, $(`#Purchase_${this.list_data[index].code+this.list_data[index].type}_tree`).val());

            // }


            // send upload request
            this.axios
                .post("/store_purchase_account_setting", formData, config)
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
                .post(`/get_purchase_account_setting`)
                .then(({ data }) => {
                    // console.log('muhibxcd', data.count_account);
                    this.list_data = data.accounts;
                    this.count_accounts = data.count_account;


                    for (let index = 0; index < this.count_accounts; index++) {



                        this.showtree(this.list_data[index].code, 'tree_account');
                        this.showtree(this.list_data[index].code + this.list_data[index].type, 'tree_account');
                    }

                });




        },


    },
};
//
</script>
  
  