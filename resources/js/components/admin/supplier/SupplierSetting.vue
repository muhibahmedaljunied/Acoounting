<template>
    <div class="container-fluid">

        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">

                    <div class="card-header">
                        <h2> تجهيز الموردين </h2>
                    </div>
                    <div class="card-body">




                        <div class="row">

                            <!-- <div class="col-md-2">
                                <label for="inputAddress">المورد</label>


                            </div> -->
                            <div class="col-md-2">
                                <label for="">التصنيف</label>
                                <select style="background-color: beige;" name="forma_pago" class="form-control"
                                    id="forma_pago" v-model="group_selected" >

                                    <option value="0">عام</option>

                                    <option v-for="supplier_group in supplier_groups" v-bind:value="supplier_group.id">
                                        {{ supplier_group.name }}</option>

                                </select>
                            </div>
                            <div class="col-md-4">

                                <label for="">الحساب</label>

                                <div class="custom-search">
                                    <input style="background-color: beige;" :id="'Supplier_supplier_tree'" type="text" readonly
                                        class="custom-search-input">
                                    <input style="background-color: beige;"  :id="'Supplier_supplier_tree_id'" type="hidden" readonly
                                        class="custom-search-input">
                                    <!-- <input style="background-color: beige;" type="hidden" readonly
                                        class="custom-search-input"> -->
                                    <button class="custom-search-botton" type="button" data-toggle="modal"
                                        :data-target="'#exampleModalSupplier'"> <i
                                            class="fa fa-plus-circle"></i></button>
                                </div>

                            </div>


                            <div class="col-md-2">


                                <button type="button" class="btn btn-primary" @click="submitForm()">حفظ
                                </button>
                            </div>



                        </div>










                    </div>

                    <div class="modal fade" :id="'exampleModalSupplier'" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">

                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    <div class="well" :id="'treeview_json_supplier'">
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
            <span class="h2"> حسابات الموردين</span>


          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <!-- <th>الرقم</th> -->
                    <th>اسم التصنيف</th>
                    <th>  الحساب</th>
                    <th >العمليات</th>

                    <!-- <th class="wd-15p border-bottom-0"> الاجمالي </th> -->
                    <!-- <th class="wd-15p border-bottom-0">  الكميه المرتحعه</th> -->

                  </tr>
                </thead>
                <tbody v-if="group_account && group_account.length > 0">
                  <tr v-for="group_accounts in group_account">
                    <!-- <td>{{ group_accounts.id }}</td> -->
                    <td>{{ group_accounts.group_name }}</td>
                    <td>{{ group_accounts.account_name }}{{  group_accounts.account_id }}</td>
                    <td>
                    <button
                      type="button"
                      @click="delete_supplier(supplier.id)"
                      class="btn btn-danger"
                    >
                      <i class="fa fa-trash"></i>
                    </button>
                    <router-link
                      :to="{
                        name: 'edit_supplier',
                        params: { id: supplier.id },
                      }"
                      class="btn btn-success"
                      ><i class="fa fa-edit"></i
                    ></router-link>
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
import operation from '../../../operation1.js';
import tree from '../../../../js/tree/tree.js';

export default {

    mixins: [tree, operation],
    data() {
        return {
            list_data: '',

            supplier_groups: '',
            account: [],
            code: [],
            type_account: [],
            count_accounts: '',
            group_selected:'',
            group_account:'',




        };
    },
    mounted() {

        this.counts[0] = 1;
        this.type_of_tree = 1;
        this.type = 'Supplier';
        this.list();
        this.showtree('supplier', 'tree_account');




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

            formData.append("group_id", this.group_selected);
            formData.append("account_id", $(`#Supplier_supplier_tree_id`).val());
            
            this.axios
                .post("/store_supplier_account_setting", formData, config)
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
                .post(`/get_supplier_account_setting`)
                .then(({ data }) => {
                    // console.log('muhibxcd', data.count_account);
                    this.list_data = data.accounts;
                    this.supplier_groups = data.groups;
                    this.group_account = data.group_accounts;

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