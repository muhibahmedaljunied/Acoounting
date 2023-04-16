<template>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-9">
                    <div class="panel panel-default sombra_caja_producto">
                        <div class="panel-body">
                            <div class="clearfix">
                                <div class="pull-left">
                                    <h3></h3>
                                    <span></span>
                                </div>
                                <div class="pull-right">
                                    <h1>كشف حساب مورد <span id="codigo"></span></h1>
                                </div>
                            </div>
                            <hr />
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
                            <!-- end row -->

                            <!-- <div class="m-t-20"></div> -->

                            <div class="row" style="font-size: 10pt">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered text-right m-t-30"
                                            style="width: 100%; font-size: x-small" id="lista_productos_temporal">
                                            <thead>
                                                <tr>


                                                    <th>التاريخ</th>
                                                    <th>البيات</th>
                                                    <th>داين</th>
                                                    <th>مدين</th>
                                                    <th>الرصيد</th>




                                                    <!-- <th>الاجمالي<small> مع الضريبه </small></th> -->
                                                    <!-- <th style="width: 60px">العمليات</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>


                                                <tr v-for="temporales in purchases">

                                                    <td>{{ temporales.date }}</td>
                                                    <td> <span style="color:red">فاتوره شراء رقم </span> {{
                                                        temporales.id
                                                    }}</td>
                                                    <td v-for="tes in temporales.payment_purchases">{{ tes.paid }}</td>
                                                    <td v-for="tes in temporales.payment_purchases">{{ tes.remaining }}
                                                    </td>

                                                    <td v-for="tes in temporales.payment_purchases">
                                                        {{ tes.remaining - tes.paid }}
                                                        <input type="hidden" v-model="xx = tes.remaining - tes.paid">
                                                    </td>

                                                </tr>

                                                <template v-for="temporales in purchases">
                                                    <tr v-for="tem in temporales.payable_notes">
                                                        <td >
                                                        {{ tem.date}}
                                                     
                                                    </td>
                                                    <td >
                                                       سند قبض
                                                     
                                                    </td>
                                                    <td >
                                                        {{ tem.paid}}
                                                     
                                                    </td>
                                                    <td >
                                                      0
                                                     
                                                    </td>

                                                    <td >
                                                        {{ xx - tem.paid }}
                                                        <input type="hidden" v-model="xx = xx - tem.paid">

                                                     
                                                    </td>

                                                    </tr>

                                                    
                                                </template>
                                                
                                                <tr>
                                                    <td colspan="4" style="color:red;font-size:30px;"> 
                                                        الاجمالي
                                                    </td>
                                                    <td > 
                                                        

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
                                        </table>
                                    </div>
                                </div>
                            </div>
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
export default {

    components: {
        pagination,
    },
    mixins: [operation],
    data() {
        return {

            date: '',
            supplier: [],
            suppliers: '',

            purchases: '',
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

        //   get_search() {
        //     this.axios
        //       .post(`/purchase/newpurchasesearch`, { word_search: this.word_search })
        //       .then(({ data }) => {
        //         this.temporales = data.temporales;

        //         this.temporale.forEach((item) => {
        //           this.total_quantity = item.tem_qty + this.total_quantity;
        //         });

        //         this.products = data.products;
        //         this.suppliers = data.suppliers;

        //         // this.stores = data;
        //       });
        //   },
        list(page = 1) {


            this.axios.post(`/purchase/newpurchase?page=${page}`).then(({ data }) => {

                this.suppliers = data.suppliers;

            });


        },

        onwaychange() {


            this.axios.post(`/supplier/supplier_account_list/${this.supplier[0]}`).then(({ data }) => {
                // console.log(data.purchases.data)



                
                this.purchases = Object.values(data.purchases.data);
                console.log(this.purchases);
              



            });


        },
        //   credit(e) {
        //     this.remaining = this.grand_total - this.paid;
        //     this.To_pay = this.paid;
        //   },



    },
};
</script>


