<template>
  <!-- row opened -->
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header">

          <span class="h2"> جزاءات الغياب</span>
          <div style="display: flex;float: left; margin: 5px">
            <a class="tn btn-info btn-sm waves-effect btn-agregar" data-toggle="modal" id="agregar_productos"
              data-target="#addSA">
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
              <th class="wd-15p border-bottom-0">الغياب</th>
              <th class="wd-15p border-bottom-0">عدد مرات التكرار</th>
              <th class="wd-15p border-bottom-0"> الجزاء</th>
              <th class="wd-15p border-bottom-0">العمليات</th>
            </tr>
          </thead>
          <tbody v-if="extra_types && extra_types.length > 0">
            <tr v-for="(extra_type, index) in extra_types" :key="index">
              <td>{{ index + 1 }}</td>
              <td>{{ extra_type.name }}</td>
              <td>
                <!-- <a data-toggle="modal" data-target="#modal_vaciar" class="tn btn-danger btn-lg waves-effect btn-agregar"><i class="fa fa-trash"></i></a> -->
                <button type="button" @click="delete_item(extra_type.id)" class="btn btn-danger">
                  <i class="fa fa-trash"></i>
                </button>

                <router-link :to="{
                  name: 'edit_branch',
                  params: { id: extra_type.id },
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
      <pagination align="center" :data="extra_type" @pagination-change-page="list"></pagination>
    </div>
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
      aria-hidden="true" style="display: none" id="addSA">
      <div class="modal-dialog modal-lg" style="width: 100%">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
              x
            </button>
            <div class="col-md-8">
              <h4 class="modal-title" id="myLargeModalLabel"> جزاءات الغياب</h4>
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

                              <th >الغياب</th>
                              <th >عدد مرات التكرار</th>
                              <th > الجزاء</th>







                              <th>اضافه</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="index in count" :key="index">
                              <td>
                                <input type="text" class="form-control" name="name" id="name" required />

                              </td>
                              <td>
                                <input type="text" class="form-control" name="name" id="name" required />

                              </td>

                              <td>
                                <input type="text" class="form-control" name="name" id="name" required />

                              </td>




                              <td v-if="index == 1">
                                <a class="tn btn-info btn-sm waves-effect btn-agregar" v-on:click="addComponent(count)">
                                  <i class="fa fa-plus-circle"></i></a>

                                <a class="tn btn-info btn-sm waves-effect btn-agregar" v-on:click="disComponent(count)">
                                  <i class="fa fa-minus-circle"></i></a>
                              </td>



                            </tr>
                            <a href="javascript:void" @click="Add_new()" class="btn btn-success"><span>تاكيد
                                العمليه</span></a>

                          </tbody>
                        </table>
                      </div>
                    </form>

                  </div>
                </div>
              </div>

            </div>
          </div>


        </div>

      </div>


    </div>
  </div>
  </div>

</div></template>

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


      list: {
        type: Object,
        default: null,
      },

    };
  },
  mounted() {
    this.list();
    this.type = '';
  },
  methods: {



    list(page = 1) {
      this.axios
        .post(`/absence_sanction?page=${page}`)
        .then(({ data }) => {
          this.absence_sanction = data.absence_sanctions;
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },



  },
};
</script>

