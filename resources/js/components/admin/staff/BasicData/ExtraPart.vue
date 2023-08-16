<template>
  <!-- row opened -->
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header">

          <span class="h2">اجزاء الاضافي</span>
          <div style="display: flex;float: left; margin: 5px">
            <a class="tn btn-info btn-sm waves-effect btn-agregar" data-toggle="modal" id="agregar_productos"
              data-target="#addEP">
              <i class="fa fa-plus-circle"></i></a>

            <input autocomplete="on" v-model="word_search" type="text" class="form-control input-text"
              placeholder="بحث ...." aria-label="Recipient's username" aria-describedby="basic-addon2"
              @input="get_search()">

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
                  <th class="wd-15p border-bottom-0">الجزء</th>
                  <th class="wd-15p border-bottom-0">من</th>
                  <th class="wd-15p border-bottom-0">الي</th>


                  <th class="wd-15p border-bottom-0">العمليات</th>
                </tr>
              </thead>
              <tbody v-if="extra_parts && extra_parts.length > 0">
                <tr v-for="(extra_part, index) in extra_parts" :key="index">
                  <td>{{ index + 1 }}</td>
                  <td>{{ extra_part.name }}</td>
                  <td>{{ extra_part.from_time }}</td>
                  <td>{{ extra_part.into_time }}</td>
                  <td>
                    <!-- <a data-toggle="modal" data-target="#modal_vaciar" class="tn btn-danger btn-lg waves-effect btn-agregar"><i class="fa fa-trash"></i></a> -->
                    <button type="button" @click="delete_extra_type(extra_part.id)"
                      class="btn btn-sm waves-effect btn-danger">
                      <i class="fa fa-trash"></i>
                    </button>

                    <router-link :to="{
                      name: 'edit_branch',
                      params: { id: extra_part.id },
                    }" class="edit btn btn-sm waves-effect  btn-success">
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
          <pagination align="center" :data="extra_part" @pagination-change-page="list"></pagination>
        </div>
        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
          aria-hidden="true" style="display: none" id="addEP">
          <div class="modal-dialog modal-lg" style="width: 100%">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                  x
                </button>
                <div class="col-md-8">
                  <h4 class="modal-title" id="myLargeModalLabel">اجزاء الاضافي</h4>
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
                        <div class="form">
                          <h3 class="text-center">أضافه </h3>
                          <form method="post" @submit.prevent="submitForm" enctype="multipart/form-data">
                            <div class="form-group"></div>
                            <div class="form-group">
                              <label for="name">من</label>
                              <input type="text" class="form-control" name="name" id="name" required />
                            </div>

                            <div class="form-group">
                              <label for="name">الي</label>
                              <input type="text" class="form-control" name="name" id="name" required />
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
                <button type="button" class="btn btn-primary" @click="Add_new()">حفظ </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

              </div>

              <pagination align="center" :data="extra_parts" @pagination-change-page="list"></pagination>
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
      // category: "yes",

      extra_parts: {
        type: Object,
        default: null,
      },


    };
  },
  mounted() {
    this.list();
    this.counts[0] = 1;

    this.type = 'extra_part';
  },
  methods: {
    Add_new() {

      this.axios
        .post(`/store_extra_part`, {
        count: this.counts,
        type: this.type,
        name: this.name,

      }
        )
        .then((response) => {
          console.log(response);
          toastMessage("تم الاضافه بنجاح");
          // this.$router.go(0);
        });


      
    },

    list(page = 1) {
      this.axios
        .post(`/extra_part?page=${page}`)
        .then(({ data }) => {
          this.extra_parts = data.extra_parts;
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },



  },
};
</script>
  
  