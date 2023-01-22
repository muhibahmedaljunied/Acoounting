<template>
  <!-- row opened -->
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header pb-0">
          <div class="d-flex justify-content-between">
            <span class="h2"> الوحدات</span>
          </div>

          <div class="d-flex justify-content-right">
            <router-link
              to="create_unit"
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

                  <th class="wd-15p border-bottom-0">العمليات</th>
                </tr>
              </thead>
              <tbody v-if="units && units.length > 0">
                <tr v-for="(unit, index) in units" :key="index">
                     <td>{{ index+1 }}</td>
                  <td>{{ unit.name }}</td>
            
                

                  <td>
                    <button
                      type="button"
                      @click="delete_unit(unit.id)"
                      class="btn btn-danger"
                    >
                      <i class="fa fa-trash"></i>
                    </button>
                    <router-link
                      :to="{ name: 'edit_unit', params: { id: unit.id } }"
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
            :data="units"
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
      //   unit: "yes",

      units: {
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
    delete_unit(id) {
      this.axios.post(`/delete_unit/${id}`).then((response) => {
        // this.$router.push('unit')
      });

      this.list();
    },
    get_search(word_search) {
      this.axios
        .post(`/unitsearch`, { word_search: this.word_search })
        .then(({ data }) => {
          this.units = data.units;
        });
    },
    list(page = 1) {
      this.axios
        .post(`/unit?page=${page}`)
        .then(({ data }) => {
          this.units = data.units;
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },
  },
};
</script>