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
            <h3 class="text-center">تعديل</h3>
            <form method="post" @submit.prevent="updateuser">
              <input
                v-model="user.id"
                type="hidden"
                name="id_name"
                id="id_name"
              />
              <div class="form-group">
                <label for="name">الاسم</label>
                <input
                  v-model="user.name"
                  type="text"
                  name="name"
                  id="name"
                  class="form-control"
                />
              </div>
              <div class="form-group">
                <label for="phone">الهاتف</label>
                <input
                  v-model="user.phone"
                  type="text"
                  name="phone"
                  id="phone"
                  class="form-control"
                />
              </div>
              <div class="form-group">
                <label for="name">اليريد الالكتروني</label>
                <input
                  v-model="user.email"
                  type="text"
                  name="email"
                  id="email"
                  class="form-control"
                />
              </div>
              <div class="form-group">
                <label for="address">العنوان</label>
                <input
                  v-model="user.address"
                  type="text"
                  name="address"
                  id="address"
                  class="form-control"
                />
              </div>
              <div class="form-group">
                <label for="role">نوع المستخدم</label>
                <select
                  v-model="roleselected"
                  name="role"
                  id="role"
                  class="form-control"
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
                  v-model="user.status"
                  type="text"
                  name="status"
                  id="status"
                  class="form-control"
                />
              </div>

              <button type="submit" class="btn btn-primary btn-lg">
                تعديل
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
      user: {
        id: "",
        name: "",
        status: "",
        phone: "",
        email: "",
        status: "",
        role:"",
        password: "",
      },
      role: "",

      roleselected:"",
    };
  },
  created() {
    let uri = `/user/${this.$route.params.id}`;
    this.axios.post(uri).then((response) => {
      console.log(response.data.user);

      response.data.user.forEach((item) => {
        this.user.id = item.id;
        this.user.name = item.name;
        this.user.phone = item.phone;
        this.user.email = item.email;
        this.user.address = item.address;
        this.user.password = item.password;
        this.user.status = item.status;
        this.roleselected = item.role_id;
     
      });
         this.role = response.data.role;
    });
  },
  methods: {
    updateuser(event) {
      let uri = `/update_user/${this.$route.params.id}`;
      axios
        .post(uri, {
          id: this.user.id,
          name: this.user.name,
          phone: this.user.phone,
          email: this.user.email,
          address: this.user.address,
          last_name: this.user.password,
          status: this.user.status,
          role: this.roleselected,
        })
        .then((response) => {
          event.preventDefault();

          this.$router.go(-1);
        });
    },
  },
};
</script>