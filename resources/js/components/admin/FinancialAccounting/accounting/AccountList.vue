<template>
    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
              <span class="h2"> بيانات دليل الحسابات</span>
            </div>
            <p class="tx-12 tx-gray-500 mb-2">
  
            </p>
            <div class="d-flex justify-content-between">
  
              <input type="search" autocomplete="on" name="search" data-toggle="dropdown" role="button"
                aria-haspopup="true" aria-expanded="true" placeholder="بحث" v-model="word_search" @input="get_search()" />
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table text-md-nowrap" id="example1">
                <thead>
                  <tr>
                    <th class="wd-15p border-bottom-0">#</th>
                    <th class="wd-15p border-bottom-0">المنتج</th>
                    <th class="wd-15p border-bottom-0"> الحاله</th>
                    <th>المواصفات والطراز</th>
                    <th class="wd-15p border-bottom-0">الكميه المتوفره</th>
                    <th class="wd-15p border-bottom-0"> المخزن</th>
                    <!-- <th class="wd-15p border-bottom-0"> الرف</th> -->
  
  
  
                    <!-- <th class="wd-15p border-bottom-0">العمليات</th> -->
                  </tr>
                </thead>
                <tbody v-if="stocks && stocks.data.length > 0">
                  <tr v-for="(stock, index) in stocks.data" :key="index">
                    <td>{{ index + 1 }}</td>
                    <td>{{ stock.product }}</td>
                    <td>{{ stock.status }}</td>
                    <td>{{ stock.desc }}</td>
                    <td>{{ stock.quantity }}</td>
                    <td>{{ stock.store }}</td>
                    <!-- <td>{{ stock.shelve_name }}</td> -->
  
                    <!-- <td>
                      <button
                        type="button"
      
                        class="btn btn-danger"
                      >
                        <i class="mdi mdi-account-minus"></i>
                      </button>
                      <router-link
                        :to="{ name: 'edit_supply', params: { id: stock.id } }"
                        class="btn btn-success"
                        ><i class="mdi mdi-account-minus"></i
                      ></router-link>
                    </td> -->
                  </tr>
                </tbody>
                <tbody v-else>
                  <tr>
                    <td align="center" colspan="7">
                      <h3> المحزن فارغ </h3>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <pagination align="center" :data="stocks" @pagination-change-page="list"></pagination>
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
        // stock:'yes',
  
        stocks: {
          type: Object,
          default: null,
        },
  
        word_search: "",
  
  
      }
    },
    mounted() {
      this.list();
    },
    methods: {
  
      get_search(word_search) {
        this.axios.post(`/stocksearch`, { word_search: this.word_search }).then(({ data }) => {
  
  
          this.stocks = data;
  
          // this.$root.logo = "Category";
        });
      },
      list(page = 1) {
        this.axios
          .post(`/stock?page=${page}`)
          .then(({ data }) => {
            console.log(data);
            this.stocks = data;
          })
          .catch(({ response }) => {
            console.error(response);
          });
      },
      // delete_supply(id){
  
      //     this.axios.post(`delete_supply/${id}`).then(response => {
  
      // 		toast.fire({
      //                           title: "Deleted!",
      //                           text: "Your category has been deleted.",
      //                           button: "Close", // Text on button
      //                           icon: "success", //built in icons: success, warning, error, info
      //                           timer: 3000, //timeOut for auto-close
      //                           buttons: {
      //                               confirm: {
      //                               text: "OK",
      //                               value: true,
      //                               visible: true,
      //                               className: "",
      //                               closeModal: true
      //                               },
      //                               cancel: {
      //                               text: "Cancel",
      //                               value: false,
      //                               visible: true,
      //                               className: "",
      //                               closeModal: true,
      //                               }
      //                           }
      //                       })
  
      //               // this.$router.push('category')
  
      // 	})
      // }
    }
  }
  </script>
  
  
  