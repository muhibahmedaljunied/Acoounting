<template>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">

                <div class="card text-right">
                    <div class="card-header">
                        <h1 class="card-title"> التسعيره</h1>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">اختر المنتج</h5>
                        <div class="custom-search">

                            <input :id="'Sale_product_tree' + index" type="text" readonly class="custom-search-input">
                            <input :id="'Sale_product_tree_id' + index" type="hidden" readonly class="custom-search-input">

                            <button class="custom-search-botton" type="button" data-toggle="modal"
                                data-target="#exampleModalProduct" @click="detect_index(index)"> <i
                                    class="fa fa-plus-circle"></i></button>
                        </div>
                        <table class="table table-bordered text-right" style="width: 100%; font-size: x-large">
                            <thead>
                                <tr>
                                    <!-- <th>Code</th> -->
                                    <th>المنتج</th>

                                    <th>المخزن</th>
                                    <th>الحاله</th>
                                    <th> المواصفات والطراز</th>
                                    <th>الكميه المنوفره</th>
                                    <th>التكلفه</th>
                                    <th>سعر الجمله</th>
                                    <th>سعر التجزيه</th>

                                    <th>سعر خاص</th>
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
                                            }}<input type="hidden" v-model="product.store_id" id="id" />
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
                                                        {{ Math.round((product.quantity / product.rate)) }}{{
                                                            product.units[0].name
                                                        }}
                                                    </span>

                                                    <span v-if="product.quantity % product.rate >= 1">
                                                        {{ Math.round((product.quantity % product.rate)) }}{{
                                                            product.units[1].name
                                                        }}
                                                    </span>
                                                </span>

                                            </div>



                                        </div>

                                    </td>



                                    <td>
                                        <input type="number" v-model="product.cost" id="price"
                                            class="form-control input_cantidad" onkeypress="return " readonly/>
                                    </td>

                                    <td>
                                        <input type="number" v-model="price_all[index]" id="qty"
                                            class="form-control input_cantidad" onkeypress="return " />
                                    </td>

                                    <td>
                                        <input type="number" v-model="price_part[index]" id="qty"
                                            class="form-control input_cantidad" onkeypress="return "  />
                                    </td>
                                    <td>
                                        <input type="number" v-model="price_part[index]" id="qty"
                                            class="form-control input_cantidad" onkeypress="return "  />
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
                                            price_all[index],
                                            price_part[index],
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
import operation from '../../../operation1.js';
import tree from '../../../../js/tree/tree.js';
export default {
    mixins: [
        operation,
        tree
    ],
    data() {
        return {
            index: 0,
            price_all:[],
            price_part:[],


        };
    },

    mounted() {
        this.type_of_tree = 1;
        this.list();
        this.showtree('product');
        this.type = 'Sale';
        this.type_refresh = 'increment';

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
        list(page = 1) {

            this.axios.post(`/Warehouse/pricing?page=${page}`).then((responce) => {


                console.log(responce.data);
                this.all_products = responce.data.products.data;

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

        add_one_sale(
            product,
            qty,
            desc,
            availabe_qty,
            unit,
            store,
            status,
            price,
            price_all,
            price_part,
            tax,
            index,
            total
        ) {

            console.log(this.counts, index);
            console.log(product, index);
            console.log(qty, index);
            console.log(unit, index);
            console.log(desc, index);
            console.log(store, index);
            console.log(status, index);
            console.log(availabe_qty, index);
            console.log(price, index);
            console.log(price_all, index);
            console.log(price_part, index);
            console.log(tax, index);
            console.log(total, index);

            if (this.check_state[index] == true) {


                if (qty != 0) {

                    if (qty <= availabe_qty) {

                        this.counts[index] = index;
                        this.product[index] = product;
                        this.qty[index] = qty;
                        this.unit[index] = unit;
                        this.tax[index] = tax;
                        this.price[index] = price;
                        this.price_all[index] = price_all;
                        this.price_part[index] = price_part;
                        this.desc[index] = desc;
                        this.store[index] = store;
                        this.status[index] = status;
                        // this.total[index] = total
                        this.availabe_qty[index] = availabe_qty;
                    }
                }



            }
            else if (this.check_state[index] == false) {

                this.$delete(this.counts, index);


            }
            console.log(this.counts, index);
            console.log(this.product, index);
            console.log(this.qty, index);
            console.log(this.desc, index);
            console.log(this.unit, index);
            console.log(this.store, index);
            console.log(this.status, index);
            console.log(this.availabe_qty, index);
            console.log(this.price, index);
            console.log(this.price_all, index);
            console.log(this.price_part, index);
            console.log(this.tax, index);
            console.log(this.total, index);
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

