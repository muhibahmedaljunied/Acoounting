<template>
  <!-- row opened -->

  <div class="container-fluid">
    <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header">

          <span class="h2"> السلف</span>
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
              <input v-model="into_date" type="date" name="" id="" class="form-control">
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
                  <!-- <th class="wd-15p border-bottom-0">الرقم الوظيفي</th> -->
                  <th class="wd-15p border-bottom-0">اسم المؤظف</th>
                  <th class="wd-15p border-bottom-0">التاريخ</th>

                  <th class="wd-15p border-bottom-0">المبلغ</th>
                  <th class="wd-15p border-bottom-0" style="color:red">الاجمالي</th>

                  <!-- <th class="wd-15p border-bottom-0"> ملاجظه</th> -->


                  <!-- <th class="wd-15p border-bottom-0">العمليات</th> -->
                </tr>
              </thead>
              <tbody v-if="list_data && list_data.data.length > 0">
                <tr v-for="(advance, index) in list_data.data" :key="index">
                  <td>{{ advance.name }}</td>

                  <td>

                    <div v-for="(adv, index) in advance.advance" :key="index">
                      {{ adv.date }}
                      <hr>
                    </div>
                  </td>

                  <td>

                    <div v-for="(adv, index) in advance.advance" :key="index">
                      {{ adv.quantity }}
                      <hr>
                    </div>
                  </td>


                  <td style="color:red">

                    {{ advance.sum_advanve }}
                  </td>

                  <!-- 
                  <td>
                    <button type="button" @click="delete_advance(advance.id)" class="btn btn-danger">
                      <i class="fa fa-trash"></i>
                    </button>

                    <router-link :to="{
                      name: 'edit_advance',
                      params: { id: advance.id },
                    }" class="edit btn btn-success">
                      <i class="fa fa-edit"></i></router-link>
                    <router-link :to="{
                      name: 'edit_advance',
                      params: { id: advance.id },
                    }" class="edit btn btn-success">
                      <i class="fa fa-eye"></i></router-link>
                  </td> -->
                </tr>
                <tr>
                  <td colspan="3" style="color:red;font-size: x-large;">الاجمالي</td>

                </tr>
              </tbody>
              <tbody v-else>
                <tr>
                  <td align="center" colspan="3">لايوجد بياتات.</td>
                </tr>
              </tbody>
            </table>
          </div>
          <pagination align="center" :data="advances" @pagination-change-page="list"></pagination>
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
      // category: "yes",

      list_data: {
        type: Object,
        default: null,
      },
      staff_selected: 1,
      count: 1,
      counts: [],
      quantity: [],
      date: [],
      staffselected: [],
      quantityselected: '',

      table: 'advance',

      staffs: '',
      note: '',

      word_search: "",



      from_date: new Date().toISOString().substr(0, 10),
      into_date: new Date().toISOString().substr(0, 10),
    };
  },
  mounted() {
    this.list();
    this.counts[0] = 1;
    this.type = 'advance';
  },
  methods: {


    // get_search(word_search) {
    //   this.axios
    //     .post(`/advancesearch`, { word_search: this.word_search })
    //     .then(({ data }) => {
    //       this.branches = data;

    //       // this.$root.logo = "Category";
    //     });
    // },

    report() {
      this.axios
        .post(`/advance_report`, { 
          type:this.type,
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
        .post(`/advance?page=${page}`)
        .then(({ data }) => {
          this.list_data = data.list;
          this.staffs = data.staffs;
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },





  },
};
</script>

