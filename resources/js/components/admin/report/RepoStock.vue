    <template>
  <div class="container-fluid">
    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
              <span style="font-size: x-large"> تقرير المخزون </span>
            </div>
          </div>
          <div class="card-body">
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
                      <div class="col-md-3" v-show="showproduct">
                        <label for="status">المنتج</label>
                        <!-- <select @change="onreportchange" v-model="productselected" name="status" id="status"
                          class="form-control">

                          <option v-for="products in product" v-bind:value="[products.id, products.name]">
                            {{ products.name }}
                          </option>

                        </select> -->

                        <div class="custom-search">
                          <!-- <label for="status">المنتج</label> -->
                          <input v-model="productselected" id='product_tree' type="text" class="custom-search-input" >
                          <button class="custom-search-botton" type="submit" data-toggle="modal"
                            data-target="#exampleModalProduct"> <i class="fa fa-plus-circle"></i></button>
                        </div>

                      </div>
                      <div class="col-md-3" v-show="showstore">
                        <label for="status">المخزن</label>
                        <!-- <select @change="onreportchange" v-model="storeselected" name="status" id="status"
                          class="form-control">

                          <option v-for="stores in store" v-bind:value="[stores.id, stores.code]">
                            {{ stores.code }}
                          </option>

                        </select> -->

                        <div class="custom-search">
                          <input  v-model="storeselected" id='store_tree' type="text" class="custom-search-input">
                          <button class="custom-search-botton" type="submit" data-toggle="modal"
                            data-target="#exampleModalStore"> <i class="fa fa-plus-circle"></i></button>
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
                        <!-- <a @click="Search()" class="tn btn-info btn-lg waves-effect btn-agregar" data-toggle="modal"
                          id="agregar_productos" data-target=".bs-example-modal-lg">
                          <i class="fa fa-search"></i></a>
                        <a @click="printDiv('printme')" class="tn btn-info btn-lg waves-effect btn-agregar"
                          data-toggle="modal" id="agregar_productos" data-target=".bs-example-modal-lg">
                          <i class="fa fa-print"></i></a> -->
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
                  <table>
                    <thead>
                      <tr style="text-indent: 2em">
                        <td v-if="productselected != 0">
                          <h4>
                            <span> المنتج</span> : {{ productselectedname }}
                          </h4>
                        </td>
                        <td v-if="storeselected != 0">
                          <h4><span> المخزن</span> : {{ storeselectedname }}</h4>
                        </td>
                        <td v-if="statusselected != 0">
                          <h4>
                            <span> حاله المنتج</span>:
                            {{ statusselected[1] }}
                          </h4>
                        </td>
                        <td v-if="descselected != 0">
                          <h4>
                            <span> المواصفات والطراز</span>:
                            {{ descselected }}
                          </h4>
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

          <div class="modal fade" id="exampleModalProduct" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
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
  </div>

  <!-- container -->
</template>
<script>
export default {
  data() {
    return {
      supplier: "yes",
      product: "",

      store: "",
      status: "",
      types: [
        'حسب المخزن',
        'حسب المنتج',
        'حسب حاله المنتج',
        'حسب المواصفات والطراز'


      ],
      showstore: false,
      showproduct: false,
      showstatus: false,
      showdesc: false,

      user: "",
      statusselected: 0,

      productselected: 0,
      productselectedname: "",
      storeselectedname: "",
      statusselectedname: "",
      storeselected: 0,
      descselected: "",
      typeselected: [],
      moveselected: 0,
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
    this.showtree();
    //
  },
  mounted() {
    // this.$router.go(0);
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
    showtree() {


      this.axios.post(`/tree_product`).then((response) => {
        this.jsonTreeDataProduct = response.data.products;
let gf_product = this;

        $('#treeview_json_product').jstree({
          core: {
            themes: {
              responsive: false,
            },
            // so that create works
            check_callback: true,
            data: this.jsonTreeDataProduct,
          },
          types: {
            default: {
              icon: "fa fa-folder text-primary",
            },
            file: {
              icon: "fa fa-file  text-primary",
            },
          },
          checkbox: {
            three_state: false,

          },
          state: {
            key: "demo2"
          },
          search: {
            case_insensitive: true,
            show_only_matches: true
          },
          plugins: ["checkbox",
           
            "dnd",
            "massload",
            "search",
            "sort",
            "state",
            "types",
            "unique",
            "wholerow",
            "changed",
            "conditionalselect"],
        





        }).on("changed.jstree", function (e, data) {

          console.log(data.node.id);
          $(`#product_tree`).val(data.node.id)
          //  modal-title-store
          gf_product.set_product(gf_product,data.node.id,data.node.text);

        });

      });
      this.axios.post(`/tree_store`).then((response) => {
        this.jsonTreeDataStore = response.data.stores;

  let gf_store = this;
        $('#treeview_json_store').jstree({
          core: {
            themes: {
              responsive: false,
            },
            // so that create works
            check_callback: true,
            data: this.jsonTreeDataStore,
          },
          types: {
            default: {
              icon: "fa fa-folder text-primary",
            },
            file: {
              icon: "fa fa-file  text-primary",
            },
          },
          checkbox: {
            three_state: false,

          },
          state: {
            key: "demo2"
          },
          search: {
            case_insensitive: true,
            show_only_matches: true
          },
          plugins: ["checkbox",
            "contextmenu",
            "dnd",
            "massload",
            "search",
            "sort",
            "state",
            "types",
            "unique",
            "wholerow",
            "changed",
            "conditionalselect"],
          contextmenu: {
            items: contextmenu
          },






        }).on("changed.jstree", function (e, data) {

          console.log(data.node.id);
          $(`#store_tree`).val(data.node.id)
          //  modal-title-store
          gf_store.set_store(gf_store,data.node.id,data.node.text);
        });

      });
    },
    set_product(gf,id,name){
      gf.productselected = id;
      gf.productselectedname = name;
    },
     set_store(gf,id,name){
      gf.storeselected = id;
            gf.storeselectedname = name;

    },
    onreportchange() {

      (this.typeselected[0] == true) ? this.showstore = true : this.showstore = false;
      (this.typeselected[1] == true) ? this.showproduct = true : this.showproduct = false;
      (this.typeselected[2] == true) ? this.showstatus = true : this.showstatus = false;
      (this.typeselected[3] == true) ? this.showdesc = true : this.showdesc = false;


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

<style scoped>
.custom-search {
  position: relative;
  width: 300px;
}

.custom-search-input {
  width: 100%;
  border: 1px solid #ccc;
  border-radius: 100px;
  padding: 10px 100px 10px 20px;
  line-height: 1;
  box-sizing: border-box;
  outline: none;
}

.custom-search-botton {
  position: absolute;
  right: 3px;
  top: 3px;
  bottom: 3px;
  border: 0;
  background: #d1095e;
  color: #fff;
  outline: none;
  margin: 0;
  padding: 0 10px;
  border-radius: 100px;
  z-index: 2;
}
</style>

<!-- <style scoped>
h2,
.h2 {
  font-size: 1rem;
}

.card-header {

  background-color: #00b9ff;
}
</style> -->








