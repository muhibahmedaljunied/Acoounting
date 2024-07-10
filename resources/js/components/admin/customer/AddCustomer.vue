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
            <h3 class="text-center">اضافه عميل </h3>

              <div class="form-group">
                <label for="name">الاسم</label>
                <input style="background-color: beige;" v-model="name" type="text" name="name" id="name" class="form-control" required />
              </div>
              <div class="form-group">
                <label for="phone">الهاتف</label>
                <input v-model="phone" type="text" name="phone" id="phone" class="form-control" />
              </div>
              <div class="form-group">
                <label for="name">البريد الالكتروني</label>
                <input v-model="email" type="text" name="email" id="email" class="form-control" />
              </div>
              <div class="form-group">
                <label for="password">كلمه السر</label>
                <input v-model="password" type="text" name="password" id="password" class="form-control" required />
              </div>
              <div class="form-group">
                <label for="address">العنوان</label>
                <input v-model="address" type="text" name="address" id="address" class="form-control" />
              </div>

              
              <div class="form-group">
                <label for="">التصنيف</label>
                <select style="background-color: beige;" name="forma_pago" class="form-control" id="forma_pago"
                  v-model="group">

                   <option value="0">عام</option>

                                    <option v-for="customer_group in customer_groups" v-bind:value="customer_group.id">
                                        {{ customer_group.name }}</option>

                </select>
              </div>
              <!-- = -->
              <!-- <div class="m-t-20 col-md-6 col-xs-6"> -->
              <!-- <div class="form-group">
                <label for="cliente">اسم الحساب</label>


                <div class="custom-search">



                  <input :id="'Customer_account_tree'" type="text" class="custom-search-input">
                  <input :id="'Customer_account_tree_id'" type="hidden" class="custom-search-input">
                  <button class="custom-search-botton" type="button" data-toggle="modal"
                    data-target="#exampleModalaccount"> <i class="fa fa-plus-circle"></i></button>
                </div>



              </div> -->
              <!-- <div class="form-group">
                <label for="status">اسم الحساب</label>
                <input :id="'Customer_account_tree'+indexselected" v-model="account_name" type="text" name="status" class="form-control" />
              </div> -->
              <!-- = -->

              <!-- <div class="form-group">
                <label for="role">الصلاحيه</label>
                <select v-model="roleselected" name="role" id="role" class="form-control">
                  <option value="">select</option>
                  <option v-for="roles in role" v-bind:value="roles.id">
                    {{ roles.name }}
                  </option>
                </select>
              </div> -->

              <!-- <div class="form-group">
                <label for="status">الحاله</label>
                <input v-model="status" type="text" name="status" id="status" class="form-control" />
              </div> -->
              <button @click="addcustomer()" type="submit" class="btn btn-primary btn-lg btn-block">
                حفظ
              </button>
   
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
import operation from '../../../operation1.js';
// import tree from '../../../../js/tree/tree.js';
export default {
  mixins: [
        operation,
        // tree
    ],
  data() {
    
    return {
  
      // indexselected:0,
      // account_name:'',
      // account:'',
      type: '',
      name: "",
      phone: "",
      email: "",
      address: "",
      password: 123,
      // status: 1,
      role: '',
      // roleselected: 1,
      type_of_tree:'',
      jsonTreeData:'',
      group:'',
      customer_groups:'',
    };
  },


  mounted() {
    this.type = 'Customer';
    // this.type_of_tree=1;
    // this.showtree('account');

    this.axios
        .post(`/customer_groups`)
        .then(({ data }) => {
          this.customer_groups = data.groups;
        })
        .catch(({ response }) => {
          console.error(response);
        });

  },
  methods: {

    
    addcustomer() {
    
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
      formData.append("group", this.group);

      // formData.append("account", this.account);
      // formData.append("password", this.password);
      // formData.append("status", this.status);
      // formData.append("role_id", this.roleselected);

      // send upload request
      this.axios
        .post("store_customer", formData, config)
        .then(function (response) {
          currentObj.success = response.data.success;
          currentObj.filename = "";

       
          toastMessage("تم الاضافه بنجاح");

        })
        .catch(function (error) {
          currentObj.output = error;
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