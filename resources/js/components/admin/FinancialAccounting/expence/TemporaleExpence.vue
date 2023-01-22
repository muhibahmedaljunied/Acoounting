<template>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="modal-body">
                    <table class="table table-bordered text-right" style="width: 100%; font-size: x-large">
                        <thead>
                            <tr>

                                <th>المصروف</th>


                                <!-- <th>الحاله</th>
                                <th>المواصفات والطراز</th>

                                <th>المخزن</th> -->

                                <th> المبلغ</th>
                                <th>اضافه</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="index in count" :key="index">

                                <td>

                                    <!-- <input type="number" v-model="product[index]" class="form-control input_cantidad"
    onkeypress="return valida(event)" />  -->
                                    <div id="factura_producto" class="input_nombre">
                                        <select v-model="expence_type[index]" name="type" id="type" class="form-control"
                                            required>
                                            <option v-for="(type, sindex) in expence_types" :key="sindex"
                                                v-bind:value="type.id">
                                                {{ type.name }}
                                            </option>
                                        </select>
                                      
                                    </div>





                                    <!-- <div class="custom-search">
                               

                                        <input :id="'supply_tree' + index" type="text" readonly
                                            class="custom-search-input">
                                        <input :id="'supply_tree_id' + index" type="hidden" v-model="product[index]"
                                            class="custom-search-input">



                                        <button class="custom-search-botton" type="button" data-toggle="modal"
                                            data-target="#exampleModalProduct" @click="detect_index(index)"> <i
                                                class="fa fa-plus-circle"></i></button>
                                    </div> -->








                                </td>

                                <!-- <td>
                                    <div id="factura_producto" class="input_nombre">
                                        <select v-model="status[index]" name="type" id="type" class="form-control"
                                            required>
                                            <option v-for="status in statuses" v-bind:value="status.id" value="">
                                                {{ status.name }}
                                            </option>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <input type="text" v-model="desc[index]" id="desc" class="form-control"
                                        onkeypress="return valida(event)" />
                                </td>
                                <td>

                                  

                                    <div id="factura_producto" class="input_nombre">
                                        <select v-model="store[index]" name="type" id="type" class="form-control"
                                            required>
                                            <option v-for="store in stores" v-bind:value="store.id" value="">
                                                {{ store.text }}
                                            </option>
                                        </select>
                                    </div>



                                </td> -->

                                <td>
                                    <input type="number" id="qty" v-model="qty[index]"
                                        class="form-control input_cantidad" onkeypress="return valida(event)" /><span style="color:red;font-size: 15px;">{{ error_qty[0] }}</span> 
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
                                <td colspan="10">
                                    <div class="m-t-30 col-md-12">
                                        <label for="date">التاريخ</label><br />

                                        <input name="date" type="date" v-model="date" class="form-control" />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="10">
                                    <div class="m-t-30 col-md-12">
                                        <label for="date">ملاحظات</label><br />
                                        <input v-model="note" type="text" name="name" id="name" class="form-control" />
                                    </div>
                                </td>
                            </tr>
                            <a href="javascript:void" @click="Add_newexpence()" class="btn btn-success"><span>تاكيد
                                    العمليه</span></a>

                        </tbody>
                    </table>
                </div>
                <div class="modal fade" id="exampleModalProduct" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">

                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <div class="well" id="treeview_json_product"></div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
<script>
import pagination from "laravel-vue-pagination";

// D:\xampp\htdocs\Warehouse_v_1.0.2 - Copy\resources\js\operation.js
export default {
    components: {
        pagination,
    },
    data() {

        return {

            error_qty:'',
    //   error_expence_type:'',
            expence_type: [],
            qty: [],
            counts: {},

            indexselected: '',
            expence_types: '',
            expence_type: [],
            type: '',
            type_refresh: '',
            count: 1,
            // counts: {},

            word_search: '',
            // check_state: [],
            // qty: [],

            // total_quantity: 0,



            date: new Date().toISOString().substr(0, 10),
            // status: [],
            // store: [],
            // show: false,
            // paid: 0,
            // remaining: 0,
            // return_qty: [],
            note: '',
            // not_qty: true,
            // seen: false,
            // detail: '',
            // id: '',

        }
        // return data;
    },
    mounted() {
        this.list();

        this.counts[0] = 1;
        this.type = 'expence';
        this.type_refresh = 'increment';

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
                 
                    // if (response.data.message != 0) {
                    //     toastMessage("تم التحويل بنجاح");
                    //     this.$router.go(0);
                    // } else {
                    //     toastMessage("فشل", response.data.text);
                    // }




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