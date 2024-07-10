<template>
  <!-- row opened -->
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header">

          <span class="h2"> انواع المصروفات</span>


          <div style="display: flex;float: left; margin: 5px">

            <a class="tn btn-info btn-sm waves-effect btn-agregar" data-toggle="modal" id="agregar_productos"
              data-target="#expence_c">
              <i class="fa fa-plus-circle"></i></a>


            <input autocomplete="on" type="text" class="form-control input-text" placeholder="بحث ...."
              aria-label="Recipient's username" aria-describedby="basic-addon2">


            <div></div>
          </div>
        </div>
        <div class="card-body" id="printme">
          <div class="table-responsive">
            <table class="table table-bordered text-center">
              <thead>
                <tr>
                  <!-- <th class="wd-15p border-bottom-0">الرقم الوظيفي</th> -->
                  <th class="wd-15p border-bottom-0">اسم المصروف</th>




                  <th class="wd-15p border-bottom-0">العمليات</th>
                </tr>
              </thead>
              <tbody v-if="expence_type && expence_type.length > 0">
                <tr v-for="(expence, index) in expence_type" :key="index">
                  <td>
                    {{ expence.name }}
                  </td>


                  <td>
                    <button data-toggle="modal" data-target="#modal_vaciar1"
                      class="tn btn-danger btn-sm waves-effect btn-agregar">
                      <i class="fa fa-trash"></i></button>

                    <router-link to="/temporale_supply" class="tn btn-info btn-sm waves-effect btn-agregar"
                      data-toggle="tooltip" title="تعديل">
                      <i class="fa fa-edit"></i></router-link>
                  </td>






                </tr>
              </tbody>

            </table>
          </div>
        </div>
        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
          aria-hidden="true" style="display: none" id="expence_c">
          <div class="modal-dialog modal-lg" style="width: 100%">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                  x
                </button>
                <div class="col-md-8">
                  <h4 class="modal-title" id="myLargeModalLabel">انواع المصروفات</h4>
                </div>
                <div class="col-md-4">
                  <div class="col-sm-12">
                    <input type="text" placeholder="بحث" class="form-control" name="buscar_producto"
                      id="buscar_producto" />
                  </div>
                </div>
              </div>
              <div class="modal-body">
                <div class="row row-sm">
                  <div class="col-xl-12">
                    <div class="card">


                      <div class="card-body">
                        <form method="post" enctype="multipart/form-data">

                          <div class="table-responsive">
                            <table class="table table-bordered text-right m-t-30" style="width: 100%; font-size: x-small">
                              <thead>
                                <tr>

                                  <th>الاسم </th>

                                  <th>اسم الحساب </th>

                                  <!-- <th>رقم الحساب </th> -->

                                  <th>اضافه</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-for="index in count" :key="index">
                                  <td>
                                    <input v-model="expence[index]" type="text" class="form-control" name="name" id="name"
                                      required />
                                  </td>
                                  <td>

                                    <div class="custom-search">

                                      <input :id="'Bank_account_tree' + index" type="text" class="custom-search-input">

                                      <button class="custom-search-botton" type="button" data-toggle="modal"
                                        @click="detect_index(index)" data-target="#exampleModalBank"> <i
                                          class="fa fa-plus-circle"></i></button>

                                    </div>

                                    <input :id="'Bank_account_tree_id' + index" type="hidden" name="status"
                                      class="form-control" />
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
                      <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="Add_new()">حفظ </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

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
import tree from '../../../../../js/tree/tree.js';
import operation from '../../../../operation1.js';
export default {
  mixins: [
    tree,
    operation
  ],
  components: {
    pagination,
  },
  data() {

    return {
      expence_type: {
        type: Object,
        default: null,
      },
      word_search: '',
      counts: {},
      expence:[],
    }

  },
  mounted() {
    this.list();

    this.counts[0] = 1;


  },

  methods: {

    list(page = 1) {
      this.axios
        .post(`/expence_type?page=${page}`)
        .then(({ data }) => {
          console.log(data.expence_types);



          this.expence_type = data.expence_types;


        })
        .catch(({ response }) => {
          console.error(response);
        });
    },


  },
};
</script>

