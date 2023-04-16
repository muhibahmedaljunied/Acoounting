<template>
  <!-- row opened -->
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header">
       

          <h2>الخصم</h2>
        </div>


        <div class="card-body" id="printme">
          <div class="row">
            <div class="col-md-4">
              <label for="status">اسم الموظف</label>
              <select @change="select_staff" v-model="staff_selected" name="type" id="type" class="form-control " required>
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
              <a href="#" ><img src="/assets/img/search.png" alt="" style="width: 10%;">  </a>
            </div>
          </div>

     
            <div class="table-responsive">
            <table class="table table-bordered text-center">
              <thead>
                <tr>

                  <th class="wd-15p border-bottom-0">اسم المؤظف</th>
                  <th class="wd-15p border-bottom-0"> نوع الخصم</th>
                  <th class="wd-15p border-bottom-0">قيمه الخصم</th>
                  <th class="wd-15p border-bottom-0">التاريخ</th>

                  <!-- <th class="wd-15p border-bottom-0"> ملاجظه</th> -->


                  <!-- <th class="wd-15p border-bottom-0">العمليات</th> -->
                </tr>
              </thead>
              <tbody v-if="list_data && list_data.data.length > 0">
                <tr v-for="(discount, index) in list_data.data" :key="index">
                  <!-- <div v-if="discount.discount"> -->
                  <td>{{ discount.name }}</td>

                  <td>

                    <div v-for="(discount_names, index) in discount.discount" :key="index">
                      {{ discount_names.discount_type.name }}
                    </div>
                  </td>

                  <td>

                    <div v-for="(discount_qty, index) in discount.discount" :key="index">
                      {{ discount_qty.quantity }}
                    </div>
                  </td>

                  <td>{{ discount.date }}</td>
                  <!-- <td>{{ discount.note }}</td> -->


                  <!-- <td>
                    <button type="button" @click="delete_discount(discount.id)" class="btn btn-danger">
                      <i class="fa fa-trash"></i>
                    </button>

                    <router-link :to="{
                      name: 'edit_discount',
                      params: { id: discount.id },
                    }" class="edit btn btn-success">
                      <i class="fa fa-edit"></i></router-link>
                    <router-link :to="{
                      name: 'edit_advance',
                    
                    }" class="edit btn btn-success">
                      <i class="fa fa-eye"></i></router-link>
                  </td> -->
                  <!-- </div> -->
                </tr>
              </tbody>
              <tbody v-else>
                <tr>
                  <td align="center" colspan="3">لايوجد بياتات.</td>
                </tr>
              </tbody>
            </table>
          </div>
          <pagination align="center" :data="discounts" @pagination-change-page="list"></pagination>
        
         
        </div>
        <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
          aria-hidden="true" style="display: none" id="addDiscount">
          <div class="modal-dialog modal-lg" style="width: 100%">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                  x
                </button>
                <div class="col-md-8">
                  <h4 class="modal-title" id="myLargeModalLabel">المنتجات</h4>
                </div>
                <div class="col-md-4">
                  <div class="col-sm-12">
                    <input type="text" placeholder="بحث" class="form-control" name="buscar_producto"
                      id="buscar_producto" v-model="word_search" @input="get_search()" />
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
                          <h3 class="text-center">أضافه </h3>
                          <form method="post" @submit.prevent="submitForm" enctype="multipart/form-data">

                            <div class="form-group">
                              <label for="name">اسم المؤظف</label>
                              <select v-model="staffselected" name="type" id="type" class="form-control" required>
                                <option v-for="staff in staffs" v-bind:value="staff.id">
                                  {{ staff.name }}
                                </option>
                              </select>
                            </div>
                            <div class="form-group">
                              <label for="Category">نوع الخصم</label>
                              <select v-model="typeselected" name="type" id="type" class="form-control" required>
                                <option v-for="discount_type in discount_types" v-bind:value="discount_type.id">
                                  {{ discount_type.name }}
                                </option>
                              </select>
                            </div>
                            <div class="form-group">
                              <label for="name"> قيمه الخصم</label>
                              <input v-model="quantity" type="number" class="form-control" name="name" id="name"
                                required />
                            </div>
                            <div class="form-group">
                              <label for="name">التاريخ</label>
                              <input v-model="date" type="date" class="form-control" name="name" id="name" required />
                            </div>


                            <div class="form-group">
                              <label for="name">ملاحظه</label>
                              <input v-model="note" type="text" class="form-control" name="name" id="name" />
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg btn-block">
                              حفظ
                            </button>
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
      discount_types: "",
      staffs: '',
      staffselected: '',
      typeselected: '',
      date: '',
      quantity: '',
      staff_selected: 1,
      note: '',
      name: '',
      table:'discount',
      list_data: {
        type: Object,
        default: null,
      },
      from_date: new Date().toISOString().substr(0, 10),
      into_date: new Date().toISOString().substr(0, 10),
      word_search: "",
    };
  },
  mounted() {
    this.list();
  },
  methods: {



    get_search(word_search) {
      this.axios
        .post(`/discountsearch`, { word_search: this.word_search })
        .then(({ data }) => {
          this.discounts = data;

          // this.$root.logo = "Category";
        });
    },

    list(page = 1) {
      this.axios
        .post(`/discount?page=${page}`)
        .then(({ data }) => {
          this.list_data = data.list;
          this.discount_types = data.discount_types;
          this.staffs = data.staffs;
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },
    // printDiv(printme) {
    //   var printContents = document.getElementById(printme).innerHTML;
    //   var originalContents = document.body.innerHTML;

    //   document.body.innerHTML = printContents;

    //   window.print();

    //   document.body.innerHTML = originalContents;
    // },
  },
};
</script>

