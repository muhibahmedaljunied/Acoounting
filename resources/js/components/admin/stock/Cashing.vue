<template>
  <div class="wrapper">
    <div class="container-fluid">
      <div class="row">

        <div class="col-md-10">
          <div class="panel panel-default sombra_caja_producto">
            <div class="panel-body">
              <div class="clearfix">
                <div class="pull-left">
                  <h3></h3>
                  <span></span>
                </div>
                <div class="pull-right">

                  <span style="font-size: x-large">صرف</span>

                </div>
              </div>
              <hr />
              <div class="row">

                <div class="col-md-4">
                  <label for="cliente">اختر عميل</label>



                  <!-- <div class="custom-search">
                    <select v-model="customer" id="customer" class="form-control">
                      <option v-for="cust in customers" v-bind:value="[cust.id, cust.name]">
                        {{ cust.name }}
                      </option>
                    </select>


                    <button class="custom-search-botton" type="button" data-toggle="modal"
                      data-target="#exampleModalCustomer"> <i class="fa fa-plus-circle"></i></button>
                  </div> -->

                  <div class="custom-search">
                    <select v-model="customer" id="customer" class="custom-search-input">
                      <option v-for="cust in customers" v-bind:value="[cust.id, cust.name]">
                        {{ cust.name }}
                      </option>
                    </select>


                    <!-- <button class="custom-search-botton" type="button" data-toggle="modal"
                      data-target="#exampleModalCustomer"> <i class="fa fa-plus-circle"></i></button>
 -->

                  </div>

                </div>

                <!-- <div class="m-t-20 col-md-6 col-xs-6">
                  <label for="cliente">اختر عميل</label>

                  <select v-model="customer" id="customer" class="form-control">
                    <option v-for="cust in customers" v-bind:value="[cust.id, cust.name]">
                      {{ cust.name }}
                    </option>
                  </select>
                </div> -->

                <div class="col-md-6">
                  <label for="date">التاريخ</label><br />

                  <input name="date" type="date" v-model="date" />
                </div>
                <div class="col-md-2">

                  <!-- <a class="tn btn-info btn-sm waves-effect btn-agregar" data-toggle="modal" id="agregar_productos"
               data-target=".bs-example-modal-lg">
               <i class="fa fa-plus-circle"></i></a> -->

                  <router-link to="/temporale_cash" class="tn btn-info btn-sm waves-effect btn-agregar"
                    id="agregar_productos">
                    <i class="fa fa-plus-circle"></i></router-link>

                  <a class="tn btn-danger btn-sm waves-effect btn-agregar" data-toggle="modal"
                    data-target="#modal_vaciar">
                    <i class="fa fa-trash"></i></a>

                  <router-link to="/cashlist" class="tn btn-info btn-sm waves-effect btn-agregar">
                    <i class="fa fa-eye"></i>
                  </router-link>



                </div>
              </div>
              <!-- end row -->



              <!-- <div class="modal fade" id="exampleModalCustomer" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">

                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">



                    </div>

                  </div>
                </div>
              </div> -->
              <div class="row" style="font-size: 10pt">
                <div class="col-md-12">
                  <div class="table-responsive">
                    <table class="table table-bordered text-right m-t-30" style="width: 100%; font-size: x-small">
                      <thead>
                        <tr>
                          <th style="width: 60px">#</th>
                          <th style="width: 60px">المنتج</th>
                          <th style="width: 60px">المخزن</th>
                          <th style="width: 60px">الحاله</th>
                          <th style="width: 60px">المواصفات والطراز</th>
                          <th style="width: 60px">الكميه</th>
                          <th style="width: 60px">التكلفه</th>
                          <th style="width: 60px">العمليات</th>
                        </tr>
                      </thead>
                      <tbody v-if="temporale && temporale.length > 0">
                        <tr v-for="(temporales, index) in temporale" :key="index">
                          <td>{{ index + 1 }}</td>
                          <td style="width: 40px">{{ temporales.product }}</td>

                          <!-- <td>{{ temporales.group_name }}</td> -->
                          <td>{{ temporales.store }}</td>
                          <!-- <td>{{ temporales.shelve_name }}</td> -->
                          <td>{{ temporales.status }}</td>
                          <td>{{ temporales.desc }}</td>
                          <td>{{ temporales.tem_qty }}</td>
                          <td></td>

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


        <!--Datos Montos-->
        <div class="col-md-2">
          <div class="panel panel-default sombra_caja_producto">
            <!-- <div class="panel-heading">
                        <h4>Invoice</h4>
                    </div> -->
            <div class="panel-body">
              <div class="m-h-50"></div>

              <div class="col-md-12">&nbsp;</div>
              <div class="col-md-12">
                <label for="pagoPrevio">اجمالي الكميه</label>
                <input type="text" readonly="readonly" id="cantidad_total" class="form-control"
                  v-model="total_quantity" />
              </div>

              <div class="col-md-12">
                <div class="text-center">
                  <a style="
                      width: 100%;
                      padding-top: 0.5em;
                      padding-bottom: 0.5em;
                      font-size: 18pt;
                    " href="javascript:void" @click="payment(customer)" class="btn btn-info waves-effect waves-light"
                    id="pagar">حفظ</a>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>



      <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" style="display: none">
        <div class="modal-dialog modal-lg" style="width: 80%">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                x
              </button>
              <div class="col-md-8">
                <h4 class="modal-title" id="myLargeModalLabel">المنتجات</h4>
                <small>The list shows the last
                  <code style="font-size: 12pt">10</code> products registered in
                  the system.</small>
              </div>
              <div class="col-md-4">
                <div class="col-sm-12">
                  <input type="text" placeholder="بحث" class="form-control" name="buscar_producto" id="buscar_producto"
                    v-model="word_search" @input="get_search()" />
                </div>
              </div>
            </div>
            <div class="modal-body">

              <div class="table-responsive">
                <table class="table table-bordered text-right m-t-30" style="width: 100%; font-size: x-small">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>المنتج</th>
                      <!-- <th>المجموعه</th>
                    <th>الصنف</th> -->
                      <th>الحاله</th>
                      <th>المواصفات والطراز</th>
                      <th>المخزن</th>
                      <!-- <th> الرف</th> -->
                      <th>الكميه المنوفره</th>
                      <th>كميه الصرف</th>


                      <th>اضافه</th>
                    </tr>
                  </thead>
                  <tbody v-if="products && products.data.length > 0">
                    <tr v-for="(product, index) in products.data" :key="index">
                      <!-- <td><input type="text" value="123" id="codigo0" class="form-control input_codigo" readonly=""></td> -->
                      <td>{{ index + 1 }}</td>
                      <td>
                        <div id="factura_producto" class="input_nombre">
                          {{
                            product.product
                          }}<input type="hidden" v-model="product.product_id" id="id" />
                        </div>
                      </td>

                      <td>
                        <div id="factura_producto" class="input_nombre">
                          {{
                            product.status
                          }}<input type="hidden" v-model="product.status_id" id="id" />
                        </div>
                      </td>
                      <td>
                        <div id="factura_producto" class="input_nombre">
                          {{
                            product.desc
                          }}<input type="hidden" v-model="product.desc" id="id" />
                        </div>
                      </td>
                      <td>
                        <div id="factura_producto" class="input_nombre">
                          {{
                            product.store
                          }}<input type="hidden" v-model="product.store_id" id="id" />
                        </div>
                      </td>



                      <td>
                        <div id="factura_producto" class="input_nombre">
                          {{ product.availabe_qty }}
                        </div>

                        <!-- <div v-for="temx in product.units">

<span v-if="temx.unit_type == 1">
  {{ parseInt(product.quantity / product.rate) }} {{ temx.name }}
</span>
<span v-if="temx.unit_type == 0">
  <span
    v-if="Math.round(((product.quantity / product.rate) - parseInt(product.quantity / product.rate)) * product.rate) != 0">
    و
    {{ Math.round(((product.quantity / product.rate) - parseInt(product.quantity / product.rate)) * product.rate) }}{{
      temx.name
    }}
  </span>

</span>
</div> -->
                    

                      </td>

                      <td>
                        <input type="number" v-model="product.quantity" min="1" :max="product.availabe_qty" step="1"
                          class="form-control input_cantidad" onkeypress="return valida(event)" />
                        <!-- @input="check_qty(qty[index], product.id)" -->
                      </td>

                      <td>

                        <input @change="
                          add_one_cash(
                            product.product_id,
                            product.quantity,
                            product.desc,
                            product.availabe_qty,
                            product.product,
                            product.store_id,
                            product.status_id,
                            index
                          )
                        " type="checkbox" v-model="check_state[index]" class="btn btn-info waves-effect" />


                      </td>


                      <td v-if="product.availabe_qty != 0">

                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <a href="javascript:void" @click="Add_new()" class="btn btn-success"><span>تاكيد العمليه</span></a>
            </div>
            <pagination align="center" :data="products" @pagination-change-page="list"></pagination>
          </div>
        </div>

      </div>

      <div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
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
      </div>


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
        </div>
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
              <button type="button" class="btn btn-success" id="confirmar_vaciar" style="font-size: 12pt"
                @click="delete_temporale">
                <i class="fa fa-thumbs-up"></i>
              </button>
            </div>
          </div>
        </div>
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
        </div>
      </div>
    </div>
  </div>
</template>



<script>
import pagination from "laravel-vue-pagination";
import operation from '../../../../js/operation.js';
export default {
  components: {
    pagination,
  },
  mixins: [operation],
  data() {
    return {
      // customers: '',
      // type: '',
      // type_refresh: '',
    }
  },

  mounted() {
    this.list();
    this.type = 'Cash';
    this.type_refresh = 'decrement';

  },
  methods: {

    get_search(word_search) {
      this.axios
        .post(`/cash/newcashsearch`, { word_search: this.word_search })
        .then(({ data }) => {
          this.temporales = data.temporales;

          this.temporale.forEach((item) => {
            this.total_quantity = item.tem_qty + this.total_quantity;
          });

          this.products = data.products;
          this.customers = data.customers;
        });
    },
    list(page = 1) {
      this.axios
        .post(`/cash/newcash?page=${page}`)
        .then(({ data }) => {
          console.log(data.products);

          this.temporale = data.temporales;

          this.temporale.forEach((item) => {
            this.total_quantity = item.tem_qty + this.total_quantity;
          });

          // this.products = data.products;
          this.customers = data.customers;

        })
        .catch(({ response }) => {
          console.error(response);
        });
    },





  },
};
</script>
  
<style scoped>
th,
td {
  text-align: center;
}
</style> 










