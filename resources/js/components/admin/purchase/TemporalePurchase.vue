<template>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="modal-body">
                    <table class="table table-bordered text-right" style="width: 100%; font-size: x-large">
                        <thead>
                            <tr>
                                <!-- <th>Code</th> -->
                                <th>المنتج</th>
                                <!-- <th>المجموعه</th> -->

                                <th>الحاله</th>
                                <th>الموصفات والطراز</th>
                                <th>المخزن</th>
                                <!-- <th>الوحده</th>
                                <th>التكلفه</th> -->

                                <th>السعر</th>
                                <th>الكميه</th>
                                <th>الضريبه</th>
                                <th>اضافه</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="index in count" :key="index">
                                <!-- <tr v-for="(products, index) in product"> -->
                                <!-- <tr v-for="(products, index) in product" :key="index"> -->
                                <!-- <td><input type="text" value="123" id="codigo0" class="form-control input_codigo" readonly=""></td> -->
                                <td>



                                    <!-- <div id="factura_producto" class="input_nombre">
                          <select v-model="product[index - 1]" name="type" id="type" class="form-control" required>
                            <option v-for="(product, sindex) in products" :key="sindex" v-bind:value="product.id">
                              {{ product.text }}
                            </option>
                          </select>
                        </div> -->

                                    <div class="custom-search">
                                        <!-- <select v-model="product[index]" id="supplier" class="custom-search-input">

                                        </select> -->
                                        <input :id="'purchase_tree' + index" type="text" readonly
                                            class="custom-search-input">
                                        <input :id="'purchase_tree_id' + index" type="hidden" readonly
                                            class="custom-search-input">

                                        <button class="custom-search-botton" type="button" data-toggle="modal"
                                            data-target="#exampleModalProduct" @click="detect_index(index)"> <i
                                                class="fa fa-plus-circle"></i></button>
                                    </div>


                                </td>

                                <td>
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
                                    <div id="factura_producto" class="input_nombre">
                                        <input type="text" v-model="desc[index]" id="desc"
                                            class="form-control input_cantidad" onkeypress="return valida(event)" />
                                    </div>
                                </td>

                                <td>
                                    <div id="factura_producto" class="input_nombre">
                                        <select v-model="store[index]" name="type" id="type" class="form-control"
                                            required>
                                            <option v-for="store in stores" v-bind:value="store.id">
                                                {{ store.text }}
                                            </option>
                                        </select>
                                    </div>
                                </td>

                                <!-- <td>
                                    <div id="factura_producto" class="input_nombre">
                                        <select v-model="store[index]" name="type" id="type" class="form-control"
                                            required>
                                            <option v-for="store in stores" v-bind:value="store.id">
                                                {{ store.text }}
                                            </option>
                                        </select>
                                    </div>
                                </td>


                                <td>
                                    <input type="number" v-model="price[index]" id="qty"
                                        class="form-control input_cantidad" onkeypress="return valida(event)" />
                                </td> -->



                                <td>
                                    <input type="number" v-model="price[index]" id="qty"
                                        class="form-control input_cantidad" onkeypress="return valida(event)" />
                                </td>
                                <td>
                                    <input type="number" v-model="qty[index]" id="qty"
                                        class="form-control input_cantidad" onkeypress="return valida(event)" />
                                </td>
                                <td>
                                    <input type="number" v-model="tax[index]" id="tax"
                                        class="form-control input_cantidad" onkeypress="return valida(event)" />
                                </td>




                                <td v-if="index == 1">

                                    <button class="tn btn-info btn-sm waves-effect btn-agregar"
                                        v-on:click="addComponent">
                                        <i class="fa fa-plus-circle"></i></button>

                                    <button class="tn btn-info btn-sm waves-effect btn-agregar"
                                        v-on:click="disComponent">
                                        <i class="fa fa-minus-circle"></i></button>



                                </td>
                            </tr>


                        </tbody>
                    </table>
                </div>
                <a href="javascript:void" @click="Add_newpurchase()" class="btn btn-success"><span>تاكيد
                        العمليه</span></a>
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
export default {

    components: {
        pagination,
    },
    data() {
        return {
            indexselected: '',
            text_message: '',
            type: '',
            type_refresh: '',
            count: 1,
            counts: {},

            product_name: [],
            product: [],
            products: '',
            word_search: '',
            check_state: [],
            qty: [],
            availabe_qty: [],
            price: [],
            tax: [],
            desc: [],
            stores: '',
            statuses: '',
            total_quantity: 0,
            grand_total: 0,
            sub_total: 0,
            discount: 0,

            status: [],
            store: [],
            temporale: 1,
            type_payment: 0,

            show: false,


            return_qty: [],
            note: '',
            not_qty: true,
            seen: false,
            detail: '',
            id: '',






        }
        // return data;
    },

    mounted() {
        this.list();
        this.showtree();
        this.counts[0] = 1;
        this.type = 'purchase';
        this.type_refresh = 'increment';


    },

    methods: {

        detect_index(index) {

            this.indexselected = index;
        },

        showtree() {

            let gf = this;
            this.axios.post(`/tree_product`).then((response) => {
                this.jsonTreeDataProduct = response.data.products;


                $('#treeview_json_product').jstree({
                    core: {
                        themes: {
                            responsive: false,
                        },
                        // so that create works
                        check_callback: true,
                        data: this.jsonTreeDataProduct,
                    },
                    types: {
                        default: {
                            icon: "fa fa-folder text-primary",
                        },
                        file: {
                            icon: "fa fa-file  text-primary",
                        },
                    },
                    checkbox: {
                        three_state: false,

                    },
                    state: {
                        key: "demo2"
                    },
                    search: {
                        case_insensitive: true,
                        show_only_matches: true
                    },
                    plugins: ["checkbox",
                        "contextmenu",
                        "dnd",
                        "massload",
                        "search",
                        "sort",
                        "state",
                        "types",
                        "unique",
                        "wholerow",
                        "changed",
                        "conditionalselect"],
                    contextmenu: {
                        items: contextmenu
                    },






                }).on("changed.jstree", function (e, data) {

                    console.log(data.node.id);

                    //  modal-title-store

                    $(`#purchase_tree${gf.indexselected}`).val(data.node.text);
                    $(`#purchase_tree_id${gf.indexselected}`).val(data.node.id);

                    gf.product[gf.indexselected] = data.node.id;



                });

            });
            // this.axios.post(`/tree_store`).then((response) => {
            //     this.jsonTreeDataStore = response.data.stores;


            //     $('#treeview_json_store').jstree({
            //         core: {
            //             themes: {
            //                 responsive: false,
            //             },
            //             // so that create works
            //             check_callback: true,
            //             data: this.jsonTreeDataStore,
            //         },
            //         types: {
            //             default: {
            //                 icon: "fa fa-folder text-primary",
            //             },
            //             file: {
            //                 icon: "fa fa-file  text-primary",
            //             },
            //         },
            //         checkbox: {
            //             three_state: false,

            //         },
            //         state: {
            //             key: "demo2"
            //         },
            //         search: {
            //             case_insensitive: true,
            //             show_only_matches: true
            //         },
            //         plugins: ["checkbox",
            //             "contextmenu",
            //             "dnd",
            //             "massload",
            //             "search",
            //             "sort",
            //             "state",
            //             "types",
            //             "unique",
            //             "wholerow",
            //             "changed",
            //             "conditionalselect"],
            //         contextmenu: {
            //             items: contextmenu
            //         },






            //     }).on("changed.jstree", function (e, data) {

            //         // console.log(data.node.id);
            //         $(`#purchase_tree${gf.indexselected}`).val(data.node.text);
            //         $(`#purchase_tree_id${gf.indexselected}`).val(data.node.id);

            //         // gf.intostore[gf.indexselected] = $(`#supply_tree${gf.indexselected}`).val(data.node.text);
            //         //  modal-title-store
            //         // gf.get_store(data.node.id);


            //     });

            // });
        },

        addComponent(index) {
            this.count += 1;
            this.counts[index] = this.count;

        },
        disComponent(index) {
            this.count -= 1;
            this.$delete(this.counts, index);

        },

        // take_discount() {

        //     if (this.discount != 0) {

        //         this.sub_total = (parseInt(this.discount) * this.sub_total) / 100;
        //     }


        // },

        get_search() {
            this.axios
                .post(`/purchase/newpurchasesearch`, { word_search: this.word_search })
                .then(({ data }) => {
                    this.products = data.products;
                });
        },
        list(page = 1) {

            this.axios.post(`/purchase/newpurchase?page=${page}`).then(({ data }) => {


                console.log(data.products);
                this.products = data.products;
                this.stores = data.stores;
                this.statuses = data.statuses;
            });

        },

        // onwaychange(e) {
        //     let input = e.target;
        //     this.type_payment = input.value;
        //     if (input.value == 2) {
        //         this.show = true;
        //     } else {
        //         this.show = false;
        //     }
        // },
        // credit(e) {
        //     this.remaining = this.grand_total - this.paid;
        //     this.To_pay = this.paid;
        // },

        Add_newpurchase() {

            Add_new(this)
            this.$router.go(-1);
        },

    },
};
</script>
<style scoped>
.custom-search {
    position: relative;
    width: 300px;
}

.custom-search-input {
    width: 100%;
    border: 1px solid #ccc;
    border-radius: 100px;
    padding: 10px 100px 10px 20px;
    line-height: 1;
    box-sizing: border-box;
    outline: none;
}

.custom-search-botton {
    position: absolute;
    right: 3px;
    top: 3px;
    bottom: 3px;
    border: 0;
    background: #d1095e;
    color: #fff;
    outline: none;
    margin: 0;
    padding: 0 10px;
    border-radius: 100px;
    z-index: 2;
}
</style>
    
<style scoped>
th,
td {
    text-align: center;
}
</style>
  
  
  