<template>
  <!-- row opened -->
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header">

          <span class="h2"> السلف</span>

          <!-- 
          <div style="display: flex;float: left; margin: 5px">
   
            <a class="tn btn-info btn-sm waves-effect btn-agregar" data-toggle="modal" id="agregar_productos"
              data-target="#addAd">
              <i class="fa fa-plus-circle"></i></a>


              <input autocomplete="on" v-model="word_search" type="text" class="form-control input-text"
              placeholder="بحث ...." aria-label="Recipient's username" aria-describedby="basic-addon2"
              @input="get_search()">


            <div></div>
          </div> -->
        </div>
        <div class="card-body" id="printme">
          <div class="row">
            <div class="col-md-4">
              <label for="status">اسم الموظف</label>
              <select @change="select_staff" v-model="staff_selected" name="type" id="type" class="form-control "
                required>
                <option v-for="staff in staffs" v-bind:value="staff.id">
                  {{ staff.name }}
                </option>
              </select>
            </div>
            <div class="col-md-2">
              <label for="status"> من تأريخ</label>
              <input v-model="from_date" type="date" name="" id="" class="form-control">
            </div>

            <div class="col-md-2">
              <label for="status">الي تأريخ</label>
              <input v-model="from_date" type="date" name="" id="" class="form-control">
            </div>
            <div class="col-sm-6 col-md-3" style="margin-top: auto;">
              <a href="#"><img src="/assets/img/search.png" alt="" style="width: 10%;"> </a>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered text-center">
              <thead>
                <tr>
                  <!-- <th class="wd-15p border-bottom-0">الرقم الوظيفي</th> -->
                  <th class="wd-15p border-bottom-0">اسم المؤظف</th>
                  <th class="wd-15p border-bottom-0">التاريخ</th>

                  <th class="wd-15p border-bottom-0">المبلغ</th>
                  <th class="wd-15p border-bottom-0" style="color:red">الاجمالي</th>

                  <!-- <th class="wd-15p border-bottom-0"> ملاجظه</th> -->


                  <!-- <th class="wd-15p border-bottom-0">العمليات</th> -->
                </tr>
              </thead>
              <tbody v-if="list_data && list_data.data.length > 0">
                <tr v-for="(advance, index) in list_data.data" :key="index">
                  <td>{{ advance.name }}</td>

                  <td>

                    <div v-for="(adv, index) in advance.advance" :key="index">
                      {{ adv.date }}
                      <hr>
                    </div>
                  </td>

                  <td>

                    <div v-for="(adv, index) in advance.advance" :key="index">
                      {{ adv.quantity }}
                      <hr>
                    </div>
                  </td>


                  <td style="color:red">

                    {{ advance.sum_advanve }}
                  </td>

                  <!-- 
                  <td>
                    <button type="button" @click="delete_advance(advance.id)" class="btn btn-danger">
                      <i class="fa fa-trash"></i>
                    </button>

                    <router-link :to="{
                      name: 'edit_advance',
                      params: { id: advance.id },
                    }" class="edit btn btn-success">
                      <i class="fa fa-edit"></i></router-link>
                    <router-link :to="{
                      name: 'edit_advance',
                      params: { id: advance.id },
                    }" class="edit btn btn-success">
                      <i class="fa fa-eye"></i></router-link>
                  </td> -->
                </tr>
                <tr>
                  <td colspan="3" style="color:red;font-size: x-large;">الاجمالي</td>
                  
                </tr>
              </tbody>
              <tbody v-else>
                <tr>
                  <td align="center" colspan="3">لايوجد بياتات.</td>
                </tr>
              </tbody>
            </table>
          </div>
          <pagination align="center" :data="advances" @pagination-change-page="list"></pagination>
        </div>
        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
          aria-hidden="true" style="display: none" id="addAd">
          <div class="modal-dialog modal-lg" style="width: 100%">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                  x
                </button>
                <div class="col-md-8">
                  <h4 class="modal-title" id="myLargeModalLabel">السلف</h4>
                </div>
                <div class="col-md-4">
                  <div class="col-sm-12">
                    <input type="text" placeholder="بحث" class="form-control" name="buscar_producto" id="buscar_producto"
                      v-model="word_search" @input="get_search()" />
                  </div>
                </div>
              </div>
              <div class="modal-body">
                <div class="row row-sm">
                  <div class="col-xl-12">
                    <div class="card">
                      <div class="card-header pb-0">
                        <!-- <div class="d-flex justify-content-between">
                          <h4 class="card-title mg-b-0">SIMPLE TABLE</h4>
                          <i class="mdi mdi-dots-horizontal text-gray"></i>
                        </div>
                        <p class="tx-12 tx-gray-500 mb-2">
                          Example of Valex Simple Table.
                          <a href="">Learn more</a>
                        </p> -->
                      </div>
                      <div class="card-body">
                        <div class="form">

                          <form method="post" @submit.prevent="submitForm" enctype="multipart/form-data">
                            <h3 class="text-center">أضافه </h3>
                            <div class="table-responsive">
                              <table class="table table-bordered text-right">
                                <thead>
                                  <tr>


                                    <th>اسم المؤظف</th>

                                    <th>المبلغ</th>

                                    <th>التاريخ</th>

                                    <th>اضافه</th>


                                  </tr>
                                </thead>
                                <tbody>
                                  <!-- <tr v-for="(allowance, index) in allowances" :key="index" class="form-check">
                                      <div v-if="allowance.allowance_type_id == 1">
                                        <td> <input v-model="checkselected[index]" @change="
                                          handleAllowance(
                                            index,
                                            checkselected[index],
                                            allowance.id
                                          )
                                        " class="form-check-input" type="checkbox" name="exampleRadios"
                                            id="exampleRadios1" /></td>

                                        <td>
                                          <div class="form-group">
                                            <input v-model="allowance.name" readonly type="text" name="name" id="name"
                                              class="form-control" />
                                          </div>
                                        </td>
                                        <td><input type="number" v-model="salv1[index]"
                                            class="form-control input_cantidad"></td>
                                      </div>
                                    </tr> -->

                                  <tr v-for="index in count" :key="index">



                                    <td>

                                      <select v-model="staffselected[index]" name="type" id="type" class="form-control"
                                        required>
                                        <option v-for="staff in staffs" v-bind:value="staff.id">
                                          {{ staff.name }}
                                        </option>
                                      </select>

                                    </td>


                                    <td>


                                      <input v-model="quantity[index]" type="number" class="form-control" name="name"
                                        id="name" required />
                                    </td>

                                    <td>

                                      <input v-model="date[index]" type="date" class="form-control" name="name" id="name"
                                        required />

                                    </td>

                                    <td v-if="index == 1">
                                      <a class="tn btn-info btn-sm waves-effect btn-agregar"
                                        v-on:click="addComponent(count)">
                                        <i class="fa fa-plus-circle"></i></a>

                                      <a class="tn btn-info btn-sm waves-effect btn-agregar"
                                        v-on:click="disComponent(count)">
                                        <i class="fa fa-minus-circle"></i></a>
                                    </td>


                                  </tr>

                                </tbody>

                              </table>
                            </div>

                            <!-- <form
                            method="post"
                            @submit.prevent="submitForm"
                            enctype="multipart/form-data"
                          >
                
                            <div class="form-group">
                              <label for="name">اسم المؤظف</label>
                             <select
                                        v-model="staffselected"
                                name="type"
                                id="type"
                                class="form-control"
                                required
                              >
                                 <option
                                  v-for="staff in staffs"
                                  v-bind:value="staff.id"
                                >
                                  {{ staff.name }}
                                </option>
                              </select>
                            </div>
                              <div class="form-group">
                              <label for="name">المبلغ</label>
                              <input
                               v-model="quantityselected"
                                type="number"
                                class="form-control"
                                name="name"
                                id="name"
                                required
                              />
                            </div>
                            <div class="form-group">
                              <label for="Category">التاريخ</label>
                              <input
                                 v-model="date"
                                type="date"
                                class="form-control"
                                name="name"
                                id="name"
                                required
                              />
                            </div>

                             <div class="form-group">
                              <label for="name">ملاحظه</label>
                              <input
                                v-model="note"
                                type="text"
                                class="form-control"
                                name="name"
                                id="name"
                     
                              />
                            </div>

                            <button
                              type="submit"
                              class="btn btn-primary btn-lg btn-block"
                            >
                              حفظ
                            </button>
                          </form> -->
                            <a href="javascript:void" @click="Add_newadvance()" class="btn btn-success"><span>تاكيد
                                العمليه</span></a>

                          </form>
                        </div>

                      </div>
                    </div>
                  </div>
                  <!--/div-->
                </div>
              </div>


            </div>
            <!-- /.modal-content -->
          </div>

          <!-- /.modal-dialog -->
        </div>
      </div>
    </div>
    <!--/div-->
  </div>
  <!-- /row -->
</template>

<script>
import pagination from "laravel-vue-pagination";
import operation from '../../../../../js/staff/StaffData/staff_data.js';

export default {
  components: {
    pagination,
  },
  mixins: [operation],
  data() {
    return {
      // category: "yes",

      list_data: {
        type: Object,
        default: null,
      },
      staff_selected: 1,
      count: 1,
      counts: [],
      quantity: [],
      date: [],
      staffselected: [],
      quantityselected: '',

      table: 'advance',

      staffs: '',
      note: '',

      word_search: "",



      from_date: new Date().toISOString().substr(0, 10),
      into_date: new Date().toISOString().substr(0, 10),
    };
  },
  mounted() {
    this.list();
    this.counts[0] = 1;
    this.type = 'advance';
  },
  methods: {


    get_search(word_search) {
      this.axios
        .post(`/advancesearch`, { word_search: this.word_search })
        .then(({ data }) => {
          this.branches = data;

          // this.$root.logo = "Category";
        });
    },

    list(page = 1) {
      this.axios
        .post(`/advance?page=${page}`)
        .then(({ data }) => {
          this.list_data = data.list;
          this.staffs = data.staffs;
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },





  },
};
</script>

