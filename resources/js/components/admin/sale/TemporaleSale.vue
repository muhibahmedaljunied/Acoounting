<template>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="modal-body">
                    <div class="custom-search">
                        <!-- <select v-model="product[index]" id="supplier" class="custom-search-input">

                                        </select> -->
                        <input :id="'purchase_tree' + index" type="text" readonly class="custom-search-input">
                        <input :id="'purchase_tree_id' + index" type="hidden" readonly class="custom-search-input">

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
                                <!-- <th>الوحده</th> -->
                                <th>السعر</th>
                                <th>الكميه</th>
                                <th>الضريبه</th>
                                <th>اضافه</th>
                            </tr>
                        </thead>
                        <tbody v-if="all_products && all_products.data.length > 0">
                            <!-- <tr v-for="(products, index) in product"> -->
                            <tr v-for="(product, index) in all_products.data" :key="index">
                                <!-- <td><input type="text" value="123" id="codigo0" class="form-control input_codigo" readonly=""></td> -->
                                <td>
                                    <div id="factura_producto" class="input_nombre">
                                        {{ product.product
                                        }}<input type="hidden" v-model="product.id" id="id" />
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
                                        {{ product.status }}
                                    </div>
                                </td>
                                <td>
                                    <div id="factura_producto" class="input_nombre">
                                        {{ product.desc }}
                                    </div>
                                </td>
                                <td>
                                    <div id="factura_producto" class="input_nombre">
                                        {{ product.availabe_qty }}
                                    </div>
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
                                </td> -->
                                <td>
                                    <input type="number" v-model="price[index]" id="price"
                                        class="form-control input_cantidad" onkeypress="return " />
                                </td>
                                <td>
                                    <input type="number" @input="on_input(qty[index], product.availabe_qty)"
                                        v-model="qty[index]" id="qty" class="form-control input_cantidad"
                                        onkeypress="return " />
                                </td>
                                <td>
                                    <input type="number" v-model="tax[index]" id="qty"
                                        class="form-control input_cantidad" onkeypress="return " />
                                </td>

                                <td>
                                    <input v-model="check_state[index]" @change="add_one_sale(
                                    
                                        product.product_id,
                                        qty[index],
                                        product.desc,
                                        product.availabe_qty,
                                        product.product,
                                        product.store_id,
                                        product.status_id,
                                        price[index],
                                        tax[index],
                                        index
                                    
                                    
                                    
                                    )" type="checkbox" class="btn btn-info waves-effect">
                                </td>

                            </tr>



                        </tbody>

                    </table>

                </div>
                <a href="javascript:void" @click="Add_newsale()" class="btn btn-success"><span>تاكيد
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
export default {
    data() {
        return {
            type: '',
            count: 1,
            counts: {},
            product: [],
            products:'',
            all_products: '',
            stores: '',
            statuses: '',
            status: [],
            store: [],
            check_state: [],
            qty: [],
            type: '',
            availabe_qty: [],
            price: [],
            tax: [],
            stores: '',
            statuses: '',


        };
    },

    mounted() {
        this.list();
        this.showtree();
        this.type = 'sale';
        this.type_refresh = 'decrement';
        // this.$Progress.start();
        // this.$store.dispatch("getAllnewsale");
        // this.$Progress.finish();
    },
    computed: {
        showNewsale() {
            return this.$store.getters.getCartSubtotal;
        },
    },
    methods: {
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

},
        list(page = 1) {

            this.axios.post(`/purchase/newpurchase?page=${page}`).then(({ data }) => {


                console.log(data.products);
                this.products = data.products;
                this.stores = data.stores;
                this.statuses = data.statuses;
            });

            this.axios
                .post(`/sale/newsale?page=${page}`)
                .then(({ data }) => {

                    this.all_products = data.products;

                })
                .catch(({ response }) => {
                    console.error(response);
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
            product_id,
            qty,
            desc,
            availabe_qty,
            product_name,
            store,
            status,
            price,
            tax,
            index
        ) {


            // console.log(product_id, index);
            // console.log(qty, index);
            // console.log(desc, index);
            // console.log(product_name, index);
            // console.log(store, index);
            // console.log(status, index);
            // console.log(availabe_qty, index);
            // console.log(price, price);
            // console.log(tax, tax);

            if (this.check_state[index] == true) {


                if (qty != 0) {

                    if (qty <= availabe_qty) {

                        this.counts[index] = index;
                        this.product[index] = product_id;
                        this.qty[index] = qty;
                        this.product_name[index] = product_name;
                        this.tax[index] = tax;
                        this.price[index] = price;
                        this.desc[index] = desc;
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
                this.$delete(this.price, price);
                this.$delete(this.tax, tax);

            }
            // console.log(this.counts, index);
            // console.log(this.product, index);
            // console.log(this.qty, index);
            // console.log(this.desc, index);
            // console.log(this.product_name, index);
            // console.log(this.store, index);
            // console.log(this.status, index);
            // console.log(this.availabe_qty, index);
            // console.log(this.price, price);
            // console.log(this.tax, tax);
        },


        Add_newsale() {
            Add_new(this);

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
  
  