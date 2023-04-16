<template>
  <div>
    <!-- row opened -->

    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <!-- <form method="post" @submit.prevent="submitForm"> -->
          <form method="post" >
            <div class="card-header pb-0">
              <div class="d-flex justify-content-between">
                <span class="h2"> اضافه تحويل مخزني</span>
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
                              {{
                                Math.round(((data_product.quantity / data_product.rate) -
                                  parseInt(data_product.quantity / data_product.rate)) * data_product.rate)
                              }}{{
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
                                        <div id="factura_producto" class="input_nombre">





                                            <select :id="'select_unit' + index" v-model="unit[index]" name="type"
                                                class="form-control" required>

                                                <option v-for="unit in data_product.units"
                                                    v-bind:value="[unit.id, unit.rate, unit.unit_type]">
                                                    {{ unit.name }}
                                                </option>
                                            </select>





                                        </div>
                                    </td>
                      <td>
                        <input @change="
                          add_one_transfer(
                            index,
                            data_product.product_id,
                            qty[index],
                            data_product.desc,
                            data_product.status_id,
                            data_product.store_id,
                            unit[index],
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
      </div>
      <!--/div-->
    </div>
  </div>
  <!-- /row -->
</template>
<script>


import operation from '../../../../../js/operation.js';
import tree from '../../../../../js/tree/tree.js';
export default {
  mixins: [
    operation,
    tree
  ],
  data() {
    return {
      index: 0,
     
      intostore: [],
      intostore_id: [],
      transfer_details: "",
      transfer_id: "",
      transfer_date: "",
      selectproduct: "",
      // detail: "",
      data_product_wait: "",



    };
  },

  mounted() {
    this.type_of_tree = 1;
    this.type = 'Transfer';
    this.showtree('product');
    this.showtree('store');
    this.get_transfer();



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
    //       this.detail = responce.data.products;

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
      product,
      qty = 0,
      desc = 0,
      status= 0,
      store= 0,
      unit,

    ) {








      if (this.check_state[index] == true) {


        if (qty != 0) {


          // if (qty <= qty_avilable) {


          this.intostore[index] = $(`#Transfer_store_tree${index}`).val();
          this.intostore_id[index] = $(`#Transfer_store_tree_id${index}`).val();
          this.counts[index] = index;
          this.product[index] = product;
          this.qty[index] = qty;
          this.desc[index] = desc;
          this.store[index] = store;
          this.status[index] = status;
          this.unit[index] = unit;


                        
                   
            
     
                        

          // }
        }

      } else if (this.check_state[index] == false) {

        this.$delete(this.counts, index);
       


      }

      console.log(this.counts, index);
      console.log(this.product, index);
      console.log(this.qty, index);
      console.log(this.desc, index);
      console.log(this.unit, index);
      console.log(this.store, index);
      console.log(this.status, index);

    },

    addTransfer() {

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
          unit_id: this.unit,
          status_id: this.status,
          intostore: this.intostore,
          intostore_id: this.intostore_id,
          old: this.detail,
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


<!-- 

  -نوع الموظف (مدير-موظف)
  -نوع التعاقد(دوام كامل-نصدوام )
  -  عدد ايام الاجازه
  - طريقه دفع الراتب
  -نوع التحضير 
  -بيانات العقد
  -اجمالي الراتب وصافي الراتب
  -

 -->
<!--  الهيكل الاداري للموظقين -->
<!-- https://www.youtube.com/watch?v=7mgiW-Fe_7w&list=PLMYF6NkLrdN8V2JKIMxqMsZNPsgUj3WOK&index=44  -->
<!-- https://www.youtube.com/watch?v=wsV4uBAmdj8 -->
<!-- https://www.youtube.com/watch?v=qzH-1l51Gyk  -->

<!-- https://www.youtube.com/watch?v=QQstEwvkzK4&list=PL3LzdsN_338DfbpVpyYAsz6nYxX-F6yZq   قوائم نظام شؤون الموظفين والرواتب مع التقارير والترحيل إلى الحسابات في برنامج الحناوي  -->

<!--   https://www.youtube.com/watch?v=Us0N3jCQAfQ   برنامج شئون الموظفين مع اضافة السلف 111 -->
<!-- https://www.youtube.com/watch?v=vRHsByfOKxc    برنامج محاسبة شئون الموظفين الموارد البشرية اصدار 2.0 _ برنامج ادارة الموارد البشرية | AccFlexERP  -->
<!-- https://www.youtube.com/watch?v=fwgqqkY5fxE  @hinawisoftware تسلسل إجراءات الإجازات في نظام شؤون الموظفين واالرواتب في برنامج الحناوي  -->
<!-- https://www.youtube.com/watch?v=nwOcvvmZJsk  شرح تسلسل اجراءات شؤون الموظفين والرواتب في برنامج الحناوي - عربي  -->
<!-- https://www.youtube.com/watch?v=HtWla12Qd38 111 شرح عملية التوظيف في نظام شئون الموظفين  -->
<!-- https://www.youtube.com/watch?v=qdHMrZGG-MQ 111 مكتب MaktApp - نظام إدارة المهام وفرق العمل (لمحة سريعة)  -->
<!-- https://www.youtube.com/watch?v=-WundYvoSGM 111 @hinawisoftware تسلسل إجراءات الغياب في نظام شؤون الموظفين والرواتب في برنامج الحناوي  -->
<!-- https://www.youtube.com/watch?v=Hw9zMHoxebc  @hinawisoftware قائمة كشف الدوام في نظام شؤون الموظفين في برنامج الحناوي  -->
<!-- https://www.youtube.com/watch?v=RNs8wCXAb7o  شؤون الموظفين نظام برواكتف - الموظفين  -->
<!-- https://www.youtube.com/watch?v=CLV-sZcGzi4 111 نظام مداد: شؤون الموظفين (تسجيل موظف جديد) HD  -->
<!-- https://www.youtube.com/watch?v=bhJRQgsp-48    تعرف على مزايا قيود - الأصول الثابتة 💻  -->
<!-- https://www.youtube.com/watch?v=osbIT4xRaxI   شرح نظام الأصول الثابتة ضمن برنامج المنارة للمحاسبة والمستودعات  -->