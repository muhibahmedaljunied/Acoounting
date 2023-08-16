<template>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <span class="h2">اضافه مرتجع شراء</span>
              </div>
              <div class="text-center">
                <!-- <span
                  v-if="message_check"
                  class="alert alert-warning"
                  role="alert"
                >
                  ادخل كمبه اكبر من 0 و اقل من {{ text_message }}
                </span> -->
              </div>

              <div class="card-body">
                <div class="row">
                  <div class="col-md-4">


                    <label for="date">رقم الفاتوره</label><br />

                    <input v-model="id" style="background-color: beige;" class="form-control" />



                  </div>
                  <div class="col-md-4">




                    <label for="date">التاريخ</label><br />

                    <input style="background-color: beige;" name="date" type="date" v-model="dateselected"
                      class="form-control" />




                  </div>
                  <div class="col-md-4">

                    <label for="date">طريقه الدفع</label><br />


                    <select style="background-color: beige;" name="forma_pago" class="form-control" id="forma_pago">


                      <option v-bind:value="1">نقد</option>
                      <option v-bind:value="2">أجل</option>
                    </select>


                  </div>
                  <div class="col-md-6">


                    <label for="cliente"> المورد</label>

                    <select class="form-control" style="background-color: beige;" v-model="supplier" id="supplier">
                      <option v-for="sup in suppliers" v-bind:value="[sup.id, sup.name, sup.account_id]">
                        {{ sup.name }}
                      </option>
                    </select>


                  </div>
                  <div class="col-md-6">

                    <label for="pagoPrevio">الصندوق</label>
                    <select class="form-control" style="background-color: beige;" v-model="treasury" id="supplier">
                      <option v-for="tre in treasuries" v-bind:value="[tre.id, tre.name, tre.account_id]">
                        {{ tre.name }}
                      </option>
                    </select>


                  </div>
                  <div class="col-m-12">
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <!-- <th>الرقم</th> -->
                            <th>اسم المنتج</th>
                            <th class="wd-15p border-bottom-0">كميه الشراء</th>
                            <!-- <th class="wd-15p border-bottom-0">الوحده</th> -->

                            <!-- <th class="wd-15p border-bottom-0"> سعر الوحده</th> -->
                            <!-- <th class="wd-15p border-bottom-0">  الخصم</th> -->


                            <th>الكميه المتوفره</th>
                            <th>الحاله</th>
                            <th> المواصفات والطراز</th>
                            <th>المخزن</th>
                            <th>الكميه المسموح ارجاعها</th>
                            <th>الوحده</th>
                            <th>الكميه المرتجعه الفعليه</th>

                            <th>اضافه</th>
                          </tr>
                        </thead>
                        <tbody v-if="detail && detail.length > 0">
                          <tr v-for="(purchase_details, index) in detail" :key="index">
                            <input v-model="id = purchase_details.purchase_id" readonly type="hidden" name="name"
                              id="name" class="form-control" />

                            <td>
                              <div class="form-group">
                                <input v-model="purchase_details.product" readonly type="text" name="name" id="name"
                                  class="form-control" />
                              </div>
                            </td>
                            <!-- <td>
        <div class="form-group">
          <input v-model="purchase_details.qty" readonly type="text" name="name" id="name"
            class="form-control" />
        </div>
      </td> -->
                            <!-- <td>{{ purchase_details.qty }} {{ purchase_details.unit }}</td> -->

                            <td>
                              <!-- 
        <div v-for="temx in purchase_details.units">

          <span v-if="temx.name == purchase_details.unit">

            <span v-if="temx.unit_type == 1">

              {{ purchase_details.qty }} {{ temx.name }}

            </span>

            <span v-if="temx.unit_type == 0">

              <span v-if="purchase_details.qty / purchase_details.rate >= 1">
                {{ Math.floor((purchase_details.qty / purchase_details.rate)) }}{{
                  purchase_details.units[0].name
                }}
              </span>

              <span v-if="purchase_details.qty % purchase_details.rate >= 1">
                و
                {{ Math.floor((purchase_details.qty % purchase_details.rate)) }}{{
                  purchase_details.units[1].name
                }}
              </span>
            </span>

          </span>



        </div> -->
                              <div v-for="temx in purchase_details.units">


                                <span v-if="purchase_details.unit_id == temx.id">

                                  <span v-if="temx.unit_type == 0">

                                    <span v-if="purchase_details.qty / purchase_details.rate >= 1">
                                      {{ Math.floor((purchase_details.qty / purchase_details.rate)) }}{{
                                        purchase_details.units[0].name
                                      }}
                                    </span>

                                    <span v-if="purchase_details.qty % purchase_details.rate >= 1">
                                      {{ Math.floor((purchase_details.qty % purchase_details.rate)) }}{{
                                        purchase_details.units[1].name
                                      }}
                                    </span>
                                  </span>

                                  <span v-if="temx.unit_type == 1">
                                    {{ purchase_details.qty }} {{ temx.name }}
                                  </span>

                                </span>

                              </div>


                            </td>




                            <td>

                              <div v-for="temx in purchase_details.units">



                                <span v-if="temx.unit_type == 0">

                                  <span v-if="purchase_details.avilable_qty / purchase_details.rate >= 1">
                                    {{ Math.floor((purchase_details.avilable_qty / purchase_details.rate)) }}{{
                                      purchase_details.units[0].name
                                    }}
                                  </span>

                                  <span v-if="purchase_details.avilable_qty % purchase_details.rate >= 1">
                                    {{ Math.floor((purchase_details.avilable_qty % purchase_details.rate)) }}{{
                                      purchase_details.units[1].name
                                    }}
                                  </span>
                                </span>





                              </div>

                            </td>



                            <td>{{ purchase_details.status }}</td>
                            <td>{{ purchase_details.desc }}</td>
                            <td>{{ purchase_details.store }}</td>

                            <td>

                              <div v-for="temx in purchase_details.units">


                                <span v-if="purchase_details.unit_id == temx.id">
                                  <span v-if="temx.unit_type == 0">

                                    <span v-if="purchase_details.qty_remain / purchase_details.rate >= 1">
                                      {{ Math.floor((purchase_details.qty_remain / purchase_details.rate)) }}{{
                                        purchase_details.units[0].name
                                      }}
                                    </span>

                                    <span v-if="purchase_details.qty_remain % purchase_details.rate >= 1">
                                      {{ Math.floor((purchase_details.qty_remain % purchase_details.rate)) }}{{
                                        purchase_details.units[1].name
                                      }}
                                    </span>
                                  </span>
                                  <span v-if="temx.unit_type == 1">
                                    {{ purchase_details.qty_remain }} {{ temx.name }}
                                  </span>

                                </span>

                              </div>



                            </td>


                            <td>

                              <select style="background-color: beige;" v-model="purchase_details.unit_selected" name=""
                                id="" class="form-control">
                                <option v-for="unit in purchase_details.units"
                                  :value="[unit.id, unit.rate, unit.unit_type]">

                                  {{ unit.name }}
                                </option>

                              </select>
                            </td>
                            <td>
                              <div class="form-group">
                                <input @input="calculate_price(index)" style="background-color: beige;"
                                  v-model="purchase_details.qty_return_now" type="number" min="1" step="1"
                                  class="form-control" />

                              </div>

                            </td>



                            <td>
                              <input v-if="purchase_details.qty_return !=
                                purchase_details.quantity
                                " v-model="check_state[index]" @change="
    add_one_return(

      // purchase_details.qty_remain,
      index,
      purchase_details.qty_return_now,
      purchase_details.unit_selected


    )
    " type="checkbox" class="btn btn-info waves-effect">
                            </td>
                          </tr>
                          <tr>
                            <td colspan="10">
                              <div class="m-t-30 col-md-12">
                                <label for="date">الاجمالي</label><br />
                                <input readonly name="number" type="number" class="form-control" />


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

                          <a v-if="not_qty" @click="Add_return()" class="btn btn-success"><span>تاكيد العمليه</span></a>

                          <div>
                            <div v-if="seen" class="alert alert-warning" role="alert">
                              قم باضافه الكميه المرتجعه
                            </div>
                          </div>
                        </tbody>
                        <tbody v-else>
                          <tr>
                            <td align="center" colspan="3">
                              <h3>
                                لايوجد كمبه متوفره في المخزن او انه تم ارجاع الكميه
                                المورده كامله.
                              </h3>
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
        </div>
      </div>
    </section>
  </div>
</template>
<script>
import operation from '../../../../js/operation.js';
export default {
  mixins: [operation],
  data() {
    // return data;

    return {
      qty: [],
      unit: [],
      counts: {},
      description: '',
      count: 1,
      supplier: [],
      treasury: [],
      purchase_detail: 0,
      purchase_id: "",
      suppliers: '',
      treasuries: '',
      seen: false,
      not_qty: true,
      message_check: false,
      text_message: 0,
    };
  },
  mounted() {
    this.table = 'purchase_details';
    this.type = 'PurchaseReturn';
    this.type_refresh = 'decrement';

    let uri = `/purchase_details/${this.$route.params.id}`;
    this.axios.post(uri, { table: this.table }).then((response) => {
      console.log(response);
      this.detail = response.data.purchase_details;
      this.suppliers = response.data.suppliers;

      // this.stores = data.stores;
      // this.statuses = data.statuses;
      this.treasuries = response.data.treasuries;


    });
  },

  methods: {
    add_one_return(index, qty, unit) {


 
      var result;

      if (this.check_state[index] == true) {

        // result = this.check_qty(qty, unit, availabe_qty);

        // if (result == 0) { return 0; }

        this.counts[index] = index;
        this.qty[index] = qty;
        this.unit[index] = unit;
      } else {
        this.$delete(this.counts, index);
      }

      console.log(this.counts, index);
      console.log(this.qty, index);
      console.log(this.unit, index);


    },
    Add_return() {


      // if (this.return_qty.length != 0) {

      var url = this.type.toLowerCase();
      // alert(url);
      this.axios
        .post(`/${url}`, {

          count: this.counts,
          unit: this.unit,

          // store_account: $(`#select_account_${this.type}`).val(),
          description: this.description,
          type_refresh: this.type_refresh,
          supplier_account: this.supplier[2],
          supplier_id: this.supplier[0],
          supplier_name: this.supplier[1],
          treasury_account: this.treasury[2],
          treasury: this.treasury[0],
          type: this.type,
          // type_refresh: this.type_refresh,
          old: this.detail,
          date: this.dateselected,
          // note: this.note,
          purchase_id: this.id,




        })
        .then((response) => {
          console.log(response);

          if (response.data.message != 0) {

            // console.log(response)

            this.seen = false;
            toastMessage("تم الارجاع بنجاح");
            // this.$router.go(-1);

          } else {

            toastMessage("فشل", response.data.text);




          }


        });
      // }


    },
    calculate_price(index) {



    },
  },


};
</script>

