<template>
  <!-- row opened -->
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <!-- <form method="post" @submit.prevent="submitForm"> -->
        <form method="post" @submit.prevent="addTransfer">
          <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
              <span class="h3"> تفاصيل التحويل المخزني </span>
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
  <!-- /row -->
</template>

<script>
export default {
  data() {
    return {
      transfer_details: 0,
    };
  },
  mounted() {
    let uri = `/details_transfer/${this.$route.params.id}`;
    this.axios.post(uri).then((response) => {
      this.transfer_details = response.data.transfer_details;
    });
  },

};
</script>

