<template>
  <!-- row opened -->
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header">

          <span class="h2"> الاستراحه</span>
          <div style="display: flex;float: left; margin: 5px">
            <a class="tn btn-info btn-sm waves-effect btn-agregar" data-toggle="modal" id="agregar_productos"
              data-target="#addbreak">
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
                  <th class="wd-15p border-bottom-0">من</th>
                  <th class="wd-15p border-bottom-0">الي</th>
                  <th class="wd-15p border-bottom-0">المده</th>

                  <th class="wd-15p border-bottom-0">العمليات</th>
                </tr>
              </thead>
              <tbody v-if="vacation_types && vacation_types.data.length > 0">
                <tr v-for="(vacation_type, index) in vacation_types.data" :key="index">
                  <td>{{ index + 1 }}</td>
                  <td>{{ vacation_type.name }}</td>
                  <td>{{ vacation_type.duration }}</td>
                  <td>{{ vacation_type.duration }}</td>
                  <td>
                    <!-- <a data-toggle="modal" data-target="#modal_vaciar" class="tn btn-danger btn-lg waves-effect btn-agregar"><i class="fa fa-trash"></i></a> -->
                    <button type="button" @click="delete_vacation_type(vacation_type.id)"
                      class="btn btn-sm waves-effect btn-danger">
                      <i class="fa fa-trash"></i>
                    </button>

                    <router-link :to="{
                      name: 'edit_branch',
                      params: { id: vacation_type.id },
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
          <pagination align="center" :data="vacation_type" @pagination-change-page="list"></pagination>
        </div>


        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
          aria-hidden="true" style="display: none" id="addbreak">
          <div class="modal-dialog modal-lg" style="width: 100%">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                  x
                </button>
                <div class="col-md-8">
                  <h4 class="modal-title" id="myLargeModalLabel">الاستراحه</h4>
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
                    
                      <div class="card-body">
                        <form method="post"  enctype="multipart/form-data">

                          <div class="table-responsive">
                            <table class="table table-bordered text-right m-t-30" style="width: 100%; font-size: x-small">
                              <thead>
                                <tr>

                                  <th> من</th>


                                  <th> الي </th>

                                  <th> المده </th>


                                  <th>اضافه</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-for="index in count" :key="index">

                                  <td>
                                    <input v-model="from_rest[index]" type="time" class="form-control" required />
                                  </td>
                                  <td>
                                    <input v-model="into_rest[index]" type="time" class="form-control" required />

                                  </td>


                                  <td>
                                    <input v-model="duration_rest[index]" type="text" class="form-control"
                                      id="duration_rest" required />

                                  </td>

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
                    </div>
                  </div>
                  <!--/div-->
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary" @click="Add_new()">حفظ </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

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


      vacation_types: {
        type: Object,
        default: null,
      },
      from_rest: [],
      into_rest: [],
      duration_rest: [],
    };
  },
  mounted() {
    this.list();
    this.counts[0] = 1;
    this.type = 'rest';
  },
  methods: {

    Add_new() {

      this.Add({
        count: this.counts,
        type: this.type,
        from_rest: this.from_rest,
        into_rest: this.into_rest,
        duration_rest: this.duration_rest,

      });
    },
    list(page = 1) {
      this.axios
        .post(`/vacation_type?page=${page}`)
        .then(({ data }) => {
          this.vacation_types = data.vacation_types;
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },



  },
};
</script>

