<template>
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-xs-12">
          <div class="page-title-box">
            <h4 class="page-title">تقرير الوارد</h4>
          </div>
        </div>
      </div>
      <!-- end row -->

      <div class="row">
        <div class="col-sm-12">
          <div class="card-box">
            <div class="invoice-box">
              <!-- <div class="form-group"> -->
                   <div class="row">
                <p>اختر التقرير</p>
                <form>
                  <label v-for="(typee, index) in types" class="checkbox-inline">
                    <input v-model="typeselected[index]" @change='onreportchange()' type="checkbox">&nbsp;
                    {{ types[index] }}
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
                  <div class="col-md-3" v-show="showproduct">
                    <label for="status">المنتج</label>
                    <select @change="onreportchange" v-model="productselected" name="status" id="status"
                      class="form-control">

                      <option v-for="products in product" v-bind:value="[products.id, products.name]">
                        {{ products.name }}
                      </option>

                    </select>
                  </div>
                  <div class="col-md-3" v-show="showstore">
                    <label for="status">المخزن</label>
                    <select @change="onreportchange" v-model="storeselected" name="status" id="status"
                      class="form-control">

                      <option v-for="stores in store" v-bind:value="[stores.id, stores.code]">
                        {{ stores.code }}
                      </option>

                    </select>
                  </div>

                  <div class="col-md-2" v-show="showstatus">
                    <label for="status"> حاله المنتج </label>
                    <select v-model="statusselected" class="form-control" @change="onreportchange">

                      <option v-for="statuses in status" v-bind:value="[statuses.id, statuses.name]">
                        {{ statuses.name }}
                      </option>

                    </select>
                  </div>
                  <div class="col-md-2" v-show="showsupplier">
                    <label for="status"> المورد </label>

                    <select v-model="supplierselected" class="form-control" @change="onreportchange">

                      <option v-for="suppliers in supplier" v-bind:value="[suppliers.id, suppliers.name]">
                        {{ suppliers.name }}
                      </option>

                    </select>

                  </div>
                  <div class="col-md-2" v-show="showdesc">
                    <label for="status">المواصفات والطراز </label>
                    <input type="text" v-model="descselected" class="form-control input_cantidad"
                      onkeypress="return valida(event)" />
                  </div>

                </div>


                <div class='row'>
                  <div class="col-md-10">

                  </div>

                  <div class="col-md-2">


                    <a @click="Search()" class="tn btn-info btn-lg waves-effect btn-agregar" data-toggle="modal"
                      id="agregar_productos" data-target=".bs-example-modal-lg">
                      <i class="fa fa-search"></i></a>
                    <a @click="printDiv('printme')" class="tn btn-info btn-lg waves-effect btn-agregar"
                      data-toggle="modal" id="agregar_productos" data-target=".bs-example-modal-lg">
                      <i class="fa fa-print"></i></a>
                  </div>
                </div>

              <!-- </div> -->
            </div>

          </div>
        </div>
      </div>
      <div class="row" id="printme">
        <div class="col-sm-12">
          <div class="card-box">

            <div class="invoice-box">
              <table>
                <thead>
                  <tr style="text-indent: 2em">
                    <td v-if="productselected != 0">
                      <h4>
                        <span> المنتج</span> : {{ productselected[1] }}
                      </h4>
                    </td>
                    <td v-if="storeselected != 0">
                      <h4><span> المخزن</span> : {{ storeselected[1] }}</h4>
                    </td>
                    <td v-if="statusselected != 0">
                      <h4>
                        <span> حاله المنتج</span>:
                        {{ statusselected[1] }}
                      </h4>
                    </td>
                    <td v-if="supplierselected != 0">
                      <h4>
                        <span> المورد</span>:
                        {{ supplierselected }}
                      </h4>
                    </td>
                    <td v-if="descselected != 0">
                      <h4>
                        <span> المواصفات والطراز</span>:
                        {{ descselected }}
                      </h4>
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

              <table class="table table-bordered text-right" style="width: 100%; font-size: large">
                <thead>
                  <tr class="heading" style="font-size: 10px">
                    <!-- <td>#</td> -->

                    <td v-if="productselected == 0">المنتج</td>
                    <!-- <td v-if="moveselected == 1">نوع العمليه</td> -->

                    <td v-if="storeselected == 0">المخزن</td>
                    <td v-if="statusselected == 0">الحاله</td>
                    <td v-if="supplierselected == 0">المورد</td>

                    <td v-if="descselected == 0">الطراز والمواصفات</td>

                    <td>الكميه</td>

                    <!-- <td>التاريخ</td> -->
                  </tr>
                </thead>
                <tbody v-if="report && report.data.length > 0">
                  <tr class="item" v-for="datas in report.data">
                    <!-- <td>{{ datas.id }}</td> -->
                    <td v-if="productselected == 0">
                      {{ datas.product_name }}
                    </td>

                    <td v-if="storeselected == 0">{{ datas.code }}</td>
                    <td v-if="statusselected == 0">
                      {{ datas.status }}
                    </td>
                    <td v-if="supplierselected == 0">
                      {{ datas.suppliers }}
                    </td>
                    <td v-if="descselected == 0">
                      {{ datas.desc }}
                    </td>

                    <td>{{ datas.quantity }}</td>
                    <!-- <td>{{ datas.date }}</td> -->
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

      <!-- end row -->
    </div>
    <!-- container -->
  </div>
</template>
<script>
export default {
  data() {
    return {
      supplier: "",
      product: "",
      store: "",
      status: "",
      types: [

        'حسب المخزن',
        'حسب المنتج',
        'حسب حاله المنتج',
        'حسب المواصفات والطراز',
        'حسب المورد',


      ],
      // showstore: false,
      // showproduct: false,
      // showstatus: false,
      // showdesc: false,
      // showsupplier: false,

      // user: "",
      // statusselected: 0,
      // supplierselected: 0,
      // productselected: 0,
      // productselectedname: "",
      // storeselectedname: "",
      // statusselectedname: "",
      // storeselected: 0,
      // descselected: "",
      // typeselected: [],
      // moveselected: 0,
      type_report: 0,
      from_date: "2021-11-24",
      to_date: "2021-11-24",
      //   statusselected: "",

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
    this.axios.post("/Reposupply").then((response) => {
      this.supplier = response.data.supplier;
      this.product = response.data.product;
      this.store = response.data.store;
      this.status = response.data.status;
      //   console.log(response.data);
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
      (this.typeselected[4] == true) ? this.showsupplier = true : this.showsupplier = false;


    },
    Search() {

      this.axios
        .post(`/reposupply_by_supplier`, {
          // type_operation: this.moveselected,
          store_id: this.storeselected,
          product_id: this.productselected,
          status_id: this.statusselected,
          desc: this.descselected,
          supplier: this.supplierselected,
          // from_date: this.from_date,
          // to_date: this.to_date,
        })
        .then((response) => {
          console.log(response);
          this.report.data = response.data.reposupply;
        });


    },
    printDiv(printme) {
      report_style(printme, 'تقرير الوارد');
    },
  },
};
</script>
<style scoped>
h2,
.h2 {
  font-size: 1rem;
}

.card-header {

  background-color: #00b9ff;
}
</style>


