<template>
  <!-- row opened -->

  <!-- <div class="container-fluid"> -->
  <div class="card">
    <div class="card-header pb-0">
      <div class="d-flex justify-content-between">
        <span class="h2">المنتجات</span>
      </div>
    </div>

    <div class="card-body">
      <div class="row row-sm">

        <div class="col-xl-6">
          <div class="card">
            <div class="card-header pb-0">


              <span style="font-size: x-large"> شجره المنتجات</span>

            </div>
            <div class="card-body">
              <div class="container">
                <div class="row justify-content-left">
                  <div class="col-md-6">
                    <div class="card">

                      <div class="card-header">

                        <a @click="exports_excel()">
                          <img src="/assets/img/export.png" alt="" style="width: 10%;"></a>

                        <a @click="imports_excel()">
                          <img src="/assets/img/import.png" alt="" style="width: 10%;"></a>
                      </div>
                      <div class="card-body">
                        <!-- <div class="container"> -->

                        <div class="well" id="treeview_json_product"></div>
                        <!-- </div> -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>




        <div class="col-xl-6">
          <div class="card">

            <div class="card-header">
              <span style="font-size: x-large"> اضافه المنتجات</span>
            </div>
            <form method="post">

              <div class="card-body">
                <div class="form">
                  <!-- <h3 class="text-center">اضافه منتج</h3> -->


                  <div class="form-group">
                    <ul>
                      <div v-for="error in errors">
                        <li>{{ error[0] }}</li>
                      </div>
                    </ul>
                  </div>

                  <div class="form-group">
                    <label for="Product">رقم المنتج</label>
                    <input id='product_number' type="text" class="form-control" required readonly />

                  </div>
                  <div class="form-group">
                    <label for="Product">اسم المنتج</label>
                    <input style="background-color: beige;" v-model="text" type="text" name="Product" id="product"
                      class="form-control" required /><span style="color:red">{{ error_text[0] }}</span>

                  </div>

                  <div class="form-group">
                    <label for="radio-example-one">متفرع </label>

                    <input type="checkbox" name='fieldset2' v-model="status" id="status">
                    <input id='parent' type="hidden" />

                    <input id='rank' type="hidden" />

                  </div>


                  <div v-if="!status">
                    <div class="row">


                      <div class='col-md-4'>
                        <label for="Product">الوحده الرئيسيه</label>
                        <select v-model="unit" id="supplier" class="form-control">
                          <option v-for="unit in units" v-bind:value="unit.id">
                            {{ unit.name }}
                          </option>
                        </select>

                      </div>
                      <div class='col-md-4'>
                        <label for="purchase_price"> سعر الشراء</label>
                        <input v-model="purchase_price" type="text" name="purchase_price" id="purchase_price"
                          class="form-control" /><span style="color:red">{{ error_purchase_price[0] }}</span>


                      </div>
                      <div class='col-md-4'>
                        <label for="radio-example-one">يوجد وحدات تجزئه </label>

                        <input type="checkbox" name='fieldset2' id="status" v-model="check_state">


                      </div>
                    </div>
                    <div class="row" v-if="check_state">
                      <div class="col-md-4">
                        <label for="Product">وحده التجزئه</label>
                        <!-- retail_unit -->
                        <select v-model="retail_unit" class="form-control">
                          <option v-for="unit in units" v-bind:value="unit.id">
                            {{ unit.name }}
                          </option>
                        </select>

                      </div>


                      <div class="col-md-4">
                        <label for="purchase_price"> سعر الشراء</label>
                        <input v-model="purchase_price_for_retail_unit" type="text" name="purchase_price"
                          id="purchase_price" class="form-control" />

                      </div>
                      <div class='col-md-4'>
                        <label for="purchase_price">عدد وحدات التجزئه بالوحده الاساسيه</label>
                        <input v-model="hash_rate" type="text" name="purchase_price" id="purchase_price"
                          class="form-control" />


                      </div>
                    </div>
                    <div class="form-group">
                      <label for="Product Minimum"> الحد الادني للمنتج</label>
                      <input v-model="product_minimum" type="number" name="Minimum" id="Minimum" class="form-control" />
                      <span style="color:red">{{ error_hash_rate[0] }}</span>
                    </div>

                    <div class="form-group">
                      <label for="Product Minimum">مده الارجاع</label>
                      <input v-model="period" type="number" name="Minimum" id="Minimum" class="form-control" />

                    </div>

                  </div>

                  <!-- <div class="form-group">
                    <label for="Product">الرتبه</label>
                    <input v-model="rank" type="text" id="rank" class="form-control" readonly required />

                  </div>
                  <div class="form-group">
                    <label for="Product">الريسي</label>
                    <input v-model="parent" type="text" class="form-control" readonly required />

                  </div> -->

                  <div class="form-group">
                    <label for="filePhoto">الصوره</label>
                    <input v-on:change="onFileChange" type="file" name="image" class="form-control-file" id="filePhoto" />
                    <img src="" id="previewHolder" width="150px" />
                  </div>



                </div>
              </div>
              <div class="card-footer">
                <button type="button" class="btn btn-primary btn-lg btn-block" @click="addnode()"> حفظ </button>
              </div>
            </form>
          </div>
        </div>




        <!--/div-->
      </div>

    </div>

    <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          حذف
        </div>
      </div>
    </div>

  </div>
  <!-- </div> -->
</template>

<script>

// import jtree from '../../../../js/jtree.js';
import tree from '../../../../js/tree/tree.js';

export default {
  // mixins: [jtree],
  mixins: [tree],

  // mixins: [tree],
  data() {
    return {
      // show_retail_unit:false,
      // product_first_level: '',
      // last_nodes: '',
      // rank: 1,
      // parent: 0,
      // jsonTreeData: [],
      // type_of_tree:0,
      check_state: '',
      error_text: '',
      error_hash_rate: '',
      error_purchase_price: '',
      units: '',
      unit: '',
      retail_unit: '',
      hash_rate: '',
      purchase_price: '',
      purchase_price_for_retail_unit: '',
      product_minimum: '',
      period: '',
      file: '',
      text: '',
      product: '',
      image: '',
      status: false,
      id: '',
      trees: "",
      errors: "",

      add: 0,




    };
  },
  mounted() {
    // this.list();
    this.type_of_tree = 0;
    this.axios.post("/unit").then((response) => {
      // console.log(response);
      this.units = response.data.units;


    });
  },
  created() {
    localStorage.setItem('id', 0);
    localStorage.setItem('rank', 0);
    localStorage.setItem('table', 'product');

    this.showtree('product','tree_product');
  },

  methods: {


    onFileChange(e) {
      this.file = e.target.files[0];
    },


    exports_excel() {

      axios
        .post(`export_product`)
        .then(function (response) {

          // console.log(1);
        })
        .catch(error => {

        });
    },
    imports_excel() {

      axios
        .post(`import_product`)
        .then(function (response) {

          // console.log(1);
        })
        .catch(error => {

        });
    },



  },
};
</script>




