<template>
  <!-- row opened -->
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header ">
  
            <span class="h2"> الخصميات</span>
    

          <div style="display: flex;float: left; margin: 5px">
           
            <a class="tn btn-info btn-sm waves-effect btn-agregar" data-toggle="modal" id="agregar_productos"
              data-target="#addDiscount">
              <i class="fa fa-plus-circle"></i></a>

              <input autocomplete="on" v-model="word_search" type="text" class="form-control input-text"
              placeholder="بحث ...." aria-label="Recipient's username" aria-describedby="basic-addon2"
              @input="get_search()">
           



            <div></div>
          </div>
        </div>
        <div class="card-body" id="printme">
          <div class="table-responsive">
            <table class="table table-bordered text-center">
              <thead>
                <tr>

                  <th class="wd-15p border-bottom-0">اسم المؤظف</th>
                  <th class="wd-15p border-bottom-0"> نوع الخصم</th>
                  <th class="wd-15p border-bottom-0">قيمه الخصم</th>
                  <th class="wd-15p border-bottom-0">التاريخ</th>

                  <th class="wd-15p border-bottom-0"> ملاجظه</th>


                  <th class="wd-15p border-bottom-0">العمليات</th>
                </tr>
              </thead>
              <tbody v-if="value_list && value_list.data.length > 0">
                <tr v-for="(discount, index) in value_list.data" :key="index">

                  <td>{{ discount.name }}</td>
                 
                  <td>
                   
                   <div v-for="(discount_names, index) in discount.discount" :key="index">
                     {{ discount_names.discount_type.name }}
                     <hr>
                   </div>
                   </td>
 
                   <td>
                    
                     <div v-for="(discount_qty, index) in discount.discount" :key="index">
                     {{ discount_qty.quantity }}
                     <hr>
                   </div>
                    </td>
                    
                    <td>
                    
                    <div v-for="(discount_qty, index) in discount.discount" :key="index">
                    {{ discount_qty.date }}
                    <hr>
                  </div>
                   </td>

                  <!-- <td>{{ discount.date }}</td> -->
                  <td>{{ discount.note }}</td>


                  <td>
                    <!-- <a data-toggle="modal" data-target="#modal_vaciar" class="tn btn-danger btn-lg waves-effect btn-agregar"><i class="fa fa-trash"></i></a> -->
                    <button type="button" @click="delete_discount(discount.id)" class="btn btn-danger btn-sm waves-effect">
                      <i class="fa fa-trash"></i>
                    </button>

                    <a class="tn btn-info btn-sm waves-effect btn-agregar" data-target="#updateDiscount" data-toggle="modal" id="agregar_productos"
            >
              <i class="fa fa-edit"></i></a>
                    <router-link :to="{
                      name: 'edit_advance',
                    
                    }" class="edit btn btn-success">
                      <i class="fa fa-eye"></i></router-link>
                  </td>
                </tr>
              </tbody>
              <tbody v-else>
                <tr>
                  <td align="center" colspan="3">لايوجد بياتات.</td>
                </tr>
              </tbody>
            </table>
          </div>
          <pagination align="center" :data="value_list" @pagination-change-page="list"></pagination>
        </div>
        <div class="modal fade" id="updateDiscount" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <form method="post">
            <div class="modal-dialog modal-fullscreen">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>


                <div class="modal-body">
                  <div class="row row-sm">
                    <div class="col-xl-12">
                      <!-- <form method="post"> -->
                      <div class="card">
                        <div class="card-header pb-0">
                          <div class="d-flex justify-content-between">
                            <h4 class="modal-title" id="myLargeModalLabel">الخصومات</h4>
                            <i class="mdi mdi-dots-horizontal text-gray"></i>
                          </div>
                        </div>

                        <div class="card-body">
                          <div class="form">

                            <form method="post">
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

                                        <input v-model="date[index]" type="date" class="form-control" name="name"
                                          id="name" required />

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




                            </form>
                          </div>


                          <div class="card-footer pb-0">
                            <div class="d-flex justify-content-between">
                              <i class="mdi mdi-dots-horizontal text-gray"></i>
                            </div>
                          </div>
                        </div>


                        <!-- </form> -->
                      </div>
                    </div>
                  </div>

                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary" @click="Add_newdiscount()">حفظ </button>
                    
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal fade" id="addDiscount" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <form method="post">
            <div class="modal-dialog modal-fullscreen">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>


                <div class="modal-body">
                  <div class="row row-sm">
                    <div class="col-xl-12">
                      <!-- <form method="post"> -->
                      <div class="card">
                        <div class="card-header pb-0">
                          <div class="d-flex justify-content-between">
                            <h4 class="modal-title" id="myLargeModalLabel">الخصومات</h4>
                            <i class="mdi mdi-dots-horizontal text-gray"></i>
                          </div>
                        </div>

                        <div class="card-body">
                          <div class="form">

                            <form method="post">
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

                                        <input v-model="date[index]" type="date" class="form-control" name="name"
                                          id="name" required />

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




                            </form>
                          </div>


                          <div class="card-footer pb-0">
                            <div class="d-flex justify-content-between">
                              <i class="mdi mdi-dots-horizontal text-gray"></i>
                            </div>
                          </div>
                        </div>


                        <!-- </form> -->
                      </div>
                    </div>
                  </div>

                  <div class="modal-footer">
                    <button type="button" class="btn btn-primary" @click="Add_newdiscount()">حفظ </button>
                    
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
       
      </div>
    </div>
    <!--/div-->
  </div>
  <!-- /row -->
</template>

<script>
import pagination from "laravel-vue-pagination";
import operation from '../../../../../js/staff/operation/operation.js';
export default {
  components: {
    pagination,
  },
  mixins: [operation],
  data() {
    return {
      count: 1,
      counts: [],
      discount_types: "",
      staffs: '',
      staffselected: [],
      typeselected: [],
      date: [],
      quantity: [],

      note: '',
      name: '',

      value_list: {
        type: Object,
        default: null,
      },

      word_search: "",
    };
  },
  mounted() {
    this.list();
    this.counts[0] = 1;
    this.type = 'discount';
  },
  methods: {
    data_list() {

return {
  type: this.type,
        count: this.counts,
        staff: this.staffselected,
        discount_type: this.typeselected,
        qty: this.quantity,
        date: this.date,
}
},
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
          this.value_list = data.list;
          this.discount_types = data.discount_types;
          this.staffs = data.staffs;
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },
    Add_newdiscount() {
      console.log(this.counts);
      this.axios
      .post(`/store_discount`, {
        type: this.type,
        count: this.counts,
        staff: this.staffselected,
        discount_type: this.typeselected,
        qty: this.quantity,
        date: this.date,


      })
      .then((response) => {
        // ---------------------------------------------------------------
        console.log(response);

        // this.temporale = response.data;
        // this.temporale.forEach((item) => {
        //   this.total_quantity = item.tem_qty + this.total_quantity;
  
        //   this.grand_total = item.subtotal + this.grand_total;
        //   this.To_pay = item.subtotal + this.To_pay;
  
        //   this.total_tax = item.tax + this.total_tax;
  
          //  console.log(this.total_tax);
  
  
        // });
  
        toastMessage("تم الاضافه بنجاح");
        // this.$router.go(0);
      });
    
      // this.$router.go(0);

    },

  },
};
</script>

