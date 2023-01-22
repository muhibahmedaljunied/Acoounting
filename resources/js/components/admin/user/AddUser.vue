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
            <h3 class="text-center">اضافه مستخدم </h3>
            <form method="post" @submit.prevent="adduser">
              <div class="form-group">
                <label for="name">الاسم</label>
                <input
                  v-model="name"
                  type="text"
                  name="name"
                  id="name"
                  class="form-control"
                     required
                /><span style="color:red">{{ error_name[0] }}</span>
              </div>
              <div class="form-group">
                <label for="phone">الهاتف</label>
                <input
                  v-model="phone"
                  type="text"
                  name="phone"
                  id="phone"
                  class="form-control"
                />
              </div>
              <div class="form-group">
                <label for="name">البريد الالكتروني</label>
                <input
                  v-model="email"
                  type="text"
                  name="email"
                  id="email"
                  class="form-control"
                /><span style="color:red">{{ error_email[0] }}</span>
              </div>
               <div class="form-group">
                <label for="password">كلمه السر</label>
                <input
                  v-model="password"
                  type="text"
                  name="password"
                  id="password"
                  class="form-control"
                     required
                />
                <span style="color:red">{{ error_password[0] }}</span>
              </div>
              <div class="form-group">
                <label for="address">العنوان</label>
                <input
                  v-model="address"
                  type="text"
                  name="address"
                  id="address"
                  class="form-control"
                />
              </div>
              <div class="form-group">
                <label for="role">الصلاحيه</label>
                <select
                  v-model="roleselected"
                  name="role"
                  id="role"
                  class="form-control"
                     required
                >
                  <option value="">select</option>
                  <option v-for="roles in role" v-bind:value="roles.id">
                    {{ roles.name }}
                  </option>
                </select>
              </div>

              <div class="form-group">
                <label for="status">الحاله</label>
                <input
                  v-model="status"
                  type="text"
                  name="status"
                  id="status"
                  class="form-control"
                />
              </div>
              <button type="submit" class="btn btn-primary btn-lg btn-block">
                اضافه
              </button>
            </form>
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
      error_password:'',
      name: "",
      phone: "",
      email: "",
      address: "",
      password: 123,
      status: 1,
      role:'',
      roleselected:1,
    };
  },
  created() {
    let uri = `/create_user`;
    this.axios.post(uri).then((response) => {
   console.log(response.data);
      this.role = response.data;
    });
  },
  methods: {
    // adduser(event) {
    //   this.axios.post(`/store_user`).then((response) => {
    //     event.preventDefault();
    //     this.$router.push("user");
    //   });
    // },
    adduser(event) {
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
      formData.append("password", this.password);
      formData.append("status", this.status);
      formData.append("role_id", this.roleselected);

      // send upload request
      this.axios
        .post("store_user", formData, config)
        .then(function (response) {
          currentObj.success = response.data.success;
          currentObj.filename = "";

          event.preventDefault();
          toastMessage("تم الاضافه بنجاح");
         
        })
        .catch(error => {
                       console.error(error)
                       
                       this.error_name = error.response.data.error.name
                       this.error_email = error.response.data.error.email
                       this.error_password = error.response.data.error.password
                       
                     });

                this.$router.go(-1);

    },
  },
};
</script>