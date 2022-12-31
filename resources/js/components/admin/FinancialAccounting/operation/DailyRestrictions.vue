<template>
  <!-- row opened -->
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <!-- <form method="post" @submit.prevent="submitForm"> -->
        <form method="post" @submit.prevent="addDaily">
          <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
              <span class="h2"> قيود اليوميه</span>
            </div>
          </div>
          <div class="card-body" id="printme">
            <div class="row">
              <div class="col-sm-12">
                <div class="form-group">
                  <div class="row">
                    <div class="col-md-2">
                      <label for="desde">تاريخ القيد </label>
                      <input type="date" class="form-control hasDatepicker" id="modal_reporte_venta_inicio"
                        name="modal_reporte_venta_inicio" v-model="daily_date" onkeypress="return controltag(event)"
                        style="background-color: white" />
                    </div>
                    <div class="col-md-2">
                      <div class="row">
                        <div class="col-md-6">
                          <label for="name">اجمالي المدين </label>
                          <input v-model="total" type="number" class="form-control" readonly />
                        </div>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="row">
                        <div class="col-md-6">
                          <label for="name">اجمالي الداين</label>
                          <input v-model="total" type="number" class="form-control" readonly />
                        </div>
                      </div>
                    </div>
                    <!-- <div class="form-group">
                      <div class="row">
                        <div class="col-md-6">
                          <label for="name">المبلغ</label>
                          <input
                            v-model="total"
                            type="text"
                            class="form-control"
                            name="name"
                            id="name"
                            required
                          />
                        </div>
                      </div>
                    </div> -->

                    <!-- <div class="form-group">
                      <div class="row">
                        <div class="col-md-2">
                          <button
                            type="submit"
                            id="agregar_productos"
                            class="tn btn-info btn-lg waves-effect btn-agregar"
                          >
                            <i class="fa fa-plus-circle"></i>
                          </button>
                        </div>
                      </div>
                      <div></div>
                    </div> -->
                  </div>
                </div>
              </div>
            </div>

            <div class="table-responsive">
              <table class="table table-bordered text-center">
                <thead>
                  <tr>
                    <th class="wd-15p border-bottom-0">رقم الحساب</th>
                    <th class="wd-15p border-bottom-0">اسم الحساب</th>
                    <th class="wd-15p border-bottom-0">البيان</th>
                    <th class="wd-15p border-bottom-0">مدين</th>

                    <th class="wd-15p border-bottom-0">داين</th>
                    <th>+</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="index in count" :key="index">
                    <!-- <tr > -->
                    <td>
                      <input v-model="account_id[index]" required @input="get_account_name(account_id[index], index)"
                        type="number" id="qty" name="account_id" class="form-control input_cantidad"
                        onkeypress="return valida(event)" />
                    </td>
                    <td>

                      <div class="custom-search">
                        <input type="text" class="custom-search-input">
                        <button class="custom-search-botton" type="submit" data-toggle="modal"
                          data-target="#exampleModal"> <i class="fa fa-plus-circle"></i></button>
                      </div>
                      <!-- <input
                        v-model="account_name[index]"
                        required
                       
                        type="text"
                        id="qty"
                        class="form-control input_cantidad"
                        onkeypress="return valida(event)"
                      /> -->
                    </td>
                    <td>
                      <input v-model="description[index]" required type="text" style="width: 500px" id="qty"
                        class="form-control input_cantidad" onkeypress="return valida(event)" />
                    </td>
                    <td>
                      <input v-model="debit[index]" type="number" style="width: 150px" id="qty"
                        class="form-control input_cantidad" onkeypress="return valida(event)" />
                    </td>
                    <td>
                      <input v-model="credit[index]" type="number" style="width: 150px" id="qty"
                        class="form-control input_cantidad" onkeypress="return valida(event)" />
                    </td>
                    <button v-on:click="addComponent" class="tn btn-info btn-sm waves-effect btn-agregar">
                      <i class="fa fa-plus-circle"></i>
                    </button>
                  </tr>
                </tbody>
              </table>
              <button type="submit" class="tn btn-info btn-lg waves-effect btn-agregar">
                حفظ القيد
              </button>
            </div>
          </div>
        </form>
        <!-- Button trigger modal -->

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
          aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="container">

                  <div class="well" id="treeview_json"></div>

                </div>
              </div>

            </div>
          </div>
        </div>
        <!-- </form> -->
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
      count: 1,

      daily_date: "2021-11-24",
      total: "",
      trees: "",
      jsonTreeData: [],
      account_id: [],
      account_name: [],
      description: [],
      debit: [],
      credit: [],
    };
  },
  created() {
    this.axios.post("/tree_account").then((response) => {
      this.trees = response.data.accounts;
      this.jsonTreeData = response.data.accounts;

      this.prints();


      $('#treeview_json').on('changed.jstree', function (e, data) {

      });

    });

  },
  methods: {
    prints() {
      $("#treeview_json").jstree({
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
        state: { key: "demo2" },
        plugins: ["state", "types", "checkbox", 'changed'],
      });



    },
    get_account_name(account_id, index) {
      let uri = `/get_account_name/${account_id}`;
      this.axios.post(uri).then((response) => {

        this.account_name[index] = response.data.accounts[0].account_name;
      });
    },
    addComponent() {
      this.count += 1;
    },
    addDaily(e) {
      e.preventDefault();


      this.axios
        .post("store_daily", {
          count: this.count,
          daily_date: this.daily_date,
          total: this.total,
          account_id: this.account_id,
          description: this.description,
          account_name: this.account_name,
          debit: this.debit,
          credit: this.credit,
        })
        .then(function (response) {
          console.log(response);
          currentObj.success = response.data.success;
          currentObj.filename = "";
          e.preventDefault();

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


