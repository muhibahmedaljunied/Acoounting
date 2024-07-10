<template>
    <div class="container-fluid">

        <div class="row row-sm">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <!-- <span class="h2"> المخزون</span> -->

                        <div class="pull-right">
                            <h3>كشف حساب مورد <span id="codigo"></span></h3>
                        </div>


                    </div>
                    <div class="card-body">

                        <div class="row">


                            <div class="col-md-4">
                                <label for="cliente">اختر مورد</label>

                                <select v-model="supplier" id="supplier" class="form-control">
                                    <option v-for="sup in suppliers" v-bind:value="[sup.id, sup.name]">
                                        {{ sup.name }}
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label for="date"> من تاريخ </label><br />

                                <input name="date" type="date" v-model="date" class="form-control" />
                            </div>
                            <div class="col-md-2">
                                <label for="date"> الي تاريخ </label><br />

                                <input name="date" type="date" v-model="date" class="form-control" />
                            </div>
                            <div class="col-sm-2 col-md-3" style="margin-top: auto;">
                                <a @click="onwaychange()" href="#"><img src="/assets/img/search.png" alt=""
                                        style="width: 10%;"> </a>
                            </div>

                        </div>
                        <br>
                        <hr />
                        <div class="row" style="font-size: 20px">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered text-right m-t-30" style="width: 100%"
                                        id="lista_productos_temporal">
                                        <thead>
                                            <tr>


                                                <th>التاريخ</th>
                                                <th>البيات</th>
                                                <th>مدين</th>
                                                <th>داين</th>
                                                <th>الرصيد</th>




                                                <!-- <th>الاجمالي<small> مع الضريبه </small></th> -->
                                                <!-- <th style="width: 60px">العمليات</th> -->
                                            </tr>
                                        </thead>

                                        <tbody v-if="purchases.data && purchases.data.length > 0">


                                            <tr v-for="temporales in purchases.data">

                                                <td>{{ temporales.date }}</td>
                                                <td> <span style="color:red">فاتوره شراء رقم </span> {{
                                    temporales.id
                                }}</td>
                                                <td v-for="tes in temporales.payments">{{ tes.paid }}</td>
                                                <td v-for="tes in temporales.payments">{{ tes.remaining }}
                                                </td>

                                                <td v-for="tes in temporales.payments">
                                                    {{ tes.remaining - tes.paid }}
                                                    <input type="hidden" v-model="xx = tes.remaining - tes.paid">
                                                </td>

                                            </tr>

                                            <template v-for="temporales in purchases.data">
                                                <tr v-for="tem in temporales.payable_notes">
                                                    <td>
                                                        {{ tem.date }}

                                                    </td>
                                                    <td>

                                                        <span style="color:red"> سند صرف رقم </span> {{
                                    tem.id
                                }}
                                                    </td>
                                                    <td>
                                                        {{ tem.paid }}

                                                    </td>
                                                    <td>
                                                        0

                                                    </td>

                                                    <td>
                                                        {{ xx - tem.paid }}
                                                        <input type="hidden" v-model="xx = xx - tem.paid">


                                                    </td>

                                                </tr>


                                            </template>

                                            <tr>
                                                <td colspan="2" style="color:red;font-size:30px;">
                                                    الاجمالي
                                                </td>
                                                <td>


                                                    <span style="color:green;font-size:30px;">0</span>

                                                </td>
                                                <td>


                                                    <span style="color:green;font-size:30px;">0</span>

                                                </td>
                                                <td>


                                                    <span style="color:green;font-size:30px;">{{ xx }}</span>

                                                </td>
                                            </tr>
                                            <!-- <tr v-for="tem in purchases.payable_notes">

                                                    <td>
                                                        {{ tem.date }}
                                                    </td>
                                                   <td v-for="te in tem.payable_notes">
                                                            {{ te.date}}
                                                        </td>
                                                        <td v-for="te in tem.payable_notes">
                                                            <span style="color:red">سند قبض رقم </span>{{ te.id}}
                                                        </td>

                                                        <td v-for="te in tem.payable_notes">
                                                            {{ te.paid}}
                                                        </td>

                                                        <td v-for="te in tem.payable_notes">
                                                          0
                                                        </td>

                                                        <td v-for="te in tem.payable_notes">
                                                            {{ te.paid - xx}}
                                                        </td> 








                                                </tr> -->






                                        </tbody>
                                        <tbody v-else>
                                            <tr>
                                                <td align="center" colspan="8">
                                                    <h3>
                                                        لايوجد اي بيانات
                                                    </h3>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <pagination align="center" :data="purchases" @pagination-change-page="onwaychange">
                                </pagination>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/div-->
        </div>
    </div>
</template>
<script>
import pagination from "laravel-vue-pagination";
import operation from '../../../operation1.js';
export default {

    components: {
        pagination,
    },
    mixins: [operation],
    data() {
        return {

            purchases: {
                type: Object,
                default: null,
            },
            date: '',
            supplier: [],
            suppliers: '',

            // purchases: '',
            xx: '',





        }
        // return data;
    },

    mounted() {
        this.list();




    },

    methods: {
        //   show_modal(id) {
        //     $("#vaciar1").val(id);
        //   },


        //   take_discount() {

        //     if (this.discount != 0) {

        //       this.sub_total = (parseInt(this.discount) * this.sub_total) / 100;
        //     }


        //   },

        list(page = 1) {


            this.axios.post(`/purchase/newpurchase?page=${page}`).then(({ data }) => {

                this.suppliers = data.suppliers;

            });


        },

        onwaychange(page = 1) {


            this.axios.post(`/supplier/supplier_account_list/${this.supplier[0]}?page=${page}`).then(({ data }) => {
                // console.log(data.purchases)




                this.purchases = data.purchases;
                // console.log(this.purchases);




            });


        },
        //   credit(e) {
        //     this.remaining = this.grand_total - this.paid;
        //     this.To_pay = this.paid;
        //   },



    },
};
</script>
