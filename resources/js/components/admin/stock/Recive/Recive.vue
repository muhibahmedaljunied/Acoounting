<template>
    <div>
      <!-- row opened -->
  
      <div class="row row-sm">
        <div class="col-xl-12">
          <div class="card">
            <!-- <form method="post" @submit.prevent="submitForm"> -->
            <form method="post" @submit.prevent="addTransfer">
              <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                  <span class="h2">  استلام مخزني</span>
                </div>
              </div>
              <div class="card-body" id="printme">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-4">
                          <label for="desde"> اسم المنتج</label>
  
                          <div class="custom-search">
  
                            <!-- <input id='product_tree' type="text" class="custom-search-input" readonly> -->
  
                            <input :id="'Transfer_product_tree' + index" type="text" readonly class="custom-search-input">
                            <input :id="'Transfer_product_tree_id' + index" type="hidden" readonly
                              class="custom-search-input">
  
                            <button class="custom-search-botton" type="button" data-toggle="modal"
                              @click="detect_index(index)" data-target="#exampleModalProduct"> <i
                                class="fa fa-plus-circle"></i></button>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <label for="desde">تاريخ التحويل </label>
                          <input type="date" class="form-control hasDatepicker" id="modal_reporte_venta_inicio"
                            name="modal_reporte_venta_inicio" v-model="date" onkeypress="return controltag(event)"
                            style="background-color: white" />
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
                        <th class="wd-15p border-bottom-0" rowspan="">الكميه المتوفره</th>
                        <th class="wd-15p border-bottom-0" colspan="">من</th>
  
                        <th class="wd-15p border-bottom-0" colspan="">الي</th>
                        <th class="wd-15p border-bottom-0" rowspan="">الكميه المحوله</th>
                        <th>اضافه</th>
                        <!-- <th>+</th> -->
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(data_product, index) in data_products" :key="index">
                        <td>{{ index + 1 }}</td>
                        <td>
                          <div id="factura_producto" class="input_nombre">
                            {{
                              data_product.product
                            }}<input type="hidden" v-model="data_product.product_id" id="id" />
                          </div>
                        </td>
  
                        <td>
                          <div id="factura_producto" class="input_nombre">
                            {{
                              data_product.status
                            }}<input type="hidden" v-model="data_product.status_id" id="id" />
                          </div>
                        </td>
                        <td>
                          <div id="factura_producto" class="input_nombre">
                            {{
                              data_product.desc
                            }}<input type="hidden" v-model="data_product.desc" id="id" />
                          </div>
                        </td>
                        <td>
                          <div v-for="temx in data_product.units">
  
                            <span v-if="temx.unit_type == 1">
                              <span v-if="parseInt(data_product.quantity / data_product.rate) != 0">
                                {{ parseInt(data_product.quantity / data_product.rate) }} {{ temx.name }}
  
                              </span>
                            </span>
                            <span v-if="temx.unit_type == 0">
                              <span
                                v-if="Math.round(((data_product.quantity / data_product.rate) - parseInt(data_product.quantity / data_product.rate)) * data_product.rate) != 0">
                                و
                                {{ Math.round(((data_product.quantity / data_product.rate) - parseInt(data_product.quantity / data_product.rate)) * data_product.rate) }}{{
                                  temx.name
                                }}
                              </span>
  
                            </span>
                          </div>
                        </td>
                        <td>
                          <div id="factura_producto" class="input_nombre">
                            {{
                              data_product.store
                            }}<input type="hidden" v-model="data_product.store_id" id="id" />
                          </div>
                        </td>
                        <td>
  
  
                          <div class="custom-search">
                            <input :id="'Transfer_store_tree' + index" type="text" readonly class="custom-search-input">
                            <input :id="'Transfer_store_tree_id' + index" type="hidden" readonly
                              class="custom-search-input">
  
                            <button class="custom-search-botton" type="button" data-toggle="modal"
                              data-target="#exampleModalStore" @click="detect_index_store(index)"> <i
                                class="fa fa-plus-circle"></i></button>
                          </div>
                        </td>
  
  
                        <td>
                          <input v-model="qty[index]" type="number" class="form-control input_cantidad"
                            onkeypress="return valida(event)" />
                        </td>
                        <td>
                          <input @change="
                            add_one_transfer(
                              index,
                              data_product.product_id,
                              qty[index],
                              data_product.desc,
                              data_product.product,
                              data_product.status_id,
                              data_product.store_id,
                              total[index]
                              // intostore[index]
                            )
                          " type="checkbox" v-model="check_state[index]" class="btn btn-info waves-effect" />
                        </td>
                        <!-- <td>
                        <button
                          v-on:change="addComponent"
                          class="tn btn-info btn-sm waves-effect btn-agregar"
                        >
                          <i class="fa fa-plus-circle"></i>
                        </button>
                      </td> -->
                      </tr>
                    </tbody>
                  </table>
                  <button type="submit" class="tn btn-info btn-lg waves-effect btn-agregar">
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
        </div>
        <!--/div-->
      </div>
    </div>
    <!-- /row -->
  </template>
  <script>
  
  
  import operation from '../../../../operation1.js';
  import tree from '../../../../../js/tree/tree.js';
  export default {
    mixins: [
      operation,
      tree
    ],
    data() {
      return {
        index: 0,
        // check_state: [],
        // qty: [],
        // counts: [],
        // date: new Date().toISOString().substr(0, 10),
        // indexselectedproduct: '',
        // indexselectedstore: '',
        // stores: "",
        // store: "",
        // products: "",
        // product: [],
        // desc: [],
        // product_name: [],
        // store: [],
        // status: [],
        // status: "",
        // type: '',
        // type_of_tree: 1,
        // total:[]
        intostore: [],
        intostore_id: [],
        transfer_details: "",
        transfer_id: "",
        transfer_date: "",
        selectproduct: "",
        data_products: "",
        data_product_wait: "",
        
     
       
      };
    },
    // created() {
    //   this.showtree();
  
    // },
    mounted() {
      this.type_of_tree=1;
      this.type = 'Transfer';
      this.showtree('product','tree_product');
      this.showtree('store','tree_store');
      this.get_transfer();
      // this.axios
      //   .post(`/data_for_transfer`)
      //   .then((responce) => {
      //     this.products = responce.data.products;
      //     this.data_product_wait = responce.data.temporale;
      //   })
      //   .catch(({ response }) => {
      //     console.error(response);
      //   });
  
  
    },
    methods: {
      // showtree() {
  
      //   let gf = this;
      //   this.axios.post(`/tree_product`).then((response) => {
      //     this.jsonTreeDataProduct = response.data.trees;
      //     // this.jsonTreeDataProduct = response.data.products;
  
  
  
      //     $('#treeview_json_product').jstree({
      //       core: {
      //         themes: {
      //           responsive: false,
      //         },
  
      //         check_callback: true,
      //         data: this.jsonTreeDataProduct,
      //       },
      //       types: {
      //         default: {
      //           icon: "fa fa-folder text-primary",
      //         },
      //         file: {
      //           icon: "fa fa-file  text-primary",
      //         },
      //       },
      //       checkbox: {
      //         three_state: false,
  
      //       },
      //       state: {
      //         key: "demo2"
      //       },
      //       search: {
      //         case_insensitive: true,
      //         show_only_matches: true
      //       },
      //       plugins: ["checkbox",
  
      //         "dnd",
      //         "massload",
      //         "search",
      //         "sort",
      //         "state",
      //         "types",
      //         "unique",
      //         "wholerow",
      //         "changed",
      //         "conditionalselect"],
  
  
  
  
  
  
      //     }).on("changed.jstree", function (e, data) {
  
      //       console.log(data.node.id);
      //       $(`#product_tree${gf.indexselected}`).val(data.node.text)
      //       $(`#product_tree_id${gf.indexselected}`).val(data.node.id)
  
  
      //       gf.get_product(data.node.id);
  
  
      //     });
  
  
      //   });
  
      //   this.axios.post(`/tree_store`).then((response) => {
      //     this.jsonTreeDataStore = response.data.stores;
  
  
      //     $('#treeview_json_store').jstree({
      //       core: {
      //         themes: {
      //           responsive: false,
      //         },
      //         // so that create works
      //         check_callback: true,
      //         data: this.jsonTreeDataStore,
      //       },
      //       types: {
      //         default: {
      //           icon: "fa fa-folder text-primary",
      //         },
      //         file: {
      //           icon: "fa fa-file  text-primary",
      //         },
      //       },
      //       checkbox: {
      //         three_state: false,
  
      //       },
      //       state: {
      //         key: "demo2"
      //       },
      //       search: {
      //         case_insensitive: true,
      //         show_only_matches: true
      //       },
      //       plugins: ["checkbox",
  
      //         "dnd",
      //         "massload",
      //         "search",
      //         "sort",
      //         "state",
      //         "types",
      //         "unique",
      //         "wholerow",
      //         "changed",
      //         "conditionalselect"],
  
  
  
  
  
  
      //     }).on("changed.jstree", function (e, data) {
  
      //       // console.log(data.node.id);
      //       $(`#indexselectedproduct${gf.indexselected}`).val(data.node.text);
      //       $(`#indexselectedproduct_id${gf.indexselected}`).val(data.node.id);
  
      //       gf.intostore[gf.indexselected] = $(`#indexselectedproduct${gf.indexselected}`).val(data.node.text);
      //       //  modal-title-store
      //       gf.get_store(data.node.id);
  
  
      //     });
  
  
      //   });
      // },
  
      // detect_index(index) {
  
      //   this.indexselectedproduct = index;
      // },
      // detect_index_store(index) {
  
      //   this.indexselectedstore = index;
      // },
      // get_product(id) {
      //   let uri = `/get_product`;
      //   this.axios
      //     .post(uri, { product: id })
      //     .then((responce) => {
      //       this.data_products = responce.data.products;
  
      //       // this.stores = responce.data.stores;
      //     })
      //     .catch(({ response }) => {
      //       console.error(response);
      //     });
      // },
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
        product_id,
        qty = 0,
        desc = 0,
        product_name = 0,
        status_id = 0,
        store_id = 0,
        total=0
  
        // intostore = 0
      ) {
  
  
  
  
  
  
  
  
        if (this.check_state[index] == true) {
  
  
          if (qty != 0) {
  
  
            // if (qty <= qty_avilable) {
  
  
            this.intostore[index] = $(`#Transfer_store_tree${index}`).val();
            this.intostore_id[index] = $(`#Transfer_indexselectedproduct_id${index}`).val();
  
            console.log(this.intostore);
            this.counts[index] = index;
  
            this.product[index] = product_id;
            this.qty[index] = qty;
            this.desc[index] = desc;
            this.product_name[index] = product_name;
  
            this.store[index] = store_id;
            this.status[index] = status_id;
            this.total[index] = total;
            // this.qty_avilable[index] = qty_avilable;
  
            // }
          }
  
        } else if (this.check_state[index] == false) {
          // this.$delete(this.counts, index);
          this.$delete(this.product, index);
          this.$delete(this.qty, index);
          this.$delete(this.counts, index);
          this.$delete(this.product_name, index);
          this.$delete(this.store, index);
          this.$delete(this.status, index);
          this.$delete(this.total, index);
          this.$delete(this.intostore, index);
          this.$delete(this.intostore_id, index);
  
          // this.$delete(this.qty_avilable, index);
  
  
        }
  
      },
  
      addTransfer(e) {
        e.preventDefault();
  
        this.axios
          .post("store_transfer", {
            // counts: this.counts,
            // // transfer_id:this.transfer_id,
            date: this.date,
            count: this.counts,
            product_id: this.product,
            // product_name: this.product_name,
            store_id: this.store,
            desc: this.desc,
            qty: this.qty,
            status_id: this.status,
            intostore: this.intostore,
            intostore_id: this.intostore_id,
            // qty_avilable: this.qty_avilable,
  
  
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
  
 