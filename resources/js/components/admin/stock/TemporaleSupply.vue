<template>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="card text-right">
                    <div class="card-header">
                        Featured
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Special title treatment</h5>
                        <table class="table table-bordered text-right" style="width: 100%; font-size: x-large">
                    <thead>
                        <tr>

                            <th>المنتج</th>


                            <th>الحاله</th>
                            <th>المواصفات والطراز</th>

                            <th>المخزن</th>

                            <th>الكميه الوارده</th>
                            <th>اضافه</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="index in count" :key="index">

                            <td>

                                <!-- <input type="number" v-model="product[index]" class="form-control input_cantidad"
  onkeypress="return valida(event)" />  -->
                                <!-- <div id="factura_producto" class="input_nombre">
                                      <select v-model="product[index]" name="type" id="type" class="form-control"
                                          required>
                                          <option v-for="(product, sindex) in products" :key="sindex"
                                              v-bind:value="product.id">
                                              {{ product.text }}
                                          </option>
                                      </select>
                                  </div> -->





                                <div class="custom-search">
                                    <!-- <select v-model="product[index]" id="supplier" class="custom-search-input">

                                      </select> -->

                                    <input :id="'supply_tree' + index" type="text" readonly class="custom-search-input">
                                    <input :id="'supply_tree_id' + index" type="hidden" v-model="product[index]"
                                        class="custom-search-input">



                                    <button class="custom-search-botton" type="button" data-toggle="modal"
                                        data-target="#exampleModalProduct" @click="detect_index(index)"> <i
                                            class="fa fa-plus-circle"></i></button>
                                </div>








                            </td>

                            <td>
                                <div id="factura_producto" class="input_nombre">
                                    <select v-model="status[index]" name="type" id="type" class="form-control" required>
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

                                <!-- <input type="number" v-model="store[index]" class="form-control input_cantidad"
  onkeypress="return valida(event)" /> -->

                                <div id="factura_producto" class="input_nombre">
                                    <select v-model="store[index]" name="type" id="type" class="form-control" required>
                                        <option v-for="store in stores" v-bind:value="store.id" value="">
                                            {{ store.text }}
                                        </option>
                                    </select>
                                </div>



                            </td>

                            <td>
                                <input type="number" v-model="qty[index]" id="qty" class="form-control input_cantidad"
                                    onkeypress="return valida(event)" />
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
                      

                    </tbody>
                </table>
                        <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                        <a href="javascript:void" @click="Add_newsupply()" class="btn btn-primary"><span>تاكيد
                                العمليه</span></a>
                    </div>
                    <div class="card-footer text-muted">
                        2 days ago
                    </div>
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
export default {
    components: {
        pagination,
    },
    data() {

        return {
            indexselected: '',

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
            desc: [],
            stores: '',
            statuses: '',
            total_quantity: 0,



            date: new Date().toISOString().substr(0, 10),
            status: [],
            store: [],
            show: false,
            paid: 0,
            remaining: 0,
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
        this.type = 'supply';
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

                    console.log(data);
                    $(`#supply_tree${gf.indexselected}`).val(data.node.text);
                    $(`#supply_tree_id${gf.indexselected}`).val(data.node.id);



                    gf.product[gf.indexselected] = data.node.id;

                    // gf.intostore[gf.indexselected] = $(`#supply_tree${gf.indexselected}`).val(data.node.text);
                    //  modal-title-store
                    // gf.get_store(data.node.id);


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

            //         console.log(data.node.id);
            //         $(`.modal-title-store`).val(data.node.id)
            //         //  modal-title-store
            //     });

            // });
        },
        addComponent(index) {
            // alert(index);
            this.count += 1;
            this.counts[index] = this.count;
        },
        disComponent(index) {
            this.count -= 1;
            this.$delete(this.counts, index);
        },

        get_search() {
            // alert(typeof(this.word_search));
            // alert(this.word_search);
            this.axios
                .post(`/supply/newsupplysearch`, { word_search: this.word_search })
                .then(({ data }) => {
                    console.log(data.products);
                    this.temporales = data.temporales;

                    this.temporale.forEach((item) => {
                        this.total_quantity = item.tem_qty + this.total_quantity;
                    });

                    this.products = data.products;
                    this.suppliers = data.suppliers;

                    // this.stores = data;
                });
        },
        list(page = 1) {
            this.axios
                .post(`/supply/newsupply?page=${page}`)
                .then(({ data }) => {
                    console.log(data);

                    // this.temporale = data.temporales;

                    // this.temporale.forEach((item) => {
                    //     this.total_quantity = item.tem_qty + this.total_quantity;
                    // });

                    this.products = data.products;
                    this.suppliers = data.suppliers;

                    this.stores = data.stores;
                    this.statuses = data.statuses;

                    console.log(this.stores);

                    // this.stores = data;
                })
                .catch(({ response }) => {
                    console.error(response);
                });
        },
        Add_newsupply() {

            Add_new(this);
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
