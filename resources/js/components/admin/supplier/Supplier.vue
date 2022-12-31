<template>
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header pb-0">
          <div class="d-flex justify-content-right">
            <span class="h2"> الموردين</span>
          </div>

          <div class="d-flex justify-content-right">
            <router-link
              to="create_supplier"
              class="tn btn-info btn-sm waves-effect btn-agregar"
              ><i class="fa fa-plus-circle"></i
            ></router-link>

            <!-- <button @click="Export()">
              <i
                class="fas fa-file-export"
                style="font-size: 24px; color: #ee335e"
              ></i>
            </button>

            <button @click="Import()">
              <i
                class="fas fa-file-import"
                style="font-size: 24px; color: #22c03c"
              ></i>
            </button> -->

            <input
              type="search"
              autocomplete="on"
              name="search"
              data-toggle="dropdown"
              role="button"
              aria-haspopup="true"
              aria-expanded="true"
              placeholder="بحث عن مورد"
              v-model="word_search"
              @input="get_search()"
            />
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table text-md-nowrap" id="example1">
              <thead>
                <tr>
                      <th class="wd-15p border-bottom-0">#</th>
                  <th class="wd-15p border-bottom-0">الاسم الاول</th>
                  <th class="wd-15p border-bottom-0">الاسم الاخير</th>
                  <th class="wd-15p border-bottom-0">الهاتف</th>
                  <th class="wd-15p border-bottom-0">البريد الالكتروني</th>
                  <th class="wd-15p border-bottom-0">العنوان</th>
                  <!-- <th class="wd-15p border-bottom-0">الحاله</th> -->

                  <th class="wd-15p border-bottom-0">العمليات</th>
                </tr>
              </thead>
              <tbody v-if="suppliers && suppliers.data.length > 0">
                <tr v-for="(supplier, index) in suppliers.data" :key="index">
                      <td>{{ index+1 }}</td>
                  <td>{{ supplier.name }}</td>
                  <td>{{ supplier.last_name }}</td>
                  <td>{{ supplier.phone }}</td>
                  <td>{{ supplier.email }}</td>
                  <td>{{ supplier.address }}</td>

                  <!-- <td>{{ supplier.status }}</td> -->
                  <!-- <td v-if="supplier.status == 1">
                    <span class="badge badge-warning">مفعل</span>
                  </td>

                  <td v-else-if="supplier.status == 0">
                    <span class="badge badge-danger">غبر مفعل</span>
                  </td> -->

                  <td>
                    <button
                      type="button"
                      @click="delete_supplier(supplier.id)"
                      class="btn btn-danger"
                    >
                      <i class="fa fa-trash"></i>
                    </button>
                    <router-link
                      :to="{
                        name: 'edit_supplier',
                        params: { id: supplier.id },
                      }"
                      class="btn btn-success"
                      ><i class="fa fa-edit"></i
                    ></router-link>
                  </td>
                </tr>
              </tbody>
              <tbody v-else>
                <tr>
                  <td align="center" colspan="3"><h3>  لايوجد موردين </h3></td>
                </tr>
              </tbody>
            </table>
          </div>
          <pagination
            align="center"
            :data="suppliers"
            @pagination-change-page="list"
          ></pagination>
        </div>
      </div>
    </div>
    <!--/div-->
  </div>
</template>
<script>
import pagination from "laravel-vue-pagination";
export default {
  components: {
    pagination,
  },

  data() {
    return {
      // supplier:'yes',

      suppliers: {
        type: Object,
        default: null,
      },

      word_search: "",
    };
  },
  mounted() {
    this.list();
  },
  methods: {
    get_search(word_search) {
      this.axios
        .post(`/suppliersearch`, { word_search: this.word_search })
        .then(({ data }) => {
          this.suppliers = data;
        });
    },
    Import() {
      this.axios.post(`/SupplierImport`).then(({ data }) => {
        this.list();
      });
    },

    Export() {
      this.axios.post(`/SupplierExport`).then((responce) => {
        console.log(responce);
      });
    },

    delete_supplier(id) {
      this.axios
        .post(`delete_supplier/${id}`)
        .then((response) => {
          toastMessage("تم الحذف بنجاح");

          this.list();
        })
        .catch((error) => {
          console.log(error.response);

          if (error.response.status == 500) {
            // toastMessage("فشل", error.response.data.message);
             toastMessage("فشل",'لايمكن الحذف لانه مرتبط بعملبات اخري');
          }
        });
    },
    list(page = 1) {
      this.axios
        .post(`/supplier?page=${page}`)
        .then(({ data }) => {
          this.suppliers = data;
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },
  },
};
</script>

