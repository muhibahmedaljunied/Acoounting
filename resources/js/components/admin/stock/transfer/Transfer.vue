<template>
  <!-- row opened -->
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header pb-0">
          <div class="d-flex justify-content-between">
            <span class="h2">التحويلات المخزنيه</span>
          </div>

          <div class="d-flex justify-content-right">
            <router-link
              to="create_transfer"
              id="agregar_productos"
              class="tn btn-info btn-sm waves-effect btn-agregar"
              ><i class="fa fa-plus-circle"></i
            ></router-link>
    

            <input
              type="search"
              autocomplete="on"
              name="search"
              data-toggle="dropdown"
              role="button"
              aria-haspopup="true"
              aria-expanded="true"
             
              v-model="word_search"
              @input="get_search()"
            />

     

            <div></div>
          </div>
        </div>
        <div class="card-body" id="printme">
          <div class="row row-sm">
            <div class="table-responsive">
              <table class="table table-bordered text-center">
                <thead>
                  <tr>
                    <th>#</th>
                    <th class="wd-15p border-bottom-0" rowspan="1">
                      رقم السند
                    </th>
                    <th class="wd-15p border-bottom-0" rowspan="1">التاريخ</th>
                     <th class="wd-15p border-bottom-0" rowspan="1">العمليات</th>
                  </tr>
                </thead>
                <tbody v-if="transfers && transfers.length>0">
                  <tr v-for="(transfer,index) in transfers" :key="index">
                         <td >{{ index+1 }}</td>
                    <td >{{ transfer.id }}</td>
                    <td >
                      {{ transfer.date }}
                    </td>
                    <td>
                      <router-link
                        :to="`/transfer_details/${transfer.id}`"
                        class="btn btn-success"
                      >
                        تفاصيل
                      </router-link>
                    </td>
                  </tr>
                </tbody>
                  <tbody v-else>
                <tr>
                  <td align="center" colspan="4"><h3>  لايوجد بيانات </h3></td>
                </tr>
              </tbody>
              </table>
            </div>
          </div>

          <pagination
            align="center"
            :data="categorys"
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
        // category: "yes",

        transfers: "",

        word_search: "",
      };
    },
    mounted() {
      this.get_transfer();
    },
    methods: {
      get_transfer() {
        let uri = `/listtransfer`;
        this.axios
          .post(uri)
          .then((responce) => {
            this.transfers = responce.data;
          })
          .catch(({ response }) => {
            console.error(response);
          });
      },
      //   get_search(word_search) {
      //   this.axios
      //     .post(`/listsupplysearch`, { word_search: this.word_search })
      //     .then(({ data }) => {
      //              this.transfer_details = responce.data.transfer_details;

      //       // this.$root.logo = "Category";
      //     });
      // },
      // list(page = 1) {
      //   this.axios
      //     .post(`/listsupply?page=${page}`)
      //     .then(({ data }) => {

      //       this.transfer_details = responce.data.transfer_details;
      //     })
      //     .catch(({ response }) => {
      //       console.error(response);
      //     });
      // },
    },
  };
</script>

