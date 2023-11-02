<template>
    <!-- row opened -->
    <div class="container-fluid">
        <div class="row row-sm">

            <div class="col-xl-6">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between">

                            <span style="font-size: x-large">الهيكل الاداري</span>
                            <!-- <router-link to="create_staff" id="agregar_staffos"
                class="tn btn-info btn-lg waves-effect btn-agregar"><i class="fa fa-plus-circle"></i></router-link> -->

                        </div>

                    </div>
                    <div class="card-body">
                        <div class="container">
                            <div class="row justify-content-left">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">

                                            <a @click="exports_excel()">
                                                <img src="/assets/img/export.png" alt="" style="width: 10%;"></a>

                                            <a @click="imports_excel()">
                                                <img src="/assets/img/import.png" alt="" style="width: 10%;"></a>
                                        </div>

                                        <div class="card-body">
                                            <!-- <div class="container"> -->

                                            <div class="well" id="treeview_json_structure"></div>
                                            <!-- </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




            <div class="col-xl-6">
                <div class="card">


                    <div class="card-header pb-0">


                        <span style="font-size: x-large">اضافه هيكل</span>


                    </div>
                    <form method="post">


                        <div class="card-body">
                            <div class="form">
                                <!-- <h3 class="text-center">اضافه منتج</h3> -->


                                <div class="form-group">
                                    <ul>
                                        <div v-for="error in errors">
                                            <li>{{ error[0] }}</li>
                                        </div>
                                    </ul>
                                </div>

                                <div class="form-group">
                                    <label for="Staff">رقم الهيكل</label>
                                    <input id='structure_number' type="text" class="form-control" required readonly />

                                </div>
                                <div class="form-group">
                                    <label for="Staff">اسم الهيكل</label>
                                    <input style="background-color: beige;" v-model="text" type="text" name="Staff"
                                        id="staff" class="form-control" required /><span style="color:red">{{
                                            error_text[0] }}</span>

                                </div>

                                <div class="form-group">
                                    <label for="radio-example-one">متفرع </label>

                                    <input type="checkbox" name='fieldset2' v-model="status" id="status">
                                    <input id='parent' type="hidden" />

                                    <input id='rank' type="hidden" />

                                </div>









                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-primary btn-lg btn-block" @click="addnode()"> حفظ
                            </button>
                        </div>
                    </form>
                </div>
            </div>




            <!--/div-->
        </div>



        <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    حذف
                </div>
            </div>
        </div>

    </div>
</template>

<script>

import tree from '../../../../js/tree/tree.js';

export default {

    mixins: [tree],
    data() {
        return {

            error_text: '',
            error_hash_rate: '',
            error_purchase_price: '',
            retail_unit: '',
            hash_rate: '',
            file: '',
            text: '',
            staff: '',
            image: '',
            status: false,
            id: '',
            trees: "",
            errors: "",
            add: 0,

        };
    },
    mounted() {
        this.type_of_tree = 0;

    },
    created() {
        localStorage.setItem('id', 0);
        localStorage.setItem('rank', 0);
        localStorage.setItem('table', 'structure');

        this.showtree('structure');
    },

    methods: {



        onFileChange(e) {
            this.file = e.target.files[0];
        },

        exports_excel() {

            axios
                .post(`export_AdministrativeStructure`)
                .then(function (response) {

                    // console.log(1);
                })
                .catch(error => {

                });
        },
        imports_excel() {

            axios
                .post(`import_AdministrativeStructure`)
                .then(function (response) {

                    // console.log(1);
                })
                .catch(error => {

                });
        },


    },
};
</script>

 


