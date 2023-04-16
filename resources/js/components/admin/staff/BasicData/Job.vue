<template>
  <!-- row opened -->
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header">

          <span class="h2"> المسمي الوظيفي</span>
          <div style="display: flex;float: left; margin: 5px">
            <a class="tn btn-info btn-sm waves-effect btn-agregar" data-toggle="modal" id="agregar_productos"
              data-target="#addjob">
              <i class="fa fa-plus-circle"></i></a>

            <input autocomplete="on" v-model="word_search" type="text" class="form-control input-text"
              placeholder="بحث ...." aria-label="Recipient's username" aria-describedby="basic-addon2"
              @input="get_search()">

            <div>

            </div>
          </div>
        </div>

      </div>
    </div>
    <div class="card-body" id="printme">
      <div class="table-responsive">
        <table class="table table-bordered text-center">
          <thead>
            <tr>
              <th class="wd-15p border-bottom-0">#</th>
              <th class="wd-15p border-bottom-0">الاسم</th>


              <th class="wd-15p border-bottom-0">العمليات</th>
            </tr>
          </thead>
          <tbody v-if="jobs && jobs.length > 0">
            <tr v-for="(job, index) in jobs" :key="index">
              <td>{{ index + 1 }}</td>
              <td>{{ job.name }}</td>


              <td>
                <!-- <a data-toggle="modal" data-target="#modal_vaciar" class="tn btn-danger btn-lg waves-effect btn-agregar"><i class="fa fa-trash"></i></a> -->
                <button type="button" @click="delete_job(job.id)" class="btn btn-danger">
                  <i class="fa fa-trash"></i>
                </button>

                <router-link :to="{
                  name: 'edit_job',
                  params: { id: job.id },
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
      <pagination align="center" :data="jobs" @pagination-change-page="list"></pagination>
    </div>
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
      aria-hidden="true" style="display: none" id="addjob">
      <div class="modal-dialog modal-lg" style="width: 100%">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
              x
            </button>
            <div class="col-md-8">
              <h4 class="modal-title" id="myLargeModalLabel">المسمي الوظيفي</h4>
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
                        <div class="form-group"></div>
                        <div class="form-group">
                          <label for="name">المسمي الوظيفي</label>
                          <input type="text" class="form-control" name="name" id="name" required />
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg btn-block">
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

          <pagination align="center" :data="jobs" @pagination-change-page="list"></pagination>
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
import operation from '../../../../../js/staff/operation/operation.js';
export default {
  components: {
    pagination,
  },
  mixins: [operation],
  data() {
    return {
      // category: "yes",

      jobs: {
        type: Object,
        default: null,
      },

   
    };
  },
  mounted() {
    this.list();
    this.type = 'work_type';
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
   
  
    list(page = 1) {
      this.axios
        .post(`/job?page=${page}`)
        .then(({ data }) => {
          this.jobs = data;
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },
  

  
  },
};
</script>

