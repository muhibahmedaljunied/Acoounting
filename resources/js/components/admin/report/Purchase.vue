<template>
  <div class="container-fluid">
    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
              <span style="font-size: x-large"> تقرير المشتريات </span>

            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-sm-12">
                <div class="card-box">
                  <div class="invoice-box">

                    <div class="row">
                      <p>اختر التقرير</p>&nbsp;&nbsp;
                      <form>
                        <label v-for="(typee, index) in types" class="checkbox-inline">
                          &nbsp; <input v-model="typeselected[index]" @change='onreportchange()' type="checkbox"
                            value=''>&nbsp;&nbsp; {{ types[index] }}
                        </label>&nbsp;&nbsp;&nbsp;&nbsp;


                      </form>
                    </div>


                    <div class="row">


                      <div class="col-md-6">
                        <label for="desde">من <code>X</code> تاريخ</label>
                        <input type="date" class="form-control hasDatepicker" id="modal_reporte_venta_inicio"
                          name="modal_reporte_venta_inicio" v-model="from_date" onkeypress="return controltag(event)"
                          style="background-color: white" />
                      </div>
                      <div class="col-md-6">
                        <label for="hasta">الي <code>X</code> تاريخ</label>
                        <input type="date" class="form-control hasDatepicker" id="modal_reporte_venta_final"
                          name="modal_reporte_venta_final" v-model="to_date" onkeypress="return controltag(event)"
                          style="background-color: white" />
                      </div>

                    </div>
                    <div class="row">
                      <!-- <div class="col-md-2" v-show="showoperation">
                        <label for="status"> نوع العمليه</label>
                        <select v-model="moveselected" class="form-control">
                          <option v-bind:value="1">كل العمليات</option>
                          <option v-bind:value="2">صرف</option>
                          <option v-bind:value="3">توريد</option>
                          <option v-bind:value="4">مرتجع صرف</option>

                          <option v-bind:value="5">مرتجع توريد</option>
                        </select>
                      </div> -->

                      <div class="col-md-3" v-show="showstore">
                        <label for="status">المخزن</label>


                        <div class="custom-search">
                          <input v-model="storeselected" id='store_tree' type="text" class="custom-search-input">
                          <button class="custom-search-botton" type="submit" data-toggle="modal"
                            data-target="#exampleModalStore"> <i class="fa fa-plus-circle"></i></button>
                        </div>
                      </div>

                      <div class="col-md-3" v-show="showproduct">
                        <label for="status">المنتج</label>

                        <div class="custom-search">

                          <input v-model="productselected" id='product_tree' type="text" class="custom-search-input">
                          <button class="custom-search-botton" type="submit" data-toggle="modal"
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

                      <!--  this manner did not added even now -->
                      <div class="col-md-2" >
                        <label for="status"> طريقه الدفع</label>
                        <select  name="status"  class="form-control">


                     

                        </select>
                      </div>
                    </div>

                    <div class='row'>
                      <div class="col-md-10">

                      </div>
                      <div class="col-md-2">
                        <a @click="Search()" class="tn btn-info btn-sm waves-effect btn-agregar" data-toggle="modal"
                          id="agregar_productos" data-target=".bs-example-modal-sm">
                          <i class="fa fa-search"></i></a>
                        <a @click="printDiv('printme')" class="tn btn-info btn-sm waves-effect btn-agregar"
                          data-toggle="modal" id="agregar_productos" data-target=".bs-example-modal-sm">
                          <i class="fa fa-print"></i></a>




                      </div>
                    </div>



                  </div>

                </div>
              </div>
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
                            اسم المنتج :
                            <span>{{ productselectedname }}</span>
                          </h5>
                        </td>
                        <!-- <td v-if="moveselected != 0">
                          <h5>
                            نوع العمليه :
                            <span>{{ moveselected[1] }}</span>
                          </h5>
                        </td> -->
                        <td v-if="statusselected != 0">
                          <h5>
                            الحاله : <span>{{ statusselected[1] }}</span>
                          </h5>
                        </td>
                        <td v-if="storeselected != 0">
                          <h5>
                            اسم المخزن :
                            <span>{{ storeselectedname }} </span>
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
                        <!-- <td v-if="moveselected == 0">نوع العمليه</td> -->

                        <td v-if="storeselected == 0">المخزن</td>
                        <td v-if="statusselected == 0">الحاله</td>
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

                        <div v-if="moveselected == 0">
                          <td v-if="datas.type_operation == 'Supply'">
                            توريد
                          </td>
                          <td v-if="datas.type_operation == 'cash'">صرف</td>
                          <td v-if="datas.type_operation == 'return_supply'">
                            مرتجع توريد
                          </td>
                          <td v-if="datas.type_operation == 'return_cash'">
                            مرتجع صرف
                          </td>
                        </div>
                        <td v-if="storeselected == 0">{{ datas.store }}</td>
                        <td v-if="statusselected == 0">{{ datas.status }}</td>
                        <td v-if="descselected == 0">{{ datas.desc }}</td>
                        <td>{{ datas.qty_stock }}</td>
                        <td>{{ datas.date }}</td>
                      </tr>
                    </tbody>
                    <tbody v-else>
                      <td align="center" colspan="7">
                        <h4>لايوجد بيانات بالشروط التي اخترتها</h4>
                      </td>
                    </tbody>
                  </table>
                  <div id="intro" style="text-align: left">

                    <h3>امين المخازن:{{ user }}</h3>
                    <h5>{{ timestamp }}</h5>
                  </div>
                </div>

              </div>
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

export default {
  data() {
    return {
      supplier: "yes",
      product: "",
      store: "",
      status: "",
      user: "",
      types: [
        'حسب المورد',
        'حسب المخزن',
        'حسب المنتج',
        'حسب حاله المنتج',
        'حسب المواصفات والطراز',
   

      ],
      // showstore: false,
      // showproduct: false,
      // showstatus: false,
      // showdesc: false,
      // showdate: false,
      // showoperation: false,

      // statusselected: 0,

      // productselected: 0,
      // productselectedname: "",
      // storeselectedname: "",
      // storeselected: 0,
      // descselected: "",
      // operationselected: 0,
      // dateselected: 0,
      // typeselected: [],
      // checkselected: '',
      // moveselected: 0,
      // moveselected: [],
      type_report: 0,
      from_date: "2021-11-24",
      to_date: new Date().toISOString().substr(0, 10),
      //   statusselected: "",

      report: {
        data: "",
      },

      default: 100,
    };
  },
  created() {
    // this.$router.go(0);
    setInterval(this.getNow, 1000);
    this.showtree();
  },
  mounted() {

    this.axios.post("/Reposupply").then((response) => {
      this.store = response.data.store;
      this.product = response.data.product;

      this.status = response.data.status;
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
      (this.typeselected[4] == true) ? this.showoperation = true : this.showoperation = false;



    },
    set_product(gf, id, name) {
      gf.productselected = id;
      gf.productselectedname = name;
    },
    set_store(gf, id, name) {
      gf.storeselected = id;
      gf.storeselectedname = name;

    },
    Search() {
      this.axios
        .post(`/repo_movement`, {
          type_operation: this.moveselected,
          store_id: this.storeselected,
          product_id: this.productselected,
          status_id: this.statusselected,
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

      report_style(printme, 'تقرير حركه الاصناف');

    },
  },
};
</script>

  <!-- <style scoped>
  .card-header {
  
    background-color: #00b9ff;
  }
  </style> -->
  
  
  
  
  
  
  