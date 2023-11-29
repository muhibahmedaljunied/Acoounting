<template>
  <div class="wrapper">
    <div class="container-fluid">
      <div class="row row-sm">
        <div class="col-xl-12">
          <div class="card">
            <div class="card-header">
              <div class="pull-right">
                <span style="font-size: x-large">مصروفات</span>
              </div>


              <div style="display: flex;float: left">

                <router-link to="/temporale_expence" class="tn btn-info btn-sm waves-effect btn-agregar"
                  id="agregar_productos">
                  <i class="fa fa-plus-circle"></i></router-link>



              </div>





            </div>
         
            <div class="card-body">



              <div class="col-md-12">
                <div class="table-responsive">
                  <table class="table table-bordered text-right m-t-30" style="width: 100%; font-size: x-small">
                    <thead>
                      <tr>
                        <th style="width: 60px">#</th>
                        <th style="width: 60px">المصروف</th>
                        <!-- <th style="width: 60px">المجموعه</th> -->
                        <!-- <th style="width: 60px">الصنف</th> -->
                        <!-- <th style="width: 60px">المخزن</th> -->
                        <!-- <th style="width: 60px">الرف</th> -->
                        <!-- <th style="width: 60px">الحاله</th>
                          <th style="width: 60px">المواصفات والطراز</th> -->

                        <th style="width: 60px">المبلغ</th>
                        <th style="width: 60px">التاريخ</th>
                        <th style="width: 60px">العمليات</th>
                      </tr>
                    </thead>
                    <tbody v-if="expences && expences.data.length > 0">
                      <tr v-for="(expence, index) in expences.data" :key="index">
                        <td style="width: 40px">{{ index + 1 }}</td>
                        <td style="width: 40px">{{ expence.expence }}</td>
                        <!-- <td style="width: 40px">
                            {{ temporales.group_name }}
                          </td>
                          <td style="width: 40px">
                            {{ temporales.category_name }}
                          </td> -->
                        <!-- <td style="width: 40px">
                            {{ temporales.store }}
                          </td> -->
                        <!-- <td style="width: 40px">
                            {{ temporales.shelve_name }}
                          </td> -->
                        <!-- <td style="width: 40px">{{ temporales.status }}</td> -->
                        <!-- <td style="width: 40px">{{ temporales.desc }}</td> -->

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
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>





    </div>
  </div>
</template>
<script>
import pagination from "laravel-vue-pagination";
import operation from '../../../../../js/operation.js';
export default {
  components: {
    pagination,
  },
  mixins: [operation],
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





    list(page = 1) {
      this.axios
        .post(`/expences?page=${page}`)
        .then(({ data }) => {
          console.log(data.expences);



          this.expences = data.expences;


        })
        .catch(({ response }) => {
          console.error(response);
        });
    },


  },
};
</script>
  
<style scoped>
th,
td {
  text-align: center;
}
</style> 


