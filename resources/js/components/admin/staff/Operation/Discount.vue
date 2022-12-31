<template>
  <!-- row opened -->
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header pb-0">
          <div class="d-flex justify-content-between">
            <span class="h2"> الخصميات</span>
          </div>

          <div class="d-flex justify-content-right">
            <!-- <router-link
              to="create_category"
              id="agregar_productos"
              class="tn btn-info btn-lg waves-effect btn-agregar"
              ><i class="fa fa-plus-circle"></i
            ></router-link> -->
            <a class="tn btn-info btn-lg waves-effect btn-agregar" data-toggle="modal" id="agregar_productos"
              data-target="#addDiscount">
              <i class="fa fa-plus-circle"></i></a>


            <input type="search" autocomplete="on" name="search" data-toggle="dropdown" role="button"
              aria-haspopup="true" aria-expanded="true" placeholder="بحث عن صنف" v-model="word_search"
              @input="get_search()" />



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
              <tbody v-if="discounts && discounts.data.length > 0">
                <tr v-for="(discount, index) in discounts.data" :key="index">

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
                  <td>{{ discount.note }}</td>


                  <td>
                    <!-- <a data-toggle="modal" data-target="#modal_vaciar" class="tn btn-danger btn-lg waves-effect btn-agregar"><i class="fa fa-trash"></i></a> -->
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
                          <form method="post" @submit.prevent="submitForm" enctype="multipart/form-data">
                          <h3 class="text-center">أضافه </h3>
                          <div class="table-responsive">
                            <table class="table table-bordered text-right">
                              <thead>
                                <tr>


                                  <th>اسم المؤظف</th>

                                  <th>نوع الخصم</th>
                                  <th> قيمه الخصم</th>
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

                                    <select v-model="staffselected[index]" name="type" id="type"
                                      class="form-control" required>
                                      <option v-for="staff in staffs" v-bind:value="staff.id">
                                        {{ staff.name }}
                                      </option>
                                    </select>

                                  </td>
                                  <td><select v-model="typeselected[index]" name="type" id="type"
                                      class="form-control" required>
                                      <option v-for="discount_type in discount_types" v-bind:value="discount_type.id">
                                        {{ discount_type.name }}
                                      </option>
                                    </select></td>

                                  <td>


                                    <input v-model="quantity[index]" type="number" class="form-control" name="name" id="name"
                                      required />
                                  </td>

                                  <td>

                                    <input v-model="date[index]" type="date" class="form-control" name="name"
                                      id="name" required />

                                  </td>
                                  <!-- <td> <input v-model="note[index]" type="text" class="form-control" name="name"
                                      id="name" />
                                  </td> -->
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
                          <a href="javascript:void" @click="Add_newdiscount()" class="btn btn-success"><span>تاكيد
                              العمليه</span></a>
                          </form>

                          <!-- <form method="post" @submit.prevent="submitForm" enctype="multipart/form-data">


                            <label for="name">اسم المؤظف</label>
                            <select v-model="staffselected" name="type" id="type" class="form-control" required>
                              <option v-for="staff in staffs" v-bind:value="staff.id">
                                {{ staff.name }}
                              </option>
                            </select>


                            <label for="Category">نوع الخصم</label>
                            <select v-model="typeselected" name="type" id="type" class="form-control" required>
                              <option v-for="discount_type in discount_types" v-bind:value="discount_type.id">
                                {{ discount_type.name }}
                              </option>
                            </select>


                            <label for="name"> قيمه الخصم</label>
                            <input v-model="quantity" type="number" class="form-control" name="name" id="name"
                              required />


                            <label for="name">التاريخ</label>
                            <input v-model="date" type="date" class="form-control" name="name" id="name" required />




                            <label for="name">ملاحظه</label>
                            <input v-model="note" type="text" class="form-control" name="name" id="name" />


                            <button type="submit" class="btn btn-primary btn-lg btn-block">
                              حفظ
                            </button>
                          </form> -->
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

export default {
  components: {
    pagination,
  },

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

      discounts: {
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
    addComponent(index) {
      addComponent(this,index);
    },
    disComponent(index) {
      disComponent(this,index);
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
          this.discounts = data.discounts;
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

