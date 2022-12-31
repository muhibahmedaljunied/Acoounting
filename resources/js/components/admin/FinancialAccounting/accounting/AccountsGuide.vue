<template>
  <!-- row opened -->
  <div class="row row-sm">
    <div class="col-xl-6">
      <div class="card">
        <div class="card-header pb-0">
            <div class="d-flex justify-content-between">

              <span style="font-size: x-large"> شجره الحسابات</span>
              <!-- <router-link to="create_product" id="agregar_productos"
                class="tn btn-info btn-lg waves-effect btn-agregar"><i class="fa fa-plus-circle"></i></router-link> -->

            </div>

          </div>
        <div class="card-body">
          <div class="container">
            <div class="row justify-content-left">
              <div class="col-md-6">
                <div class="card">
                
                  <div class="card-body">
                    <!-- <div class="container"> -->
                      <!-- <button @click="prints()">click</button> -->
                      <div class="well" id="treeview_json"></div>

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


      <div class="container">
        <div class="row justify-content-left">
          <div class="col-md-6">
            <div class="card">


              <form method="post">

                <div class="card-body">
                  <div class="form">
                <h3 class="text-center">اضافه حساب</h3>

                <div class="form-group">
                  <ul>
                    <div v-for="error in errors">
                      <li>{{ error[0] }}</li>
                    </div>
                  </ul>
                </div>

                <div class="form-group">
                  <label for="Product">رقم الحساب</label>
                  <input id='account_number_first_level' type="text" class="form-control" required />

                </div>

                <div class="form-group">
                  <label for="Product">اسم الحساب</label>
                  <input v-model="text" type="text" name="Product" id="account_first_level"
                    class="form-control" required />

                </div>

                <div class="form-group">
                  <label for="radio-example-one">متفرع </label>

                  <input type="checkbox" name='fieldset2' id="attend" @change="check()" />
                </div>


                <div class="form-group">
                  <label for="radio-example-one">مدين </label>

                  <input type="checkbox" name='field1' id="attend" @change="check()" />

                  <label for="radio-example-one">داين </label>

                  <input type="checkbox" name='field2' id="attend" @change="check()" />

                </div>

              </div>
                </div>
                <div class="card-footer">
                  <button type="button" class="btn btn-primary btn-lg btn-block" @click="submitForm()"> حفظ </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

    </div>

<!-- 
    <div class="modal fade" id="account_main" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <form method="post" @submit.prevent="first_level">
          <div class="modal-content">
            <div class="modal-header">

              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <div class="form">
                <h3 class="text-center">اضافه حساب</h3>

                <div class="form-group">
                  <ul>
                    <div v-for="error in errors">
                      <li>{{ error[0] }}</li>
                    </div>
                  </ul>
                </div>

                <div class="form-group">
                  <label for="Product">رقم الحساب</label>
                  <input id='account_number_first_level' type="text" class="form-control" required />

                </div>

                <div class="form-group">
                  <label for="Product">اسم الحساب</label>
                  <input v-model="account_first_level" type="text" name="Product" id="account_first_level"
                    class="form-control" required />

                </div>

                <div class="form-group">
                  <label for="radio-example-one">متفرع </label>

                  <input type="checkbox" name='fieldset2' id="attend" @change="check()" />
                </div>


                <div class="form-group">
                  <label for="radio-example-one">مدين </label>

                  <input type="checkbox" name='field1' id="attend" @change="check()" />

                  <label for="radio-example-one">داين </label>

                  <input type="checkbox" name='field2' id="attend" @change="check()" />

                </div>

              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary btn-lg btn-block"> حفظ </button>
            </div>
          </div>
        </form>
      </div>
    </div> -->

    <!-- <div class="modal fade" id="exampleModal_add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <form method="post" @submit.prevent="submitForm">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"> </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="container">


            </div>
            <div class="modal-body">

              <div class="form">
                <h3 class="text-center">اضافه حساب</h3>

                <div class="form-group">
                  <ul>
                    <div v-for="error in errors">
                      <li>{{ error[0] }}</li>
                    </div>
                  </ul>
                </div>
                <div class="form-group">
                  <label for="Product">رقم الحساب</label>
                  <input type="text" id="account_number" class="form-control" required />

                </div>

                <div class="form-group">
                  <label for="Product"> الاسم العربي </label>
                  <input v-model="text" type="text" id="account" class="form-control" required />

                </div>
                <div class="form-group">
                  <label for="Product">الاسم الانجلبزي</label>
                  <input type="text" id="account_name_en" class="form-control" required />

                </div>

                <div class="form-group">
                  <label for="Product">الحساب الريسي</label>
                  <input type="text" id="parent" class="form-control" required />

                </div>


                <div class="form-group">
                  <label for="Product">الرتبه</label>
                  <input type="text" id="rank" class="form-control" required />

                </div>


                <div class="form-group">
                  <label for="currency">العمله</label>
                  <input type="text" id="currency" class="form-control" />
                </div>








              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary btn-lg btn-block"> حفظ </button>
            </div>
          </div>
        </form>
      </div>
    </div> -->
    <!-- <div class="modal fade" id="exampleModal_update" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <form method="post" @submit.prevent="update_account">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"> </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <div class="form">
                <h3 class="text-center">نعديل حساب</h3>

                <div class="form-group">
                  <label for="Product">رقم الحساب</label>
                  <input type="text" id="update_account_number" class="form-control" required />

                </div>

                <div class="form-group">
                  <label for="Product">اسم الحساب </label>
                  <input v-model="text" type="text" class="form-control" id="update_account" required />
                </div>


                <div class="form-group">
                  <label for="Product">الحساب الريسي</label>
                  <input type="text" id="update_parent" class="form-control" required />

                </div>


                <div class="form-group">
                  <label for="Product">الرتبه</label>
                  <input type="text" id="update_rank" class="form-control" required />

                </div>



                <div class="form-group">
                  <label for="currency">العمله</label>
                  <input type="text" id="update_currency" class="form-control" />
                </div>





              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary btn-lg btn-block"> نعديل </button>
            </div>
          </div>
        </form>
      </div>
    </div> -->
    <!-- <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
      aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          حذف
        </div>
      </div>
    </div> -->
  </div>


</template>
<script>

export default {
  data() {
    return {
      n: "",
      show: false,

      account_id: [],
      text: [],
      account_name_en: [],
      // account_main: [],
      rank: [],
      account_first_level: '',
      account_type: [],
      currency: [],



      tree: {
        child: [],
      },

      account_main: '',
      count: 1,
      trees: "",
      jsonTreeData: [],


      errors: "",

      success: "",
    };
  },


  created() {
    localStorage.setItem('id', 0);
    localStorage.setItem('rank', 0);
    localStorage.setItem('table', 'account');


    // --------

    this.showtree();

    // initial();

  },
  methods: {

    showtree() {

      this.axios.post(`/tree_account`).then((response) => {
        this.trees = response.data.accounts;
        this.jsonTreeData = response.data.accounts;
        this.last_nodes = response.data.last_nodes;

        $(`#account_number_first_level`).val(response.data.last_nodes + 1);

        $('#treeview_json').jstree({
          core: {
            themes: {
              responsive: false,
            },
            // so that create works
            check_callback: true,
            data: this.jsonTreeData,
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






        });

      });
    },

   

    // first_level(e) {
    //   e.preventDefault();
    //   addnode_first(this.account_first_level);

    // },

    // data_for_select_node(node_id) {


    //   $("#account_main_first_level").val(node_id);

    // },




    submitForm() {

      // e.preventDefault();
      addnode(this.text);
      // this.$router.go(0);
    },

    update_account(e) {
      e.preventDefault();
      updatenode($("#update_account_number").val(), this.text);
    },

  },
};
</script>
<!-- <style scoped>
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
</style> -->

