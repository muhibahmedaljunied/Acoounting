<template>
    <div class="content-wrapper">


        <div class="container-fluid">

            <div class="card">
                <div class="card-header">
                    <span class="h2">المصروفات</span>

                </div>
                <h5 class="card-title">اختر المنتج</h5>
                <div class="custom-search">


                    <input :id="'Cash_product_tree' + index" type="text" readonly class="custom-search-input">
                    <input :id="'Cash_product_tree_id' + index" type="hidden" v-model="product[index]"
                        class="custom-search-input">



                    <button class="custom-search-botton" type="button" data-toggle="modal"
                        data-target="#exampleModalProduct" @click="detect_index(index)"> <i
                            class="fa fa-plus-circle"></i></button>
                </div>
                <div class="card-body">
                    <table class="table table-bordered text-right" style="width: 100%; font-size: x-large">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>المنتج</th>
                                <!-- <th>المجموعه</th>
                  <th>الصنف</th> -->
                                <th>الحاله</th>
                                <th>المواصفات والطراز</th>
                                <th>المخزن</th>
                                <!-- <th> الرف</th> -->
                                <th>الكميه المنوفره</th>
                                <th>الوحده</th>
                                <th>التكلفه</th>
                                                                <th>كميه الصرف</th>

                                <th>الاجمالي</th>
                                <th>اضافه</th>
                            </tr>
                        </thead>
                        <tbody v-if="products && products.data.length > 0">
                            <tr v-for="(product, index) in products.data" :key="index">
                                <!-- <td><input type="text" value="123" id="codigo0" class="form-control input_codigo" readonly=""></td> -->
                                <td>{{ index + 1 }}</td>
                                <td>
                                    <div id="factura_producto" class="input_nombre">
                                        {{
                                            product.product
                                        }}<input type="hidden" v-model="product.product_id" id="id" />
                                    </div>
                                </td>

                                <td>
                                    <div id="factura_producto" class="input_nombre">
                                        {{
                                            product.status
                                        }}<input type="hidden" v-model="product.status_id" id="id" />
                                    </div>
                                </td>
                                <td>
                                    <div id="factura_producto" class="input_nombre">
                                        {{
                                            product.desc
                                        }}<input type="hidden" v-model="product.desc" id="id" />
                                    </div>
                                </td>
                                <td>
                                    <div id="factura_producto" class="input_nombre">
                                        {{
                                            product.store
                                        }}<input type="hidden" v-model="product.store_id" id="id" />
                                    </div>
                                </td>
                                <td>
                                    <!-- <div id="factura_producto" class="input_nombre">
                                        {{ product.availabe_qty }}
                                    </div> -->
                                    <div v-for="temx in product.units">

                                        <span v-if="temx.unit_type == 1">
                                            {{ parseInt(product.quantity / product.rate) }} {{ temx.name }}
                                        </span>
                                        <span v-if="temx.unit_type == 0">
                                            <span
                                                v-if="Math.round(((product.quantity / product.rate) - parseInt(product.quantity / product.rate)) * product.rate) != 0">
                                                و
                                                {{
                                                    Math.round(((product.quantity / product.rate) -
                                                        parseInt(product.quantity / product.rate)) * product.rate)
                                                }}{{
    temx.name
}}
                                            </span>

                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <div id="factura_producto" class="input_nombre">





                                        <select :id="'select_unit' + index" v-model="unit[index]" name="type"
                                            class="form-control" required>

                                            <option v-for="unit in product.units"
                                                v-bind:value='[unit.id, unit.rate, unit.unit_type]'>
                                                {{ unit.name }}
                                            </option>
                                        </select>





                                    </div>
                                </td>
                                    
                                <td>
                                    <!-- <input type="number" v-model="product.quantity" min="1" :max="product.availabe_qty"
                                        step="1" class="form-control input_cantidad" /> -->

                                    <input type="number" v-model="price[index]" step="1"
                                        class="form-control input_cantidad" />

                                </td>

                                <td>
                                    <input type="number"
                                        @input="on_input(qty[index], product.availabe_qty), calculate_price(price[index], qty[index], index)"
                                        v-model="qty[index]" id="qty" class="form-control input_cantidad"
                                        onkeypress="return " />
                                </td>
                            
                           

                         
                                <td>
                                    <input type="number" v-model="total[index]" class="form-control input_cantidad"
                                        onkeypress="return " />
                                </td>


                                <td>

                                    <input @change="
                                        add_one_cash(
                                            product.product_id,
                                            qty[index],
                                            product.desc,
                                            product.availabe_qty,
                                            product.store_id,
                                            product.status_id,
                                            index,
                                            total[index]
                                        )
                                    " type="checkbox" v-model="check_state[index]" class="btn btn-info waves-effect" />


                                </td>


                                <td v-if="product.availabe_qty != 0">

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <a href="javascript:void" @click="Add_newcash()" class="btn btn-success"><span>تاكيد
                        العمليه</span></a>



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



    </div>
</template>

<script>
import pagination from "laravel-vue-pagination";
import operation from '../../../../js/operation.js';
import tree from '../../../../js/tree/tree.js';
export default {
    components: {
        pagination,
    },
    mixins: [operation, tree],
    data() {

        return {
            text_message: '',
           
            total_quantity: 0,
            grand_total: 0,
            sub_total: 0,
            To_pay: 0,
            discount: 0,
            total_tax: 0,
            customer: [],
            supplier: [],
            suppliers: '',
            customers: '',

            temporale: 1,
            type_payment: 0,
            Way_to_pay_selected: 1,
            show: false,
            paid: 0,
            remaining: 0,

            note: '',
            not_qty: true,
            seen: false,

            id: '',


        };
    },

    mounted() {
        this.type_of_tree = 1;
        this.list();
        this.type = 'Cash';
        this.showtree('product');
        this.type_refresh = 'decrement';

    },
    methods: {


         calculate_price(price, qty, index) {
            // console.log(this.unit[index][2]);

            if (this.unit[index][2] == 0) {

                this.total[index] = price * qty;

            }

            if (this.unit[index][2] == 1) {

                this.total[index] = price * this.unit[index][1] * qty;

            }

        },
        on_input(qty, availabe_qty) {
            if (qty <= availabe_qty) {

                this.text_message = 'هذه الكميه غير متوفره ';
            }

        },

        get_search(word_search) {
            this.axios
                .post(`/cash/newcashsearch`, { word_search: this.word_search })
                .then(({ data }) => {

                    this.products = data.products;

                });
        },
        list(page = 1) {
            this.axios
                .post(`/cash/newcash?page=${page}`)
                .then(({ data }) => {
                    console.log(data.products);

                    this.products = data.products;

                })
                .catch(({ response }) => {
                    console.error(response);
                });
        },

        add_one_cash(
            product_id,
            qty = 0,
            desc,
            availabe_qty,
    
            store,
            status,
            index,
            total
        ) {



            if (this.check_state[index] == true) {

                if (qty != 0) {


                    if (qty <= availabe_qty) {


                        this.counts[index] = index;

                        this.product[index] = product_id;
                        this.qty[index] = qty;
                        this.desc[index] = desc;
                   

                        this.store[index] = store;
                        this.status[index] = status;

                        this.availabe_qty[index] = availabe_qty;
                        this.total[index] = total;


                    }
                }


            } else if (this.check_state[index] == false) {

                this.$delete(this.counts, index);
                this.$delete(this.product, index);
                this.$delete(this.qty, index);
                this.$delete(this.desc, index);
                this.$delete(this.product_name, index);
                this.$delete(this.store, index);
                this.$delete(this.status, index);
                this.$delete(this.availabe_qty, index);
                this.$delete(this.total, index);


            }
            console.log(this.counts);
            console.log(this.product);
            console.log(this.qty);
            console.log(this.desc);
            console.log(this.product_name);
            console.log(this.store);
            console.log(this.status);
            console.log(this.availabe_qty);
            console.log(this.total);





        },




    },
};
</script>

