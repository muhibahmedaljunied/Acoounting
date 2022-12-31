<template>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <span class="h2"> تعديل سند التوريد</span>
              </div>
              <div class="text-center">
                <span v-if="message_check" class="alert alert-warning" role="alert">
                  ادخل كمبه اكبر من 0 و اقل من {{ text_message }}
                </span>
              </div>

              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered text-right" style="width: 100%; font-size: x-large">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>اسم المنتج</th>
                        <th>الحاله</th>
                        <th>المواصفات والطراز</th>
                        <th class="wd-15p border-bottom-0"> الكميه الوارده</th>
                        <th>المخزن</th>
                        <!-- <th>الرف</th> -->


                        <th>اضافه</th>
                      </tr>
                    </thead>
                    <tbody v-if="supply_detail && supply_detail.length > 0">
                      <tr v-for="(supply_details, index) in supply_detail" :key="index">
                        <input v-model="supply_id = supply_details.supply_id" readonly type="hidden" name="name"
                          id="name" class="form-control" />
                        <td>{{ index + 1 }}</td>

                        <td>
                          <div class="form-group">
                            <input v-model="supply_details.product" readonly type="text" name="name" id="name"
                              class="form-control" />
                          </div>
                        </td>
                        <td>{{ supply_details.status }}</td>
                        <td>{{ supply_details.desc }}</td>
                        <td>
                          <div class="form-group">
                            <input v-model="supply_details.quantity" readonly type="text" name="name" id="name"
                              class="form-control" />
                          </div>
                        </td>
                      
                        <td>

                          <div class="form-group">
                            <input v-model="supply_details.store" readonly type="text" name="name" id="name"
                              class="form-control" />
                          </div>
                        </td>
                      


                 
                        <td>
                          <input v-if="supply_details.qty_remain != 0"
                            @change="add_return(supply_details.qty_remain, index, supply_details.product_id, supply_details.store_id, supply_details.shelve_id, supply_details.status_id, supply_details.desc)"
                            type="checkbox" v-model="check_state[index]" class="btn btn-info waves-effect">
                            
                        </td>

                      </tr>
                        <tr>
                        <td colspan="10">
                          <div class="m-t-30 col-md-12">
                            <label for="date">اسم المورد</label><br />
                            <input v-model="note" type="text" name="name" id="name" class="form-control" />
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="10">
                          <div class="m-t-30 col-md-12">
                            <label for="date">التاريخ</label><br />

                            <input name="date" type="date" v-model="dateselected" class="form-control" />
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="10">
                          <div class="m-t-30 col-md-12">
                            <label for="date">ملاحظات</label><br />
                            <input v-model="note" type="text" name="name" id="name" class="form-control" />
                          </div>
                        </td>
                      </tr>

                      <a v-if="not_qty" @click="refund()" class="btn btn-success"><span>تاكيد العمليه</span></a>

<!-- 
                      <div>


                        <div v-if="seen" class="alert alert-warning" role="alert">
                          قم باضافه الكميه المرتجعه
                        </div>

                      </div> -->
                    </tbody>
                    <tbody v-else>
                      <tr>
                        <td align="center" colspan="10">
                          <h3>لايوجد كمبه متوفره في المخزن او انه تم ارجاع الكميه المورده كامله.</h3>
                        </td>
                      </tr>
                    </tbody>

                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
export default {
  data() {
    return {
      supply_detail: "",
      supply_id: "",
      dateselected: new Date().toISOString().substr(0, 10),
      note: "",
      Total_quantity: 0,
      return_qty: [],
      check_state: [],
      seen: false,
      not_qty: true,
      message_check: false,
      text_message: 0,

    };
  },
  mounted() {
    let uri = `/supply_details/${this.$route.params.id}`;
    this.axios.post(uri).then((response) => {
      this.supply_detail = response.data.supply_details;

      this.$root.logo = "SupplyDetails";
    });
  },
  methods: {



    refund() {

      // console.log(this.return_qty.length);

      if (this.return_qty.length != 0) {

        //  console.log(this.Total_quantity)
        this.axios
          .post("/supplyreturn", {
            return_supply: this.supply_detail,
            date: this.dateselected,
            note: this.note,
            supply_id: this.supply_id,
            return_qty: this.return_qty,

            total: this.Total_quantity,
          })
          .then((response) => {
            console.log(response.data);

            if (response.data.message != 0) {

              // console.log(response)

              this.seen = false;
              toastMessage("تم الارجاع بنجاح");
              this.$router.go(-1);

            } else {

              toastMessage("فشل", response.data.text);




            }


          });
      } else {

        this.seen = true;
      }

    },
    add_return(qty_return, index, product_id, store_id, shelve_id, status_id, desc) {


      // alert('ds');
      if (this.check_state[index] == true) {



        this.Total_quantity = parseInt(this.Total_quantity) + parseInt(qty_return);


        this.return_qty[index] = {
          product_id: product_id,
          store_id: store_id,
          shelve_id: shelve_id,
          status_id: status_id,
          desc: desc,
          qty: qty_return
        };

        console.log(this.return_qty);
      } else if (this.check_state[index] == false) {

        this.$delete(this.return_qty, product_id);

        console.log(this.return_qty);
      }



    },
  },
  computed: {},
};
</script>

