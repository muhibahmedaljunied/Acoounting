<template>
  <!-- row opened -->
  <div>
    <div class="row row-sm">

      <div class="col-xl-6">
        <div class="card">
          <div class="card-header pb-0">
            <div class="d-flex justify-content-between">

              <span style="font-size: x-large"> شجره المخازن</span>

            </div>
            <div class="card-body">
              <div class="container">
                <div class="row justify-content-left">
                  <div class="col-md-6">
                    <div class="card">
                      <div class="card-header">
                        <!-- <a class="tn btn-info btn-sm waves-effect btn-agregar" data-toggle="modal" id="agregar_storeos"
                          data-target="#store_main">
                          <i class="fa fa-plus-circle"></i></a> -->
                      </div>

                      <div class="card-body">

                        <div class="well" id="treeview_json"></div>
                      </div>
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
            <div class="col-md-6">
              <div class="card">
                <form method="post">

                  <!-- <div class="card-header">
                          <span style="font-size: x-large"> اضافه مخزن</span>

                        </div> -->

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
                        <input v-model="text" type="text" name="store" id="store" class="form-control" required />

                      </div>



                      <div class="form-group">
                        <label for="radio-example-one">متفرع </label>

                        <input type="checkbox" name='fieldset2' id="attend" @change="check()" />

                        <input id='parent' type="hidden" />

                        <input id='rank' type="hidden" />

                      </div>

                    </div>
                    <div class="card-footer">
                      <button type="button" class="btn btn-primary btn-lg btn-block" @click="add_store"> حفظ </button>
                    </div>
                  </div>
                </form>

              </div>
            </div>
          </div>
        </div>


        <!--/div-->
      </div>

      <!-- <div class="modal fade" id="store_main" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                  <h3 class="text-center">اضافه مخزن</h3>

                  <div class="form-group">
                    <ul>
                      <div v-for="error in errors">
                        <li>{{ error[0] }}</li>
                      </div>
                    </ul>
                  </div>

                  <div class="form-group">
                    <label for="store">رقم المخزن</label>
                    <input id='store_number_first_level' type="text" class="form-control" required />

                  </div>

                  <div class="form-group">
                    <label for="store">اسم المخزن</label>
                    <input v-model="store_first_level" type="text" name="store" id="store_first_level"
                      class="form-control" required />

                  </div>

                  <div class="form-group">
                    <input v-model="rank" type="hidden" id="rank" class="form-control" readonly required />

                  </div>
                  <div class="form-group">
                    <input v-model="parent" type="hidden" class="form-control" readonly required />

                  </div>



                </div>

              </div>
              <div class="modal-footer">

                <button type="submit" class="btn btn-primary btn-lg btn-block"> حفظ </button>
              </div>
            </div>
          </form>
        </div>
      </div> -->
      <!--  -->



      <!-- <div class="modal fade" id="exampleModalTree_add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
          <form method="post" @submit.prevent="add_store">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">

                <div class="form">
                  <h3 class="text-center">اضافه مخزن</h3>

                  <div class="form-group">
                    <ul>
                      <div v-for="error in errors">
                        <li>{{ error[0] }}</li>
                      </div>
                    </ul>
                  </div>

                  <div class="form-group">
                    <label for="store">رقم المخزن</label>
                    <input id='store_number' type="text" class="form-control" required />

                  </div>
                  <div class="form-group">
                    <label for="store">اسم المخزن</label>
                    <input v-model="text" type="text" name="store" id="store" class="form-control" required />

                  </div>
                 

                  <div class="form-group">

                    <input id='parent' type="text" />

                    <input id='rank' type="text" />

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
          <form method="post" @submit.prevent="update_store">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">

                <div class="form">
                  <h3 class="text-center">نعديل المخازن</h3>

                  <div class="form-group">
                    <ul>
                      <div v-for="error in errors">
                        <li>{{ error[0] }}</li>
                      </div>
                    </ul>
                  </div>

                  <div class="form-group">
                    <label for="store">رقم المخزن</label>
                    <input id='update_store_number' value="" type="text" class="form-control" required />

                  </div>
                  <div class="form-group">
                    <label>اسم المخزن</label>
                    <input v-model="text" type="text" value="" id="update_store" class="form-control" required />

                  </div>
                  <div class="form-group">
                    <label>الريسي</label>
                    <input id='update_parent' value="" type="text" class="form-control" required />

                  </div>

                  <div class="form-group">
                    <label> الرتبه</label>
                    <input id='update_rank' value="" type="text" class="form-control" required />

                  </div>

                </div>

              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary btn-lg btn-block"> حفظ </button>
              </div>

            </div>
          </form>
        </div>
      </div> -->

      <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            حذف
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
      d: 0,
      show: false,
      id: 1,
      parent: 0,
      store_id: [],
      text: [],
      store_name_en: [],
      rank: [],
      store: '',
      // store_first_level: '',

      tree: {
        child: [],
      },

      store_main: '',
      trees: "",
      jsonTreeData: [],

      errors: "",

      success: "",
    };
  },


  created() {

    localStorage.setItem('id', 0);
    localStorage.setItem('rank', 0);
    localStorage.setItem('table', 'store');
    // initial();

    this.showtree();

  },
  methods: {
    showtree() {


      this.axios.post(`/tree_store`).then((response) => {
        this.trees = response.data.stores;
        this.jsonTreeData = response.data.stores;
        this.last_nodes = response.data.last_nodes;

        // $(`#store_number_first_level`).val(response.data.last_nodes + 1);
        $(`#store_number`).val(response.data.last_nodes + 1);


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






        }).on('rename_node.jstree', function (e, data) {
          let currentObj = this;
          const config = {
            headers: {
              "content-type": "multipart/form-data",
            },
          };


          let formData = new FormData();
          formData.append("text", data.node.text);

          let url = `/store_rename_node/${data.node.id}`;
          axios.post(url, formData).then((response) => {

            currentObj.success = response.data.success;
            currentObj.filename = "";
            this.$router.go(0);
          }).catch(function (error) {
            currentObj.output = error;
          });
        }).on("changed.jstree", function (e, data) {


        });

      });
    },
    first_level(e) {
      e.preventDefault();
      addnode_first(this.store);

    },
    add_store(e) {


      addnode(this.text);

      this.$router.go(0);
    },

    update_store(e) {

      e.preventDefault();

      updatenode($("#update_store_number").val(), this.text);

      // this.$router.go(0);
    },

    data_for_select_node(node_id) {


      $("#store_main_first_level").val(node_id);

    },






  },
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
