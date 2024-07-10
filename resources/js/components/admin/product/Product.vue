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
                  <div class="col-md-8">
                    <div class="card">


                      <div class="card-header">

                        <a @click="exports_excel()">
                          <img src="/assets/img/export.png" alt="" style="width: 10%;"></a>

                        <a @click="imports_excel()">
                          <img src="/assets/img/import.png" alt="" style="width: 10%;"></a>
                      </div>

                      <div class="card-body">
                        <!-- <div class="container">
                          <div class="well" id="treeview_json_product"></div>
                        </div> -->

                        <div class="container">
                          <div class="row">
                            <div class="col-xs-12">
                              <div class="input-group">

                                <input type="text" id="ricerca-enti" class="form-control" placeholder="بحث"
                                  aria-describedby="search-addon">

                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-xs-12" id="treeview_json_product">

                              <div id="test">

                              </div>
                            </div>
                          </div>
                        </div>

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
            <!-- <form method="post"> -->

            <div class="card-body">
              <div class="row">

                <div class="col-md-4">
                  <label for="Product">رقم المنتج</label>
                  <input id='product_number' type="text" class="form-control" required readonly />

                </div>
                <div class="col-md-4">
                  <label for="Product">اسم المنتج</label>
                  <input style="background-color: beige;" v-model="text" type="text" name="Product" id="product"
                    class="form-control" required /><span style="color:red">{{ error_text[0] }}</span>

                </div>

                <div class="col-md-4">
                  <label for="radio-example-one">متفرع </label>

                  <input type="checkbox" name='fieldset2' v-model="status" id="status">
                  <input id='parent' type="hidden" />

                  <input id='rank' type="hidden" />

                </div>
              </div>

              <br>
              <div class="row">

                <div class="col-md-12" v-if="!status">
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
                      <input v-model="purchase_price" type="text" name="purchase_price" class="form-control" /><span
                        style="color:red">{{ error_purchase_price[0] }}</span>

                      <!-- <input v-model="rate[0]" type="text" 
                          class="form-control" /> -->
                    </div>



                    <div class='col-md-4'>
                      <label for="radio-example-one">اضافه وحدات تجزئه </label><br>


                      <!-- <input type="checkbox" name='fieldset2' id="status" v-model="check_state"> -->


                      <button type="button" class="btn btn-info btn-sm waves-effect btn-agregar" data-toggle="modal"
                        data-target="#exampleModalUnit">
                        <i class="fa fa-eye"></i></button>






                    </div>
                  </div>

                  <br>
                  <div class="row">
                    <div class="col-md-4">
                      <label for="Product Minimum"> الحد الادني للمنتج</label>
                      <input v-model="product_minimum" type="number" name="Minimum" id="Minimum" class="form-control" />
                      <span style="color:red">{{ error_hash_rate[0] }}</span>
                    </div>

                    <div class="col-md-4">
                      <label for="Product Minimum">مده الارجاع</label>
                      <input v-model="period" type="number" name="Minimum" id="Minimum" class="form-control" />

                    </div>

                    <div class="col-md-4">
                      <label for="filePhoto">الصوره</label>
                      <input v-on:change="onFileChange" type="file" name="image" class="form-control-file"
                        id="filePhoto" />
                      <img src="" id="previewHolder" width="150px" />
                    </div>

                    

                  </div>

                </div>





              </div>

              
              <br>

<div class="row">

  <div class="col-md-12">
    <button type="button" class="btn btn-primary btn-lg btn-inline" @click="addnode()"> حفظ </button>

  </div>
</div>
            </div>
            <!-- <div class="card-footer">
              <button type="button" class="btn btn-primary" @click="addnode()"> حفظ </button>
            </div> -->
            <!-- </form> -->
          </div>
        </div>




        <!--/div-->
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <span class="h2">تفاصيل المنتجات</span>


            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <!-- <th>  رقم الفاتوره </th> -->
                      <th>اسم المنتج</th>
                      <th> المواصفات والطراز</th>
                      <th>الحاله</th>
                      <th>المخزن</th>

                      <th class="wd-15p border-bottom-0"> كميه الشراء</th>
                      <!-- <th>الوحده</th> -->
                      <th class="wd-15p border-bottom-0"> السعر </th>
                      <!-- <th class="wd-15p border-bottom-0"> الاجمالي </th> -->

                      <!-- <th class="wd-15p border-bottom-0">  الكميه المرتحعه</th> -->


                    </tr>
                  </thead>
                  <tbody v-if="purchase_detail && purchase_detail.length > 0">
                    <tr v-for="purchase_details in purchase_detail">
                      <!-- <td>{{ purchase_details.id }}</td> -->
                      <td>{{ purchase_details.product }}</td>
                      <td>{{ purchase_details.desc }}</td>
                      <td>{{ purchase_details.status }}</td>
                      <td>{{ purchase_details.store }}</td>
                      <!-- <td>{{ purchase_details.qty }} {{ purchase_details.unit }}</td> -->
                      <td>


                        <div v-for="temx in purchase_details.qty_after_convert['qty']">



                          <span v-for="temx2 in temx">


                            <span style="float: right;">
                              {{ temx2[0] }}
                              <span style="color: red;">
                                {{ temx2[1] }}
                              </span>

                            </span>



                          </span>

                          <!-- <span v-if="temx.unit_type == 0">


                          <span>{{ Math.floor((stock.quantity)) }}</span><span style="color: red;"> {{
                        temx.name }}</span>



                        </span> -->

                        </div>


                      </td>

                      <!-- <td>{{ purchase_details.unit }}</td> -->
                      <td>{{ purchase_details.price }}</td>
                      <!-- <td>{{ purchase_details.total }}</td> -->
                      <!-- <td>{{ purchase_details.qty_return }}</td> -->



                    </tr>
                    <!-- <tr>

                    <td colspan="7" style="text-align:center;color:red;font-size:large">الاجمالي</td>
                    <td>{{ total }}</td>
                  </tr> -->

                  </tbody>
                  <tbody v-else>
                    <tr>
                      <td align="center" colspan="8">
                        <h3>
                          لايوجد اي مشتريات
                        </h3>
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

    <div class="modal fade" id="exampleModalUnit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <!-- <div class="modal-header">

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">وحدات التجزئه</span>
            </button>
          </div> -->
          <div class="modal-body">



            <div class="row">
              <div class="table-responsive">
                <table class="table table-bordered text-right" style="width: auto; font-size: x-large">
                  <thead>
                    <tr>
                      <!-- <th>Code</th> -->
                      <th>وحده التجزئه</th>
                      <th>سعر الشراء</th>
                      <th>عدد وحدات التجزئه بالوحده الاساسيه</th>

                      <th>اضافه</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="index in count" :key="index">
                      <td>

                        <!-- retail_unit -->
                        <select v-model="retail_unit[index]" class="form-control">
                          <option v-for="unit in units" v-bind:value="unit.id">
                            {{ unit.name }}
                          </option>
                        </select>





                      </td>
                      <td>


                        <input v-model="purchase_price_for_retail_unit[index]" type="text" name="purchase_price"
                          class="form-control" />




                      </td>

                      <td>


                        <input v-model="hash_rate[index]" type="text" name="purchase_price" class="form-control" />

                      </td>


                      <td v-if="index == 1">

                        <button class="btn btn-info btn-sm waves-effect btn-agregar" v-on:click="addComponent(count)">
                          <i class="fa fa-plus-circle"></i></button>

                        <button class="btn btn-info btn-sm waves-effect btn-agregar" v-on:click="disComponent(count)">
                          <i class="fa fa-minus-circle"></i></button>



                      </td>
                    </tr>


                  </tbody>
                </table>
              </div>
            </div>


          </div>

          <!-- <div class="modal-footer">

        
            <button class="tn btn-info btn-lg waves-effect btn-agregar" @click="addunit()"> حفظ </button>

          </div>  -->
        </div>
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
import operation from '../../../operation1.js';
import tree from '../../../../js/tree/tree.js';

export default {
  // mixins: [jtree],
  mixins: [tree, operation],

  // mixins: [tree],
  data() {
    return {

      check_state: '',
      error_text: '',
      error_hash_rate: '',
      error_purchase_price: '',
      units: '',
      unit: '',
      retail_unit: [],
      hash_rate: [],
      purchase_price: '',
      purchase_price_for_retail_unit: [],
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
      counts: [],
      add: 0,




    };
  },
  mounted() {
    // this.list();
    this.counts[0] = 1;
    this.type_of_tree = 0;
    this.axios.post("/unit").then((response) => {
      // console.log(response);
      this.units = response.data.units;


    });


    this.type = 'Stock';

  },
  created() {
    localStorage.setItem('id', 0);
    localStorage.setItem('rank', 0);
    localStorage.setItem('table', 'product');

    this.showtree('product', 'tree_product');
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
