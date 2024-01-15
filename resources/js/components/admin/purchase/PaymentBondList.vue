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
                           رقم السند
                          </th>
                          <th class="wd-15p border-bottom-0" rowspan="1">
                           رقم فاتوره الشراء
                          </th>
                          <th class="wd-15p border-bottom-0" rowspan="1">المورد</th>

                          <th class="wd-15p border-bottom-0" rowspan="1">التأريخ</th>
                          <th class="wd-15p border-bottom-0" rowspan="1">المبلغ</th>
                          <!-- <th class="wd-15p border-bottom-0" rowspan="1">العمليات</th> -->

                        </tr>
                      </thead>
                      <tbody v-if="Bonds && Bonds.length > 0">
                        <tr v-for="(Bond, index) in Bonds" :key="index">
                          <td>{{ index + 1 }}</td>
                          <td style="width: 40px">
                            {{ Bond.id }}
                          </td>
                          <td style="width: 40px">
                            {{ Bond.purchase_id }}
                          </td>
                          <td style="width: 40px">
                            {{ Bond.supplier_name }}
                          </td>
                          <td style="width: 40px">
                            {{ Bond.date }}
                          </td>
                          <td style="width: 40px">
                            {{ Bond.total }}
                          </td>

                          <!-- <td>
                            <button class="btn btn-success" type="button" @click="get_details_bond(Bond.id)">    <i class="fa fa-eye"></i></button>

                          </td> -->

                         
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

import tree from '../../../tree/tree.js';

export default {
  mixins: [tree],
  data() {
    return {

      Bonds:'',

    };
  },
  mounted() {
    this.list();



  },
  methods: {

    list(page = 1) {
      let uri = `/payment_bond_list`;
      this.axios.post(uri).then((response) => {

        console.log(response.data.payable.data);
        this.Bonds = response.data.payable.data;

      });
    },

   

    

  },

};
</script>

