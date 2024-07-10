<template>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">

                <div class="card text-right">
                    <div class="card-header">
                        <h1 class="card-title"> المبيعات</h1>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-4">
                                <h5 class="card-title">اختر المنتج</h5>
                                <div class="custom-search">

                                    <input :id="'Cash_product_tree'" type="text" readonly
                                        class="custom-search-input">
                                    <input :id="'Cash_product_tree_id'" type="hidden" readonly
                                        class="custom-search-input">

                                    <button class="custom-search-botton" type="button" data-toggle="modal"
                                        data-target="#exampleModalProduct" > <i
                                            class="fa fa-plus-circle"></i></button>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <h5 class="card-title">اختر المخزن</h5>
                                <div class="custom-search">

                                    <input :id="'Cash_store_tree'" type="text" readonly class="custom-search-input">
                                    <input :id="'Cash_store_tree_id'" type="hidden" readonly
                                        class="custom-search-input">

                                    <button class="custom-search-botton" type="button" data-toggle="modal"
                                        data-target="#exampleModalStore" > <i
                                            class="fa fa-plus-circle"></i></button>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <h5 class="card-title">اسم الحساب</h5>
                                <div class="custom-search">

                                    <input :id="'Cash_account_tree'" type="text" readonly class="custom-search-input">
                                    <input :id="'Cash_account_tree_id'" type="hidden" readonly
                                        class="custom-search-input">

                                    <button class="custom-search-botton" type="button" data-toggle="modal"
                                        data-target="#exampleModalAcoount" > <i
                                            class="fa fa-plus-circle"></i></button>
                                </div>
                            </div>

                            <!-- <div class="col-sm-6 col-md-2" style="margin-top: auto;">
                                <a href="#"><img src="/assets/img/search.png" alt="" style="width: 10%;"> </a>
                            </div> -->
                        </div>


                        <br>

                        <table class="table table-bordered text-right" style="width: 100%; font-size: x-large">
                            <thead>
                                <tr>
                                    <!-- <th>Code</th> -->
                                    <th>المنتج</th>

                                    <th>المخزن</th>
                                    <th>الحاله</th>
                                    <th> المواصفات والطراز</th>
                                    <th>الكميه المنوفره</th>
                                    <th>الوحده</th>
                                    <th>السعر</th>
                                    <th>الكميه</th>
                                    <th>الضريبه</th>
                                    <th>الاجمالي</th>
                                    <th>اضافه</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- <tr v-for="(products, index) in product"> -->
                                <tr v-for="(product, index) in all_products" :key="index">
                                    <!-- <td><input type="text" value="123" id="codigo0" class="form-control input_codigo" readonly=""></td> -->
                                    <td>
                                        <div id="factura_producto" class="input_nombre">
                                            {{
                                                product.product
                                            }}<input type="hidden" v-model="product.id" id="id" />
                                        </div>
                                    </td>



                                    <td>
                                        <div id="factura_producto" class="input_nombre">
                                            {{
                                                product.store
                                            }}<input  type="hidden" v-model="product.store_id" id="store_temporale" />
                                        </div>
                                    </td>

                                    <td>
                                        <div id="factura_producto" class="input_nombre">
                                            {{ product.status }}
                                        </div>
                                    </td>
                                    <td>
                                        <div id="factura_producto" class="input_nombre">
                                            {{ product.desc }}
                                        </div>
                                    </td>
                                    <td>
                                        <div id="factura_producto" class="input_nombre" v-if="product.availabe_qty">







                                            <div v-for="temx in product.units">



                                                <span v-if="temx.unit_type == 0">

                                                    <span v-if="product.quantity / product.rate >= 1">
                                                        {{ Math.floor((product.quantity / product.rate)) }}{{
                                                            product.units[0].name
                                                        }}
                                                    </span>

                                                    <span v-if="product.quantity % product.rate >= 1">
                                                        {{ Math.floor((product.quantity % product.rate)) }}{{
                                                            product.units[1].name
                                                        }}
                                                    </span>
                                                </span>

                                            </div>



                                        </div>

                                    </td>


                                    <td>
                                        <div id="factura_producto" class="input_nombre">





                                            <select style="background-color: beige;" :id="'select_unit' + index"
                                                v-model="unit[index]" name="type" class="form-control" required>

                                                <option v-for="unit in product.units"
                                                    v-bind:value="[unit.id, unit.rate, unit.unit_type]">
                                                    {{ unit.name }}
                                                </option>
                                            </select>





                                        </div>
                                    </td>
                                    <td>
                                        <input type="number" v-model="product.cost" id="price"
                                            class="form-control input_cantidad" onkeypress="return " />
                                    </td>
                                    <td>
                                        <input style="background-color: beige;" type="number" @input="on_input(qty[index], product.availabe_qty), calculate_price(product.cost, qty[index],
                                            index)" v-model="qty[index]" id="qty" class="form-control input_cantidad"
                                            onkeypress="return " />
                                    </td>
                                    <td>
                                        <input type="number" v-model="tax[index]" id="qty"
                                            class="form-control input_cantidad" onkeypress="return " />
                                    </td>

                                    <td>
                                        <input type="number" v-model="total[index]" id="qty"
                                            class="form-control input_cantidad" onkeypress="return " readonly />
                                    </td>

                                    <td>
                                        <input v-model="check_state[index]" @change="add_one_sale(

                                            product.product_id,
                                            qty[index],
                                            product.desc,
                                            product.availabe_qty,
                                            unit[index],
                                            product.store_id,
                                            product.status_id,
                                            product.price,
                                            tax[index],
                                            index,
                                            total



                                        )" type="checkbox" class="btn btn-info waves-effect">
                                    </td>

                                </tr>



                            </tbody>

                        </table>
                        <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                        <a href="javascript:void" @click="Add_new()" class="btn btn-primary"><span>تاكيد
                                العمليه</span></a>
                    </div>

                </div>






                <!-- <div class="modal fade" id="exampleModalProduct" tabindex="-1" role="dialog"
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
                <div class="modal fade" id="exampleModalAcoount" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">

                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <div class="well" id="treeview_json_account"></div>

                            </div>

                        </div>
                    </div>
                </div> -->
            </div>
        </section>
    </div>
</template>
<script>
import operation from '../../../operation1.js';
import tree from '../../../tree/tree.js';
export default {
    mixins: [
        operation,
        tree
    ],
    data() {
        return {
            account:'',
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

            index: 0,
            all_products: '',
            jsonTreeData: '',
            type_of_tree: 1,
            indexselected: '',
            // indexselectedproduct: '',
            // indexselectedstore: '',
            last_nodes: '',


            statusselected: 0,
            unitselected: 0,
            unitselectedname: '',
            productselected: 0,
            productselectedname: "",
            storeselectedname: "",
            storeselected: 0,
            descselected: "",
            operationselected: 0,
            dateselected: 0,
            typeselected: [],
            checkselected: '',




        };
    },

    mounted() {
        this.type_of_tree = 1;
        this.type = 'Cash';
        this.type_refresh = 'increment';
        this.list();
        this.showtree('product','tree_product');
        this.showtree('store','tree_store');
        this.showtree('account','tree_account');
      
        // this.$Progress.start();
        // this.$store.dispatch("getAllnewsale");
        // this.$Progress.finish();
    },

    methods: {


        calculate_price(price, qty, index) {
            console.log(price);

            if (this.unit[index][2] == 0) {

                this.total[index] = price * qty;

            }

            if (this.unit[index][2] == 1) {

                this.total[index] = price * this.unit[index][1] * qty;

            }

        },
        list(page = 1) {

            this.axios.post(`/sale/newsale?page=${page}`).then((responce) => {


                console.log(responce.data);
                // this.all_products = responce.data.products.data;

            });


        },

        take_discount() {

            this.sub_total *= parseInt(this.discount) / 100;
            // this.sub_total = this.sub_total/100;
        },
        onwaychange(e) {
            let input = e.target;
            this.type_payment = input.value;
            if (input.value == 2) {
                this.show = true;
            } else {
                this.show = false;
            }
        },
        on_input(qty, availabe_qty) {
            if (qty <= availabe_qty) {

                this.text_message = 'هذه الكميه غير متوفره ';
            }

        },
        credit(e) {
            this.remaining = this.sub_total - this.paid;
            this.To_pay = this.paid;
        },

        // add_one_sale(
        //     product,
        //     qty,
        //     desc,
        //     availabe_qty,
        //     unit,
        //     store,
        //     status,
        //     price,
        //     tax,
        //     index,
        //     total
        // ) {

        //     // console.log(this.counts, index);
        //     // console.log(product, index);
        //     // console.log(qty, index);
        //     // console.log(unit, index);
        //     // console.log(desc, index);
        //     // console.log(store, index);
        //     // console.log(status, index);
        //     // console.log(availabe_qty, index);
        //     // console.log(price, index);
        //     // console.log(tax, index);
        //     // console.log(total, index);

        //     if (this.check_state[index] == true) {


        //         if (qty != 0) {

        //             if (qty <= availabe_qty) {

        //                 this.counts[index] = index;
        //                 this.product[index] = product;
        //                 this.qty[index] = qty;
        //                 this.unit[index] = unit;
        //                 this.tax[index] = tax;
        //                 this.price[index] = price;
        //                 this.desc[index] = desc;
        //                 this.store[index] = store;
        //                 this.status[index] = status;
        //                 // this.total[index] = total
        //                 this.availabe_qty[index] = availabe_qty;
        //             }
        //         }



        //     }
        //     else if (this.check_state[index] == false) {

        //         this.$delete(this.counts, index);
        //         // this.$delete(this.product, index);
        //         // this.$delete(this.qty, index);
        //         // this.$delete(this.unit, index);
        //         // this.$delete(this.desc, index);
        //         // this.$delete(this.store, index);
        //         // this.$delete(this.status, index);
        //         // this.$delete(this.availabe_qty, index);
        //         // this.$delete(this.price, index);
        //         // this.$delete(this.tax, index);
        //         // this.$delete(this.total, index);

        //     }
        //     // console.log(this.counts, index);
        //     // console.log(this.product, index);
        //     // console.log(this.qty, index);
        //     // console.log(this.desc, index);
        //     // console.log(this.unit, index);
        //     // console.log(this.store, index);
        //     // console.log(this.status, index);
        //     // console.log(this.availabe_qty, index);
        //     // console.log(this.price, index);
        //     // console.log(this.tax, index);
        //     // console.log(this.total, index);
        // },

        Add_new() {



this.axios
    .post(`/add_Cash`, {
        type: this.type,
        count: this.counts,
        product: this.product,
        store_account: this.account,
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


    },
};
</script>
  
<style scoped>
th,
td {
    text-align: center;
}
</style>

