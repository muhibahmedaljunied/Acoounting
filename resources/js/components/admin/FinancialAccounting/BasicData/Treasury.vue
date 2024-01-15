<template>
  <!-- row opened -->
  <div>

    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header">

            <h4 class="modal-title" id="myLargeModalLabel">اضافه صندوق</h4>


          </div>
          <div class="card-body">

            <div class="row">
              <div class="col-xl-2">
                <label for="">الحساب المرتبط </label>

                <div class="custom-search">

                  <input id="Treasury_account_tree" type="text" class="custom-search-input">

                  <button class="custom-search-botton" type="button" data-toggle="modal"
                    data-target="#exampleModalTreasury"> <i class="fa fa-plus-circle"></i></button>

                </div>

              </div>
              
              <div class="col-xl-2">
                <label for="">رقم الحساب </label>

                <input type="text"  name="status" id="Treasury_account_tree_id"
                  class="form-control" />
              </div>
            </div>
            <br>
          
            <div class="row row-sm">
         

          
           
              <div class="col-xl-12">



                <form method="post" enctype="multipart/form-data">

                  <div class="table-responsive">
                    <table class="table table-bordered text-right m-t-30" style="width: 100%; font-size: x-small">
                      <thead>
                        <tr>

                          <th>الصندوق </th>

                          <!-- <th> الحساب التحليلي </th> -->

                          <th>العمله </th>


                          <!-- <th>رقم الحساب </th> -->



                          <th>اضافه</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="index in count" :key="index">
                          <td>
                            <input v-model="treasury[index]" type="text" class="form-control" name="name" id="name"
                              required />
                          </td>
                   




                          <td>
                            <input v-model="currency[index]" type="text" class="form-control" name="name" id="name"
                              required />
                          </td>






                          <td v-if="index == 1">
                            <a class="tn btn-info btn-sm waves-effect btn-agregar" v-on:click="addComponent(count)">
                              <i class="fa fa-plus-circle"></i></a>

                            <a class="tn btn-info btn-sm waves-effect btn-agregar" v-on:click="disComponent(count)">
                              <i class="fa fa-minus-circle"></i></a>
                          </td>



                        </tr>

                        <tr>
                          <td colspan="2"></td>
                          <td>

                            <button type="button" class="btn btn-primary" @click="Add_new()">حفظ </button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>


                          </td>
                        </tr>

                      </tbody>
                    </table>
                  </div>
                </form>






              </div>


            </div>
          </div>

          <div class="modal fade" id="exampleModalTreasury" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">

                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">

                  <div class="well" id="treeview_json_account_treasury"></div>

                </div>

              </div>
            </div>
          </div>


        </div>
      </div>
    </div>
    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header">



            <h4 class="modal-title" id="myLargeModalLabel">الصناديق </h4>


          </div>
          <div class="card-body" id="printme">
            <div class="table-responsive">
              <table class="table table-bordered text-center">
                <thead>
                  <tr>
                    <!-- <th class="wd-15p border-bottom-0">الرقم الوظيفي</th> -->
                    <th class="wd-15p border-bottom-0">اسم الصندوق</th>
                    <th class="wd-15p border-bottom-0"> الحساب</th>



                    <th class="wd-15p border-bottom-0">العمليات</th>
                  </tr>
                </thead>
                <tbody v-if="treasuries && treasuries.data.length > 0">
                  <tr v-for="(treasury, index) in treasuries.data" :key="index">
                    <td>
                      {{ treasury.name }}
                    </td>
                    <td>
                      {{ treasury.text }} {{ treasury.account_id }}
                    </td>

                    <td>
                      <button data-toggle="modal" class="tn btn-danger btn-sm waves-effect btn-agregar">
                        <i class="fa fa-trash"></i></button>

                    </td>






                  </tr>
                </tbody>
                <tbody v-else>
                  <tr>
                    <td align="center" colspan="3">
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
</template>
<script>
import pagination from "laravel-vue-pagination";
import tree from '../../../../../js/tree/tree.js';
import operation from '../../../../../js/operation.js';


export default {
  mixins: [
    tree,
    operation
  ],
  components: {
    pagination,
  },
  data() {

    return {
      treasuries: {
        type: Object,
        default: null,
      },
      treasury: [],
      currency: [],

      account: [],
      // indexselectedtreasury: 0,
      type: '',
      type_of_tree: 0,
      jsonTreeData: '',
    }
    // return data;
  },
  mounted() {

    this.list();
    this.counts[0] = 1;
    this.type = 'Treasury';
    this.type_of_tree == 1
    this.showtree('account');



  },

  methods: {




    Add_new() {

      this.axios
        .post(`/store_treasury`, {
          count: this.counts,
          type: this.type,
          name: this.treasury,
          account: this.account,


        }
        )
        .then((response) => {
          console.log(response);
          toastMessage("تم الاضافه بنجاح");
          // this.$router.go(0);
        });




    },


    list(page = 1) {
      this.axios
        .post(`/treasuries?page=${page}`)
        .then(({ data }) => {
          console.log(data);



          this.treasuries = data.treasuries;

        })
        .catch(({ response }) => {
          console.error(response);
        });
    },


  },
};
</script>
  
  