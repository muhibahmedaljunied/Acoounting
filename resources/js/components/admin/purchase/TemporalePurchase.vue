<template>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">

                <div class="card text-right">
                    <div class="card-header">

                        <h1 class="card-title"> المشتريات</h1>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Special title treatment</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered text-right" style="width: 100%; font-size: x-large">
                                <thead>
                                    <tr>
                                        <!-- <th>Code</th> -->
                                        <th>المنتج</th>
                                        <!-- <th>المجموعه</th> -->

                                        <th>الحاله</th>
                                        <th>الموصفات والطراز</th>
                                        <th>المخزن</th>
                                        <th>الوحده</th>
                                        <!--<th>التكلفه</th> -->

                                        <th>السعر</th>
                                        <th>الكميه</th>
                                        <th>الضريبه</th>
                                        <th>الاجمالي</th>
                                        <th>تاريخ الانتهاء</th>


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
                                                <input style="background-color: beige;"
                                                    :id="'Purchase_product_tree' + index" type="text" readonly
                                                    class="custom-search-input">
                                                <input :id="'Purchase_product_tree_id' + index" type="hidden" readonly
                                                    class="custom-search-input">

                                                <button class="custom-search-botton" type="button" data-toggle="modal"
                                                    data-target="#exampleModalProduct" @click="detect_index_product(index)">
                                                    <i class="fa fa-plus-circle"></i></button>
                                            </div>



                                        </td>

                                        <td>
                                            <div id="factura_producto">
                                                <select v-model="status[index]" name="type" id="type" class="form-control"
                                                    required>

                                                    <option v-for="status in statuses" v-bind:value="status.id">
                                                        {{ status.name }}
                                                    </option>
                                                </select>
                                            </div>
                                        </td>

                                        <td>
                                            <div id="factura_producto">
                                                <input type="text" v-model="desc[index]" id="desc" class="form-control" />
                                            </div>
                                        </td>

                                        <td>
                                            <!-- <div id="factura_producto" class="input_nombre">
                                      <select v-model="store[index]" name="type" id="type" class="form-control"
                                          required>
                                          <option v-for="store in stores" v-bind:value="store.id">
                                              {{ store.text }}
                                          </option>
                                      </select>
                                  </div> -->


                                            <div class="custom-search">

                                                <input style="background-color: beige;" :id="'Purchase_store_tree' + index"
                                                    type="text" readonly class="custom-search-input">
                                                <input :id="'Purchase_store_tree_id' + index" type="hidden" readonly
                                                    class="custom-search-input">

                                                <button class="custom-search-botton" type="button" data-toggle="modal"
                                                    data-target="#exampleModalStore" @click="detect_index_store(index)"> <i
                                                        class="fa fa-plus-circle"></i></button>
                                            </div>
                                        </td>


                                        <td>
                                            <div id="factura_producto">
                                                <!-- <input v-model="unit_type[index]" :id="'unit_type' + index" type="hidden" readonly> -->

                                                <select style="background-color: beige;" v-model="unit[index]" name="type"
                                                    :id="'select_unit' + index" class="form-control" required>

                                                </select>
                                            </div>
                                        </td>


                                        <td>
                                            <input style="background-color: beige;" type="number" v-model="price[index]"
                                                id="qty" class="form-control" />
                                        </td>
                                        <td>
                                            <input style="background-color: beige;"
                                                @input="calculate_price(price[index], qty[index], index)" type="number"
                                                v-model="qty[index]" id="qty" class="form-control" />
                                        </td>
                                        <td>
                                            <input type="number" v-model="tax[index]" id="tax" class="form-control" />
                                        </td>

                                        <td>
                                            <input type="number" v-model="total[index]" id="tax" class="form-control"
                                                readonly />


                                        </td>

                                        <td>
                                            <input name="expiry_date" type="date" v-model="expiry_date"
                                                class="form-control" />

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
                        <a href="javascript:void" @click="Add_new()" class="btn btn-primary"><span>تاكيد
                                العمليه</span></a>
                    </div>
                    <!-- <div class="card-footer text-muted">
                        2 days ago
                    </div> -->
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

                <div class="modal fade" id="exampleModalStore" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">

                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <div class="well" id="treeview_json_store"></div>

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
import operation from '../../../operation1.js';
import tree from '../../../../js/tree/tree.js';
export default {

    components: {
        pagination,
    },
    // mixins: [operation],
    mixins: [tree, operation],
    data() {
        return {
            product: [],
            qty: [],
            unit: [],
            desc: [],
            store: [],
            status: [],
            counts: {},
            count: 1,
            date: new Date().toISOString().substr(0, 10),
            dateselected: new Date().toISOString().substr(0, 10),
            expiry_date: new Date().toISOString().substr(0, 10),
            table: '',
            type: '',
            type_refresh: '',
            note: "",
            detail: '',
            Total_quantity: 0,
            total_quantity: 0,
            check_state: [],
            return_qty: [],
            price: [],
            tax: [],
            products: '',
            stores: '',
            statuses: '',
            stores: '',
            statuses: '',
            units: '',
            opening: '',
            availabe_qty: [],
            word_search: '',
            total: [],
            customer: [],
            supplier: [],
            suppliers: '',
            customers: '',
            seen: false,
            id: '',

            // status_tree: 1,
            text_message: '',
            indexselected: '',
            // indexselectedstore: '',
            total_quantity: 0,
            grand_total: 0,
            sub_total: 0,
            discount: 0,
            expiry_date: [],
            temporale: 1,
            type_payment: 0,
            show: false,
            not_qty: true,
            seen: false,
            id: '',
        }

    },

    mounted() {
        this.list();
        this.type_of_tree = 1;
        this.showtree('product','tree_product');
        this.showtree('store','tree_store');
        this.counts[0] = 1;
        this.type = 'Purchase';
        this.type_refresh = 'increment';


    },

    methods: {
        calculate_price(price, qty, index) {
            var unit = JSON.parse($(`#select_unit${index}`).val());
            if (unit[2] == 0) {

                this.total[index] = price * qty;
            }

            if (unit[2] == 1) {

                this.total[index] = price * unit[1] * qty;

            }

        },





        get_search() {
            this.axios
                .post(`/purchase/newpurchasesearch`, { word_search: this.word_search })
                .then(({ data }) => {
                    this.products = data.products;
                });
        },
        Add_new() {



            this.axios
                .post(`/add_Purchase`, {
                    type: this.type,
                    count: this.counts,
                    product: this.product,

                    store: this.store,
                    unit: this.unit,
                    desc: this.desc,
                    qty: this.qty,
                    status: this.status,
                    price: this.price,
                    total: this.total,
                    tax: this.tax,
                })
                .then((response) => {
                    // ---------------------------------------------------------------
                    console.log(response);

                    toastMessage("تم الاضافه بنجاح");
                    // this.$router.go(0);
                });

            // }
        },

        list(page = 1) {

            this.axios.post(`/purchase/newpurchase?page=${page}`).then(({ data }) => {


                console.log(data);
                this.products = data.products;
                this.stores = data.stores;
                this.statuses = data.statuses;
                // this.units = data.units;
            });

        },


    },
};
</script>
  
<style scoped>
th,
td {
    text-align: center;
}
</style>


