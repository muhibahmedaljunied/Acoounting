<template>
  <!-- row opened -->
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <form method="post" @submit.prevent="submitForm">
          <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
              <span class="h2">ميزان المراجعه</span>
            </div>
          </div>
          <div class="card-body" id="printme">
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <div class="row">

                    <div class="col-xl-3">
                      <label for="">الحساب </label>

                      <div class="custom-search">

                        <input id="AccountReport_account_tree" type="text" class="custom-search-input">

                        <button class="custom-search-botton" type="button" data-toggle="modal"
                          data-target="#exampleModalAccountReport"> <i class="fa fa-plus-circle"></i></button>



                      </div>

                      <input type="hidden" name="status" id="AccountReport_account_tree_id" class="form-control" />


                    </div>


                    <div class="col-md-3">
                      <label for="desde">من تاريخ </label>
                      <input type="date" class="form-control hasDatepicker" id="modal_reporte_venta_inicio"
                        name="modal_reporte_venta_inicio" v-model="daily_date" onkeypress="return controltag(event)"
                        style="background-color: white" />
                    </div>

                    <div class="col-md-3">
                      <label for="desde">الي تاريخ </label>
                      <input type="date" class="form-control hasDatepicker" id="modal_reporte_venta_inicio"
                        name="modal_reporte_venta_inicio" v-model="daily_date" onkeypress="return controltag(event)"
                        style="background-color: white" />
                    </div>
                    <div class="col-sm-2 col-md-3" style="margin-top: auto;">
                      <a @click="onwaychange()" href="#"><img src="/assets/img/search.png" alt="" style="width: 10%;">
                      </a>
                    </div>

                  </div>
                </div>
              </div>
            </div>

      

            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
              aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>

      <div class="card">
        <form method="post" @submit.prevent="submitForm">
     
          <div class="card-body" id="printme">
        

            <div class="table-responsive">
              <table class="table table-bordered text-center">
                <thead>
                  <tr>
                    <th class="wd-15p border-bottom-0" rowspan="2">
                      رقم الحساب
                    </th>
                    <th class="wd-15p border-bottom-0" rowspan="2">
                      اسم الحساب
                    </th>
                    <th class="wd-15p border-bottom-0" colspan="2">
                      بالمجاميع
                    </th>
                    <!-- <th class="wd-15p border-bottom-0" colspan="2">بالارصده</th> -->
                  </tr>
                  <tr>
                    <th class="wd-15p border-bottom-0">مدين</th>

                    <th class="wd-15p border-bottom-0">داين</th>
                    <!-- <th class="wd-15p border-bottom-0">الرصيد</th> -->


                    <!-- <th class="wd-15p border-bottom-0">مدين</th>

                    <th class="wd-15p border-bottom-0">داين</th> -->
                  </tr>
                </thead>
                <tbody v-if="auditBalances && auditBalances.length > 0">
                  <tr v-for="(auditBalance, index) in auditBalances" :key="index">

                    <template v-if="auditBalance.balance != null">
                      <td>{{ auditBalance.id }}</td>

                      <td>{{ auditBalance.text }}</td>
                      <td>{{ auditBalance.debit }}</td>
                      <td>{{ auditBalance.credit }}</td>

                      <!-- <td v-if="auditBalance.balance < 0">

                        <span style="color:red">
                          {{ auditBalance.balance }}
                        </span>

                      </td>
                      <td v-else>

                        <span style="color:blue">
                          {{ auditBalance.balance }}
                        </span>

                      </td> -->



                      <!-- <td v-if="auditBalance.debit > auditBalance.credit">
                        {{ auditBalance.debit - auditBalance.credit }}
                      </td>
                      <td v-else>
                        0
                      </td>
                      <td v-if="auditBalance.credit > auditBalance.debit">
                        {{ auditBalance.credit - auditBalance.debit }}
                      </td>
                      <td v-else>0</td> -->
                    </template>

                  </tr>

                  <tr>
                    <td colspan="2">الاجمالي</td>
                    <td> <span style="color:green">{{ sum_debit }}</span></td>
                    <td> <span style="color:green">{{ sum_credit }}</span></td>
                    <!-- <td></td> -->


                  </tr>
                </tbody>
                <tbody v-else>
                  <tr>
                    <td align="center" colspan="5">لايوجد بياتات.</td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
              aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
    <!--/div-->
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
      n: "",
      trees: "",
      auditBalances: "",
      data: {
        description: "",
        debit: "",
        credit: "",
        balance: "",
        daily_date: "",
      },
      sum_debit: '',
      sum_credit: '',
    };
  },
  mounted() {
    this.axios.post("/auditBalance").then((response) => {
      console.log(response.data);
      this.auditBalances = response.data.auditBalances;
      this.sum_debit = response.data.sum_debit;
      this.sum_credit = response.data.sum_credit
    });
  },
  created() {
    this.axios.post("/tree_account").then((response) => {
      this.trees = response.data.accounts;
    });
  },
  methods: {
    // account_list(id) {
    //   // alert(id);
    //   let uri = `/account_list/${id}`;
    //   this.axios.get(uri).then((response) => {
    //     console.log(response.data.daily_details);
    //     // this.repoaccounts = response.data.daily_details;
    //   });
    // },
    add_row() { },
  },
};
</script>

