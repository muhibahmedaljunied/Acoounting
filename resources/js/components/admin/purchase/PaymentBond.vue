<template>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row row-sm">
          <div class="col-xl-12">
            <div class="card">
              <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                  <span class="h2"> سند صرف</span>
                </div>



              </div>
              <div class="card-body">

                <div class="row">


                  <div class="col-md-4">
                    <h5 class="card-title">رقم الحساب</h5>
                    <div class="custom-search">


                      <input :id="'PaymentBond_account_tree_id'" type="text" readonly class="custom-search-input">

                      <button class="custom-search-botton" type="button" data-toggle="modal"
                        data-target="#exampleModalPaymentBond">
                        <i class="fa fa-plus-circle"></i></button>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <h5 class="card-title">اسم الحساب</h5>
                    <div class="custom-search">

                      <input style="background-color: beige;" :id="'PaymentBond_account_tree'" type="text" readonly
                        class="custom-search-input">

                    </div>
                  </div>


                </div>

                <br>
                <hr>
                <div class="row">


                  <div class="col-md-4">
                    <h5 class="card-title">العمله</h5>
                    <div class="custom-search">

                      <select class="form-control" style="background-color: beige;" name="forma_pago">

                      </select>

                    </div>
                  </div>

                  <div class="col-md-3">
                    <label for="pagoPrevio">البيان</label>
                     <input v-model= "description" type="text" class="form-control"
                      style="background-color: beige;">
                    </div>



                  <div class="col-md-2">
                    <label for="pagoPrevio">التاريخ</label>
                    <input v-model= "date" type="date" class="form-control input_cantidad" onkeypress="return valida(event)" />

                  </div>
                </div>

                <br>
                <hr>


                <div class="row">

                  <div class="col-md-4">
                    <label for="pagoPrevio">المورد</label>
                    <input v-model="details[0].name" type="text" class="form-control input_cantidad"
                      onkeypress="return valida(event)" />

                  </div>


                  <div class="col-md-2">
                    <label for="pagoPrevio">المبلغ المتبقي</label>
                    <input v-model="details[0].remaining" style="background-color: beige;" type="number"
                      class="form-control input_cantidad" onkeypress="return valida(event)" />

                  </div>

                  <div class="col-md-2">
                    <label for="pagoPrevio">المبلغ المدفوع</label>
                    <input @input="credit(details[0].paid)" v-model="details[0].paid" style="background-color: beige;" type="number"
                      class="form-control input_cantidad" onkeypress="return valida(event)" />

                  </div>

                  <div class="col-md-4">

                    <button @click="payment()" class="btn btn-info">تاكيد
                      العمليه</button>


                  </div>
                </div>
                <br>
                <hr>



              </div>
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
                    <span class="h2"> سندات الصرف </span>
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
                          <th>#</th>
                          <th class="wd-15p border-bottom-0" rowspan="1">
                            اسم المنتج
                          </th>
                          <th class="wd-15p border-bottom-0" rowspan="1">الحاله</th>
                          <th class="wd-15p border-bottom-0" rowspan="1">الطراز</th>
                          <th class="wd-15p border-bottom-0" colspan="1"> محول من</th>

                          <th class="wd-15p border-bottom-0" colspan="1">محول الي</th>
                          <th class="wd-15p border-bottom-0" rowspan="1">الكميه المحوله</th>
                        </tr>
                      </thead>
                      <tbody v-if="transfer_details && transfer_details.length > 0">
                        <tr v-for="(transfer_detail, index) in transfer_details" :key="index">
                          <td>{{ index + 1 }}</td>
                          <td style="width: 40px">
                            {{ transfer_detail.product }}
                          </td>
                          <td style="width: 40px">
                            {{ transfer_detail.status }}
                          </td>
                          <td style="width: 40px">
                            {{ transfer_detail.desc }}
                          </td>
                          <td style="width: 40px">
                            {{ transfer_detail.from_store }}
                          </td>

                          <td style="width: 40px">
                            {{ transfer_detail.into_store }}
                          </td>

                          <!-- <td style="width: 40px">{{ transfer_detail.status }}</td> -->

                          <!-- <td>{{ transfer_detail.qty }}</td> -->
                          <td>
                            <div v-for="temx in transfer_detail.units">

                              <span v-if="temx.name == transfer_detail.unit">

                                <span v-if="temx.unit_type == 1">

                                  {{ transfer_detail.qty }} {{ temx.name }}

                                </span>

                                <span v-if="temx.unit_type == 0">

                                  <span v-if="transfer_detail.qty / transfer_detail.rate >= 1">
                                    {{ Math.floor((transfer_detail.qty / transfer_detail.rate)) }}{{
                                      transfer_detail.units[0].name
                                    }}
                                  </span>

                                  <span v-if="transfer_detail.qty % transfer_detail.rate >= 1
                                      &&
                                      transfer_detail.qty / transfer_detail.rate >= 1">و
                                  </span>
                                  <span v-if="transfer_detail.qty % transfer_detail.rate >= 1">
                                    <!-- و -->
                                    {{ Math.floor((transfer_detail.qty % transfer_detail.rate)) }}{{
                                      transfer_detail.units[1].name
                                    }}
                                  </span>


                                </span>

                              </span>



                            </div>
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
              </form>
              <!-- </form> -->
            </div>
          </div>
          <!--/div-->
        </div>


      </div>
    </section>

    <div class="modal fade" id="exampleModalPaymentBond" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
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
    </div>


  </div>
</template>
<script>

import tree from '../../../../js/tree/tree.js';

export default {
  mixins: [tree],
  data() {
    return {

      jsonTreeData: '',
      type_of_tree: 1,
      details: '',
      date:'',
      description:'',
      remaining:'',

    };
  },
  props: ['data'],
  mounted() {
    this.list();

    this.type = 'PaymentBond';
    this.type_of_tree = 1;
    this.showtree('account');


  },
  methods: {

    list(page = 1) {
      let uri = `/data_for_payment_bond/${this.data}`;
      this.axios.post(uri).then((response) => {

        this.details = response.data.list_data;
        this.remaining =this.details[0].remaining;

      });
    },

    credit(paid) {

      
        var remaining = this.remaining - paid;

        if (remaining<0) {

          this.details[0].remaining = 0
        }else{

          this.details[0].remaining = remaining

        }
      
    },

    payment() {

      this.axios
        .post(`/store_PaymentBond`, {
          type: 'PaymentBond',
          date: this.date,
          remaining: this.details[0].remaining,
          purchase_id: this.details[0].purchase_id,
          description: this.description,
          paid: this.details[0].paid,

          debit:{
            debit_account_id: this.details[0].account_id,
          },
          
          credit:{
            credit_account_id: $('#PaymentBond_account_tree_id').val(),
          },
          


        })
        .then((response) => {




          // this.$router.go(0);
        });

    },

  },

};
</script>

