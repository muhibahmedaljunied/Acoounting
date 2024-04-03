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
              <!-- <div class="form-group">
                <label for="cliente">رقم الحساب</label>


                <div class="custom-search">

                  <input :id="'Supplier_account_tree_id'" type="text" class="custom-search-input">
                  <button class="custom-search-botton" type="button" data-toggle="modal" 
                    data-target="#exampleModalaccount"> <i class="fa fa-plus-circle"></i></button>

                </div>



              </div> -->
              <!-- <div class="form-group">
                <label for="status">اسم الحساب</label>
                <input id = "Supplier_account_tree"  type="text" name="status"  class="form-control" />
              </div> -->
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
        <!-- <div class="modal fade" id="exampleModalaccount" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
        </div> -->
      </div>
    </div>
    <!--/div-->
  </div>
  <!-- /row -->
</template>
<script>
import operation from '../../../../js/operation.js';
import tree from '../../../../js/tree/tree.js';
export default {
  mixins: [
        operation,
        tree
    ],
  data() {
    return {
  
      // indexselected:0,
      type:'',
      error_name:'',
      error_email:'',
      name: "",
      phone: "",
      email: "",
      address: "",
      last_name: "",
      status: "",
      type_of_tree:0,
      jsonTreeData:'',
    };
  },
 
  mounted() {
    this.type =  'Supplier';
    this.type_of_tree =1;
    // this.showtree('account','tree_account');
   
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
      // formData.append("account", this.account);
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
    
  },
};
</script>
  
<style scoped>
th,
td {
  text-align: center;
}
</style> 


