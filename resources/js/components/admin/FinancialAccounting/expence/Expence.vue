<template>
  <div class="wrapper">
    <div class="container-fluid">
      <div class="row">
        <!--
            *******************************************************************
            *******************************************************************
                                LISTA PRODUCTOS PRINCIPAL
            *******************************************************************
            *******************************************************************
            -->
        <div class="col-md-12">
          <div class="panel panel-default sombra_caja_producto">
            <div class="panel-body">
              <div class="clearfix">
                <div class="pull-left">
                  <h3></h3>
                  <span></span>
                </div>
                <div class="pull-right">
                  <span style="font-size: x-large">مصروفات</span>
                </div>
              </div>
              <hr />
              <div class="row">





                <!-- <div class="m-t-20"></div> -->
                <!-- <div class="m-t-20 col-md-4">
                  <label for="cliente">اختر مورد</label>



                  <div class="custom-search">
                    <select v-model="supplier" id="supplier" class="custom-search-input">
                      <option v-for="sup in suppliers" v-bind:value="[sup.id, sup.name]">
                        {{ sup.name }}
                      </option>
                    </select>


                    <button class="custom-search-botton" type="button" data-toggle="modal"
                      data-target="#exampleModalSupplier"> <i class="fa fa-plus-circle"></i></button>


                  </div>



                </div> -->

                <!-- <div class="m-t-30 col-md-6">
                  <label for="date">التاريخ</label><br />

                  <input name="date" type="date" v-model="date" />
                </div> -->

                <div class="col-md-2">
             

                  <router-link to="/temporale_expence" class="tn btn-info btn-sm waves-effect btn-agregar"
                    id="agregar_productos">
                    <i class="fa fa-plus-circle"></i></router-link>
                  <a class="tn btn-danger btn-sm waves-effect btn-agregar" data-toggle="modal"
                    data-target="#modal_vaciar">
                    <i class="fa fa-trash"></i></a>
                  <router-link to="/supplylist" class="tn btn-info btn-sm waves-effect btn-agregar">
                    <i class="fa fa-eye"></i>
                  </router-link>

                </div>
              </div>


             


              <!-- end row -->

              <div class="row" style="font-size: 10pt">
                <div class="col-md-12">
                  <div class="table-responsive">
                    <table class="table table-bordered text-right m-t-30" style="width: 100%; font-size: x-small">
                      <thead>
                        <tr>
                          <th style="width: 60px">#</th>
                          <th style="width: 60px">المصروف</th>
                          <!-- <th style="width: 60px">المجموعه</th> -->
                          <!-- <th style="width: 60px">الصنف</th> -->
                          <!-- <th style="width: 60px">المخزن</th> -->
                          <!-- <th style="width: 60px">الرف</th> -->
                          <!-- <th style="width: 60px">الحاله</th>
                          <th style="width: 60px">المواصفات والطراز</th> -->

                          <th style="width: 60px">المبلغ</th>
                          <th style="width: 60px">التاريخ</th>
                          <th style="width: 60px">العمليات</th>
                        </tr>
                      </thead>
                      <tbody v-if="expences && expences.data.length > 0">
                        <tr v-for="(expence, index) in expences.data" :key="index">
                          <td style="width: 40px">{{ index + 1 }}</td>
                          <td style="width: 40px">{{ expence.expence }}</td>
                          <!-- <td style="width: 40px">
                            {{ temporales.group_name }}
                          </td>
                          <td style="width: 40px">
                            {{ temporales.category_name }}
                          </td> -->
                          <!-- <td style="width: 40px">
                            {{ temporales.store }}
                          </td> -->
                          <!-- <td style="width: 40px">
                            {{ temporales.shelve_name }}
                          </td> -->
                          <!-- <td style="width: 40px">{{ temporales.status }}</td> -->
                          <!-- <td style="width: 40px">{{ temporales.desc }}</td> -->

                          <td>{{ expence.quantity}}</td>
                          <td>{{ expence.date}}</td>

                          <td>
                            <button type="button" class="btn btn-danger">
                              <i class="fa fa-trash"></i>
                            </button>
                            <router-link class="btn btn-success"><i class="fa fa-edit"></i></router-link>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- <div class="col-md-2">
          <div class="panel panel-default sombra_caja_producto">
            <div class="panel-body">
              <div class="m-h-50"></div>

              <div class="col-md-12">&nbsp;</div>
              <div class="col-md-12">
                <label for="pagoPrevio">اجمالي الكميه</label>
                <input type="text" readonly="readonly" id="cantidad_total" class="form-control"
                  v-model="total_quantity" />
                <input type="hidden" id="items_totales" />
                <input type="hidden" id="registros_totales" />
              </div>

              <div class="col-md-12">
                <div class="text-center">
                  <a style="
                      width: 100%;
                      padding-top: 0.5em;
                      padding-bottom: 0.5em;
                      font-size: 18pt;
                    " href="javascript:void" @click="payment(supplier)" class="btn btn-info waves-effect waves-light"
                    id="pagar">
                    حفظ
                  </a>

                </div>
              </div>
            </div>
          </div>
        </div> -->



      </div>
      <!-- modal for tree -->
      <!-- <div class="modal fade" id="exampleModal_tree_product" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <form method="post" @submit.prevent="add_store">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">شجره الاصناف</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">


                <div class="well" id="treeview_json_product"></div>
              </div>

              <div class="modal-footer">
                <input class="modal-title-product" type="button" value="">
              </div>


            </div>
          </form>
        </div>
      </div> -->

      <!-- <div class="modal fade" id="exampleModal_tree_store" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <form method="post" @submit.prevent="add_store">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">شجره المخازن</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">

                <div class="well" id="treeview_json_store"></div>

              </div>
              <div class="modal-footer">
                <input class="modal-title-store" type="button" value="">
              </div>

            </div>
          </form>
        </div>
      </div> -->
      <!--  -->
      <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" style="display: none">
        <div class="modal-dialog modal-lg" style="width: 100%">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                x
              </button>
              <div class="col-md-8">
                <h4 class="modal-title" id="myLargeModalLabel">المصروف</h4>
              </div>
              <div class="col-md-4">
                <div class="col-sm-12">
                  <input type="text" placeholder="بحث" class="form-control" name="buscar_producto" id="buscar_producto"
                    v-model="word_search" @input="get_search()" />
                </div>
              </div>
            </div>

          

            <pagination align="center" :data="expences" @pagination-change-page="list"></pagination>
          </div>
          <!-- /.modal-content -->
        </div>


      </div>

      <!-- <div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" style="display: none">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                x
              </button>
              <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="numeroProceso" class="control-label"></label>
                    <input type="text" readonly="readonly" class="form-control" id="codigo_proceso" value="" />
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="cantidadProductos" class="control-label"></label>
                    <input type="text" readonly="readonly" class="form-control" id="modal_cantidad_productos" />
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    <label for="descuento" class="control-label"></label>
                    <input type="text" readonly="readonly" class="form-control" id="modal_descuento" />
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="formaPago" class="control-label">)</label>
                    <input type="text" readonly="readonly" class="form-control" id="modal_forma_pago" />
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="subtotal" class="control-label">Total <small></small></label>
                    <input type="text" readonly="readonly" class="form-control" id="modal_subtotal_cf" />
                    <input type="hidden" readonly="readonly" class="form-control" id="modal_subtotal_sf" />
                  </div>
                </div>
              </div>
              <hr />
              <div class="row text-center">
                <div class="col-md-12">
                  <label for="total" class="text-left">
                    <h2>)</h2>
                  </label>
                  <div class="col-md-12 letra_calculator_total text-center" id="modal_div_total_modal_cf">
                    0.00
                  </div>
                  <input type="hidden" id="modal_total_sf" />
                </div>
              </div>

              <hr />
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group no-margin">
                    <label for="comentario" class="control-label"></label>
                    <textarea class="form-control autogrow" id="modal_comentario" style="
                        overflow: hidden;
                        word-wrap: break-word;
                        resize: horizontal;
                        height: 104px;
                        resize: none;
                      "></textarea>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal"></button>
              <button type="button" class="btn btn-success waves-effect waves-light" id="procesarAhora">
                <span id="loading_modal"></span>
              </button>
            </div>
          </div>
        </div>
      </div> -->




      <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
        aria-hidden="true" style="display: none" id="modal_cero">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header text-center">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                x
              </button>
              <h2 class="modal-title" id="mySmallModalLabel" style="color: red"></h2>
            </div>
            <div class="modal-body">sdffffffffffffffffff</div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

      <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
        aria-hidden="true" style="display: none" id="modal_vaciar">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header text-center">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                هل انت متاكد انك تريد الحذف x
              </button>
              <h2 class="modal-title" id="mySmallModalLabel"></h2>
            </div>
            <div class="modal-body text-center">
              <button type="button" class="btn btn-danger" data-dismiss="modal" style="font-size: 12pt">
                <i class="fa fa-thumbs-down"></i>
              </button>
             
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>


      <div id="proceso_exitoso" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" style="display: none">
        <div class="modal-dialog">
          <div class="modal-content p-0 b-0">
            <div class="panel panel-color panel-primary">
              <div class="panel-heading text-center">
                <h3 class="panel-title"></h3>
              </div>
              <div class="panel-body">
                <div class="account-content">
                  <div class="text-center m-b-20">
                    <div class="m-b-20">
                      <div class="checkmark">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 130.2 130.2">
                          <circle class="path circle" fill="none" stroke="#4bd396" stroke-width="6"
                            stroke-miterlimit="10" cx="65.1" cy="65.1" r="62.1" />
                          <polyline class="path check" fill="none" stroke="#4bd396" stroke-width="6"
                            stroke-linecap="round" stroke-miterlimit="10" points="100.2,40.2 51.5,88.8 29.8,67.5 " />
                        </svg>
                      </div>
                    </div>

                    <h3></h3>

                    <button type="button" class="btn btn-success" id="continuar" style="font-size: 12pt">
                      <i class="fa fa-thumbs-up"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

    </div>
  </div>
</template>
<script>
import pagination from "laravel-vue-pagination";
export default {
    components: {
        pagination,
    },
    data() {

        return {
          expences: {
        type: Object,
        default: null,
      },
            word_search:'',
        }
        // return data;
    },
    mounted() {
        this.list();


    },

    methods: {
    

         
       

        // get_search() {
        //     // alert(typeof(this.word_search));
        //     // alert(this.word_search);
        //     this.axios
        //         .post(`/supply/newsupplysearch`, { word_search: this.word_search })
        //         .then(({ data }) => {
        //             console.log(data.products);
        //             this.temporales = data.temporales;

        //             this.temporale.forEach((item) => {
        //                 this.total_quantity = item.tem_qty + this.total_quantity;
        //             });

        //             this.products = data.products;
        //             this.suppliers = data.suppliers;

        //             // this.stores = data;
        //         });
        // },
        list(page = 1) {
            this.axios
                .post(`/expences?page=${page}`)
                .then(({ data }) => {
                    console.log(data.expences);

                   

                    this.expences = data.expences;
                   

                    // console.log(this.stores);

                    // this.stores = data;
                })
                .catch(({ response }) => {
                    console.error(response);
                });
        },
      

    },
};
</script>
<style scoped>
.custom-search {
  position: relative;
  width: 300px;
}

.custom-search-input {
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 100px;
  padding: 10px 100px 10px 20px;
  line-height: 1;
  box-sizing: border-box;
  outline: none;
}

.custom-search-botton {
  position: absolute;
  right: 3px;
  top: 3px;
  bottom: 3px;
  border: 0;
  background: #d1095e;
  color: #fff;
  outline: none;
  margin: 0;
  padding: 0 10px;
  border-radius: 100px;
  z-index: 2;
}
</style>
  
<style scoped>
th,
td {
  text-align: center;
}
</style> 


