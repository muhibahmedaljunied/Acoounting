<template>
  <!-- row opened -->

  <div>


    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header">
            <span class="h3">التحويلات المخزنيه</span>


            <div style="display: flex;float: left; margin: 5px">
              <!-- <router-link to="create_transfer" id="agregar_productos"
              class="tn btn-info btn-sm waves-effect btn-agregar"><i class="fa fa-plus-circle"></i></router-link> -->


              <input type="search" autocomplete="on" name="search" data-toggle="dropdown" role="button"
                aria-haspopup="true" aria-expanded="true" v-model="word_search" @input="get_search()" />




            </div>
          </div>
          <div class="card-body" id="printme">
            <div class="row row-sm">
              <div class="table-responsive">
                <table class="table table-bordered text-center">
                  <thead>
                    <tr>
                      <th>الرقم التسلسلي</th>
                      <th class="wd-45p border-bottom-0" rowspan="1">
                        رقم السند
                      </th>
                      <th class="wd-15p border-bottom-0" rowspan="1">التاريخ</th>
                      <th class="wd-15p border-bottom-0" rowspan="1">العمليات</th>
                    </tr>
                  </thead>
                  <tbody v-if="transfers && transfers.length > 0">
                    <tr v-for="(transfer, index) in transfers" :key="index">
                      <td>{{ index + 1 }}</td>
                      <td>{{ transfer.id }}</td>
                      <td>
                        {{ transfer.date }}
                      </td>
                      <td>
                        <!-- <router-link :to="`/transfer_details/${transfer.id}`" class="btn btn-success">
                        <i class="fa fa-eye"></i>

                      </router-link> -->


                        <button class="btn btn-success" type="button" @click="get_details(transfer.id)"> <i
                            class="fa fa-eye"></i></button>
                      </td>
                    </tr>
                  </tbody>
                  <tbody v-else>
                    <tr>
                      <td align="center" colspan="4">
                        <h3> لايوجد بيانات </h3>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <!-- <pagination align="center" :data="categorys" @pagination-change-page="list"></pagination> -->
          </div>
        </div>
      </div>

    </div>
    <!--/div-->

    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <!-- <form method="post" @submit.prevent="submitForm"> -->
          <form method="post">
            <div class="card-header pb-0">
              <div class="d-flex justify-content-between">
                <span class="h2"> تفاصيل التحويل المخزني </span>
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
                      <th>الرقم التسلسلي</th>
                      <th class="wd-15p border-bottom-0" rowspan="1"> اسم المنتج</th>
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


                        <div v-for="temx in transfer_detail.qty_after_convert['qty']">



                          <span v-for="temx2 in temx">


                            <span style="float: right;">
                              {{ temx2[0] }}
                              <span style="color: red;">
                                {{ temx2[1] }}
                              </span>

                            </span>



                          </span>

                          <!-- <span v-if="temx.unit_type == 0">


<span>{{ Math.floor((stock.quantity)) }}</span><span style="color: red;"> {{
temx.name }}</span>



</span> -->

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

  <!-- /row -->
</template>



<script>
import pagination from "laravel-vue-pagination";
export default {
  components: {
    pagination,
  },

  data() {
    return {
      // category: "yes",
      transfer_details: 0,
      transfers: "",

      word_search: "",
    };
  },
  mounted() {
    this.get_transfer();
  },
  methods: {

    get_details(id) {

      let uri = `/details_transfer/${id}`;
      this.axios.post(uri).then((response) => {
        this.transfer_details = response.data.transfer_details;
      });

    },
    get_transfer() {
      let uri = `/listtransfer`;
      this.axios
        .post(uri, { type: 'Transfer' })
        .then((responce) => {
          this.transfers = responce.data;
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },

  },
};
</script>
