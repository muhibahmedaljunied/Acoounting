<template>
  <!-- row opened -->
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header pb-0">
          <div class="d-flex justify-content-between">
            <span class="h2">تحويل فرع</span>
          </div>

          <div class="d-flex justify-content-right">
            <!-- <router-link
              to="create_category"
              id="agregar_productos"
              class="tn btn-info btn-lg waves-effect btn-agregar"
              ><i class="fa fa-plus-circle"></i
            ></router-link> -->
            <a
              class="tn btn-info btn-lg waves-effect btn-agregar"
              data-toggle="modal"
              id="agregar_productos"
              data-target="#addTB"
            >
              <i class="fa fa-plus-circle"></i
            ></a>
           

            <input
              type="search"
              autocomplete="on"
              name="search"
              data-toggle="dropdown"
              role="button"
              aria-haspopup="true"
              aria-expanded="true"
              placeholder="بحث عن صنف"
              v-model="word_search"
              @input="get_search()"
            />

          
            <div></div>
          </div>
        </div>
        <div class="card-body" id="printme">
          <div class="table-responsive">
            <table class="table table-bordered text-center">
              <thead>
                <tr>
                  <th class="wd-15p border-bottom-0">الرقم</th>
                  <th class="wd-15p border-bottom-0">الفرع</th>
               

                  <th class="wd-15p border-bottom-0">العمليات</th>
                </tr>
              </thead>
              <tbody v-if="branches && branches.data.length > 0">
                <tr v-for="(branch, index) in branches.data" :key="index">
                  <td>{{ branch.name }}</td>
              
                 
                  <td>
                    <!-- <a data-toggle="modal" data-target="#modal_vaciar" class="tn btn-danger btn-lg waves-effect btn-agregar"><i class="fa fa-trash"></i></a> -->
                    <button
                      type="button"
                      @click="delete_branch(branch.id)"
                      class="btn btn-danger"
                    >
                      <i class="fa fa-trash"></i>
                    </button>

                    <router-link
                      :to="{
                        name: 'edit_branch',
                        params: { id: branch.id },
                      }"
                      class="edit btn btn-success"
                    >
                      <i class="fa fa-edit"></i
                    ></router-link>
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
          <pagination
            align="center"
            :data="branches"
            @pagination-change-page="list"
          ></pagination>
        </div>
        <div
          class="modal fade bs-example-modal-lg"
          tabindex="-1"
          role="dialog"
          aria-labelledby="myLargeModalLabel"
          aria-hidden="true"
          style="display: none"
          id="addTB"
        >
          <div class="modal-dialog modal-lg" style="width: 100%">
            <div class="modal-content">
              <div class="modal-header">
                <button
                  type="button"
                  class="close"
                  data-dismiss="modal"
                  aria-hidden="true"
                >
                  x
                </button>
                <div class="col-md-8">
                  <h4 class="modal-title" id="myLargeModalLabel">تحويل فرع</h4>
                </div>
                <div class="col-md-4">
                  <div class="col-sm-12">
                    <input
                      type="text"
                      placeholder="بحث"
                      class="form-control"
                      name="buscar_producto"
                      id="buscar_producto"
                      v-model="word_search"
                      @input="get_search()"
                    />
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
                          <form
                            method="post"
                            
                            enctype="multipart/form-data"
                          >
                            <div class="form-group"></div>
                            <div class="form-group">
                              <label for="name">الاسم</label>
                              <input
                                type="text"
                                class="form-control"
                                name="name"
                                id="name"
                                required
                              />
                            </div>
                            <div class="form-group">
                              <label for="Category">المجموعه</label>
                              <select
                                name="type"
                                id="type"
                                class="form-control"
                                required
                              >
                                <option value="">select</option>
                              </select>
                            </div>

                            <div class="form-group">
                              <label for="filePhoto">الصوره</label>
                              <input
                                type="file"
                                name="image"
                                class="form-control-file"
                                id="filePhoto"
                              />
                              <img src="" id="previewHolder" width="150px" />
                            </div>

                            <div class="form-group">
                              <label for="status">الحاله</label>
                              <input
                                type="number"
                                class="form-control"
                                name="status"
                                id="status"
                              />
                            </div>

                            <button
                              type="submit"
                              class="btn btn-primary btn-lg btn-block"
                            >
                              حفظ
                            </button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!--/div-->
                </div>
              </div>

              <pagination
                align="center"
                :data="branches"
                @pagination-change-page="list"
              ></pagination>
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

// import pagination from "laravel-vue-pagination";

// export default {
//   components: {
//     pagination,
//   },

//   data() {
//     return {
//       // category: "yes",

//       branches: {
//         type: Object,
//         default: null,
//       },

//       word_search: "",
//     };
//   },
//   mounted() {
//     this.list();
//   },
//   methods: {
//     Import() {
//       this.axios.post(`/CategoryImport`).then(({ data }) => {
//         console.log(data);

//         this.list();
//         toast.fire({
//           title: "تم الاستيراد بنجاح",
//           text: "Products are successfully exported.",
//           button: "Close", // Text on button
//           icon: "success", //built in icons: success, warning, error, info
//           timer: 3000, //timeOut for auto-close
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
//       });
//     },
//     Export() {
//       this.axios.post(`/CategoryExport`).then((response) => {
//         toast.fire({
//           title: "تم التصدير بنجاح",
//           text: "Products are successfully exported.",
//           button: "Close", // Text on button
//           icon: "success", //built in icons: success, warning, error, info
//           timer: 3000, //timeOut for auto-close
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
//         console.log(response.data.data);
//       });
//     },
//     get_search(word_search) {
//       this.axios
//         .post(`/branchsearch`, { word_search: this.word_search })
//         .then(({ data }) => {
//           this.branches = data;

//           // this.$root.logo = "Category";
//         });
//     },
//     delete_category(id) {
//       this.axios
//         .post(`delete_branch/${id}`)
//         .then((response) => {
//           toastMessage("تم الحذف بنجاح");

//           this.list();
//           // this.$router.push('category')
//         })
//         .catch((error) => {
//           console.log(error.response);

//           if (error.response.status == 500) {
//             toast.fire({
//               title: " فشل",
//               text: error.response.data.message,
//               button: "Close", // Text on button
//               icon: "error", //built in icons: success, warning, error, info
//               timer: 5000, //timeOut for auto-close
//               buttons: {
//                 confirm: {
//                   text: "OK",
//                   value: true,
//                   visible: true,
//                   className: "",
//                   closeModal: true,
//                 },
//                 cancel: {
//                   text: "Cancel",
//                   value: false,
//                   visible: true,
//                   className: "",
//                   closeModal: true,
//                 },
//               },
//             });
//           }
//         });
//     },
//     list(page = 1) {
//       this.axios
//         .post(`/branch?page=${page}`)
//         .then(({ data }) => {
//           this.branches = data;
//         })
//         .catch(({ response }) => {
//           console.error(response);
//         });
//     },
//     // print() {

//     //   this.$htmlToPaper("printMe");
//     // },

//     printDiv(printme) {
//       var printContents = document.getElementById(printme).innerHTML;
//       var originalContents = document.body.innerHTML;

//       document.body.innerHTML = printContents;

//       window.print();

//       document.body.innerHTML = originalContents;
//     },
//   },
// };
// </script>

