<template>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">

        <div class="row row-sm">
          <div class="col-xl-12">
            <div class="card">
              <!-- <form method="post" @submit.prevent="submitForm"> -->
              <form method="post">
                <div class="card-header pb-0">
                  <div class="d-flex justify-content-between">
                    <span class="h2"> سندات القبض </span>
                  </div>
                </div>
                <div class="card-body" id="printme">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <div class="row">
                          <div class="col-md-2">
                            <label for="pagoPrevio">رقم الفاتوره</label>


                            <input class="form-control" style="background-color: beige;" type="text" v-model="sale_id">


                          </div>

                          <div class="col-md-4">
                            <label for="pagoPrevio">العميل</label>
                            <select class="form-control" style="background-color: beige;" v-model="customer"
                              id="supplier">
                              <option v-for="cus in customers" v-bind:value="[cus.id, cus.name]">
                                {{ cus.name }}
                              </option>
                            </select>


                          </div>

                          <!-- <div class="col-md-2">
                            <label for="pagoPrevio">حاله الفاتوره</label>


                            <select style="background-color: beige;" name="forma_pago" class="form-control"
                              id="forma_pago" v-model="Way_to_pay_selected" v-on:change="onwaychange">
                              text

                              <option v-bind:value="1">نقد</option>
                              <option v-bind:value="2">أجل</option>
                              <option v-bind:value="3">بنك</option>
                            </select>


                          </div> -->
                          <div class="col-sm-2 col-md-3" style="margin-top: auto;">
                            <a @click="search()" href="#"><img src="/assets/img/search.png" alt="" style="width: 10%;">
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
              </form>

            </div>
          </div>

        </div>

        <div class="row row-sm">
          <div class="col-xl-12">
            <div class="card">
              <!-- <form method="post" @submit.prevent="submitForm"> -->
              <form method="post">
                <div class="card-header pb-0">
                  <div class="d-flex justify-content-between">
                    <span class="h2"> سندات القبض </span>
                  </div>
                </div>
                <div class="card-body" id="printme">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="form-group">
                        <div class="row"></div>
                      </div>
                    </div>
                  </div>

                  <div class="table-responsive">
                    <table class="table table-bordered text-center">
                      <thead>
                        <tr>
                          <!-- <th class="wd-15p border-bottom-0" rowspan="1">#</th> -->
                          <th class="wd-15p border-bottom-0" rowspan="1">
                            رقم السند
                          </th>
                          <th class="wd-15p border-bottom-0" rowspan="1">العميل</th>

                          <th class="wd-15p border-bottom-0" rowspan="1">مبلغ القبض</th>
                          <th class="wd-15p border-bottom-0" colspan="1"> ظريقه الدفع </th>
                          <th class="wd-15p border-bottom-0" colspan="1"> العمليات </th>

                        </tr>
                      </thead>


                      <tbody v-if="receivable_bond && receivable_bond.data.length > 0">
                          <tr v-for="(receivable_bonds, index) in receivable_bond.data" :key="index">
                          <!-- <td>{{ receivable_bonds.id }}</td> -->
                          <td>{{ receivable_bonds.paymentable.receivable_id }}</td>
                          <td>{{ receivable_bonds.paymentable.customer_name }}</td>
                          <td>{{ receivable_bonds.paid }}</td>
                          <td>{{ receivable_bonds.payment_info }}</td>


                          <td>

                            <div class="optionbox">
                              <select @change="changeRoute(index)" v-model="operationselected[index]" name="العمليات"
                                class="form-control">

                                <!--                           
                                <option class="btn btn-success"
                                  v-bind:value="['/sale_invoice/', receivable_bonds.paymentable.sale_id, 1]">
                                  عرض الفاتوره
                                </option> -->

                                >

                                <option class="btn btn-success"
                                  v-bind:value="['receivable_bond_daily', receivable_bonds.paymentable.receivable_id, 2]">
                                  عرض القيد المحاسبي
                                </option>

                              </select>
                            </div>


                            <!-- <router-link
:to="`/sale_details/${sale.paymentable.sale_id}`"
class="btn btn-success"
>
<span><i class="fa fa-search-plus"></i></span>
</router-link>

<router-link
:to="`/return_sale/${sale.paymentable.sale_id}`"
class="btn btn-success"
>
<span> ارجاع</span>
</router-link>
<router-link
:to="`/sale_invoice/${sale.paymentable.sale_id}`"
  class="btn btn-success">

<span>فاتوره</span>
</router-link> -->


                          </td>
                          <!-- <td>{{ receivable_bonds.total }}</td> -->
                          <!-- <td>{{ receivable_bonds.qty_return }}</td> -->



                        </tr>
                        <!-- <tr>

                    <td colspan="7" style="text-align:center;color:red;font-size:large">الاجمالي</td>
                    <td>{{ total }}</td>
                  </tr> -->

                      </tbody>
                      <tbody v-else>
                        <tr>
                          <td align="center" colspan="8">
                            <h3>
                              لايوجد  بيانات
                            </h3>
                          </td>
                        </tr>
                      </tbody>

                    </table>
                  </div>
                </div>
              </form>

            </div>
          </div>

        </div>

      </div>
    </section>



  </div>
</template>
<script>

import tree from '../../../tree/tree.js';
export default {
  mixins: [tree],
  data() {
    return {
      jsonTreeData: '',
      type_of_tree: 1,
      details: '',
      remaining: '',
      date: '',
      description: '',
      receivable_bond: '',
      customer: '',
      customers: '',
      operationselected: [],
    };
  },
  mounted() {

    this.list();

    this.type = 'ReceivableBond';
    // this.type_of_tree = 1;
    // this.showtree('account', 'tree_account');

    // console.log(this.$route.params);

  },

  methods: {

    list(page = 1) {
      // let uri = `/receivable_bond_list/${this.$route.params.id}`;
      let uri = `/receivable_bond_list`;

      this.axios.post(uri).then((response) => {


        this.details = response.data.list_data;
        this.remaining = this.details[0].remaining;




      });
    },


    search() {

      this.axios
        .post(`/get_receivable_bond`, {

          // type: 'ReceivableBond',
          id: this.sale_id,






        })
        .then(({ data }) => {


          this.receivable_bond = data.list_data;

          // this.$router.go(0);
        });

    },


    changeRoute(index) {


      // if (this.operationselected[index][2] == 0) {

      //   this.axios
      //     .post(this.operationselected[index][0] + this.operationselected[index][1], { table: this.table })
      //     .then((response) => {

      //       console.log(response.data);
      //       this.receivable_bond_detail = response.data.details;
      //       this.sale_detail.forEach((item) => {
      //         this.total = parseInt(item.total) + parseInt(this.total);
      //       });

      //     })
      //     .catch(({ response }) => {
      //       console.error(response);
      //     });

      // } else {

      // this.$router.push(this.operationselected[index][0] + this.operationselected[index][1]);
      this.$router.push({
        name: this.operationselected[index][0],
        params: {
          data: this.operationselected[index][1]
        }
      }
      );
      // });


    }

  },


 




};
</script>

<style scoped>
.optionbox select {
  background: #E62968;
  color: #fff;
  padding: 10px;
  width: 120px;
  height: 30px;
  border: none;
  font-size: 20px;
  box-shadow: 0 5px 18px rgb(93, 15, 9);
  -webkit-appearance: button;
  outline: none;
}
</style>
