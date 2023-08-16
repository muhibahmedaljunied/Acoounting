<template>
  <div class="container-fluid">
    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header">

            <span style="font-size: x-large"> تقرير حركه الاصناف </span>

          </div>
          <div class="card-body">
            <div class="card-box">
              <div class="invoice-box">

                <h4>اختر التقرير</h4>


                <div class="row">


                  <div class="col-sm-10">
                    <form>
                      <div v-for="(typee, index) in types" style="display: inline-flex;">
                        <input v-model="typeselected[index]" @change='onreportchange()' type="checkbox"
                          value=''>&nbsp;&nbsp;
                        <label class="checkbox-inline">{{ types[index] }}</label>

                        <!-- &nbsp;&nbsp;&nbsp;&nbsp; -->

                      </div>
                    </form>
                  </div>

                  <div class="col-sm-2">
                    <a @click="Search()" class="tn btn-info btn-sm waves-effect btn-agregar" data-toggle="modal"
                      id="agregar_productos" data-target=".bs-example-modal-sm">
                      <i class="fa fa-search"></i></a>
                    <a @click="printDiv('printme')" class="tn btn-info btn-sm waves-effect btn-agregar"
                      data-toggle="modal" id="agregar_productos" data-target=".bs-example-modal-sm">
                      <i class="fa fa-print"></i></a>
                  </div>



                </div>

                <hr>
                <div class="row">


                  <div class="col-md-5">
                    <label for="desde">من <code>X</code> تاريخ</label>
                    <input type="date" class="form-control hasDatepicker" id="modal_reporte_venta_inicio"
                      name="modal_reporte_venta_inicio" v-model="from_date" onkeypress="return controltag(event)"
                      style="background-color: white" />
                  </div>
                  <div class="col-md-5">
                    <label for="hasta">الي <code>X</code> تاريخ</label>
                    <input type="date" class="form-control hasDatepicker" id="modal_reporte_venta_final"
                      name="modal_reporte_venta_final" v-model="to_date" onkeypress="return controltag(event)"
                      style="background-color: white" />
                  </div>
                  <div class="col-md-2" v-show="showunit">
                    <label for="status">الوحده</label>
                    <select v-model="unitselected" name="status" id="status" class="form-control">


                      <option v-for="units in unit" v-bind:value="[units.id, units.name]">
                        {{ units.name }}
                      </option>

                    </select>
                  </div>

                </div>
                <hr>
                <div class="row">
                  <div class="col-md-2" v-show="showoperation">
                    <label for="status"> نوع العمليه</label>
                    <select v-model="moveselected" class="form-control">
                      <option v-bind:value="1">كل العمليات</option>
                      <option v-bind:value="2">صرف</option>
                      <option v-bind:value="3">توريد</option>
                      <option v-bind:value="4">مرتجع صرف</option>
                      <option v-bind:value="5">مرتجع توريد</option>
                      <option v-bind:value="6"> بيع</option>
                      <option v-bind:value="7">شراء</option>
                      <option v-bind:value="8">مرتجع بيع</option>
                      <option v-bind:value="9">مرتجع شراء</option>

                    </select>
                  </div>

                  <div class="col-md-3" v-show="showstore">
                    <label for="status">المخزن</label>


                    <div class="custom-search">
                      <input :id="'Movement_store_tree' + index" type="text" readonly class="custom-search-input">
                      <input :id="'Movement_store_tree_id' + index" type="hidden" readonly class="custom-search-input">
                      <button @click="detect_index_store(index)" class="custom-search-botton" type="submit"
                        data-toggle="modal" data-target="#exampleModalStore"> <i class="fa fa-plus-circle"></i></button>
                    </div>
                  </div>

                  <div class="col-md-3" v-show="showproduct">
                    <label for="status">المنتج</label>

                    <div class="custom-search">

                      <input :id="'Movement_product_tree' + index" type="text" readonly class="custom-search-input">
                      <input :id="'Movement_product_tree_id' + index" type="hidden" readonly class="custom-search-input">

                      <button @click="detect_index(index)" class="custom-search-botton" type="submit" data-toggle="modal"
                        data-target="#exampleModalProduct"> <i class="fa fa-plus-circle"></i></button>
                    </div>
                  </div>
                  <div class="col-md-2" v-show="showstatus">
                    <label for="status">حاله المنتج</label>
                    <select v-model="statusselected" name="status" id="status" class="form-control">


                      <option v-for="statuses in status" v-bind:value="[statuses.id, statuses.name]">
                        {{ statuses.name }}
                      </option>

                    </select>
                  </div>

                  <div class="col-md-2" v-show="showdesc">
                    <label for="status">المواصفات والطراز </label>
                    <input type="text" v-model="descselected" class="form-control input_cantidad"
                      onkeypress="return valida(event)" />
                  </div>


                </div>

                <!-- <div class='row'>
                                          
                      <div class="col-md-2">
                        <a @click="Search()" class="tn btn-info btn-sm waves-effect btn-agregar" data-toggle="modal"
                          id="agregar_productos" data-target=".bs-example-modal-sm">
                          <i class="fa fa-search"></i></a>
                        <a @click="printDiv('printme')" class="tn btn-info btn-sm waves-effect btn-agregar"
                          data-toggle="modal" id="agregar_productos" data-target=".bs-example-modal-sm">
                          <i class="fa fa-print"></i></a>




                      </div>
                    </div> -->



              </div>

            </div>

            <div class="row" id="printme">
              <div class="col-sm-12">
                <div class="card-box">

                  <div class="invoice-box">
                    <!-- --------------------------------------------------------------------------------------------------------------------------------- -->
                    <table>
                      <thead>
                        <tr style="text-indent: 2em">
                          <td v-if="productselected != 0">
                            <h5>
                              المنتج :
                              <span>{{ productselectedname }}</span>
                            </h5>
                          </td>
                          <td v-if="moveselected != 0">
                            <h5>
                              نوع العمليه :
                              <span>{{ movement_of_type_operation[moveselected] }}</span>
                            </h5>
                          </td>
                          <td v-if="statusselected != 0">
                            <h5>
                              الحاله : <span>{{ statusselected[1] }}</span>
                            </h5>
                          </td>
                          <td v-if="storeselected != 0">
                            <h5>
                              المخزن :
                              <span>{{ storeselectedname }} </span>
                            </h5>
                          </td>
                          <td v-if="unitselected != 0">
                            <h5>
                              الوحده :
                              <span>{{ unitselected[1] }} </span>
                            </h5>
                          </td>
                          <td v-if="descselected != 0">
                            <h5>
                              المواصفات والطراز :
                              <span>{{ descselected }} </span>
                            </h5>
                          </td>
                          <td>
                            <span> من تاريخ {{ from_date }}</span>
                            <span> الي
                              تاريخ{{
                                to_date
                              }}</span>
                          </td>

                        </tr>

                      </thead>
                    </table>
                    <!-- --------------------------------------------------------------------------------------------------------------------------------- -->



                    <table class="table table-bordered text-right" style="width: 100%; font-size: large">
                      <thead>
                        <tr class="heading" style="font-size: 10pt">
                          <!-- <td>#</td> -->

                          <td v-if="productselected == 0">المنتج</td>
                          <td v-if="moveselected == 0">نوع العمليه</td>

                          <td v-if="storeselected == 0">المخزن</td>
                          <td v-if="statusselected == 0">الحاله</td>
                          <!-- <td v-if="unitselected == 0">الوحده</td> -->
                          <td v-if="descselected == 0">الطراز والمواصفات</td>

                          <td>الكميه</td>
                          <td>التاريخ</td>
                        </tr>
                      </thead>
                      <tbody v-if="report && report.data.length > 0">
                        <tr class="item" v-for="datas in report.data">
                          <!-- <td>{{ datas.id }}</td> -->
                          <td v-if="productselected == 0">
                            {{ datas.product }}
                          </td>
                          <!-- <td>
  
</td> -->
                          <div v-if="moveselected == 0">
                            <td v-if="datas.type_operation == 'Supply'">
                              توريد
                            </td>
                            <td v-if="datas.type_operation == 'Purchase'">
                              شراء
                            </td>
                            <td v-if="datas.type_operation == 'Sale'">
                              بيع
                            </td>
                            <td v-if="datas.type_operation == 'Cash'">صرف</td>
                            <td v-if="datas.type_operation == 'Transfer'">تحويل</td>
                            <td v-if="datas.type_operation == 'SupplyReturn'">
                              مرتجع توريد
                            </td>
                            <td v-if="datas.type_operation == 'CashReturn'">
                              مرتجع صرف
                            </td>
                            <td v-if="datas.type_operation == 'SaleReturn'">
                              مرتجع بيع
                            </td>
                            <td v-if="datas.type_operation == 'PurchaseReturn'">
                              مرتجع شراء
                            </td>



                          </div>
                          <td v-if="storeselected == 0">{{ datas.store }}</td>
                          <td v-if="statusselected == 0">{{ datas.status }}</td>
                          <!-- <td v-if="unitselected == 0">{{ datas.unit }}</td> -->
                          <td v-if="descselected == 0">{{ datas.desc }}</td>

                          <td>{{ datas.qty_stock }}{{ datas.unit }}</td>
                          <td>{{ datas.date }}</td>
                        </tr>
                      </tbody>
                      <tbody v-else>
                        <td align="center" colspan="7">
                          <h4>لايوجد بيانات بالشروط التي اخترتها</h4>
                        </td>
                      </tbody>
                    </table>
                    <!-- <div id="intro" style="text-align: left">

                      <h3>امين المخازن:{{ user }}</h3>
                      <h5>{{ timestamp }}</h5>
                    </div> -->
                  </div>

                </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <div id="intro" style="text-align: left">

              <h3>امين المخازن:{{ user }}</h3>
              <h5>{{ timestamp }}</h5>
            </div>
          </div>

        </div>
      </div>
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
</template>


<script>
import tree from '../../../../js/tree/tree.js';
import ReportOperation from '../../../../js/ReportOperation.js';
export default {
  mixins: [tree, ReportOperation],
  data() {
    return {

      all_products: '',
   
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

      name_of_report: 'تقرير حركه الاصناف',
      type: '',
      type_of_tree: 1,
      jsonTreeData: '',
      supplier: "yes",
      product: "",
      store: "",
      status: "",
      user: "",
      unit: '',
      types: [
        'حسب المخزن',
        'حسب المنتج',
        'حسب حاله المنتج',
        'حسب المواصفات والطراز',
        'حسب نوع العمليه',
        'حسب الوحده',
      ],
      movement_of_type_operation: [
        '',
        ' كل العمليات',
        ' صرف',
        ' توريد',
        ' مرتجع صرف',
        ' مرتجع توريد',
        '   بيع',
        ' شراء',
        ' مرتجع بيع',
        ' مرتجع شراء',



      ],
      timestamp: '',
      index: 1,




      // type_report: 0,
      // from_date: "2021-11-24",
      // to_date: new Date().toISOString().substr(0, 10),


      report: {
        data: "",
      },

      default: 100,
    };
  },
  created() {
    // this.$router.go(0);
    setInterval(this.getNow, 1000);
  },
  mounted() {
    this.type = 'Movement';
    this.showtree('product');
    this.showtree('store');
    this.axios.post("/Reposupply").then((response) => {


      this.status = response.data.status;
      this.unit = response.data.unit;
      this.user = response.data.users.name;
    });
  },

  methods: {
    getNow: function () {
      const today = new Date();
      const date =
        today.getFullYear() +
        "-" +
        (today.getMonth() + 1) +
        "-" +
        today.getDate();
      const time =
        today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
      const dateTime = date + " " + time;
      this.timestamp = dateTime;
    },


    onreportchange() {

      (this.typeselected[0] == true) ? this.showstore = true : this.showstore = false;
      (this.typeselected[1] == true) ? this.showproduct = true : this.showproduct = false;
      (this.typeselected[2] == true) ? this.showstatus = true : this.showstatus = false;
      (this.typeselected[3] == true) ? this.showdesc = true : this.showdesc = false;
      (this.typeselected[4] == true) ? this.showoperation = true : this.showoperation = false;
      (this.typeselected[5] == true) ? this.showunit = true : this.showunit = false;



    },

    Search() {
      this.axios
        .post(`/repo_movement`, {
          type_operation: this.moveselected,
          store_id: this.storeselected,
          product_id: this.productselected,
          status_id: this.statusselected,
          unit_id: this.unitselected,
          desc: this.descselected,
          from_date: this.from_date,
          to_date: this.to_date,
        })
        .then((response) => {
          console.log(response.data);
          this.report.data = response.data.repomovement;
        });
    },
    printDiv(printme) {

      report_style(printme, '');

    },
  },
};
</script>

<!-- <style scoped>
.card-header {

  background-color: #00b9ff;
}
</style> -->






