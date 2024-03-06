<template>
  <div class = 'container-fluid'>
    <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <!-- <form method="post" @submit.prevent="submitForm"> -->

        <div class="card-header pb-0">
          <div class="d-flex justify-content-between">
            <span class="h2">اقفال الحسابات</span>
          </div>
        </div>
        <div class="card-body" id="printme">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <div class="row">
                  <div class="col-md-10">
                    <label for="desde">تاريخ القيد </label>
                    <input type="date" class="form-control hasDatepicker" id="modal_reporte_venta_inicio"
                      name="modal_reporte_venta_inicio" v-model="daily_date" onkeypress="return controltag(event)"
                      style="background-color: white" />
                  </div>
              

                </div>
              </div>
            </div>
          </div>

          <div class="table-responsive">
            <table class="table table-bordered text-center">
              <thead>
                <tr>
                  <th class="wd-15p border-bottom-0">رقم الحساب</th>
                  <th class="wd-15p border-bottom-0">اسم الحساب</th>
                  <th class="wd-15p border-bottom-0">البيان</th>
                  <th class="wd-15p border-bottom-0">مدين</th>

                  <th class="wd-15p border-bottom-0">داين</th>
                  <th>+</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="index in count" :key="index">
                  <!-- <tr > -->
                  <td>
                    <input required type="number" :id="'Daily_account_tree_id' + index" name="account_id"
                      class="form-control input_cantidad" readonly />
                  </td>
                  <td>

                    <!-- <div class="custom-search">
                      <input type="text" class="custom-search-input">
                      <button class="custom-search-botton" type="submit" data-toggle="modal" data-target="#exampleModal">
                        <i class="fa fa-plus-circle"></i></button>
                    </div> -->


                    <div class="custom-search">
                      <!-- <select v-model="product[index]" id="supplier" class="custom-search-input">

                                      </select> -->
                      <input :id="'Daily_account_tree' + index" type="text" readonly class="custom-search-input">
                      <!-- <input :id="'Daily_account_tree_id' + index" type="hidden" readonly class="custom-search-input"> -->

                      <button class="custom-search-botton" type="button" data-toggle="modal" data-target="#exampleModal"
                        @click="detect_index(index)"> <i class="fa fa-plus-circle"></i></button>
                    </div>

           


                    <!-- <input
                        v-model="account_name[index]"
                        required
                       
                        type="text"
                        id="qty"
                        class="form-control input_cantidad"
                        onkeypress="return valida(event)"
                      /> -->
                  </td>
                  <td>
                    <input v-model="description[index]" required type="text" style="width: 500px" id="qty"
                      class="form-control input_cantidad" onkeypress="return valida(event)" />
                  </td>
                  <td>
                    <input v-model="debit[index]" type="number" style="width: 150px" id="qty"
                      class="form-control input_cantidad" onkeypress="return valida(event)" />
                  </td>
                  <td>
                    <input v-model="credit[index]" type="number" style="width: 150px" id="qty"
                      class="form-control input_cantidad" onkeypress="return valida(event)" />
                  </td>
                  <!-- <button v-on:click="addComponent" class="tn btn-info btn-sm waves-effect btn-agregar">
                      <i class="fa fa-plus-circle"></i>
                    </button> -->

                  <td v-if="index == 1">

                    <button class="tn btn-info btn-sm waves-effect btn-agregar" v-on:click="addComponent">
                      <i class="fa fa-plus-circle"></i></button>

                    <button class="tn btn-info btn-sm waves-effect btn-agregar" v-on:click="disComponent">
                      <i class="fa fa-minus-circle"></i></button>



                  </td>
                </tr>
                <tr>

                  <td colspan="3" style="text-align:center;color:red;font-size:large">الاجمالي</td>
                  <td colspan="2" style="text-align:center;color:red;font-size:large">
                  
                    <input  type="hidden" style="width: 250px" 
                      class="form-control input_cantidad" onkeypress="return valida(event)" />

                  </td>


                  <td>          <a href="javascript:void" @click="addDaily()" class="btn btn-primary"><span>تاكيد
              العمليه</span></a></td>
                </tr>
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>


    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="container">

              <div class="well" id="treeview_json_account"></div>

            </div>
          </div>

        </div>
      </div>
    </div>
    <!-- </form> -->
  </div>

  </div>

</template>
<script>
import tree from '../../../../../js/tree/tree.js';

export default {
  mixins: [tree],
  data() {
    return {


      value_list: {
          type: Object,
          default: null,
        },
      counts: {},
  
      date: new Date().toISOString().substr(0, 10),

      table: '',
      type: '',
     

   
      // -----------------------------------------
      count: 1,
      daily_date: "2021-11-24",
      daily_id:'',
      trees: "",
      account: [],
      account_name: [],
      description: [],
      debit: [],
      credit: [],
      jsonTreeData: '',
      type_of_tree: 1,
      indexselected: '',
      indexselectedaccount: '',

      last_nodes: '',

      index: 0,


    };
  },
  mounted() {
    this.list();
    this.type = 'Daily';
    this.counts[0] = 1;
    this.type_of_tree = 1;
    this.showtree('account','tree_account');




  },

  methods: {

    list(){

      this.axios
          .post(`/daily`)
          .then(({ data }) => {
            console.log('daily',data.daily_details.data);
            this.value_list = data.daily_details;
          })
          .catch(({ response }) => {
            console.error(response);
          });
    },
    addComponent(index) {
      // alert(index);
      this.count += 1;
      this.counts[index] = this.count;
    },
    disComponent(index) {
      this.count -= 1;
      this.$delete(this.counts, index);
    },

    addDaily() {

      this.axios
        .post("store_daily", {

          count: this.counts,
          daily_date: this.daily_date,
          total: this.total,
          account_id: this.account,
          description: this.description,
          // account_name: this.account_name,
          debit: this.debit,
          credit: this.credit,
        })
        .then(function (response) {
          console.log(response);
          currentObj.success = response.data.success;
          currentObj.filename = "";


          toastMessage("تم الاضافه بنجاح");
        })
        .catch(function (error) {
          currentObj.output = error;
        });

      // this.$router.go(-1);
    },
  },
};
</script>




