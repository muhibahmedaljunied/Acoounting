<template>
  <!-- row opened -->
  <div class="row row-sm">

    <div class="col-xl-12">
      <div class="card">
        <div class="card-header">

          <span class="h2"> الصناديق</span>


          <div style="display: flex;float: left; margin: 5px">

            <a class="tn btn-info btn-sm waves-effect btn-agregar" data-toggle="modal" id="agregar_productos"
              data-target="#treasury">
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
                  <th class="wd-15p border-bottom-0">اسم الصندوق</th>
                  <th class="wd-15p border-bottom-0"> الحساب</th>



                  <th class="wd-15p border-bottom-0">العمليات</th>
                </tr>
              </thead>
              <tbody v-if="treasuries && treasuries.data.length > 0">
                <tr v-for="(treasury, index) in treasuries.data" :key="index">
                  <td>
                    {{ treasury.name }}
                  </td>
                  <td>
                    {{ treasury.text }} {{ treasury.account_id }}
                  </td>

                  <td>
                    <button data-toggle="modal" class="tn btn-danger btn-sm waves-effect btn-agregar">
                      <i class="fa fa-trash"></i></button>

                  </td>






                </tr>
              </tbody>

            </table>
          </div>
        </div>

      </div>
    </div>



    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
      aria-hidden="true" style="display: none" id="treasury">
      <div class="modal-dialog modal-lg" style="width: 100%">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
              x
            </button>
            <div class="col-md-8">
              <h4 class="modal-title" id="myLargeModalLabel">اضافه صناديق</h4>
            </div>
            <div class="col-md-4">
              <div class="col-sm-12">
                <input type="text" placeholder="بحث" class="form-control" name="buscar_producto" id="buscar_producto" />
              </div>
            </div>
          </div>
          <div class="modal-body">
            <div class="row row-sm">

              <div class="col-xl-12">
                <div class="card">

                  <div class="card-body">
                    <form method="post" @submit.prevent="submitForm" enctype="multipart/form-data">

                      <div class="table-responsive">
                        <table class="table table-bordered text-right m-t-30" style="width: 100%; font-size: x-small">
                          <thead>
                            <tr>

                              <th>الصندوق </th>

                              <th>اسم الحساب </th>


                              <th>رقم الحساب </th>



                              <th>اضافه</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="index in count" :key="index">
                              <td>
                                <input v-model="treasury[index]" type="text" class="form-control" name="name" id="name"
                                  required />
                              </td>
                              <td>


                                <div class="custom-search">

                                  <input :id="'Treasury_account_tree' + indexselectedtreasury" type="text"
                                    class="custom-search-input">

                                  <button class="custom-search-botton" type="button" data-toggle="modal"
                                    @click="detect_index_treasury(indexselectedtreasury)"
                                    data-target="#exampleModaltreasury"> <i class="fa fa-plus-circle"></i></button>

                                </div>

                              </td>
                              <td>

                                <input type="text" name="status" :id="'Treasury_account_tree_id' + indexselectedtreasury"
                                  class="form-control" />
                              </td>






                              <td v-if="index == 1">
                                <a class="tn btn-info btn-sm waves-effect btn-agregar" v-on:click="addComponent(count)">
                                  <i class="fa fa-plus-circle"></i></a>

                                <a class="tn btn-info btn-sm waves-effect btn-agregar" v-on:click="disComponent(count)">
                                  <i class="fa fa-minus-circle"></i></a>
                              </td>



                            </tr>


                          </tbody>
                        </table>
                      </div>
                    </form>

                  </div>

                  <!-- <div class="card-body">
                  <div class="form">

                    <form method="post">
                      <div class="form-group">
                        <label for="name"> الاسم </label>
                        <input type="text" name="name" id="name" class="form-control" />
                      </div>


                      <div class="form-group">
                        <label for="status">رقم الحساب</label>
                        <input type="text" name="status" :id="'Treasury_account_tree_id' + indexselectedtreasury"
                          class="form-control" />
                      </div>
                      <div class="form-group">
                        <label for="cliente">اسم الحساب</label>


                        <div class="custom-search">

                          <input :id="'Treasury_account_tree' + indexselectedtreasury" type="text"
                            class="custom-search-input">

                          <button class="custom-search-botton" type="button" data-toggle="modal"
                            @click="detect_index_treasury(indexselectedtreasury)" data-target="#exampleModaltreasury"> <i
                              class="fa fa-plus-circle"></i></button>

                        </div>



                      </div>






                      <button type="submit" class="btn btn-primary">
                        Add
                      </button>
                    </form>
                  </div>
                </div> -->

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
</template>
<script>
import pagination from "laravel-vue-pagination";
import tree from '../../../../../js/tree/tree.js';
import operation from '../../../../../js/operation.js';


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
      treasuries: {
        type: Object,
        default: null,
      },
      treasury: [],
      account: [],
      indexselectedtreasury: 0,
      type: '',
      type_of_tree: 0,
      jsonTreeData: '',
    }
    // return data;
  },
  mounted() {

    this.list();
    this.counts[0] = 0;
    this.type = 'Bank';
    this.type_of_tree == 1
    this.showtree('account');



  },

  methods: {





    list(page = 1) {
      this.axios
        .post(`/treasuries?page=${page}`)
        .then(({ data }) => {
          console.log(data);



          this.treasuries = data.treasuries;

        })
        .catch(({ response }) => {
          console.error(response);
        });
    },


  },
};
</script>
  
  