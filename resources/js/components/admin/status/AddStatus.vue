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
            <h3 class="text-center">اضافه مخزن</h3>
            <form method="post" @submit.prevent="addstatus">
              <div class="form-group">
                <label for="name">الاسم</label>
                <input
                  v-model="name"
                  type="text"
                  name="name"
                  id="name"
                  class="form-control"
                     required
                />
              </div>
            
              <button type="submit" class="btn btn-primary btn-lg btn-block">
                حفظ
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
      name: "",

    };
  },
  // created() {
  //   let uri = `/create_supplier`;
  //   this.axios.post(uri).then((response) => {
  //  console.log(response.data);
  //     this.role = response.data;
  //   });
  // },
  methods: {

    addstatus(event) {
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

      

      // send upload request
      this.axios
        .post("store_status", formData, config)
        .then(function (response) {
          currentObj.success = response.data.success;
          currentObj.filename = "";

          event.preventDefault();

          toastMessage("تم الاضافه بنجاح");
         
        })
        .catch(function (error) {
          currentObj.output = error;
        });

                this.$router.go(-1);

    },
  },
};
</script>