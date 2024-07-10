<template>
  <div class="card">
    <div class="card-header pb-0">
      <div class="d-flex justify-content-between">
        <span class="h2"> الدليل المحاسبي</span>
      </div>
    </div>
    <div class="card-body">
      <div class="row row-sm">
        <div class="col-xl-6">
          <div class="card">
            <div class="card-header pb-0">


              <span style="font-size: x-large"> شجره الحسابات</span>
              <!-- <router-link to="create_product" id="agregar_productos"
                class="tn btn-info btn-lg waves-effect btn-agregar"><i class="fa fa-plus-circle"></i></router-link> -->



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
                          <div class="well" id="treeview_json_account"></div>
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
                            <div class="col-xs-12" id="treeview_json_account">

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


          <div class="container">
            <div class="row justify-content-left">
              <div class="col-md-12">
                <div class="card">

                  <div class="card-header pb-0">


                    <span style="font-size: x-large">اضافه حساب</span>


                  </div>

                  <form method="post">

                    <div class="card-body">
                      <div class="row">
                        <!-- <h3 class="text-center">اضافه حساب</h3> -->

                        <!-- <div class="col-md-4">
                          <ul>
                            <div v-for="error in errors">
                              <li>{{ error[0] }}</li>
                            </div>
                          </ul>
                        </div> -->

                        <div class="col-md-4">
                          <label for="Product">رقم الحساب</label>
                          <input id='account_number' type="text" class="form-control" required />

                        </div>

                        <div class="col-md-4">
                          <label for="Product">اسم الحساب</label>
                          <input v-model="text" type="text" name="Product" id="account_first_level" class="form-control"
                            required />

                        </div>


                      </div>

                      <br>
                      <div class="row">

                        <div class="col-md-4">
                          <label for="radio-example-one">متفرع </label>

                          <input type="checkbox" name='fieldset2' v-model="status" id="status" />
                        </div>




                      </div>
<br>
                      <div class="row">



<div class="col-md-4">
  <label for="radio-example-one">مدين </label>

  <input type="checkbox" name='field1' id="attend" @change="check()" />

  <label for="radio-example-one">داين </label>

  <input type="checkbox" name='field2' id="attend" @change="check()" />

</div>

<input id='parent' type="hidden" />

<input id='rank' type="text" />


</div>

<div class="row">

  <div class="col-md-12">

    <button type="button" class="btn btn-primary btn-lg btn-inline" @click="addnode"> حفظ </button>


  </div>
</div>

                    </div>
                    <!-- <div class="card-footer">
                      <button type="button" class="btn btn-primary btn-lg btn-block" @click="addnode"> حفظ </button>
                    </div> -->
                  </form>
                </div>
              </div>
            </div>
          </div>

        </div>


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
  </div>
</template>
<script>

import tree from '../../../../../js/tree/tree.js';
export default {
  mixins: [tree],
  data() {
    return {
      file: '',
      text: '',
      product: '',
      status: false,
      rank: 1,
      id: '',
      trees: "",
      errors: "",

      add: 0,
      // type_of_tree:0,
    };
  },


  created() {
    this.type_of_tree = 0;
    localStorage.setItem('id', 0);
    localStorage.setItem('rank', 0);
    localStorage.setItem('table', 'account');

    this.showtree('account', 'tree_account');
  },
  methods: {

    update_account(e) {
      e.preventDefault();
      updatenode($("#update_account_number").val(), this.text);
    },

    exports_excel() {

      axios
        .post(`export_account`)
        .then(function (response) {

          // console.log(1);
        })
        .catch(error => {

        });
    },
    imports_excel() {

      axios
        .post(`import_account`)
        .then(function (response) {

          // console.log(1);
        })
        .catch(error => {

        });
    },


  },
};
</script>
