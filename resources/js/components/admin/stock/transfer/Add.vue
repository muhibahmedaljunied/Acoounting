<template>
  <div>
    <!-- row opened -->

    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <!-- <form method="post" @submit.prevent="submitForm"> -->
          <form method="post">
            <div class="card-header pb-0">
              <div class="d-flex justify-content-between">
                <span class="h2">  تحويل مخزني</span>
              </div>
            </div>
            <div class="card-body" id="printme">
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <div class="row">
                   

                      <div class="col-md-3">
                        <label for="desde"> المخزن</label>

                        <div class="custom-search">
                          <!-- <input id='product_tree' type="text" class="custom-search-input" readonly> -->

                          <input :id="'Transfer_store_tree'" type="text" readonly class="custom-search-input" />
                          <input :id="'Transfer_store_tree_id'" type="hidden" readonly class="custom-search-input" />

                          <button class="custom-search-botton" type="button" data-toggle="modal"
                            data-target="#exampleModalStore">
                            <i class="fa fa-plus-circle"></i>
                          </button>
                        </div>
                      </div>


                      <div class="col-md-3">
                        <label for="desde"> المخزن المحول اليه</label>

                        <div class="custom-search">
                          <!-- <input id='product_tree' type="text" class="custom-search-input" readonly> -->

                          <input :id="'Transfer_intostore_tree'" type="text" readonly class="custom-search-input" />
                          <input :id="'Transfer_intostore_tree_id'" type="hidden" readonly class="custom-search-input" />

                          <button class="custom-search-botton" type="button" data-toggle="modal"
                            data-target="#exampleModalIntoStore">
                            <i class="fa fa-plus-circle"></i>
                          </button>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <label for="desde">تاريخ التحويل </label>
                        <input style="background-color: beige;" type="date" class="form-control hasDatepicker"
                          id="modal_reporte_venta_inicio" name="modal_reporte_venta_inicio" v-model="date"
                          onkeypress="return controltag(event)" />
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="table-responsive">
                <table class="table table-bordered text-center">
                  <thead>
                    <tr>
                      <th>#</th>
                      <!-- <th class="wd-15p border-bottom-0">رقم الحساب</th> -->
                      <th class="wd-15p border-bottom-0" rowspan="">
                        اسم المنتج
                      </th>
                      <th class="wd-15p border-bottom-0" rowspan="">الحاله</th>
                      <th class="wd-15p border-bottom-0" rowspan="">الطراز</th>
                      <th class="wd-15p border-bottom-0" rowspan="">
                        الكميه المتوفره
                      </th>
                      <th class="wd-15p border-bottom-0" colspan="">المخزن</th>

                      <!-- <th class="wd-15p border-bottom-0" colspan="">الي</th> -->
                      <th class="wd-15p border-bottom-0" rowspan="">
                        الكميه المحوله
                      </th>
                      <th class="wd-15p border-bottom-0" colspan="">الوحده</th>

                      <th>اضافه</th>
                      <!-- <th>+</th> -->
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(data_product, index) in detail" :key="index">
                      <td>{{ index + 1 }}</td>
                      <td>
                        <div id="factura_producto" class="input_nombre">
                          {{ data_product.product
                          }}
                          <!-- <input type="hidden" v-model="data_product.product_id" id="id" /> -->
                        </div>
                      </td>

                      <td>
                        <div id="factura_producto" class="input_nombre">
                          {{ data_product.status
                          }}
                          <!-- <input type="hidden" v-model="data_product.status_id" id="id" /> -->
                        </div>
                      </td>
                      <td>
                        <div id="factura_producto" class="input_nombre">
                          {{ data_product.desc
                          }}
                          <!-- <input type="hidden" v-model="data_product.desc" id="id" /> -->
                        </div>
                      </td>
                      <td>
                        <div v-for="temx in data_product.units">
                          <span v-if="temx.unit_type == 1">
                            <span v-if="parseInt(
                              data_product.quantity / data_product.rate
                            ) != 0
                              ">
                              {{
                                parseInt(
                                  data_product.quantity / data_product.rate
                                )
                              }}
                              {{ temx.name }}
                            </span>
                          </span>
                          <span v-if="temx.unit_type == 0">
                            <span v-if="Math.round(
                              (data_product.quantity / data_product.rate -
                                parseInt(
                                  data_product.quantity / data_product.rate
                                )) *
                              data_product.rate
                            ) != 0
                              ">
                              و
                              {{
                                Math.round(
                                  (data_product.quantity / data_product.rate -
                                    parseInt(
                                      data_product.quantity / data_product.rate
                                    )) *
                                  data_product.rate
                                )
                              }}{{ temx.name }}
                            </span>
                          </span>
                        </div>
                      </td>
                      <td>
                        <div id="factura_producto" class="input_nombre">
                          {{ data_product.store
                          }}
                          <!-- <input type="hidden" v-model="data_product.store_id" id="id" /> -->
                        </div>
                      </td>
                   

                      <td>
                        <input style="background-color: beige;" v-model="data_product.qty_transfer" type="number"
                          class="form-control input_cantidad" onkeypress="return valida(event)" />
                      </td>

                      <td>
                        <div id="factura_producto" class="input_nombre">
                          <select style="background-color: beige;" :id="'select_unit' + index"
                            v-model="data_product.unit_selected" name="type" class="form-control" required>
                            <option v-for="unit in data_product.units" v-bind:value="[
                              unit.id,
                              unit.rate,
                              unit.unit_type,
                            ]">
                              {{ unit.name }}
                            </option>
                          </select>
                        </div>
                      </td>
                      <td>
                        <input @change="
                          add_one_transfer(
                            index,
                            data_product.qty_transfer,
                            data_product.quantity,
                            data_product.unit_selected
                        
                          )
                          " type="checkbox" v-model="check_state[index]" class="btn btn-info waves-effect" />
                      </td>
                   
                    </tr>
                  </tbody>
                </table>
                <button @click="addTransfer()" type="button" class="tn btn-info btn-lg waves-effect btn-agregar">
                  تحويل
                </button>
              </div>
            </div>
          </form>
          <!-- </form> -->
        </div>
        <div class="modal fade" id="exampleModalProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
          aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="well" id="treeview_json_product"></div>
              </div>
            </div>
          </div>
        </div>

        <div class="modal fade" id="exampleModalStore" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
          aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="well" id="treeview_json_store"></div>
              </div>
            </div>
          </div>
        </div>

        <div class="modal fade" id="exampleModalIntoStore" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
          aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="well" id="treeview_json_intostore"></div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

</template>
<script>
import operation from "../../../../../js/operation.js";
import tree from "../../../../../js/tree/tree.js";
export default {
  mixins: [operation, tree],
  data() {
    return {
      product_one: '',
      store_one: '',
      product: [],
      qty: [],
      unit: [],
      desc: [],
      store: [],
      status: [],
      counts: {},
      count: 1,
      date: new Date().toISOString().substr(0, 10),
      dateselected: new Date().toISOString().substr(0, 10),
      expiry_date: new Date().toISOString().substr(0, 10),
      table: '',
      type: '',
      type_refresh: '',
      note: "",
      detail: '',
      Total_quantity: 0,
      total_quantity: 0,
      check_state: [],


      products: '',
      stores: '',
      statuses: '',
      stores: '',
      statuses: '',
      units: '',
      opening: '',
      availabe_qty: [],
      word_search: '',
      total: [],


      seen: false,
      id: '',
      // --------------------------------------------
      all_products: '',
      jsonTreeData: '',
      type_of_tree: 1,
      indexselected: '',
      indexselectedproduct: '',
      indexselectedstore: '',
      last_nodes: '',
      rank: 1,
      parent: 0,
      index: 0,

      statusselected: 0,
      unitselected: 0,
      unitselectedname: '',
      productselected: 0,
      productselectedname: "",
      storeselectedname: "",
      storeselected: 0,
      descselected: "",
      operationselected: 0,
      dateselected: 0,
      typeselected: [],
      checkselected: '',
      moveselected: 0,


      type: "",
      intostore: 0,
      intostore_id: 0,

      fromstore: 0,
      fromstore_id: 0,


      quantity: [],
      transfer_details: "",
      transfer_id: "",
      transfer_date: "",
      selectproduct: "",
      data_product_wait: "",
    };
  },

  mounted() {

    this.type_of_tree = 1;
    this.type = "Transfer";
    this.showtree("product");
    this.showtree("intostore");
    this.showtree("store");
    this.get_transfer();
  },
  methods: {

    get_transfer() {
      let uri = `/transfer_before`;
      this.axios
        .post(uri)
        .then((responce) => {
          this.transfer_details = responce.data.transfer_details;
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },

    add_one_transfer(
      index,
      qty,
      quantity,
      unit
    ) {

      var result;

      if (this.check_state[index] == true) {

        result = this.check_qty(qty, unit, quantity);
        if (result == 0) { return 0; }

        // if (qty != 0) {
        // if (qty <= qty_avilable) {

        this.counts[index] = index;
        this.qty[index] = qty;
        this.unit[index] = unit;


        // }
        // }
      } else if (this.check_state[index] == false) {
        this.$delete(this.counts, index);
      }
      console.log(this.counts, index);
      console.log(this.unit, index);
      console.log(this.qty, index);

    },

    check_qty(qty, unit, availabe_qty) {

      var producter_qty = 0;

      if (unit[2] == 1) {

        producter_qty = qty * unit[1];
      } else {

        producter_qty = qty;
      }

      if (producter_qty > availabe_qty || qty == 0) {

        toastMessage('فشل', "تأكد من الكميه المحوله", 'error');
        return 0;

      }

      return 1;
    },
    addTransfer() {



      if ($(`#Transfer_store_tree`).val() == $(`#Transfer_intostore_tree`).val()) {

        toastMessage('فشل', "لايمكن التحويل الي نفس المخزن ", 'error');

      }

      if (!$(`#Transfer_intostore_tree`).val()) {

        toastMessage('فشل', "لم يتم تحديد المخزن المحول اليه ", 'error');

      }



      this.axios
        .post("store_transfer", {
 
          type: this.type,
          date: this.date,
          count: this.counts,
          qty_transfer: this.qty,
          unit: this.unit,
          units: this.units,
          intostore: this.intostore,
          intostore_id: this.intostore_id,
          fromstore: this.fromstore,
          fromstore_id: this.fromstore_id,
          old: this.detail,
        })
        .then(function (response) {
          console.log(response);
          if (response.data.message != 0) {
            toastMessage("تم التحويل بنجاح");
            this.$router.go(0);
          } else {
            toastMessage("فشل", response.data.text);
          }

          this.data_product_wait = response.data.temporale;

          currentObj.success = response.data.success;
          currentObj.filename = "";
        })
        .catch(function (error) {
          currentObj.output = error;
        });

      // this.$router.go(-1);
    },
  },
};
</script>

