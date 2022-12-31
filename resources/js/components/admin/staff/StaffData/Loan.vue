<template>
  <!-- row opened -->
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header pb-0">
          <div class="col-md-4" >
            <label for="status">اسم الموظف</label>
            <select name="status" id="status" class="form-control">


              <option >
           muhib
              </option>

            </select>
          </div>
          <div class="col-md-4" >
            <label for="status">الفرع</label>
            <select name="status" id="status" class="form-control">


              <option >
           muhib
              </option>

            </select>
          </div>
          <div class="col-md-4" >
            <label for="status">نوع الوظيفه</label>
            <select name="status" id="status" class="form-control">


              <option >
           muhib
              </option>

            </select>
          </div>
        </div>
        <div class="card-body" id="printme">
          <div class="table-responsive">
            <table class="table table-bordered text-center">
              <thead>
                <tr>
                  <!-- <th class="wd-15p border-bottom-0">الرقم الوظيفي</th> -->
                  <th class="wd-15p border-bottom-0">اسم المؤظف</th>
                  <th class="wd-15p border-bottom-0">التاريخ</th>
                  <th class="wd-15p border-bottom-0">المبلغ</th>
                  <th class="wd-15p border-bottom-0">اجمالي الاقساط</th>
                  <th class="wd-15p border-bottom-0">قيمه القسط</th>
                  <th class="wd-15p border-bottom-0">ملاجظه</th>

                  <th class="wd-15p border-bottom-0">العمليات</th>
                </tr>
              </thead>
              <tbody v-if="loans && loans.data.length > 0">
                <tr v-for="(loan, index) in loans.data" :key="index">
                  <td>{{ loan.staff }}</td>
                  <td>{{ loan.date }}</td>
                  <td>{{ loan.quantity }}</td>
                  <td>{{ loan.number_premium }}</td>
                  <td>{{ loan.premium }}</td>
                  <td>{{ loan.note }}</td>

                  <td>
                    <!-- <a data-toggle="modal" data-target="#modal_vaciar" class="tn btn-danger btn-lg waves-effect btn-agregar"><i class="fa fa-trash"></i></a> -->
                    <button
                      type="button"
                      @click="delete_loan(loan.id)"
                      class="btn btn-danger"
                    >
                      <i class="fa fa-trash"></i>
                    </button>

                    <router-link
                      :to="{
                        name: 'edit_loan',
                        params: { id: loan.id },
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
            :data="loans"
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
          id="addLoan"
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
                  <h4 class="modal-title" id="myLargeModalLabel">القروض</h4>
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
                            @submit.prevent="submitForm"
                            enctype="multipart/form-data"
                          >
                            <div class="form-group">
                              <label for="name">اسم المؤظف</label>
                              <select
                                v-model="staffselected"
                                name="type"
                                id="type"
                                class="form-control"
                                required
                              >
                                <option
                                  v-for="staff in staffs"
                                  v-bind:value="staff.id"
                                >
                                  {{ staff.name }}
                                </option>
                              </select>
                            </div>
                            <div class="form-group">
                              <label for="name">التاريخ</label>
                              <input
                                v-model="date"
                                type="date"
                                class="form-control"
                                name="name"
                                id="name"
                                required
                              />
                            </div>
                            <div class="form-group">
                              <label for="name">المبلغ</label>
                              <input
                                v-model="quantity"
                                type="text"
                                class="form-control"
                                name="name"
                                id="name"
                                required
                              />
                            </div>
                            <div class="form-group">
                              <label for="name">اجمالي الاقساط</label>
                              <input
                                v-model="number_premium"
                                type="text"
                                class="form-control"
                                name="name"
                                id="name"
                                required
                              />
                            </div>
                            <div class="form-group">
                              <label for="name">قيمه القسط</label>
                              <input
                                v-model="value_premium"
                                type="text"
                                class="form-control"
                                name="name"
                                id="name"
                                required
                              />
                            </div>
                            <div class="form-group">
                              <label for="name">ملاحظه</label>
                              <input
                                v-model="note"
                                type="text"
                                class="form-control"
                                name="name"
                                id="name"
                        
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
      // category: "yes",

      loans: {
        type: Object,
        default: null,
      },

      staffs: "",
      staffselected: "",

      number_premium: "",
     
      date: "",
      quantity: "",
      value_premium: "",
      note: "",
      word_search: "",
    };
  },
  mounted() {
    this.list();
  },
  methods: {
  
    get_search(word_search) {
      this.axios
        .post(`/loansearch`, { word_search: this.word_search })
        .then(({ data }) => {
          this.loans = data.loans;

          // this.$root.logo = "Category";
        });
    },
    delete_loan(id) {
      this.axios
        .post(`delete_loan/${id}`)
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
        .post(`/loan?page=${page}`)
        .then(({ data }) => {
          this.loans = data.loans;
          this.staffs = data.staffs;
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },
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
      formData.append("quantity", this.quantity);
      formData.append("value_premium", this.value_premium);
       formData.append("number_premium", this.number_premium);
      formData.append("note", this.note);


     
     
  
  

    //   // send upload request
      this.axios
        .post("/store_loan", formData, config)
        .then(function (response) {
          currentObj.success = response.data.success;
          currentObj.filename = "";

          e.preventDefault();

          toastMessage("تم الاضافه بنجاح");
        })
        .catch(function (error) {
          currentObj.output = error;
        });

      this.$router.go(-1);
    },

 
  },
};
</script>

