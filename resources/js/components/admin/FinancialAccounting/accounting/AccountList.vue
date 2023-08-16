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
                    <th class="wd-15p border-bottom-0">رقم الحساب</th>
                    <th class="wd-15p border-bottom-0"> اسم الحساب</th>
                    <th> مدين</th>
                    <th class="wd-15p border-bottom-0"> داين</th>
                
  
                    <!-- <th class="wd-15p border-bottom-0">العمليات</th> -->
                  </tr>
                </thead>
                <tbody v-if="value_list && value_list.data.length > 0">
                  <tr v-for="(daily, index) in value_list.data" :key="index">
           
                    <td>{{ index + 1 }}</td>
                    <td>{{ daily.account_id }}</td>
                    <td>{{ daily.text }}</td>
                    <td>{{ daily.debit }}</td>
                    <td>{{ daily.credit }}</td>
                
                  </tr>
                </tbody>
                <tbody v-else>
                  <tr>
                    <td align="center" colspan="7">
                      <h3> لايوجد بيانات </h3>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <pagination align="center" :data="value_list" @pagination-change-page="list"></pagination>
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
  
        value_list: {
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
  
        });
      },
      list(page = 1) {
        this.axios
          .post(`/account_list?page=${page}`)
          .then(({ data }) => {
            console.log(data.daily_details);
            this.value_list = data.daily_details;
          })
          .catch(({ response }) => {
            console.error(response);
          });
      },
     
    }
  }
  </script>
  
  
  