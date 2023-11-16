<template>
  <!-- row opened -->

  <div class="card">
    <div class="card-header pb-0">
      <div class="d-flex justify-content-between">
        <span class="h2">المخازن</span>
      </div>
    </div>
    <div class="card-body">
      <div class="row row-sm">

        <div class="col-xl-6">
          <div class="card">
            <div class="card-header pb-0">
              <div class="d-flex justify-content-between">

                <span style="font-size: x-large"> شجره المخازن</span>

              </div>
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

        <div class="col-xl-6">

          <div class="container">
            <div class="row justify-content-left">
              <div class="col-md-12">
                <div class="card">
                  <form method="post">

                    <div class="card-header">
                      <span style="font-size: x-large"> اضافه المخازن</span>

                    </div>

                    <div class="card-body">
                      <div class="form">

                        <div class="form-group">
                          <ul>
                            <div v-for="error in errors">
                              <li>{{ error[0] }}</li>
                            </div>
                          </ul>
                        </div>

                        <div class="form-group">
                          <label for="store">رقم المخزن</label>
                          <input id='store_number' type="text" class="form-control" required readonly />

                        </div>
                        <div class="form-group">
                          <label for="store">اسم المخزن</label>
                          <input v-model="text" type="text" name="store" id="store" class="form-control" required /><span
                            style="color:red">{{ error_text[0] }}</span>

                        </div>

                        <div class="form-group">
                          <label for="radio-example-one">متفرع </label>

                          <input type="checkbox" name='fieldset2' v-model="status" id="status">

                          <input id='parent' type="hidden" />

                          <input id='rank' type="hidden" />

                        </div>

                        <div v-if="status == false" class="form-group">
                          <label for="cliente">اسم الحساب</label>


                          <div class="custom-search">

                            <input :id="'Store_account_tree'" type="text" class="custom-search-input">
                            <input :id="'Store_account_tree_id'" type="hidden" readonly class="custom-search-input">
                            <button class="custom-search-botton" type="button" data-toggle="modal"
                              data-target="#exampleModalaccount"> <i class="fa fa-plus-circle"></i></button>

                          </div>



                        </div>




                      

                      </div>
                      <div class="card-footer">
                        <button type="button" class="btn btn-primary btn-lg btn-block" @click="addnode()"> حفظ </button>
                      </div>
                    </div>
                  </form>

                </div>
              </div>
            </div>
          </div>


          <!--/div-->
        </div>



        <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
          aria-hidden="true">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              حذف
            </div>
          </div>
        </div>

        <div class="modal fade" id="exampleModalaccount" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
          aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">

                <div class="well" id="treeview_json_account"></div>

              </div>

            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<script>
// import jtree from '../../../../js/jtree.js';
import tree from '../../../../js/tree/tree.js';

export default {
  // mixins: [jtree],
  mixins: [tree],

  data() {

    return {
      d: 0,
      error_text: '',
      show: false,
      status: false,
      id: 1,
      parent: 0,
      store_id: [],
      text: [],
      store_name_en: [],
      rank: [],
      store: '',
      status_product: false,
      // store_first_level: '',

      tree: {
        child: [],
      },

      account: '',
      store_main: '',
      trees: "",
      // jsonTreeData: [],
      // type_of_tree:0,
      errors: "",

      success: "",
    };
  },

  mounted() {
    this.type = 'Store';
    this.showtree('account');

  },
  created() {

    this.type_of_tree = 0;
    localStorage.setItem('id', 0);
    localStorage.setItem('rank', 0);
    localStorage.setItem('table', 'store');
    this.showtree('store');

  },
  methods: {


    // add_store(e) {


    //   addnode(this);

    //   // this.$router.go(0);
    // },

    // update_store(e) {

    //   e.preventDefault();

    //   updatenode($("#update_store_number").val(), this.text);

    //   // this.$router.go(0);
    // },

    data_for_select_node(node_id) {


      $("#store_main_first_level").val(node_id);

    },


    exports_excel() {

      axios
        .post(`export_store`)
        .then(function (response) {

          // console.log(1);
        })
        .catch(error => {

        });
    },
    imports_excel() {

      axios
        .post(`import_store`)
        .then(function (response) {

          // console.log(1);
        })
        .catch(error => {

        });
    },






  },
};
</script>



