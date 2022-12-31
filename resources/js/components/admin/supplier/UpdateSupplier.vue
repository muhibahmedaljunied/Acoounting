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
            <h3 class="text-center">نعديل بيانات المورد</h3>
            <form method="post" @submit.prevent="updatesupplier">
              <input v-model="supplier.id" type="hidden" name="name" id="name" />
              <div class="form-group">
                <label for="name">الاسم</label>
                <input
                  v-model="supplier.name"
                  type="text"
                  name="name"
                  id="name"
                  class="form-control"
                />
              </div>
               <div class="form-group">
                <label for="address">الاسم الاخير</label>
                <input
                  v-model="supplier.last_name"
                  type="text"
                  name="address"
                  id="address"
                  class="form-control"
                />
              </div>
              <div class="form-group">
                <label for="phone">الهاتف</label>
                <input
                  v-model="supplier.phone"
                  type="text"
                  name="phone"
                  id="phone"
                  class="form-control"
                />
              </div>
              <div class="form-group">
                <label for="name">الايميل</label>
                <input
                  v-model="supplier.email"
                  type="text"
                  name="email"
                  id="email"
                  class="form-control"
                />
              </div>
              <div class="form-group">
                <label for="address">العنوات</label>
                <input
                  v-model="supplier.address"
                  type="text"
                  name="address"
                  id="address"
                  class="form-control"
                />
              </div>
             

              <!-- <div class="form-group">
                <label for="status">الحاله</label>
                <input
                  v-model="supplier.status"
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
      supplier: {
        id: "",
        name: "",
        last_name: "",
        phone: "",
        email: "",
        address: "",
        status: "",
      },
    };
  },
  created() {
    let uri = `/supplier/${this.$route.params.id}`;
    this.axios.post(uri).then((response) => {
      console.log(response);
      this.supplier.id = response.data.supplier.id;
      this.supplier.name = response.data.supplier.name;
      this.supplier.phone = response.data.supplier.phone;
      this.supplier.email = response.data.supplier.email;
      this.supplier.address = response.data.supplier.address;
      this.supplier.last_name = response.data.supplier.last_name;
      this.supplier.status = response.data.supplier.status;
    });
  },
  methods: {
    updatesupplier(event) {
      axios
        .post(`/update_supplier/${this.$route.params.id}`, {
          id: this.supplier.id,
          name: this.supplier.name,
          phone: this.supplier.phone,
          email: this.supplier.email,
          address: this.supplier.address,
          last_name: this.supplier.last_name,
          status: this.supplier.status,
        })
        .then((response) => {
          console.log(response);
          event.preventDefault();

          toastMessage("تم التعديل بنجاح");
        });

      this.$router.go(-1);
    },
  },
};
</script>