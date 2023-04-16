<template>
  <!-- row opened -->
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header pb-0">
          <div class="d-flex justify-content-between">
            <span class="h2"> التاخير</span>
          </div>

          <div class="d-flex justify-content-right">
            <!-- <router-link
              to="create_category"
              id="agregar_productos"
              class="tn btn-info btn-lg waves-effect btn-agregar"
              ><i class="fa fa-plus-circle"></i
            ></router-link> -->
            <a class="tn btn-info btn-lg waves-effect btn-agregar" data-toggle="modal" id="agregar_productos"
              data-target="#addDelay">
              <i class="fa fa-plus-circle"></i></a>

            <input type="search" autocomplete="on" name="search" data-toggle="dropdown" role="button" aria-haspopup="true"
              aria-expanded="true" placeholder="بحث عن صنف" v-model="word_search" @input="get_search()" />

            <div></div>
          </div>
        </div>
        <div class="card-body" id="printme">
          <div class="table-responsive">
            <table class="table table-bordered text-center">
              <thead>
                <tr>
                  <!-- <th class="wd-15p border-bottom-0">الرقم الوظيفي</th> -->
                  <th class="wd-15p border-bottom-0">اسم المؤظف</th>
                  <th class="wd-15p border-bottom-0">نوع التاخير</th>
                  <th class="wd-15p border-bottom-0"> التاريخ</th>
                  <th class="wd-15p border-bottom-0">ملاجظه</th>

                  <th class="wd-15p border-bottom-0">العمليات</th>
                </tr>
              </thead>
              <tbody v-if="delays && delays.data.length > 0">
                <tr v-for="(delay, index) in delays.data" :key="index">

                  <td>{{ delay.name }}</td>

                  <td>{{ delay.delay }}</td>
                  <td>{{ delay.date }}</td>

                  <td>{{ delay.note }}</td>




                  <td>
                    <!-- <a data-toggle="modal" data-target="#modal_vaciar" class="tn btn-danger btn-lg waves-effect btn-agregar"><i class="fa fa-trash"></i></a> -->
                    <button type="button" @click="delete_delay(delay.id)" class="btn btn-danger btn-sm waves-effect">
                      <i class="fa fa-trash"></i>
                    </button>

                    <router-link :to="{
                      name: 'edit_delay',
                      params: { id: delay.id },
                    }" class="edit btn btn-success">
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
          <pagination align="center" :data="delays" @pagination-change-page="list"></pagination>
        </div>
        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
          aria-hidden="true" style="display: none" id="addDelay">
          <div class="modal-dialog modal-lg" style="width: 100%">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                  x
                </button>
                <div class="col-md-8">
                  <h4 class="modal-title" id="myLargeModalLabel">التاخير</h4>
                </div>
                <div class="col-md-4">
                  <div class="col-sm-12">
                    <input type="text" placeholder="بحث" class="form-control" name="buscar_producto" id="buscar_producto"
                      v-model="word_search" @input="get_search()" />
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
                      <div class="card-body">
                        <div class="form">
                          <h3 class="text-center">أضافه </h3>
                          <form method="post" @submit.prevent="submitForm" enctype="multipart/form-data">
                            <div class="form-group col-md-3">
                              <label for="name">اسم المؤظف</label>
                              <select v-model="staffselected" name="type" id="type" class="form-control" required>
                                <option v-for="staff in staffs" v-bind:value="staff.id">
                                  {{ staff.name }}
                                </option>
                              </select>
                            </div>
                            <div class="form-group col-md-3">
                              <label for="Category">نوع التاخير</label>
                              <select v-model="delay_typeselected" name="type" id="type" class="form-control" required>
                                <option v-for="delay_type in delay_types" v-bind:value="delay_type.id">
                                  {{ delay_type.name }}
                                </option>
                              </select>
                            </div>
                            <div class="form-group col-md-3">
                              <label for="name">التاريخ</label>
                              <input v-model="date" type="date" class="form-control" name="name" id="name" required />
                            </div>
                            <div class="form-group col-md-3">
                              <label for="name">ملاحظه</label>
                              <input v-model="note" type="text" class="form-control" name="name" id="name" />
                            </div>

                           
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!--/div-->
                </div>
              </div>
              <div class="modal-footer">
                <a href="javascript:void" @click="Add_new()" class="btn btn-success"><span>تاكيد
                    العمليه</span></a>
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

export default {
  components: {
    pagination,
  },

  data() {
    return {
      delay_typeselected: "",
      staffselected: "",
      delay_types: "",
      date: '',

      staffs: "",
      note: "",

      delays: {
        type: Object,
        default: null,
      },

      word_search: "",
    };
  },
  mounted() {
    this.list();
  },
  methods: {

    submitForm(e) {
      e.preventDefault();
      let currentObj = this;
      const config = {
        headers: {
          "content-type": "multipart/form-data",
        },
      };
      // form data
      let formData = new FormData();
      formData.append("date", this.date);
      formData.append("staff", this.staffselected);
      formData.append("delay_type", this.delay_typeselected);
      formData.append("note", this.note);

      // send upload request
      this.axios
        .post("/store_delay", formData, config)
        .then(function (response) {
          currentObj.success = response.data.success;
          currentObj.filename = "";

          e.preventDefault();

          toastMessage("تم الاضافه بنجاح");
        })
        .catch(function (error) {
          currentObj.output = error;
        });

      // this.$router.go(-1);
    },
    get_search(word_search) {
      this.axios
        .post(`/delaysearch`, { word_search: this.word_search })
        .then(({ data }) => {
          this.delays = data;

          // this.$root.logo = "Category";
        });
    },
    // delete_delay(id) {
    //   this.axios
    //     .post(`delete_delay/${id}`)
    //     .then((response) => {
    //       toastMessage("تم الحذف بنجاح");

    //       this.list();
    //       // this.$router.push('category')
    //     })
    //     .catch((error) => {
    //       console.log(error.response);

    //       if (error.response.status == 500) {
    //         toast.fire({
    //           title: " فشل",
    //           text: error.response.data.message,
    //           button: "Close", // Text on button
    //           icon: "error", //built in icons: success, warning, error, info
    //           timer: 5000, //timeOut for auto-close
    //           buttons: {
    //             confirm: {
    //               text: "OK",
    //               value: true,
    //               visible: true,
    //               className: "",
    //               closeModal: true,
    //             },
    //             cancel: {
    //               text: "Cancel",
    //               value: false,
    //               visible: true,
    //               className: "",
    //               closeModal: true,
    //             },
    //           },
    //         });
    //       }
    //     });
    // },
    // list(page = 1) {
    //   this.axios
    //     .post(`/delay?page=${page}`)
    //     .then(({ data }) => {
    //       console.log(data.delays);
    //       this.delays = data.delays;
    //       this.delay_types = data.delay_types;
    //       this.staffs = data.staffs;
    //     })
    //     .catch(({ response }) => {
    //       console.error(response);
    //     });
    // },
    // print() {

    //   this.$htmlToPaper("printMe");
    // },


  },
};
</script>

