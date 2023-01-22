<template>
  <!-- row opened -->
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header pb-0">
          <div class="d-flex justify-content-between">
            <span class="h2"> العملاء</span>
          </div>

          <div class="d-flex justify-content-right">
            <router-link
              to="create_customer"
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
              placeholder=" بحث عن عميل"
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
                  <th class="wd-15p border-bottom-0">الاسم</th>
                  <th class="wd-15p border-bottom-0">الهاتف</th>
                  <th class="wd-15p border-bottom-0">البريد الالكتروني</th>
                  <th class="wd-15p border-bottom-0">العنوان</th>
                  <th class="wd-15p border-bottom-0">رقم الحساب</th>
                  <th class="wd-15p border-bottom-0">الرصيد</th>
                  <th class="wd-15p border-bottom-0">كلمه السر</th>
                  <th class="wd-15p border-bottom-0">الصلاحيه</th>
                  <!-- <th class="wd-15p border-bottom-0">الحاله</th> -->

                  <th class="wd-15p border-bottom-0">العمليات</th>
                </tr>
              </thead>
              <tbody v-if="customers && customers.data.length > 0">
                <tr v-for="(customer, index) in customers.data" :key="index">
                  <td>{{ index+1 }}</td>
                  <td>{{ customer.name }}</td>
                  <td>{{ customer.phone }}</td>
                  <td>{{ customer.email }}</td>
                  <td>{{ customer.address }}</td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <!-- <td>{{ customer.status }}</td> -->
                  <!-- <td v-if="customer.status == 1">
                    <span class="badge badge-warning">مفعل</span>
                  </td>
                  <td v-else-if="customer.status == 0">
                    <span class="badge badge-danger">غبر مفعل</span>
                  </td> -->

                  <td>
                    <button
                      type="button"
                      @click="delete_customer(customer.id)"
                      class="btn btn-danger"
                    >
                      <i class="fa fa-trash"></i>
                    </button>
                    <router-link
                      :to="{ name: 'edit_customer', params: { id: customer.id } }"
                      class="btn btn-success"
                      ><i class="fa fa-edit"></i
                    ></router-link>
                  </td>
                </tr>
              </tbody>
              <tbody v-else>
                <tr>
                  <td align="center" colspan="3"><h3>  لايوجد عملاء </h3></td>
                </tr>
              </tbody>
            </table>
          </div>
          <pagination
            align="center"
            :data="customers"
            @pagination-change-page="list"
          ></pagination>
        </div>
      </div>
    </div>
    <!--/div-->
  </div>
  <!-- /row -->
</template>
<script>
import pagination from "laravel-vue-pagination";
export default {
  components: {
    pagination,
  },
  data() {
    return {
      //   customer: "yes",

      customers: {
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
    delete_customer(id) {
      this.axios.post(`/delete_customer/${id}`).then((response) => {
        // this.$router.push('customer')
      });

      this.list();
    },
    get_search(word_search) {
      this.axios
        .post(`/customersearch`, { word_search: this.word_search })
        .then(({ data }) => {
          this.customers = data;
        });
    },
    list(page = 1) {
      this.axios
        .post(`/customer?page=${page}`)
        .then(({ data }) => {
          this.customers = data;
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },
  },
};
</script>