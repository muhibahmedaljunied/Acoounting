<template>

  <div class="container-fluid">


    <div class="row row-sm">

      <div class="col-xl-4">
        <div class="card">
          <div class="card-header pb-0">


            <span style="font-size: x-large"> شجره المنتجات</span>

          </div>
          <div class="card-body">
            <div class="container">
              <div class="row justify-content-left">
                <div class="col-md-12">
                  <div class="card">


                    <div class="card-body">
                      <!-- <div class="container">
                  <div class="well" id="treeview_json_product"></div>
                </div> -->

                      <div class="container">
                        <div class="row">
                          <div class="col-xs-12">
                            <div class="input-group">

                              <input type="text" id="ricerca-enti" class="form-control" placeholder="بحث"
                                aria-describedby="search-addon">

                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-xs-12" id="treeview_json_product">

                            <div id="test">

                            </div>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
      <div class="col-xl-8">
        <div class="card">
          <div class="card-header">
            <span class="h2"> المخزون</span>

            <div style="display: flex;float: left; margin: 5px">

              <input type="search" autocomplete="on" name="search" data-toggle="dropdown" role="button"
                aria-haspopup="true" aria-expanded="true" placeholder="بحث" v-model="word_search"
                @input="get_search()" />
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
                    <th class="wd-15p border-bottom-0"> المخزن</th>

                    <th class="wd-15p border-bottom-0">الكميه المتوفره</th>
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

                    <td>{{ stock.store }}</td>

                    <td>


                      <div v-for="temx in stock.qty_after_convert['quantity']">



                        <span v-for="temx2 in temx">


                          <span style="float: right;">
                            {{ temx2[0] }}
                            <span style="color: red;">
                              {{ temx2[1] }}
                            </span>

                          </span>



                        </span>



                      </div>

                    </td>



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

  </div>

</template>
<script>

import pagination from "laravel-vue-pagination";
import operation from '../../../operation1.js';
import tree from '../../../../js/tree/tree.js';

export default {

  mixins: [pagination, operation, tree],
  data() {
    return {
      stocks: {
        type: Object,
        default: null,
      },

      word_search: "",
      trees: '',


    }
  },
  mounted() {

    this.type = 'Product';
    this.type_of_tree = 0;

    this.list();


    // this.showtree('product', 'tree_product');


  },
  created() {

    localStorage.setItem('id', 0);
    localStorage.setItem('rank', 0);
    localStorage.setItem('table', 'product');
    this.showtree('product', 'tree_product');
  },
  methods: {

    get_search(word_search) {
      this.axios.post(`/stocksearch`, { word_search: this.word_search }).then(({ data }) => {


        this.stocks = data;

      });
    },
    list(page = 1) {
      this.axios
        .post(`/stock?page=${page}`, {
          "type_qty": this.type,
          "operation": 'StockQty',

        })
        .then(({ data }) => {
          console.log(data);
          this.stocks = data.stocks;
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },

  }
}
</script>
