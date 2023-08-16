<template>
  <!-- row opened -->
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header">

          <span class="h2"> اضافه صندوق</span>



        </div>
        <div class="card-body" id="printme">
          <div class="row row-sm">
            <div class="col-xl-12">
              <div class="card">

                <div class="card-body">
                  <div class="form">

                    <form method="post">
                      <div class="form-group">
                        <label for="name"> الاسم </label>
                        <input type="text" name="name" id="name" class="form-control" />
                      </div>


                      <div class="form-group">
                        <label for="status">رقم الحساب</label>
                        <input type="text" name="status" :id="'Treasury_account_tree_id' + indexselectedtreasury"
                          class="form-control" />
                      </div>
                      <div class="form-group">
                        <label for="cliente">اسم الحساب</label>


                        <div class="custom-search">

                          <input :id="'Treasury_account_tree' + indexselectedtreasury" type="text"
                            class="custom-search-input">

                          <button class="custom-search-botton" type="button" data-toggle="modal"
                            @click="detect_index_treasury(indexselectedtreasury)" data-target="#exampleModaltreasury"> <i
                              class="fa fa-plus-circle"></i></button>

                        </div>



                      </div>






                      <button type="submit" class="btn btn-primary">
                        Add
                      </button>
                    </form>
                  </div>
                </div>

              </div>
            </div>

          </div>
        </div>
        <div class="modal fade" id="exampleModaltreasury" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
          aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">

                <div class="well" id="treeview_json_account"></div>

              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header">

          <span class="h2"> الصناديق</span>


          <div style="display: flex;float: left; margin: 5px">


            <input autocomplete="on" type="text" class="form-control input-text" placeholder="بحث ...."
              aria-label="Recipient's username" aria-describedby="basic-addon2">


            <div></div>
          </div>
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

            </table>
          </div>
        </div>

      </div>
    </div>

  </div>
</template>
<script>
import pagination from "laravel-vue-pagination";
import tree from '../../../../../js/tree/tree.js';
export default {
  mixins: [
    tree
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
      indexselectedtreasury: 0,
      type: '',
      type_of_tree: 0,
      jsonTreeData: '',
    }
    // return data;
  },
  mounted() {

    this.list();
    this.type = 'Bank';
    this.type_of_tree == 1
    this.showtree('account');



  },

  methods: {





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
  
  