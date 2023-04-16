<template>
  <!-- row opened -->
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header">

          <span class="h2"> جزاءات الانصراف المبكر</span>
          <div style="display: flex;float: left; margin: 5px">
            <a class="tn btn-info btn-sm waves-effect btn-agregar" data-toggle="modal" id="agregar_productos"
              data-target="#addSLA">
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
              <th class="wd-15p border-bottom-0">النوع</th>


              <th class="wd-15p border-bottom-0">العمليات</th>
            </tr>
          </thead>
          <tbody v-if="list && v.length > 0">
            <tr v-for="(extra_type, index) in list" :key="index">
              <td>{{ index+ 1 }}</td>
              <td>{{ extra_type.name }}</td>
              <td>
                <!-- <a data-toggle="modal" data-target="#modal_vaciar" class="tn btn-danger btn-lg waves-effect btn-agregar"><i class="fa fa-trash"></i></a> -->
                <button type="button" @click="delete_item(extra_type.id)" class="btn btn-danger">
                  <i class="fa fa-trash"></i>
                </button>


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
      <pagination align="center" :data="list" @pagination-change-page="list"></pagination>
    </div>
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
      aria-hidden="true" style="display: none" id="addSLA">
      <div class="modal-dialog modal-lg" style="width: 100%">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
              x
            </button>
            <div class="col-md-8">
              <h4 class="modal-title" id="myLargeModalLabel"> الدياته</h4>
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

                              <th> الديانه</th>







                              <th>اضافه</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="index in count" :key="index">
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

  </div>
  
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

      extra_types: {
        type: Object,
        default: null,
      },
  
  
    };
  },
  mounted() {
    this.list();
    this.type = 'leav_sanction';
  },
  methods: {



    // list(page = 1) {
    //   this.axios
    //     .post(`/extra_type?page=${page}`)
    //     .then(({ data }) => {
    //       this.extra_types = data.extra_types;
    //     })
    //     .catch(({ response }) => {
    //       console.error(response);
    //     });
    // },



  },
};
</script>

