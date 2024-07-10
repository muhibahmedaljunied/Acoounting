<template>
  <!-- row opened -->

  <div class="container-fluid">

    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header">


            <h2>الخصم</h2>
          </div>


          <div class="card-body" id="printme">
            <div class="row">
              <div class="col-md-4">
                <label for="status">اسم الموظف</label>
                <select @change="select_staff" v-model="staff_selected" name="type" id="type" class="form-control "
                  required>
                  <option v-for="staff in staffs" v-bind:value="staff.id">
                    {{ staff.name }}
                  </option>
                </select>
              </div>
              <div class="col-md-2">
                <label for="status"> من تأريخ</label>
                <input v-model="from_date" type="date" name="" id="" class="form-control">
              </div>

              <div class="col-md-2">
                <label for="status">الي تأريخ</label>
                <input v-model="from_date" type="date" name="" id="" class="form-control">
              </div>

              <div class="col-sm-6 col-md-3" style="margin-top: auto;">
                <a href="#" @click="report()"><img src="/assets/img/search.png" alt="" style="width: 10%;"> </a>
              </div>
            </div>



          </div>

        </div>
      </div>
      <!--/div-->
    </div>
    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">



          <div class="card-body" id="printme">
            <div class="row">
              <div class="table-responsive">
              <table class="table table-bordered text-center">
                <thead>
                  <tr>

                    <th class="wd-15p border-bottom-0">اسم المؤظف</th>
                    <th class="wd-15p border-bottom-0">التاريخ</th>

                    <th class="wd-15p border-bottom-0"> نوع الخصم</th>
                    <th class="wd-15p border-bottom-0">قيمه الخصم</th>

                    <th class="wd-15p border-bottom-0" style="color:red"> الاجمالي</th>


                  </tr>
                </thead>
                <tbody v-if="list_data && list_data.data.length > 0">
                  <tr v-for="(discount, index) in list_data.data" :key="index">
                    <td>{{ discount.name }}</td>
                    <td>{{ discount.date }}</td>

                    <td>

                      <div v-for="(discount_names, index) in discount.discount" :key="index">
                        {{ discount_names.discount_type.name }}
                      </div>
                    </td>

                    <td>

                      <div v-for="(discount_qty, index) in discount.discount" :key="index">
                        {{ discount_qty.quantity }}
                      </div>
                    </td>

                    <td style="color:red">{{ discount.sum_discount }}</td>

                  </tr>
                  <tr>
                    <td colspan="4" style="color:red;font-size: x-large;">الاجمالي</td>

                  </tr>
                </tbody>
                <tbody v-else>
                  <tr>
                    <td align="center" colspan="3">لايوجد بياتات.</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <pagination align="center" :data="discounts" @pagination-change-page="list"></pagination>
            </div>


 


          </div>
     
        </div>
      </div>
      <!--/div-->
    </div>
  </div>

  <!-- /row -->
</template>

<script>
import pagination from "laravel-vue-pagination";
import operation from '../../../../../js/staff/StaffData/staff_data.js';

export default {
  components: {
    pagination,
  },
  mixins: [operation],
  data() {
    return {
      discount_types: "",
      staffs: '',
      staffselected: '',
      typeselected: '',
      date: '',
      quantity: '',
      staff_selected: 1,
      note: '',
      name: '',
      table: 'discount',
      list_data: {
        type: Object,
        default: null,
      },
      from_date: new Date().toISOString().substr(0, 10),
      into_date: new Date().toISOString().substr(0, 10),
      word_search: "",
    };
  },
  mounted() {
    this.list();
    this.type = 'discount';
  },
  methods: {



    get_search(word_search) {
      this.axios
        .post(`/discountsearch`, { word_search: this.word_search })
        .then(({ data }) => {
          this.discounts = data;

          // this.$root.logo = "Category";
        });
    },


    report() {
      this.axios
        .post(`/discount_report`, {
          type: this.type,
          staff: this.staff_selected,
          from_date: this.from_date,
          into_date: this.into_date,
        })
        .then(({ data }) => {
          this.list_data = data.list;

        });
    },

    list(page = 1) {
      this.axios
        .post(`/discount?page=${page}`)
        .then(({ data }) => {
          this.list_data = data.list;
          this.discount_types = data.discount_types;
          this.staffs = data.staffs;
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },
    // printDiv(printme) {
    //   var printContents = document.getElementById(printme).innerHTML;
    //   var originalContents = document.body.innerHTML;

    //   document.body.innerHTML = printContents;

    //   window.print();

    //   document.body.innerHTML = originalContents;
    // },
  },
};
</script>

