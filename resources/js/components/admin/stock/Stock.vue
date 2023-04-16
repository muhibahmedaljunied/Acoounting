<template>
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header pb-0">
          <div class="d-flex justify-content-between">
            <span class="h2"> المخزون</span>
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
                  <!-- <td>{{ stock.quantity }} {{ stock.unit }}</td> -->


                  <td>

                    <div v-for="temx in stock.units">



                      <span v-if="temx.unit_type == 0">

                        <span v-if="stock.quantity / stock.rate >= 1">
                          {{ Math.floor((stock.quantity / stock.rate)) }}{{
                            stock.units[0].name
                          }}
                        </span>

                        <span v-if="stock.quantity % stock.rate >= 1">
                          {{ Math.floor((stock.quantity % stock.rate)) }}{{
                            stock.units[1].name
                          }}
                        </span>
                      </span>

                    </div>

                  </td>

            
                  <td>{{ stock.store }}</td>

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

  }
}
</script>


