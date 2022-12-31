<template>
  <!-- row opened -->
  <div>
    <div class="row row-sm">

      <div class="col-xl-6">
        <div class="card">
          <div class="card-header pb-0">
            <div class="d-flex justify-content-between">

              <span style="font-size: x-large"> شجره المنتجات</span>
              <!-- <router-link to="create_product" id="agregar_productos"
                class="tn btn-info btn-lg waves-effect btn-agregar"><i class="fa fa-plus-circle"></i></router-link> -->

            </div>

          </div>
          <div class="card-body">
            <div class="container">
              <div class="row justify-content-left">
                <div class="col-md-6">
                  <div class="card">
                    <div class="card-header">
                      <!-- <a class="tn btn-info btn-sm waves-effect btn-agregar" data-toggle="modal" id="agregar_productos"
                        data-target="#product_main">
                        <i class="fa fa-plus-circle"></i></a> -->
                    </div>

                    <div class="card-body">
                      <!-- <div class="container"> -->

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
                        <input v-model="text" type="text" name="Product" id="product" class="form-control" required />

                      </div>

                      <div class="form-group">
                        <label for="radio-example-one">متفرع </label>

                        <input type="checkbox" name='fieldset2' id="attend" @change="check()" />
                        <input id='parent' type="hidden" />

                        <input id='rank' type="hidden" />

                      </div>

                      <!-- <div class="form-group">
                        <label for="Product">الوحده الريسيه</label>
                        <input v-model="text" type="text" name="Product" id="product" class="form-control" required />

                      </div> -->

                      <div id="factura_producto" class="input_nombre">
                        <label for="Product">الوحده الريسيه</label>
                                        <select name="type" id="type" class="form-control"
                                            required>
                                            <option >
                                                
                                            </option>
                                        </select>
                                    </div>


                      <div class="form-group">
                        <label for="Product"> سعر الشراء</label>
                        <input v-model="text" type="text" name="Product" id="product" class="form-control" required />

                      </div>

                      <div class="form-group">
                        <label for="Product"> الحد الادني للمنتج</label>
                        <input v-model="text" type="number" name="Product" id="product" class="form-control" required />

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
                        <input v-on:change="onFileChange" type="file" name="image" class="form-control-file"
                          id="filePhoto" />
                        <img src="" id="previewHolder" width="150px" />
                      </div>



                    </div>
                  </div>
                  <div class="card-footer">
                    <button type="button" class="btn btn-primary btn-lg btn-block" @click="add_product"> حفظ </button>
                  </div>
                </form>
              </div>
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

  </div>

</template>

<script>


export default {

  data() {
    return {
      file: '',
      text: '',
      product: '',
      image: '',
      // product_first_level: '',
      last_nodes: '',
      rank: 1,
      parent: 0,
      id: '',
      trees: "",
      errors: "",
      jsonTreeData: [],
      add: 0,


    };
  },
  created() {
    localStorage.setItem('id', 0);
    localStorage.setItem('rank', 0);
    localStorage.setItem('table', 'product');

    // initial();

    this.showtree();
  },

  methods: {
    showtree() {

      let gthis = 'this';
      this.axios.post(`/tree_product`).then((response) => {
        this.trees = response.data.products;
        this.jsonTreeData = response.data.products;
        this.last_nodes = response.data.last_nodes;

        // $(`#product_number_first_level`).val(response.data.last_nodes + 1);
        $(`#product_number`).val(response.data.last_nodes + 1);


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

          let url = `/product_rename_node/${data.node.id}`;
          axios.post(url, formData).then((response) => {

            currentObj.success = response.data.success;
            currentObj.filename = "";

          }).catch(function (error) {
            currentObj.output = error;
          });
        }).on("changed.jstree", function (e, data) {


        });

      });
    },


    // Import() {
    //   this.axios.post(`/ProductImport`).then(({

    //   }) => {
    //     this.list();

    //     toastMessage("تم الاستيراد بنجاح");
    //   });
    // },
    // Export() {
    //   this.axios.post(`/ProductExport`).then((responce) => {
    //     toastMessage("تم التصدير بنجاح");

    //     console.log(responce.data.data);
    //   });
    // },

    first_level(e) {

      e.preventDefault();
      addnode_first(this.product);
    },

    onFileChange(e) {
      this.file = e.target.files[0];
    },
    add_product(e) {
      // e.preventDefault();

      addnode(this.text);
      this.$router.go(0);




    },

    updateproduct(e) {
      e.preventDefault();
      updatenode($("#update_product_number").val(), this.text);



    }

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


