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
                  <span style="font-size: x-large">توريد</span>
                </div>
              </div>
              <hr />
              <div class="row">





                <!-- <div class="m-t-20"></div> -->
                <div class="m-t-20 col-md-4">
                  <label for="cliente">اختر مورد</label>



                  <div class="custom-search">
                    <select v-model="supplier" id="supplier" class="custom-search-input">
                      <option v-for="sup in suppliers" v-bind:value="[sup.id, sup.name]">
                        {{ sup.name }}
                      </option>
                    </select>


                    <!-- <button class="custom-search-botton" type="button" data-toggle="modal"
                      data-target="#exampleModalSupplier"> <i class="fa fa-plus-circle"></i></button> -->


                  </div>



                </div>

                <div class="m-t-30 col-md-4">
                  <label for="date">التاريخ</label><br />

                  <input name="date" type="date" v-model="date" class="form-control" />
                </div>





                <div class="col-md-4">


                  <router-link to="/temporale_supply" class="tn btn-info btn-sm waves-effect btn-agregar"
                    id="agregar_productos" data-toggle="tooltip" data-placement="top" title="اضافه">
                    <i class="fa fa-plus-circle"></i></router-link>
                  <a class="tn btn-danger btn-sm waves-effect btn-agregar" data-toggle="modal"
                    data-target="#modal_vaciar">
                    <i class="fa fa-trash"></i></a>
                  <router-link to="/supplylist" class="tn btn-info btn-sm waves-effect btn-agregar"
                    data-toggle="tooltip" data-placement="top" title="تفاصيل">
                    <i class="fa fa-eye"></i>
                  </router-link>

                </div>
              </div>


              <!-- <div class="modal fade" id="exampleModalSupplier" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">

                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">

                      <div class="card-body">
                        <div class="form">
                          <h3 class="text-center">اضافه مورد</h3>
                          <form method="post" @submit.prevent="addsupplier">
                            <div class="form-group">
                              <label for="name"> الاسم الاول</label>
                              <input v-model="name" type="text" name="name" id="name" class="form-control" required />
                            </div>
                            <div class="form-group">
                              <label for="role">الاسم الاخير</label>
                              <input v-model="last_name" type="text" name="last_name" id="last_name"
                                class="form-control" />
                            </div>

                            <div class="form-group">
                              <label for="phone">الهاتف</label>
                              <input v-model="phone" type="text" name="phone" id="phone" class="form-control" />
                            </div>
                            <div class="form-group">
                              <label for="name">البريد الالكتروني</label>
                              <input v-model="email" type="text" name="email" id="email" class="form-control" />
                            </div>

                            <div class="form-group">
                              <label for="address">العنوان</label>
                              <input v-model="address" type="text" name="address" id="address" class="form-control" />
                            </div>

                            <div class="form-group">
                              <label for="cliente">رقم الحساب</label>


                              <div class="custom-search">
                                <select v-model="supplier" id="supplier" class="custom-search-input">

                                </select>



                              </div>



                            </div>
                            <div class="form-group">
                              <label for="status">اسم الحساب</label>
                              <input v-model="status" type="text" name="status" id="status" class="form-control" />
                            </div>
                       
                            <div class="form-group">
                              <label for="status">الحاله</label>
                              <input v-model="status" type="text" name="status" id="status" class="form-control" />
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg btn-block">
                              Add
                            </button>
                          </form>
                        </div>
                      </div>

                    </div>

                  </div>
                </div>
              </div> -->


              <!-- end row -->

              <div class="row" style="font-size: 10pt">
                <div class="col-md-12">
                  <div class="table-responsive">
                    <table class="table table-bordered text-right m-t-30" style="width: 100%; font-size: x-small">
                      <thead>
                        <tr>
                          <th style="width: 60px">#</th>
                          <th style="width: 60px">المنتج</th>
                          <!-- <th style="width: 60px">المجموعه</th> -->
                          <!-- <th style="width: 60px">الصنف</th> -->
                          <th style="width: 60px">المخزن</th>
                          <!-- <th style="width: 60px">الرف</th> -->
                          <th style="width: 60px">الحاله</th>
                          <th style="width: 60px">المواصفات والطراز</th>

                          <th style="width: 60px">الكميه الوارده</th>
                          <th style="width: 60px">التكلفه</th>
                          <th style="width: 60px">العمليات</th>
                        </tr>
                      </thead>
                      <tbody v-if="temporale && temporale.length > 0">
                        <tr v-for="(temporales, index) in temporale" :key="index">
                          <td style="width: 40px">{{ index + 1 }}</td>
                          <td style="width: 40px">{{ temporales.product }}</td>
                          <!-- <td style="width: 40px">
                            {{ temporales.group_name }}
                          </td>
                          <td style="width: 40px">
                            {{ temporales.category_name }}
                          </td> -->
                          <td style="width: 40px">
                            {{ temporales.store }}
                          </td>
                          <!-- <td style="width: 40px">
                            {{ temporales.shelve_name }}
                          </td> -->
                          <td style="width: 40px">{{ temporales.status }}</td>
                          <td style="width: 40px">{{ temporales.desc }}</td>

                          <td>{{ temporales.tem_qty }} {{ temporales.unit }}</td>
                          <td></td>

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

        <div class="col-md-2">
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
                      font-size: 18pt;" href="javascript:void" @click="payment(supplier)"
                    class="btn btn-info waves-effect waves-light" id="pagar">
                    حفظ
                  </a>

                </div>


              </div>
            </div>
          </div>
        </div>



      </div>

      <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" style="display: none">
        <div class="modal-dialog modal-lg" style="width: 100%">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                x
              </button>
              <div class="col-md-8">
                <h4 class="modal-title" id="myLargeModalLabel">المنتجات</h4>
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

                      <th>المنتج</th>


                      <th>الحاله</th>
                      <th>المواصفات والطراز</th>

                      <th>المخزن</th>

                      <th>الكميه الوارده</th>
                      <th>اضافه</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="index in count" :key="index">

                      <td>

                        <!-- <input type="number" v-model="product[index]" class="form-control input_cantidad"
                          onkeypress="return valida(event)" /> -->
                        <div id="factura_producto" class="input_nombre">
                          <select v-model="product[index]" name="type" id="type" class="form-control" required>
                            <option v-for="(product, sindex) in products" :key="sindex" v-bind:value="product.id">
                              {{ product.text }}
                            </option>
                          </select>
                        </div>


                      </td>

                      <td>
                        <div id="factura_producto" class="input_nombre">
                          <select v-model="status[index]" name="type" id="type" class="form-control" required>
                            <option v-for="status in statuses" v-bind:value="status.id" value="">
                              {{ status.name }}
                            </option>
                          </select>
                        </div>
                      </td>
                      <td>
                        <input type="text" v-model="desc[index]" id="desc" class="form-control"
                          onkeypress="return valida(event)" />
                      </td>
                      <td>

                        <!-- <input type="number" v-model="store[index]" class="form-control input_cantidad"
                          onkeypress="return valida(event)" /> -->

                        <div id="factura_producto" class="input_nombre">
                          <select v-model="store[index]" name="type" id="type" class="form-control" required>
                            <option v-for="store in stores" v-bind:value="store.id" value="">
                              {{ store.text }}
                            </option>
                          </select>
                        </div>



                      </td>

                      <td>
                        <input type="number" v-model="qty[index]" id="qty" class="form-control input_cantidad"
                          onkeypress="return valida(event)" />
                      </td>


                      <td v-if="index == 1">

                        <button class="tn btn-info btn-sm waves-effect btn-agregar" v-on:click="addComponent(count)">
                          <i class="fa fa-plus-circle"></i></button>

                        <button class="tn btn-info btn-sm waves-effect btn-agregar" v-on:click="disComponent(count)">
                          <i class="fa fa-minus-circle"></i></button>




                        <!-- <input @change="
                          add_one_supply(
                            index,
                            product.id,
                            qty[index],
                            desc[index],
                            product.name,
                            storeselected[index],
                            statusselected[index],
                            product
                          )
                        " type="checkbox" v-model="check_state[index]" class="btn btn-info waves-effect" /> -->
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <a href="javascript:void" @click="Add_new()" class="btn btn-success"><span>تاكيد العمليه</span></a>
            </div>

            <pagination align="center" :data="products" @pagination-change-page="list"></pagination>
          </div>
          <!-- /.modal-content -->
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
              <button type="button" class="btn btn-success" id="confirmar_vaciar" style="font-size: 12pt"
                @click="delete_temporale">
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
import operation from '../../../../js/operation.js';
export default {
  components: {
    pagination,
  },
  mixins: [operation],
  data() {

    return {


      // count: 1,
      // counts: {},
      // intostore: [],
      // intostore_id: [],
      // product_name: [],
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
      // status: [],
      // store: [],
      // return_qty: [],
      // detail: '',
      // date: new Date().toISOString().substr(0, 10),
      // customer: [],
      // supplier: [],
      // suppliers: '',
      // customers: '',
      // type_refresh: '',
      remove: false,
      text_message: '',
      // type: '',
      total_quantity: 0,
      grand_total: 0,
      sub_total: 0,
      To_pay: 0,
      discount: 0,
      total_tax: 0,
      temporale: 1,
      type_payment: 0,
      Way_to_pay_selected: 1,
      show: false,
      paid: 0,
      remaining: 0,
      note: '',
      not_qty: true,
      seen: false,

      id: '',

    }
    // return data;
  },
  mounted() {

    // jtree.muhib();
    this.list();
    this.counts[0] = 1;
    this.type = 'Supply';
    this.type_refresh = 'increment';

  },

  methods: {

    show_modal(id) {
      $("#vaciar1").val(id);
    },
    addsupplier(event) {
      event.preventDefault();
      let currentObj = this;
      const config = {
        headers: {
          "content-type": "multipart/form-data",
        },
      };
      // form data
      let formData = new FormData();

      formData.append("name", this.name);
      formData.append("phone", this.phone);
      formData.append("email", this.email);
      formData.append("address", this.address);
      formData.append("last_name", this.last_name);
      formData.append("status", this.status);

      // send upload request
      this.axios
        .post("store_supplier", formData, config)
        .then(function (response) {
          currentObj.success = response.data.success;
          currentObj.filename = "";

          event.preventDefault();
          toastMessage("تم الاضافه بنجاح");
        })
        .catch(function (error) {
          currentObj.output = error;
        });

      this.$router.go(-1);
    },

    get_search() {
      // alert(typeof(this.word_search));
      // alert(this.word_search);
      this.axios
        .post(`/supply/newsupplysearch`, { word_search: this.word_search })
        .then(({ data }) => {
          console.log(data.products);
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
      this.axios
        .post(`/supply/newsupply?page=${page}`)
        .then(({ data }) => {
          console.log(data);

          this.temporale = data.temporales;

          this.temporale.forEach((item) => {
            this.total_quantity = item.tem_qty + this.total_quantity;
          });

          // this.products = data.products;
          this.suppliers = data.suppliers;

          // this.stores = data.stores;
          // this.statuses = data.statuses;

          console.log(this.stores);

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
th,
td {
  text-align: center;
}
</style> 


