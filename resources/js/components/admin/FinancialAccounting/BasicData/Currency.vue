<template>
  <!-- row opened -->
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header">

          <span class="h4"> اضافه عملات</span>


          <div style="display: flex;float: left; margin: 5px">

            
          </div>
        </div>
        <div class="card-body" >
      
         
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

                                  <th>رمز العمله </th>


                                  <th>معدل التحويل </th>



                                  <th>اضافه</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-for="index in count" :key="index">
                                  <td>
                                    <input v-model="currency[index]" type="text" class="form-control" name="name"
                                      id="name" required />
                                  </td>
                                  <td>



                                    <input v-model="symbole_currency[index]" type="text" class="form-control">


                                  </td>
                                  <td>

                                    <input v-model="rate[index]" type="text" class="form-control" />
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
                                <tr>
                          <td colspan="3"></td>
                          <td>

                            <button type="button" class="btn btn-primary" @click="Add_new()">حفظ </button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>


                          </td>
                        </tr>

                              </tbody>
                            </table>
                          </div>
                        </form>

                      </div>

                      <div class="modal-footer">
                     
                      </div>

                    </div>
                  </div>
                  <!--/div-->
                </div>
             
      
      
        </div>
        <!-- <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
          aria-hidden="true" style="display: none" id="currency">
          <div class="modal-dialog modal-lg" style="width: 100%">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                  x
                </button>
                <div class="col-md-8">
                  <h4 class="modal-title" id="myLargeModalLabel">العملات</h4>
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

                                  <th>رمز العمله </th>


                                  <th>معدل التحويل </th>



                                  <th>اضافه</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-for="index in count" :key="index">
                                  <td>
                                    <input v-model="currency[index]" type="text" class="form-control" name="name"
                                      id="name" required />
                                  </td>
                                  <td>



                                    <input v-model="symbole_currency[index]" type="text" class="form-control">


                                  </td>
                                  <td>

                                    <input v-model="rate[index]" type="text" class="form-control" />
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
                </div>
              </div>


            </div>
          </div>

        </div> -->
      </div>
    </div>
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header">

          <span class="h2"> العملات</span>


          <div style="display: flex;float: left; margin: 5px">

            <a class="tn btn-info btn-sm waves-effect btn-agregar" data-toggle="modal" id="agregar_productos"
              data-target="#currency">
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
                  <th class="wd-15p border-bottom-0">اسم العمله</th>
                  <th class="wd-15p border-bottom-0">رمز العمله</th>
                  <th class="wd-15p border-bottom-0">معدل التحويل</th>
                  <th class="wd-15p border-bottom-0"> النوع</th>



                  <th class="wd-15p border-bottom-0">العمليات</th>
                </tr>
              </thead>
              <tbody v-if="currencies && currencies.data.length > 0">
                <tr v-for="(currency, index) in currencies.data" :key="index">
                  <td>
                    {{ currency.name }}
                  </td>

                  <td>

                    {{ currency.symbole }}
                  </td>
                  <td>

                    {{ currency.rate }}
                  </td>


                  <td>

                    {{ currency.type }}
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
              <tbody v-else>
                <tr>
                  <td align="center" colspan="3">
                    <h3> لايوجد بيانات </h3>
                  </td>
                </tr>
              </tbody>

            </table>
          </div>
        </div>
        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
          aria-hidden="true" style="display: none" id="currency">
          <div class="modal-dialog modal-lg" style="width: 100%">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                  x
                </button>
                <div class="col-md-8">
                  <h4 class="modal-title" id="myLargeModalLabel">العملات</h4>
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

                                  <th>رمز العمله </th>


                                  <th>معدل التحويل </th>



                                  <th>اضافه</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-for="index in count" :key="index">
                                  <td>
                                    <input v-model="currency[index]" type="text" class="form-control" name="name"
                                      id="name" required />
                                  </td>
                                  <td>



                                    <input v-model="symbole_currency[index]" type="text" class="form-control">


                                  </td>
                                  <td>

                                    <input v-model="rate[index]" type="text" class="form-control" />
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
import operation from '../../../../../js/operation.js';

export default {
  mixins: [
    operation
  ],
  components: {
    pagination,
  },
  data() {

    return {
      currencies: {
        type: Object,
        default: null,
      },
      currency: [],
      symbole_currency: [],
      rate: [],
      jsonTreeData: '',

      word_search: '',
    }

  },
  mounted() {


    this.list();


  },

  methods: {
    Add_new() {

      this.axios
        .post(`/store_currency`, {
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
        .post(`/currencies?page=${page}`)
        .then(({ data }) => {
          console.log(data.currencies);



          this.currencies = data.currencies;


        })
        .catch(({ response }) => {
          console.error(response);
        });
    },


  },
};
</script>

