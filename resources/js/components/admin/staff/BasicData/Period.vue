<template>
  <!-- row opened -->
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header">

          <span class="h2"> فترات الدوام </span>
          <div style="display: flex;float: left; margin: 5px">
            <a class="tn btn-info btn-sm waves-effect btn-agregar" data-toggle="modal" id="agregar_productos"
              data-target="#addperiods">
              <i class="fa fa-plus-circle"></i></a>

            <!-- <input autocomplete="on" v-model="word_search" type="text" class="form-control input-text"
              placeholder="بحث ...." aria-label="Recipient's username" aria-describedby="basic-addon2"
              @input="get_search()"> -->

            <div>

            </div>
          </div>
        </div>

        <div class="card-body" id="printme">
          <div class="table-responsive">
            <table class="table table-bordered text-center">
              <thead>
                <tr>
                  <th class="wd-15p border-bottom-0">#</th>
                  <th class="wd-15p border-bottom-0">الفتره</th>
                  <!-- <th class="wd-15p border-bottom-0">من</th>
                  <th class="wd-15p border-bottom-0">الي</th>
                  <th class="wd-15p border-bottom-0"> عدد الساعات </th> -->


                  <th class="wd-15p border-bottom-0">العمليات</th>
                </tr>
              </thead>
              <tbody v-if="periods && periods.length > 0">
                <tr v-for="(period, index) in periods" :key="index">

                  <td>{{ index + 1 }}</td>
                  <td>{{ period.name }}</td>
                  <!-- <td>{{ period.from_time }}</td>
                  <td>{{ period.into_time }}</td>
                  <td>{{ period.duration }}</td> -->

                  <td>
                    <!-- <a data-toggle="modal" data-target="#modal_vaciar" class="tn btn-danger btn-lg waves-effect btn-agregar"><i class="fa fa-trash"></i></a> -->
                    <button type="button" @click="delete_period(period.id)" class="btn btn-sm waves-effect btn-danger">
                      <i class="fa fa-trash"></i>
                    </button>

                    <router-link :to="{
                      name: 'edit_branch',
                      params: { id: period.id },
                    }" class="edit btn btn-sm waves-effect btn-success">
                      <i class="fa fa-edit"></i></router-link>
                  </td>
                </tr>
              </tbody>
              <tbody v-else>
                <tr>
                  <td align="center" colspan="3">لايوجد بياتات.</td>
                </tr>
              </tbody>
            </table>
          </div>
          <pagination align="center" :data="periods" @pagination-change-page="list"></pagination>
        </div>


        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
          aria-hidden="true" style="display: none" id="addperiods">
          <div class="modal-dialog modal-lg" style="width: 100%">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                  x
                </button>
                <div class="col-md-8">
                  <h4 class="modal-title" id="myLargeModalLabel">فترات الدوام</h4>
                </div>
                <!-- <div class="col-md-4">
                  <div class="col-sm-12">
                    <input type="text" placeholder="بحث" class="form-control" name="buscar_producto"
                      id="buscar_producto" v-model="word_search" @input="get_search()" />
                  </div>
                </div> -->
              </div>
              <div class="modal-body">
                <div class="row row-sm">
                  <div class="col-xl-12">
                    <div class="card">
                    
                      <div class="card-body">
                        <form method="post"  enctype="multipart/form-data">

                          <div class="table-responsive">
                            <table class="table table-bordered text-right m-t-30" style="width: 100%; font-size: x-small">
                              <thead>
                                <tr>
                                  <th> الفتره </th>
                                  <!-- <th> من</th>


                                  <th> الي </th>

                                  <th> عدد الساعات </th> -->


                                  <th>اضافه</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-for="index in count" :key="index">
                                  <td>
                                    <div class="col-md-12">
                           

                                         <input type="text" v-model="work_type_selected[index]" class="form-control" name="name"
                                      required />

                                    </div>

                                  </td>
                                  <!-- <td>
                                    <input type="time" v-model="from_period[index]" class="form-control" name="name"
                                      required />

                                  </td>

                                  <td>
                                    <input type="time" v-model="into_period[index]" class="form-control" name="name"
                                      required />

                                  </td>
                                  <td>
                                    <input type="text" @keypress="calc_duration(index)" class="form-control"
                                     v-bind:id='"duration_period" + indexs'  name="name" required />

                                    <input type="hidden" v-model="duration_period[index]">

                                  </td> -->


                                  <td v-if="index == 1">
                                    <a class="tn btn-info btn-sm waves-effect btn-agregar"
                                      v-on:click="addComponent(count)">
                                      <i class="fa fa-plus-circle"></i></a>

                                    <a class="tn btn-info btn-sm waves-effect btn-agregar"
                                      v-on:click="disComponent(count)">
                                      <i class="fa fa-minus-circle"></i></a>
                                  </td>



                                </tr>

                              </tbody>
                            </table>
                          </div>
                        </form>

                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="Add_new()">حفظ </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                      </div>
                    </div>
                  </div>
                  <!--/div-->
                </div>
              </div>


            </div>
            <!-- /.modal-content -->
          </div>

          <!-- /.modal-dialog -->
        </div>
      </div>
    </div>
    <!--/div-->
  </div>
  <!-- /row -->
</template>

<script>

import pagination from "laravel-vue-pagination";
import operation from '../../../../../js/staff/BasicData/operation.js';

export default {
  components: {
    pagination,
  },
  mixins: [operation],
  data() {
    return {


      periods: {
        type: Object,
        default: null,
      },
      // period_name: [],
      // from_period: [],
      // into_period: [],
      // duration_period: [],
      work_type_selected:[],
      work_types:'',

    };
  },
  mounted() {
    this.list();
    this.counts[0] = 1;

    this.type = 'period';
  },
  methods: {

    Add_new() {

      this.axios
        .post(`/store_period`, {
          count: this.counts,
          type: this.work_type_selected,
          // period_name: this.period_name,
          // from_period: this.from_period,
          // into_period: this.into_period,
          // duration_period: this.duration_period,

        }
        )
        .then((response) => {
          console.log(response);
          toastMessage("تم الاضافه بنجاح");
          // this.$router.go(0);
        });


    },
    // calc_duration(index) {

    //   var date_current = new Date().toISOString().substr(0, 10);
    //   var split_start = this.from_period[index].split(":");
    //   var split_end = this.into_period[index].split(":");
    //   var date = date_current.split("-");


 


    //   var date1 = new Date(date[0], date[1], date[2], split_start[0], split_start[1]); // 9:00 AM
    //   var date2 = new Date(date[0], date[1], date[2], split_end[0], split_end[1]); // 5:00 PM
    //   if (date2 < date1) {
    //     date2.setDate(date2.getDate() + 1);
    //   }
    //   var diff = date2 - date1;
    //   // 28800

    //   // ---------------------
    //   var msec = diff;
    //   var hh = Math.floor(msec / 1000 / 60 / 60);
    //   msec -= hh * 1000 * 60 * 60;
    //   var mm = Math.floor(msec / 1000 / 60);
    //   msec -= mm * 1000 * 60;
    //   var ss = Math.floor(msec / 1000);
    //   msec -= ss * 1000;
    //   // diff = 28800000 => hh = 8, mm = 0, ss = 0, msec = 0

    //   console.log(hh, mm);


    //   this.duration_period[index] = hh;
    //   $(`#duration_period${index}`).val(`${hh}ساعه,${mm}دقيقه`);

    // },
    list(page = 1) {
      this.axios
        .post(`/period?page=${page}`)
        .then(({ data }) => {
          this.periods = data.periods;

        })
        .catch(({ response }) => {
          console.error(response);
        });
    },



  },
};
</script>

