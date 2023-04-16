<template>
  <!-- row opened -->
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">

        <div class="card-header ">

          <h2>الاضافي</h2>
        </div>
        <div class="card-body">
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
              <a href="#"><img src="/assets/img/search.png" alt="" style="width: 10%;"> </a>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered text-center">
              <thead>
                <tr>

                  <th class="wd-15p border-bottom-0">اسم المؤظف</th>
                  <th class="wd-15p border-bottom-0"> نوع الاضافي</th>
                  <th class="wd-15p border-bottom-0"> عدد الساعات</th>
        
                  <th class="wd-15p border-bottom-0">التأريخ </th>
                  <th class="wd-15p border-bottom-0">وقت البدء</th>
                  <th class="wd-15p border-bottom-0">وقت الانتعاء</th>
                  <th class="wd-15p border-bottom-0"> ملاجظه</th>


                  <!-- <th class="wd-15p border-bottom-0">العمليات</th> -->
                </tr>
              </thead>
              <tbody v-if="list_data && list_data.data.length > 0">
                <tr v-for="(extra, index) in list_data.data" :key="index">
                  <td>{{ extra.name }}</td>

                  <td>

                    <div v-for="(extra_names, index) in extra.extra" :key="index">
                      {{ extra_names.extra_type.name }}
                    </div>
                  </td>

                  <td>

                    <div v-for="(extra_number_hours, index) in extra.extra" :key="index">
                      {{ extra_number_hours.number_hours }}
                    </div>
                  </td>


                  <td>

                    <div v-for="(extra_start_date, index) in extra.extra" :key="index">
                      {{ extra_start_date.date }}
                    </div>
                  </td>


               


                  <td>

                    <div v-for="(extra_start_time, index) in extra.extra" :key="index">
                      {{ extra_start_time.start_time }}
                    </div>
                  </td>

                  <td>

                    <div v-for="(extra_end_time, index) in extra.extra" :key="index">
                      {{ extra_end_time.end_time }}
                    </div>
                  </td>





                  <!-- <td>{{ extra.extra }}</td> -->
                  <!-- <td>{{ extra.start_date }}</td>
                  <td>{{ extra.end_date }}</td>
                  <td>{{ extra.start_time }}</td>
                  <td>{{ extra.end_time }}</td> -->
                  <td>{{ extra.note }}</td>


                  <!-- <td>
                    <button type="button" @click="delete_extra(extra.id)" class="btn btn-danger">
                      <i class="fa fa-trash"></i>
                    </button>

                    <router-link :to="{
                      name: 'edit_extra',
                      params: { id: extra.id },
                    }" class="edit btn btn-success">
                      <i class="fa fa-edit"></i>
                    </router-link>
                  </td> -->
                </tr>
              </tbody>
              <tbody v-else>
                <tr>
                  <td align="center" colspan="3">لايوجد بياتات.</td>
                </tr>
              </tbody>
            </table>
          </div>
          <pagination align="center" :data="list_data" @pagination-change-page="list"></pagination>
        </div>
        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
          aria-hidden="true" style="display: none" id="addExtra">
          <div class="modal-dialog modal-lg" style="width: 100%">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                  x
                </button>
                <div class="col-md-8">
                  <h4 class="modal-title" id="myLargeModalLabel">الاضافي</h4>
                </div>
                <div class="col-md-4">
                  <div class="col-sm-12">
                    <input type="text" placeholder="بحث" class="form-control" name="buscar_producto"
                      id="buscar_producto" v-model="word_search" @input="get_search()" />
                  </div>
                </div>
              </div>
              <div class="modal-body">
                <div class="row row-sm">
                  <div class="col-xl-12">
                    <div class="card">
                      <div class="card-header pb-0">
                        <!-- <div class="d-flex justify-content-between">
                          <h4 class="card-title mg-b-0">SIMPLE TABLE</h4>
                          <i class="mdi mdi-dots-horizontal text-gray"></i>
                        </div>
                        <p class="tx-12 tx-gray-500 mb-2">
                          Example of Valex Simple Table.
                          <a href="">Learn more</a>
                        </p> -->
                      </div>
                      <!-- <div class="card-body">
                        <form method="post" @submit.prevent="submitForm" enctype="multipart/form-data">

                          <div class="table-responsive">
                            <table class="table table-bordered text-right m-t-30"
                              style="width: 100%; font-size: x-small">
                              <thead>
                                <tr>

                                  <th>اسم المؤظف</th>


                                  <th>نوع الاضافي </th>
                                  <th> تاريخ اليدء </th>

                                  <th>تاريخ الانتهاء</th>

                                  <th> وقت البدء</th>
                                  <th>وقت الانتهاء</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>
                                    <select  name="type" id="type" class="form-control "
                                      required>
                                      <option v-for="staff in staffs" v-bind:value="staff.id">
                                        {{ staff.name }}
                                      </option>
                                    </select>
                                  </td>
                                  <td>
                                    <select v-model="typeselected" name="type" id="type" class="form-control" required>
                                      <option v-for="extra_type in extra_types" v-bind:value="extra_type.id">
                                        {{ extra_type.name }}
                                      </option>
                                    </select>
                                  </td>
                                  <td>
                                    <input v-model="start_date" type="date" class="form-control" name="name" id="name"
                                      required />
                                  </td>
                                  <td>
                                    <input v-model="end_date" type="date" class="form-control" name="name" id="name"
                                      required />
                                  </td>
                                  <td>
                                    <input v-model="start_time" type="time" class="form-control" name="name"
                                      id="name" />
                                  </td>
                                  <td>
                                    <input v-model="end_time" type="time" class="form-control" name="name" id="name" />
                                  </td>





                                </tr>
                                <button type="submit" class="btn btn-primary btn-lg btn-block">
                                  حفظ
                                </button>

                              </tbody>
                            </table>
                          </div>
                        </form>

                      </div> -->
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
import operation from '../../../../../js/staff/StaffData/staff_data.js';
export default {
  components: {
    pagination,
  },
  mixins: [operation],
  data() {
    return {
      count: 1,
      extra_types: "",
      staffs: '',
      staffselected: '',
      typeselected: '',
      start_date: '',
      end_date: '',
      start_time: '',
      end_time: '',
      note: '',
      name: '',
      staff_selected: 1,
      list_data: {
        type: Object,
        default: null,
      },
      table: 'extra',
      word_search: "",
      from_date: new Date().toISOString().substr(0, 10),
      into_date: new Date().toISOString().substr(0, 10),
    };
  },
  mounted() {
    this.list();
  },
  methods: {
    Import() {
      this.axios.post(`/CategoryImport`).then(({ data }) => {
        console.log(data);

        this.list();
        toast.fire({
          title: "تم الاستيراد بنجاح",
          text: "Products are successfully exported.",
          button: "Close", // Text on button
          icon: "success", //built in icons: success, warning, error, info
          timer: 3000, //timeOut for auto-close
          buttons: {
            confirm: {
              text: "OK",
              value: true,
              visible: true,
              className: "",
              closeModal: true,
            },
            cancel: {
              text: "Cancel",
              value: false,
              visible: true,
              className: "",
              closeModal: true,
            },
          },
        });
      });
    },
    Export() {
      this.axios.post(`/CategoryExport`).then((response) => {
        toast.fire({
          title: "تم التصدير بنجاح",
          text: "Products are successfully exported.",
          button: "Close", // Text on button
          icon: "success", //built in icons: success, warning, error, info
          timer: 3000, //timeOut for auto-close
          buttons: {
            confirm: {
              text: "OK",
              value: true,
              visible: true,
              className: "",
              closeModal: true,
            },
            cancel: {
              text: "Cancel",
              value: false,
              visible: true,
              className: "",
              closeModal: true,
            },
          },
        });
        console.log(response.data.data);
      });
    },

    get_search(word_search) {
      this.axios
        .post(`/extrasearch`, { word_search: this.word_search })
        .then(({ data }) => {
          this.extras = data;

          // this.$root.logo = "Category";
        });
    },

    list(page = 1) {
      this.axios
        .post(`/extra?page=${page}`)
        .then(({ data }) => {
          this.list_data = data.list;
          this.extra_types = data.extra_types;
          this.staffs = data.staffs;
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },



  },
};
</script>

