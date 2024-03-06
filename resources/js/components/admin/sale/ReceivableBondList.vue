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
                      <tbody v-if="details && details.length > 0">
                        <tr v-for="(detail, index) in details" :key="index">
                          <td>{{ index + 1 }}</td>
                          <td style="width: 40px">
                            {{ detail.product }}
                          </td>
                          <td style="width: 40px">
                            {{ detail.status }}
                          </td>
                          <td style="width: 40px">
                            {{ detail.desc }}
                          </td>
                          <td style="width: 40px">
                            {{ detail.from_store }}
                          </td>

                          <td style="width: 40px">
                            {{ detail.into_store }}
                          </td>

                          <!-- <td style="width: 40px">{{ detail.status }}</td> -->

                          <!-- <td>{{ detail.qty }}</td> -->
                          <td>
                            <div v-for="temx in detail.units">

                              <span v-if="temx.name == detail.unit">

                                <span v-if="temx.unit_type == 1">

                                  {{ detail.qty }} {{ temx.name }}

                                </span>

                                <span v-if="temx.unit_type == 0">

                                  <span v-if="detail.qty / detail.rate >= 1">
                                    {{ Math.floor((detail.qty / detail.rate)) }}{{
                                      detail.units[0].name
                                    }}
                                  </span>

                                  <span v-if="detail.qty % detail.rate >= 1
                                      &&
                                      detail.qty / detail.rate >= 1">و
                                  </span>
                                  <span v-if="detail.qty % detail.rate >= 1">
                                    <!-- و -->
                                    {{ Math.floor((detail.qty % detail.rate)) }}{{
                                      detail.units[1].name
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

    <div class="modal fade" id="exampleModalReceivableBond" tabindex="-1" role="dialog"
      aria-labelledby="exampleModalLabel" aria-hidden="true">
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
      jsonTreeData: '',
      type_of_tree: 1,
      details: '',
      remaining: '',
      date:'',
      description:'',
    };
  },
  mounted() {

    this.list();

    this.type = 'ReceivableBond';
    this.type_of_tree = 1;
    this.showtree('account','tree_account');

    // console.log(this.$route.params);

  },

  methods: {

    list(page = 1) {
      let uri = `/receivable_bond_list/${this.$route.params.id}`;
      this.axios.post(uri).then((response) => {


        this.details = response.data.list_data;
        this.remaining = this.details[0].remaining;

     


      });
    },


    // credit(paid) {


    //   var remaining = this.remaining - paid;

    //   if (remaining < 0) {

    //     this.details[0].remaining = 0
    //   } else {

    //     this.details[0].remaining = remaining

    //   }

    // },

    // payment() {

    //   this.axios
    //     .post(`/store_ReceivableBond`, {
    //       type: 'ReceivableBond',

    //       sale_id: this.details[0].sale_id,
    //       remaining: this.details[0].remaining,
    //       date: this.date,
    //       description: this.description,
    //       sale_id: this.details[0].sale_id,
    //       paid: this.details[0].paid,
    //       credit: {
    //         credit_account_id: this.details[0].account_id,
    //       },
    //       debit: {
    //         debit_account_id: $('#ReceivableBond_account_tree_id').val(),

    //       },



    //     })
    //     .then((response) => {




    //       // this.$router.go(0);
    //     });

    // },


  },

};
</script>

