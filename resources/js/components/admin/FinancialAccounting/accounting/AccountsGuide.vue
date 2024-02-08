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
                         
                                <input type="text" id="ricerca-enti" class="form-control"
                                  placeholder="بحث" aria-describedby="search-addon">
                           
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
                      <div class="form">
                        <!-- <h3 class="text-center">اضافه حساب</h3> -->

                        <div class="form-group">
                          <ul>
                            <div v-for="error in errors">
                              <li>{{ error[0] }}</li>
                            </div>
                          </ul>
                        </div>

                        <div class="form-group">
                          <label for="Product">رقم الحساب</label>
                          <input id='account_number' type="text" class="form-control" required />

                        </div>

                        <div class="form-group">
                          <label for="Product">اسم الحساب</label>
                          <input v-model="text" type="text" name="Product" id="account_first_level" class="form-control"
                            required />

                        </div>

                        <div class="form-group">
                          <label for="radio-example-one">متفرع </label>

                          <input type="checkbox" name='fieldset2' v-model="status" id="status" />
                        </div>


                        <div class="form-group">
                          <label for="radio-example-one">مدين </label>

                          <input type="checkbox" name='field1' id="attend" @change="check()" />

                          <label for="radio-example-one">داين </label>

                          <input type="checkbox" name='field2' id="attend" @change="check()" />

                        </div>

                        <input id='parent' type="hidden" />

                        <input id='rank' type="hidden" />

                      </div>
                    </div>
                    <div class="card-footer">
                      <button type="button" class="btn btn-primary btn-lg btn-block" @click="addnode"> حفظ </button>
                    </div>
                  </form>
                </div>
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

    this.showtree('account');
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


