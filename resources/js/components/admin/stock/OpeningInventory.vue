<template>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">

                <div class="card text-right">
                    <div class="card-header">

                        <h1 class="card-title"> المخزون الافتتاحي</h1>
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
                                        <th>التكلفه</th>

                                        <th>الكميه</th>

                                        <th>الاجمالي</th>
                                        <th>تاريخ الانتهاء</th>


                                        <th>اضافه</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="index in count" :key="index">

                                        <td>





                                            <div class="custom-search">

                                                <input :id="'Opening_product_tree' + index" type="text" readonly
                                                    class="custom-search-input">
                                                <input :id="'Opening_product_tree_id' + index" type="hidden" readonly
                                                    class="custom-search-input">

                                                <button class="custom-search-botton" type="button" data-toggle="modal"
                                                    data-target="#exampleModalProduct" @click="detect_index(index)"> <i
                                                        class="fa fa-plus-circle"></i></button>
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

                                                <input :id="'Opening_store_tree' + index" type="text" readonly
                                                    class="custom-search-input">
                                                <input :id="'Opening_store_tree_id' + index" type="hidden" readonly
                                                    class="custom-search-input">

                                                <button class="custom-search-botton" type="button" data-toggle="modal"
                                                    data-target="#exampleModalStore" @click="detect_index_store(index)">
                                                    <i class="fa fa-plus-circle"></i></button>
                                            </div>
                                        </td>




                                        <td>
                                            <div id="factura_producto">

                                                <select v-model="unit[index]" name="type" :id="'select_unit' + index"
                                                    class="form-control" required>

                                                </select>
                                            </div>
                                        </td>


                                        <td>
                                            <input type="number" v-model="price[index]" class="form-control" />
                                        </td>

                                        <td>
                                            <input @input="calculate_price(price[index], qty[index], index)" type="number"
                                                v-model="qty[index]" id="qty" class="form-control" />
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
                        <a href="javascript:void" @click="add_opening()" class="btn btn-primary"><span>تاكيد
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
                <div class="row" style="font-size: 10pt">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered text-right m-t-30" style="width: 100%; font-size: x-small">
                                <thead>
                                    <tr>
                                        <th style="width: 60px">#</th>
                                        <th style="width: 60px">المنتج</th>
                                        <th style="width: 60px">المخزن</th>
                                        <th style="width: 60px">الحاله</th>
                                        <th style="width: 60px">المواصفات والطراز</th>
                                        <th style="width: 60px">الكميه </th>
                                        <th style="width: 60px">التكلفه</th>
                                        <th style="width: 60px">الاجمالي</th>
                                        <th style="width: 60px">العمليات</th>
                                    </tr>
                                </thead>
                                <tbody v-if="opening && opening.data.length > 0">
                                    <tr v-for="(openings, index) in opening.data" :key="index">
                                        <td style="width: 40px">{{ index + 1 }}</td>
                                        <td style="width: 40px">{{ openings.product }}</td>

                                        <td style="width: 40px">
                                            {{ openings.store }}
                                        </td>

                                        <td style="width: 40px">{{ openings.status }}</td>
                                        <td style="width: 40px">{{ openings.desc }}</td>

                                        <td>{{ openings.tem_qty }} {{ openings.unit }}</td>
                                        <td>{{ openings.price }}</td>
                                        <td>{{ openings.total }}</td>
                                        <td>
                                            <button data-toggle="modal" data-target="#modal_vaciar1"
                                                @click="show_modal(openings.product_id)"
                                                class="tn btn-danger btn-sm waves-effect btn-agregar">
                                                <i class="fa fa-trash"></i></button>

                                            <router-link to="/opening_supply"
                                                class="tn btn-info btn-sm waves-effect btn-agregar" data-toggle="tooltip"
                                                title="تعديل">
                                                <i class="fa fa-edit"></i></router-link>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr>
                                        <td align="center" colspan="7">
                                            <h3> لايوجد بيانات </h3>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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

    mixins: [tree, operation],

    data(){

        return{

                  all_products: '',
            jsonTreeData: '',
            type_of_tree: 1,
            indexselected: '',
            indexselectedproduct: '',
            indexselectedstore: '',
            last_nodes: '',
            rank: 1,
            parent: 0,
            index: 0,

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
            moveselected: 0,

        }
    },


    mounted() {
        this.list();
        this.type_of_tree = 1;
        this.showtree('product');
        this.showtree('store');
        this.counts[0] = 1;
        this.type = 'Opening';
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
        add_opening() {

            this.axios
                .post("add_Opening", {
                    date: this.date,
                    count: this.counts,
                    product_id: this.product,
                    store_id: this.store,
                    type: this.type,
                    type_refresh: this.type_refresh,
                    desc: this.desc,
                    qty: this.qty,
                    unit_id: this.unit,
                    status_id: this.status,
                    price: this.price,
                    expiry_date: this.expiry_date,
                    total: this.total,
                    // old: this.detail,


                })
                .then(function (response) {
                    console.log(response);
                    if (response.data.message != 0) {
                        toastMessage("تم التحويل بنجاح");
                        this.$router.go(0);
                    } else {
                        toastMessage("فشل", response.data.text);
                    }


                })
                .catch(function (error) {
                    currentObj.output = error;
                });

            // this.$router.go(-1);
        },
        list(page = 1) {
            this.axios
                .post(`/opening/newopening?page=${page}`)
                .then(({ data }) => {
                    console.log('data.statuses');

                    // this.opening = data.temporales;
                    this.statuses = data.statuses;

                })
                .catch(({ response }) => {
                    console.error(response);
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


