<template>
  <div class="wrapper">
    <div class="container-fluid">
      <div class="row">

        <div class="col-md-12">

          <div class="card">

            <div class="card-header">
              <span style="font-size: x-large">ايرادات</span>

              <div style="display: flex;float: left">
                <router-link to="/temporale_income" class="tn btn-info btn-sm waves-effect btn-agregar"
                    id="agregar_productos">
                    <i class="fa fa-plus-circle"></i></router-link>



              </div>
            </div>

            <div class="card-body">

              





              <!-- end row -->

              <div class="row" style="font-size: 10pt">
                <div class="col-md-12">
                  <div class="table-responsive">
                    <table class="table table-bordered text-right m-t-30" style="width: 100%; font-size: x-small">
                      <thead>
                        <tr>
                          <th style="width: 60px">#</th>
                          <th style="width: 60px">الايراد</th>
                      

                          <th style="width: 60px">المبلغ</th>

                          <th style="width: 60px">التاريخ</th>
                          <th style="width: 60px">العمليات</th>
                        </tr>
                      </thead>
                      <tbody v-if="expences && expences.data.length > 0">
                        <tr v-for="(expence, index) in expences.data" :key="index">
                          <td style="width: 40px">{{ index + 1 }}</td>
                          <td style="width: 40px">{{ expence.expence }}</td>
                         

                          <td>{{ expence.quantity }}</td>
                          <td>{{ expence.date }}</td>

                          <td>
                            <button type="button" class="btn btn-danger">
                              <i class="fa fa-trash"></i>
                            </button>
                            <router-link class="btn btn-success"><i class="fa fa-edit"></i></router-link>
                          </td>
                        </tr>
                      </tbody>
                      <tbody v-else>
                        <tr>
                          <td align="center" colspan="5">
                            <h3> لايوجد بيانات </h3>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>


        </div>





      </div>

      <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" style="display: none">
        <div class="modal-dialog modal-lg" style="width: 100%">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                x
              </button>
              <div class="col-md-8">
                <h4 class="modal-title" id="myLargeModalLabel">الايراد</h4>
              </div>
              <div class="col-md-4">
                <div class="col-sm-12">
                  <input type="text" placeholder="بحث" class="form-control" name="buscar_producto" id="buscar_producto"
                    v-model="word_search" @input="get_search()" />
                </div>
              </div>
            </div>



            <pagination align="center" :data="expences" @pagination-change-page="list"></pagination>
          </div>

        </div>


      </div>





      <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
        aria-hidden="true" style="display: none" id="modal_cero">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header text-center">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                x
              </button>
              <h2 class="modal-title" id="mySmallModalLabel" style="color: red"></h2>
            </div>
            <div class="modal-body">sdffffffffffffffffff</div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

      <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
        aria-hidden="true" style="display: none" id="modal_vaciar">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header text-center">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                هل انت متاكد انك تريد الحذف x
              </button>
              <h2 class="modal-title" id="mySmallModalLabel"></h2>
            </div>
            <div class="modal-body text-center">
              <button type="button" class="btn btn-danger" data-dismiss="modal" style="font-size: 12pt">
                <i class="fa fa-thumbs-down"></i>
              </button>

            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>




    </div>
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
      expences: {
        type: Object,
        default: null,
      },
      word_search: '',
    }
    // return data;
  },
  mounted() {
    this.list();


  },

  methods: {





    // get_search() {
    //     // alert(typeof(this.word_search));
    //     // alert(this.word_search);
    //     this.axios
    //         .post(`/supply/newsupplysearch`, { word_search: this.word_search })
    //         .then(({ data }) => {
    //             console.log(data.products);
    //             this.temporales = data.temporales;

    //             this.temporale.forEach((item) => {
    //                 this.total_quantity = item.tem_qty + this.total_quantity;
    //             });

    //             this.products = data.products;
    //             this.suppliers = data.suppliers;

    //             // this.stores = data;
    //         });
    // },
    list(page = 1) {
      this.axios
        .post(`/expences?page=${page}`)
        .then(({ data }) => {
          console.log(data.expences);



          this.expences = data.expences;


          // console.log(this.stores);

          // this.stores = data;
        })
        .catch(({ response }) => {
          console.error(response);
        });
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
  
<style scoped>
th,
td {
  text-align: center;
}
</style> 


