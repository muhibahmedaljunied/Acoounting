<template>
  <div class="wrapper">
    <div class="container-fluid">
      <div class="row">

        <div class="col-md-9">
          <div class="panel panel-default sombra_caja_producto">
            <div class="panel-body">
              <div class="clearfix">
                <div class="pull-left">
                  <h3></h3>
                  <span></span>
                </div>
                <div class="pull-right">
                  <h1>المشتريات <span id="codigo"></span></h1>
                </div>
              </div>
              <hr />
              <div class="row">


                <div class="col-md-4">
                  <label for="cliente">اختر مورد</label>

                  <select v-model="supplier" id="supplier" class="form-control">
                    <option v-for="sup in suppliers" v-bind:value="[sup.id, sup.name]">
                      {{ sup.name }}
                    </option>
                  </select>
                </div>

                <div class="col-md-4">
                  <label for="date">التاريخ</label><br />

                  <input name="date" type="date" v-model="date" class="form-control" />
                </div>
                <div class="col-md-4">


                  <!-- <a class="tn btn-info btn-sm waves-effect btn-agregar" data-toggle="modal" id="agregar_productos"
                      data-target=".bs-example-modal-lg">
                      <i class="fa fa-plus-circle"></i></a> -->

                  <router-link to="/temporale_purchase" class="tn btn-info btn-sm waves-effect btn-agregar"
                    id="agregar_productos">
                    <i class="fa fa-plus-circle"></i></router-link>

                  <a class="tn btn-danger btn-sm waves-effect btn-agregar" data-toggle="modal"
                    data-target="#modal_vaciar">
                    <i class="fa fa-trash"></i></a>

                  <router-link to="/listpurchase" class="tn btn-info btn-sm waves-effect btn-agregar">
                    <i class="fa fa-eye"></i>
                  </router-link>


                </div>
              </div>
              <!-- end row -->

              <!-- <div class="m-t-20"></div> -->

              <div class="row" style="font-size: 10pt">
                <div class="col-md-12">
                  <div class="table-responsive">
                    <table class="table table-bordered text-right m-t-30" style="width: 100%; font-size: x-small"
                      id="lista_productos_temporal">
                      <thead>
                        <tr>
                          <th style="width: 40px">المنتج</th>


                          <th>الكميه</th>
                          <th>السعر</th>
                          <th>الحاله</th>
                          <th>المخزن</th>
                          <!-- <th>الرف</th> -->
                          <th>الضريبه</th>


                          <th>الاجمالي</th>
                          <!-- <th>الاجمالي<small> مع الضريبه </small></th> -->
                          <th style="width: 60px">العمليات</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="temporales in temporale">
                          <td style="width: 40px">{{ temporales.product }}</td>

                          <td>
                            <!-- <div v-for="temx in purchase_details.units">



                              <span v-if="temx.unit_type == 0">

                                <span v-if="purchase_details.qty / purchase_details.rate >= 1">
                                  {{ Math.floor((purchase_details.qty / purchase_details.rate)) }}{{
                                    purchase_details.units[0].name
                                  }}
                                </span>

                                <span v-if="purchase_details.qty % purchase_details.rate >= 1">
                                  {{ Math.floor((purchase_details.qty % purchase_details.rate)) }}{{
                                    purchase_details.units[1].name
                                  }}
                                </span>
                              </span>

                            </div> -->
                            {{ temporales.tem_qty }} {{ temporales.unit }}
                          </td>
                          <td>{{ temporales.price }}</td>
                          <td>{{ temporales.status }}</td>
                          <td>{{ temporales.store }}</td>

                          <td>{{ temporales.tax }}</td>

                          <td>{{ temporales.sub_total }}</td>
                          <!-- <td>
                            {{ temporales.total }}<small> </small>
                          </td> -->
                          <td>
                            <button data-toggle="modal" data-target="#modal_vaciar1"
                              @click="show_modal(temporales.product_id)"
                              class="tn btn-danger btn-sm waves-effect btn-agregar">
                              <i class="fa fa-trash"></i></button>
                            <!-- <button data-toggle="modal"
                            data-target="#modal_update"   @click="show_modal(temporales.product_id)" class="tn btn-danger btn-sm waves-effect btn-agregar">
                              <i class="fa fa-edit"></i></button> -->
                            <router-link to="/temporale_supply" class="tn btn-info btn-sm waves-effect btn-agregar"
                              data-toggle="tooltip" title="تعديل">
                              <i class="fa fa-edit"></i></router-link>
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

        <div class="col-md-3">
          <div class="panel panel-default sombra_caja_producto">
            <!-- <div class="panel-heading">
                        <h4>Invoice</h4>
                    </div> -->
            <div class="panel-body">
              <div class="m-h-50"></div>

              <div class="row">
                <div class="col-md-12">
                  <div class="col-md-12">
                    <label for="subTotal">الاجمالي (بدون ضريبه) <small></small></label>
                    <input type="text" readonly id="subtotal_general_si" name="subtotal_general_si" class="form-control"
                      value="0.00" v-model="sub_total" />
                  </div>
                  <div class="col-md-12">&nbsp;</div>
                  <div class="col-md-12">
                    <label for="impuestosTotales">مجموع الضريبه</label>
                    <input type="text" readonly="readonly" id="impuestos_totales" class="form-control"
                      v-model="total_tax" />
                  </div>
                  <div class="col-md-12">&nbsp;</div>
                  <div class="col-md-12">
                    <label for="subTotal">الاجمالي (مع الضريبه) <small></small></label>

                    <input type="text" readonly id="subtotal_general" name="subtotal_general" class="form-control"
                      v-model="grand_total" />
                    <input type="hidden" id="subtotal_general_sf" name="subtotal_general_sf" class="form-control"
                      value="0.00" />
                  </div>
                  <div class="col-md-12"> <label for="pagoPrevio">نوع العمله</label>
                    <select name="forma_pago" class="form-control" id="forma_pago">
                      <option v-bind:value="2">ريال يمني </option>
                      <option v-bind:value="1">دولار امريكي</option>
                      <option v-bind:value="2">ريال سعودي </option>
                    </select>
                  </div>
                  <div class="col-md-12">&nbsp;</div>
                  <div class="col-md-12">
                    <label for="pagoPrevio">الخصم (%)</label>
                    <input type="number" @input="take_discount" v-model="discount" :min="0" :max="99" :step="1"
                      oninput="validity.valid||(value='');" class="form-control input_cantidad"
                      onkeypress="return valida(event)" />

                  </div>
                  <div class="col-md-12">
                    <label for="pagoPrevio">مصروفات مباشره</label>
                    <input type="number" :min="0" :max="99" :step="1" oninput="validity.valid||(value='');"
                      class="form-control input_cantidad" onkeypress="return valida(event)" />

                  </div>

                  <div class="col-md-12">&nbsp;</div>
                  <div class="col-md-12">
                    <label for="FormaPago">طريقه الدفع</label>
                    <select name="forma_pago" class="form-control" id="forma_pago" v-model="Way_to_pay_selected"
                      v-on:change="onwaychange">
                      text
                      <!-- <option v-bind:value="1">cash Money</option>
                      <option v-bind:value="2">Credit</option> -->
                      <option v-bind:value="1">نقد</option>
                      <option v-bind:value="2">أجل</option>
                    </select>
                  </div>
                  <br />
                </div>
              </div>
              <div class="col-md-12">&nbsp;</div>
              <div class="col-md-12">
                <label for="pagoPrevio">اجمالي الكميه</label>
                <input type="text" readonly="readonly" id="cantidad_total" class="form-control"
                  v-model="total_quantity" />
                <input type="hidden" id="items_totales" />
                <input type="hidden" id="registros_totales" />
              </div>
              <div class="col-md-12">
                <label for="pagoPrevio">الصندوق</label>
                <select name="forma_pago" class="form-control" id="forma_pago" v-model="Way_to_pay_selected"
                  v-on:change="onwaychange">
                  <option></option>
                </select>

              </div>

              <div class="col-md-12" v-show="show">
                <label for="pagoPrevio">المدفوع</label>
                <input type="text" id="paid" v-on:input="credit" class="form-control" v-model="(paid = grand_total)"
                  style="color: red" />
                <input type="hidden" id="items_totales" />
                <input type="hidden" id="registros_totales" />
              </div>

              <div class="col-md-12" v-show="show">
                <label for="pagoPrevio">المتبقي</label>
                <input type="text" readonly="readonly" id="remaining" class="form-control" v-model="remaining" />
                <input type="hidden" id="items_totales" />
                <input type="hidden" id="registros_totales" />
              </div>
              <div class="col-md-12">
                <label for="pagoPrevio">تاريخ الاستحقاق</label>
                <input type="date" id="remaining" class="form-control" v-model="remaining" />

              </div>
              <div class="col-md-12">&nbsp;</div>
              <div class="col-md-12">
                <label for="total" class="text-left">TO PAY (USD):</label>
                <div class="col-md-12 letra_calculator_total text-center" id="div_total">
                  {{ grand_total }}
                </div>
                <input type="hidden" name="total" id="total" v-model="grand_total" />
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
                    <i class="fa fa-credit-card"></i></a>
                </div>
              </div>

            </div>
          </div>
        </div>

      </div>



      <!-- <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" style="display: none">
        <div class="modal-dialog modal-lg" style="max-width:1000px">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                x
              </button>
           
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
                   
                      <th>المنتج</th>
                    

                      <th>الحاله</th>
                      <th>الموصفات والطراز</th>
                      <th>مكان الحفظ</th>

                      <th>السعر</th>
                      <th>الكميه</th>
                      <th>الضريبه</th>
                      <th>اضافه</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="index in count" :key="index">
                     
                      <td>



                        <div id="factura_producto" class="input_nombre">
                          <select v-model="product[index - 1]" name="type" id="type" class="form-control" required>
                            <option v-for="(product, sindex) in products" :key="sindex" v-bind:value="product.id">
                              {{ product.text }}
                            </option>
                          </select>
                        </div>


                      </td>

                      <td>
                        <div id="factura_producto" class="input_nombre">
                          <select v-model="status[index - 1]" name="type" id="type" class="form-control" required>
                            <option v-for="status in statuses" v-bind:value="status.id" value="">
                              {{ status.name }}
                            </option>
                          </select>
                        </div>
                      </td>

                      <td>
                        <div id="factura_producto" class="input_nombre">
                          <input type="text" v-model="desc[index - 1]" id="desc" class="form-control input_cantidad"
                            onkeypress="return valida(event)" />
                        </div>
                      </td>

                      <td>
                        <div id="factura_producto" class="input_nombre">
                          <select v-model="store[index - 1]" name="type" id="type" class="form-control" required>
                            <option v-for="store in stores" v-bind:value="store.id">
                              {{ store.text }}
                            </option>
                          </select>
                        </div>
                      </td>


                      <td>
                        <input type="number" v-model="price[index - 1]" id="qty" class="form-control input_cantidad"
                          onkeypress="return valida(event)" />
                      </td>
                      <td>
                        <input type="number" v-model="qty[index - 1]" id="qty" class="form-control input_cantidad"
                          onkeypress="return valida(event)" />
                      </td>
                      <td>
                        <input type="number" v-model="tax[index - 1]" id="tax" class="form-control input_cantidad"
                          onkeypress="return valida(event)" />
                      </td>



             
                      <td v-if="index == 1">

                        <button class="tn btn-info btn-sm waves-effect btn-agregar" v-on:click="addComponent">
                          <i class="fa fa-plus-circle"></i></button>

                        <button class="tn btn-info btn-sm waves-effect btn-agregar" v-on:click="disComponent">
                          <i class="fa fa-minus-circle"></i></button>


                     
                      </td>
                    </tr>




                
                  </tbody>
                </table>
              </div>
              <a href="javascript:void" @click="Add_new()" class="btn btn-success"><span>تاكيد
                  العمليه</span></a>
            </div>
            <pagination align="center" :data="products" @pagination-change-page="list"></pagination>
          </div>
       
        </div>


      </div> -->



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
                x
              </button>
              <h2 class="modal-title" id="mySmallModalLabel"></h2>
            </div>
            <div class="modal-body text-center">
              <button type="button" class="btn btn-danger" data-dismiss="modal" style="font-size: 12pt">
                <i class="fa fa-thumbs-down"></i>
              </button>
              <button @click="delete_temporale()" type="button" class="btn btn-success" id="confirmar_vaciar"
                style="font-size: 12pt">
                <i class="fa fa-thumbs-up"></i>
              </button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

      <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
        aria-hidden="true" style="display: none" id="modal_vaciar1">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header text-center">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                هل انت متاكد انك تريد الحذف x
              </button>
              <h2 class="modal-title" id="mySmallModalLabel"></h2>
            </div>
            <div class="modal-body text-center">
              <input type="hidden" id="vaciar1">
              <button type="button" class="btn btn-danger" data-dismiss="modal" style="font-size: 12pt">
                <i class="fa fa-thumbs-down"></i>
              </button>
              <button type="button" class="btn btn-success" id="confirmar_vaciar" style="font-size: 12pt"
                @click="delete_one_temporale()">
                <i class="fa fa-thumbs-up"></i>
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
                          <circle class="path circle" fill="none" stroke="#4bd396" stroke-width="6" stroke-miterlimit="10"
                            cx="65.1" cy="65.1" r="62.1" />
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
import operation from '../../../../js/operation.js';
export default {

  components: {
    pagination,
  },
  mixins: [operation],
  data() {
    return {

      text_message: '',
      // type: '',
      // type_refresh: '',
      // count: 1,
      // counts: {},
      // product: [],
      // products: '',
      // word_search: '',
      // check_state: [],
      // qty: [],
      // availabe_qty: [],
      // price: [],
      // tax: [],
      // desc: [],
      // stores: '',
      // statuses: '',
      // date: new Date().toISOString().substr(0, 10),
      // status: [],
      // store: [],
      intostore: [],
      intostore_id: [],

      total_quantity: 0,
      grand_total: 0,
      sub_total: 0,
      To_pay: 0,
      discount: 0,
      total_tax: 0,
      customer: [],
      supplier: [],
      suppliers: '',
      customers: '',

      temporale: 1,
      type_payment: 0,
      Way_to_pay_selected: 1,
      show: false,
      paid: 0,
      remaining: 0,
      return_qty: [],
      note: '',
      not_qty: true,
      seen: false,
      // detail: '',
      id: '',


      // ----------------------------
      // supply_detail: "",
      // supply_id: "",
      //---------------------------- 
      // cash_detail: 0,
      // cash_id: "",
      // ---------------------------------------------------
      // purchase_detail: 0,
      // purchase_id: "",
      // -----------------------------------
      // sale_detail: 0,
      // sale_id: "",
      // ---------------------------------

      // dateselected: new Date().toISOString().substr(0, 10),



    }
    // return data;
  },

  mounted() {
    this.list();
    this.counts[0] = 0;
    this.type = 'Purchase';
    this.type_refresh = 'increment';


  },

  methods: {
    show_modal(id) {
      $("#vaciar1").val(id);
    },


    take_discount() {

      if (this.discount != 0) {

        this.sub_total = (parseInt(this.discount) * this.sub_total) / 100;
      }


    },

    get_search() {
      this.axios
        .post(`/purchase/newpurchasesearch`, { word_search: this.word_search })
        .then(({ data }) => {
          this.temporales = data.temporales;

          this.temporale.forEach((item) => {
            this.total_quantity = item.tem_qty + this.total_quantity;
          });

          this.products = data.products;
          this.suppliers = data.suppliers;

          // this.stores = data;
        });
    },
    list(page = 1) {


      this.axios.post(`/purchase/newpurchase?page=${page}`).then(({ data }) => {
        // console.log(data.temporales);
        this.temporale = data.temporales;

        this.temporale.forEach((item) => {
          this.total_quantity = item.tem_qty + this.total_quantity;
          this.sub_total = item.sub_total + this.sub_total;
          this.grand_total = item.total + this.grand_total;
          this.To_pay = item.sub_total + this.To_pay;
          this.total_tax = item.tax + this.total_tax;

        });

        this.products = data.products;
        this.suppliers = data.suppliers;

        this.stores = data.stores;
        this.statuses = data.statuses;
      });

    },

    onwaychange(e) {
      let input = e.target;
      this.type_payment = input.value;
      if (input.value == 2) {
        this.show = true;
      } else {
        this.show = false;
      }
    },
    credit(e) {
      this.remaining = this.grand_total - this.paid;
      this.To_pay = this.paid;
    },



  },
};
</script>


