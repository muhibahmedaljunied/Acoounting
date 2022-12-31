<template>
  <!-- row opened -->
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header pb-0">
          <div class="d-flex justify-content-between">
            <span class="h2"> المستخدمين</span>
          </div>

          <div class="d-flex justify-content-right">
            <router-link
              to="create_user"
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
              placeholder=" بحث عن مستخدم"
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
                  <th class="wd-15p border-bottom-0">كلمه السر</th>
                  <th class="wd-15p border-bottom-0">الصلاحيه</th>
                  <!-- <th class="wd-15p border-bottom-0">الحاله</th> -->

                  <th class="wd-15p border-bottom-0">العمليات</th>
                </tr>
              </thead>
              <tbody v-if="users && users.data.length > 0">
                <tr v-for="(user, index) in users.data" :key="index">
                     <td>{{ index+1 }}</td>
                  <td>{{ user.name }}</td>
                  <td>{{ user.phone }}</td>
                  <td>{{ user.email }}</td>
                  <td>{{ user.address }}</td>
                  <td>{{ user.password }}</td>
                  <td>{{ user.role_name }}</td>
                  <!-- <td>{{ user.status }}</td> -->
                  <!-- <td v-if="user.status == 1">
                    <span class="badge badge-warning">مفعل</span>
                  </td>
                  <td v-else-if="user.status == 0">
                    <span class="badge badge-danger">غبر مفعل</span>
                  </td> -->

                  <td>
                    <button
                      type="button"
                      @click="delete_user(user.id)"
                      class="btn btn-danger"
                    >
                      <i class="fa fa-trash"></i>
                    </button>
                    <router-link
                      :to="{ name: 'edit_user', params: { id: user.id } }"
                      class="btn btn-success"
                      ><i class="fa fa-edit"></i
                    ></router-link>
                  </td>
                </tr>
              </tbody>
              <tbody v-else>
                <tr>
                  <td align="center" colspan="3">لايوجد بياتات.</td>
                </tr>
              </tbody>
            </table>
          </div>
          <pagination
            align="center"
            :data="users"
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
      //   user: "yes",

      users: {
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
    delete_user(id) {
      this.axios.post(`/delete_user/${id}`).then((response) => {
        // this.$router.push('user')
      });

      this.list();
    },
    get_search(word_search) {
      this.axios
        .post(`/usersearch`, { word_search: this.word_search })
        .then(({ data }) => {
          this.users = data;
        });
    },
    list(page = 1) {
      this.axios
        .post(`/user?page=${page}`)
        .then(({ data }) => {
          this.users = data;
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },
  },
};
</script>