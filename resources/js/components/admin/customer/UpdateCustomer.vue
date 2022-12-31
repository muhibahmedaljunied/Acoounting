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
            <form method="post" @submit.prevent="updatecustomer">
              <input
                v-model="customer.id"
                type="text"
                name="id_name"
                id="id_name"
              />
              <div class="form-group">
                <label for="name">الاسم</label>
                <input
                  v-model="customer.name"
                  type="text"
                  name="name"
                  id="name"
                  class="form-control"
                />
              </div>
              <div class="form-group">
                <label for="phone">الهاتف</label>
                <input
                  v-model="customer.phone"
                  type="text"
                  name="phone"
                  id="phone"
                  class="form-control"
                />
              </div>
              <div class="form-group">
                <label for="name">اليريد الالكتروني</label>
                <input
                  v-model="customer.email"
                  type="text"
                  name="email"
                  id="email"
                  class="form-control"
                />
              </div>
              <div class="form-group">
                <label for="address">العنوان</label>
                <input
                  v-model="customer.address"
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

              <!-- <div class="form-group">
                <label for="status">الحاله</label>
                <input
                  v-model="customer.status"
                  type="text"
                  name="status"
                  id="status"
                  class="form-control"
                />
              </div> -->

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
      customer: {
        id: "",
        name: "",
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
    let uri = `/customer/${this.$route.params.id}`;
    this.axios.post(uri).then((response) => {
     
      this.customer.id = response.data.customer.id;
      this.customer.name = response.data.customer.name;
      this.customer.phone = response.data.customer.phone;
      this.customer.email = response.data.customer.email;
      this.customer.address = response.data.customer.address;
      this.customer.last_name = response.data.customer.last_name;
      this.customer.status = response.data.customer.status;

   
    });
  },
  methods: {
    updatecustomer(event) {
      let uri = `/update_customer/${this.$route.params.id}`;
      axios
        .post(uri, {

          id: this.customer.id,
          name: this.customer.name,
          phone: this.customer.phone,
          email: this.customer.email,
          address: this.customer.address,
          last_name: this.customer.last_name,
          status: this.customer.status,
        })
        .then((response) => {
          event.preventDefault();

          this.$router.go(-1);
        });
    },
  },
};
</script>