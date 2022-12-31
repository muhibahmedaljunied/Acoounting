<template>
    <div class="content-wrapper">


        <div class="container-fluid">

            <div class="card">
                <div class="card-header">
                    <span class="h2">المصروفات</span>

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
                                <th>كميه الصرف</th>


                                <th>اضافه</th>
                            </tr>
                        </thead>
                        <tbody v-if="products && products.data.length > 0">
                            <tr v-for="(product, index) in products.data" :key="index">
                                <!-- <td><input type="text" value="123" id="codigo0" class="form-control input_codigo" readonly=""></td> -->
                                <td>{{ index + 1 }}</td>
                                <td>
                                    <div id="factura_producto" class="input_nombre">
                                        {{ product.product
                                        }}<input type="hidden" v-model="product.product_id" id="id" />
                                    </div>
                                </td>

                                <td>
                                    <div id="factura_producto" class="input_nombre">
                                        {{ product.status
                                        }}<input type="hidden" v-model="product.status_id" id="id" />
                                    </div>
                                </td>
                                <td>
                                    <div id="factura_producto" class="input_nombre">
                                        {{ product.desc
                                        }}<input type="hidden" v-model="product.desc" id="id" />
                                    </div>
                                </td>
                                <td>
                                    <div id="factura_producto" class="input_nombre">
                                        {{ product.store
                                        }}<input type="hidden" v-model="product.store_id" id="id" />
                                    </div>
                                </td>



                                <td>
                                    <div id="factura_producto" class="input_nombre">
                                        {{ product.availabe_qty }}
                                    </div>
                                </td>

                                <td>
                                    <input type="number" v-model="product.quantity" min="1" :max="product.availabe_qty"
                                        step="1" class="form-control input_cantidad"
                                        onkeypress="return valida(event)" />
                                    <!-- @input="check_qty(qty[index], product.id)" -->
                                </td>

                                <td>

                                    <input @change="
                                        add_one_cash(
                                            product.product_id,
                                            product.quantity,
                                            product.desc,
                                            product.availabe_qty,
                                            product.product,
                                            product.store_id,
                                            product.status_id,
                                            index
                                        )
                                    " type="checkbox" v-model="check_state[index]"
                                        class="btn btn-info waves-effect" />


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
        </div>



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
            type: '',
            count: 1,
            counts: {},
            product: [],
            products: '',
            stores: '',
            statuses: '',
            status: [],
            store: [],
            check_state: [],
            qty: [],
        };
    },

    mounted() {
        this.list();
        this.type = 'cash';
        this.type_refresh = 'decrement';

    },
    methods: {




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
            product_name,
            store,
            status,
            index
        ) {



            if (this.check_state[index] == true) {

                if (qty != 0) {


                    if (qty <= availabe_qty) {


                        this.counts[index] = index;

                        this.product[index] = product_id;
                        this.qty[index] = qty;
                        this.desc[index] = desc;
                        this.product_name[index] = product_name;

                        this.store[index] = store;
                        this.status[index] = status;

                        this.availabe_qty[index] = availabe_qty;


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


            }
            // console.log(this.counts);
            // console.log(this.product);
            // console.log(this.qty);
            // console.log(this.desc);
            // console.log(this.product_name);
            // console.log(this.store);
            // console.log(this.status);
            // console.log(this.availabe_qty);





        },


        Add_newcash() {
            //    Add_new(this)

        }

    },
};
</script>
  
  