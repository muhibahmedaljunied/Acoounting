<template>
  <!-- row opened -->
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header pb-0">
          <div class="d-flex justify-content-between">
            <span class="h2"> الغياب</span>
          </div>

          <div class="d-flex justify-content-right">
            <!-- <router-link
              to="create_category"
              id="agregar_productos"
              class="tn btn-info btn-lg waves-effect btn-agregar"
              ><i class="fa fa-plus-circle"></i
            ></router-link> -->
            <a class="tn btn-info btn-lg waves-effect btn-agregar" data-toggle="modal" id="agregar_productos"
              data-target="#addAb">
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

                  <th class="wd-15p border-bottom-0">اسم المؤظف</th>
                  <th class="wd-15p border-bottom-0">نوع الغياب</th>
                  <th class="wd-15p border-bottom-0"> التاريخ</th>
                  <th class="wd-15p border-bottom-0">ملاجظه</th>
                  <th class="wd-15p border-bottom-0">العمليات</th>
                </tr>
              </thead>
              <tbody v-if="absences && absences.data.length > 0">
                <tr v-for="(absence, index) in absences.data" :key="index">

                  <td>{{ absence.staff }}</td>

                  <td>{{ absence.absence }}</td>
                  <td>{{ absence.date }}</td>

                  <td>{{ absence.note }}</td>




                  <td>
                    <!-- <a data-toggle="modal" data-target="#modal_vaciar" class="tn btn-danger btn-lg waves-effect btn-agregar"><i class="fa fa-trash"></i></a> -->
                    <button type="button" @click="delete_absence(absence.id)" class="btn btn-danger">
                      <i class="fa fa-trash"></i>
                    </button>

                    <router-link :to="{
                      name: 'edit_absence',
                      params: { id: absence.id },
                    }" class="edit btn btn-success">
                      <i class="fa fa-edit"></i>
                    </router-link>
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
          <pagination align="center" :data="absences" @pagination-change-page="list"></pagination>
        </div>
        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
          aria-hidden="true" style="display: none" id="addAb">
          <div class="modal-dialog modal-lg" style="max-width: 800px">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                  x
                </button>
                <div class="col-md-8">
                  <h4 class="modal-title" id="myLargeModalLabel">الغيابات</h4>
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

                      </div>
                      <div class="card-body">

                        <form method="post" @submit.prevent="submitForm" enctype="multipart/form-data">

                          <div class="table-responsive">
                            <table class="table table-bordered text-right m-t-30" style="width: 100%; font-size: x-small">
                              <thead>
                                <tr>

                                  <th>اسم المؤظف</th>


                                  <th>نوع الغياب </th>
                                  <th> التاريخ</th>
                                  <th> ملاحظه </th>



                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>
                                    <select v-model="staffselected" name="type" id="type" class="form-control" required>
                                      <option v-for="staff in staffs" v-bind:value="staff.id">
                                        {{ staff.name }}
                                      </option>
                                    </select>
                                  </td>
                                  <td>
                                    <select v-model="typeselected" name="type" id="type" class="form-control" required>
                                      <option v-for="absence_type in absence_types" v-bind:value="absence_type.id">
                                        {{ absence_type.name }}
                                      </option>
                                    </select>
                                  </td>
                                  <td>
                                    <input v-model="date" type="date" class="form-control" name="name" id="name"
                                      required />
                                  </td>

                                  <td>
                                    <input v-model="note" type="text" class="form-control" name="name" id="name" />
                                  </td>





                                </tr>


                              </tbody>
                            </table>
                          </div>
                        </form>

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

      absence_types: "",
      staffs: '',



      typeselected: '',
      staffselected: '',
      date: '',
      note: '',


      absences: {
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
    // filtering: function(e) {
    //      var searchData = new DataManager({
    //           url: 'https://services.odata.org/V4/Northwind/Northwind.svc/Customers',
    //           adaptor: new ODataV4Adaptor,
    //           crossDomain: true
    //       });

    //      if(e.text == '') e.updateData(searchData);
    //       else{
    //       // restrict the remote request until search key contains 3 characters.
    //           if (e.text.length < 3) { return; }
    //           var query = new Query().select(['ContactName', 'CustomerID']);
    //           query = (e.text !== '') ? query.where('ContactName', 'startswith', e.text, true) : query;

    //           e.updateData(searchData, query);
    //       }
    //   },


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
      formData.append("absence_type", this.typeselected);
      formData.append("note", this.note);


      // send upload request
      this.axios
        .post("/store_absence", formData, config)
        .then(function (response) {
          console.log(response);
          currentObj.success = response.data.success;
          currentObj.filename = "";

          e.preventDefault();

          toastMessage("تم الاضافه بنجاح");


        })
        .catch(function (error) {
          currentObj.output = error;
        }); ث

      // this.$router.go(-1);
    },
    get_search(word_search) {
      this.axios
        .post(`/absencesearch`, { word_search: this.word_search })
        .then(({ data }) => {
          this.absnces = data;

          // this.$root.logo = "Category";
        });
    },
    delete_absence(id) {
      this.axios
        .post(`delete_absence/${id}`)
        .then((response) => {
          toastMessage("تم الحذف بنجاح");

          this.list();
          // this.$router.push('category')
        })
        .catch((error) => {
          console.log(error.response);

          if (error.response.status == 500) {
            toast.fire({
              title: " فشل",
              text: error.response.data.message,
              button: "Close", // Text on button
              icon: "error", //built in icons: success, warning, error, info
              timer: 5000, //timeOut for auto-close
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
          }
        });
    },
    list(page = 1) {
      this.axios
        .post(`/absence?page=${page}`)
        .then(({ data }) => {
          this.absences = data.absences;
          this.absence_types = data.absence_types;
          this.staffs = data.staffs;
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },
  },
};
</script>








