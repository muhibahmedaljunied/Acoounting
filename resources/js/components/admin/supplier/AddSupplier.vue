<template>
  <!-- row opened -->
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header pb-0">
          <div class="d-flex justify-content-between">
            <h4 class="card-title mg-b-0">SIMPLE TABLE</h4>
            <i class="mdi mdi-dots-horizontal text-gray"></i>
          </div>
          <p class="tx-12 tx-gray-500 mb-2">
            Example of Valex Simple Table. <a href="">Learn more</a>
          </p>
        </div>
        <div class="card-body">
          <div class="form">
            <h3 class="text-center">اضافه مورد</h3>
            <form method="post" @submit.prevent="addsupplier">
              <div class="form-group">
                <label for="name"> الاسم الاول</label>
                <input v-model="name" type="text" name="name" id="name" class="form-control" /><span style="color:red">{{ error_name[0] }}</span> 
              </div>
              <div class="form-group">
                <label for="role">الاسم الاخير</label>
                <input v-model="last_name" type="text" name="last_name" id="last_name" class="form-control" />
              </div>

              <div class="form-group">
                <label for="phone">الهاتف</label>
                <input v-model="phone" type="text" name="phone" id="phone" class="form-control" />
              </div>
              <div class="form-group">
                <label for="name">البريد الالكتروني</label>
                <input v-model="email" type="text" name="email" id="email" class="form-control" /><span style="color:red">{{ error_email[0] }}</span> 
              </div>

              <div class="form-group">
                <label for="address">العنوان</label>
                <input v-model="address" type="text" name="address" id="address" class="form-control" />
              </div>
              <!-- = -->
              <!-- <div class="m-t-20 col-md-6 col-xs-6"> -->
              <div class="form-group">
                <label for="cliente">رقم الحساب</label>


                <div class="custom-search">
                  <select v-model="supplier" id="supplier" class="custom-search-input">
                    <!-- <option v-for="sup in suppliers" v-bind:value="[sup.id, sup.name]">
                      {{ sup.name }}
                    </option> -->
                  </select>


                  <!-- <input id='product_tree' type="text" class="custom-search-input"> -->
                  <button class="custom-search-botton" type="button" data-toggle="modal"
                    data-target="#exampleModalProduct"> <i class="fa fa-plus-circle"></i></button>
                </div>



              </div>
              <div class="form-group">
                <label for="status">اسم الحساب</label>
                <input v-model="status" type="text" name="status" id="status" class="form-control" />
              </div>
              <!-- = -->
              <div class="form-group">
                <label for="status">الحاله</label>
                <input v-model="status" type="text" name="status" id="status" class="form-control" />
              </div>
              <button type="submit" class="btn btn-primary btn-lg btn-block">
                Add
              </button>
            </form>
          </div>
        </div>
        <div class="modal fade" id="exampleModalProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
          aria-hidden="true">
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
      </div>
    </div>
    <!--/div-->
  </div>
  <!-- /row -->
</template>
<script>
export default {
  data() {
    return {
      error_name:'',
      error_email:'',
      name: "",
      phone: "",
      email: "",
      address: "",
      last_name: "",
      status: "",
    };
  },
  created() {
    this.showtree();
  },
  methods: {
    addsupplier(event) {
      event.preventDefault();
      let currentObj = this;
      const config = {
        headers: {
          "content-type": "multipart/form-data",
        },
      };
      // form data
      let formData = new FormData();

      formData.append("name", this.name);
      formData.append("phone", this.phone);
      formData.append("email", this.email);
      formData.append("address", this.address);
      formData.append("last_name", this.last_name);
      formData.append("status", this.status);

      // send upload request
      this.axios
        .post("store_supplier", formData, config)
        .then(function (response) {
          currentObj.success = response.data.success;
          currentObj.filename = "";
          // console.log(response.error);
          event.preventDefault();
          toastMessage("تم الاضافه بنجاح");
        })
        .catch(error => {
                       console.error(error)
                       
                       this.error_name = error.response.data.error.name
                       this.error_email = error.response.data.error.email
                       
                     });

      // this.$router.go(-1);
    },
    showtree() {


      this.axios.post(`/tree_product`).then((response) => {
        this.jsonTreeDataProduct = response.data.products;


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
          $(`.modal-title-product`).val(data.node.id)
          //  modal-title-store

        });

      });
      this.axios.post(`/tree_store`).then((response) => {
        this.jsonTreeDataStore = response.data.stores;


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
          $(`.modal-title-store`).val(data.node.id)
          //  modal-title-store
        });

      });
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
  
<style scoped>
th,
td {
  text-align: center;
}
</style> 


