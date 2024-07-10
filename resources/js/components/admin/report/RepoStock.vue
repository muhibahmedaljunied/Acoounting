<template>
  <div class="container-fluid">
    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header">
            <span style="font-size: x-large"> تقرير المخزون </span>

          </div>
          <div class="card-body">





            <fieldset class="border rounded-3 p-3">

              <div class="row">
                <div class="col-sm-10">
                  <form>
                    <div v-for="(typee, index) in types">
                      <input v-model="typeselected[index]" @change='onreportchange()' type="checkbox"
                        value=''>&nbsp;&nbsp;
                      <label class="checkbox-inline">{{ types[index] }}</label>

                      &nbsp;&nbsp;&nbsp;&nbsp;

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
            </fieldset>

            <fieldset class="border rounded-3 p-3">
              <div class="row">
                <div class="col-md-3" v-show="showproduct">
                  <label for="status">المنتج</label>


                  <div class="custom-search">

                    <input :id="'Stock_product_tree' + index" type="text" readonly class="custom-search-input">
                    <input :id="'Stock_product_tree_id' + index" type="hidden" readonly class="custom-search-input">


                    <button @click="detect_index(index)" class="custom-search-botton" type="submit" data-toggle="modal"
                      data-target="#exampleModalProduct"> <i class="fa fa-plus-circle"></i></button>
                  </div>

                </div>
                <div class="col-md-3" v-show="showstore">
                  <label for="status">المخزن</label>

                  <div class="custom-search">

                    <input :id="'Stock_store_tree' + index" type="text" readonly class="custom-search-input">
                    <input :id="'Stock_store_tree_id' + index" type="hidden" readonly class="custom-search-input">
                    <button @click="detect_index_store(index)" class="custom-search-botton" type="submit"
                      data-toggle="modal" data-target="#exampleModalStore"> <i class="fa fa-plus-circle"></i></button>
                  </div>
                </div>

                <div class="col-md-3" v-show="showstatus">
                  <label for="status"> حاله المنتج </label>
                  <select v-model="statusselected" class="form-control" @change="onreportchange">

                    <option v-for="statuses in status" v-bind:value="[statuses.id, statuses.name]">
                      {{ statuses.name }}
                    </option>

                  </select>
                </div>
                <div class="col-md-3" v-show="showdesc">
                  <label for="status">المواصفات والطراز </label>
                  <input type="text" v-model="descselected" class="form-control input_cantidad"
                    onkeypress="return valida(event)" />
                </div>

                <div class="col-md-3" v-show="showunit">
                  <label for="status"> الوحده </label>
                  <select v-model="unitselected" class="form-control" @change="onreportchange">

                    <option v-for="units in unit" v-bind:value="[units.id, units.name]">
                      {{ units.name }}
                    </option>

                  </select>
                </div>



              </div>
            </fieldset>

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
    </div>

    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header">
            <span style="font-size: x-large"> تقرير المخزون </span>

          </div>
          <div class="card-body">




            <div class="row" id="printme">
              <div class="col-sm-12">
                <div class="card-box">

                  <div class="invoice-box">
                    <!-- --------------------------------------------------------------------------------------------------------------------------------- -->

                    <fieldset class="border rounded-3 p-3">


                      <div class="row">


                        <div class="col-sm-12">

                          <h4 v-if="productselected != 0">
                            <span> المنتج</span> : {{ productselectedname }}
                          </h4>
                        </div>
                        <div class="col-sm-12">
                          <h4 v-if="storeselected != 0"><span> المخزن</span> : {{ storeselectedname }}</h4>
                        </div>
                        <div class="col-sm-12">
                          <h4 v-if="statusselected != 0">
                            <span> حاله المنتج</span>:
                            {{ statusselected[1] }}
                          </h4>
                        </div>
                        <div class="col-sm-12">
                          <h4 v-if="descselected != 0">
                            <span> المواصفات والطراز</span>:
                            {{ descselected }}
                          </h4>

                        </div>


                      </div>




















                    </fieldset>


                    <fieldset class="border rounded-3 p-3">
                  
                      <table class="table table-bordered text-right" style="width: 100%; font-size: large">
                <thead>
                  <tr class="heading" style="font-size: 10px">
                    <!-- <td>#</td> -->

                    <td v-if="productselected == 0">المنتج</td>
                    <!-- <td v-if="moveselected == 1">نوع العمليه</td> -->
                    <td v-if="storeselected == 0">المخزن</td>
                    <td v-if="statusselected == 0">الحاله</td>
                    <td v-if="descselected == 0">الطراز والمواصفات</td>
                    <td>الكميه</td>

                    <!-- <td>التاريخ</td> -->
                  </tr>
                </thead>
                <tbody v-if="report && report.data.length > 0">
                  <tr class="item" v-for="datas in report.data">
                    <!-- <td>{{ datas.id }}</td> -->
                    <td v-if="productselected == 0">
                      {{ datas.product }}
                    </td>

                    <td v-if="storeselected == 0">{{ datas.store }}</td>
                    <td v-if="statusselected == 0">
                      {{ datas.status }}
                    </td>
                    <td v-if="descselected == 0">
                      {{ datas.desc }}
                    </td>

                    <td>
                      <!-- {{ datas.quantity }} {{ datas.unit }} -->


                      <div v-for="temx in datas.units">



                        <span v-if="temx.unit_type == 0">

                          <span v-if="datas.quantity / datas.rate >= 1">
                            {{ Math.round((datas.quantity / datas.rate)) }}{{
                      datas.units[0].name
                    }}
                          </span>

                          <span v-if="datas.quantity % datas.rate >= 1">
                            {{ Math.round((datas.quantity % datas.rate)) }}{{
                      datas.units[1].name
                    }}
                          </span>
                        </span>

                      </div>

                    </td>


                    <!-- <td>{{ datas.date }}</td> -->
                  </tr>
                </tbody>
                <tbody v-else>
                  <td align="center" colspan="7">
                    <h4>لايوجد بيانات بالشروط التي اخترتها</h4>
                  </td>
                </tbody>
              </table>
                    </fieldset>
                    <!-- <div id="intro" style="text-align: left">

                      <h3>امين المخازن:{{ user }}</h3>
                      <h5>{{ timestamp }}</h5>
                    </div> -->
                  </div>

                </div>
              </div>
            </div>

            <!-- -------------------------------------------------- -->



          </div>




          <div class="card-footer">
            <div id="intro" style="text-align: left">

              <h3>امين المخازن:{{ user }}</h3>
              <h5>{{ timestamp }}</h5>
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
    </div>
  </div>


  <!--/div-->


  <!-- container -->
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

      type: '',
      supplier: "yes",
      product: "",
      type_of_tree: 1,
      store: "",
      status: "",
      unit: '',
      types: [
        'حسب المخزن',
        'حسب المنتج',
        'حسب حاله المنتج',
        'حسب المواصفات والطراز',
        // 'حسب نوع العمليه',
        'حسب الوحده',


      ],
      timestamp: '',
      user: '',
      index: 1,

      // user: "",

      // type_report: 0,
      // from_date: "2021-11-24",
      // to_date: "2021-11-24",


      report: {
        data: "",
      },

      default: 100,
    };
  },
  created() {
    setInterval(this.getNow, 1000);

  },
  mounted() {
    // this.$router.go(0);

    this.type = 'Stock';
    this.showtree('product');
    this.showtree('store');

    this.axios.post("/Reposupply").then((response) => {
      this.status = response.data.status;
      this.unit = response.data.unit;
      console.log(response.data.users);
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
      (this.typeselected[4] == true) ? this.showunit = true : this.showunit = false;


    },
    // oninput(){
    //   (this.typeselected[1] == true) ? this.showproduct = true : this.showproduct = false;

    // },

    Search() {
      // alert( this.productselected);
      this.axios
        .post(`/repo_stock`, {
          // type_operation: this.moveselected,
          store_id: this.storeselected,
          product_id: this.productselected,
          status_id: this.statusselected,
          desc: this.descselected,
          unit: this.unitelected,
          // from_date: this.from_date,
          // to_date: this.to_date,
        })
        .then((response) => {
          console.log(response);
          this.report.data = response.data.repostocks;
        });
    },
    printDiv(printme) {

      report_style(printme, 'تقرير المخزون');

    },
  },
  computed: {},
};
</script>


<!-- <style scoped>
h2,
.h2 {
  font-size: 1rem;
}

.card-header {

  background-color: #00b9ff;
}
</style> -->
