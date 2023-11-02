<template>
   
          <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">

                  <span class="h2">   جزاءات ضافي الموظف </span>

                </div>
                <div class="card-body" id="printme">
                   
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <!-- <th class="wd-15p border-bottom-0">الرقم الوظيفي</th> -->
                                    <th class="wd-15p border-bottom-0">اسم المؤظف</th>
                                    <!-- <th class="wd-15p border-bottom-0">نوع الجراء</th> -->

                                    <th class="wd-15p border-bottom-0">التاريخ</th>
                                    <th class="wd-15p border-bottom-0">البند</th>
                                    <th class="wd-15p border-bottom-0">الوقت</th>
                                    <th class="wd-15p border-bottom-0">عدد مرات التكرار</th>

                                    <th class="wd-15p border-bottom-0">الخصم</th>
                                    <!-- <th class="wd-15p border-bottom-0" style="color:red">الاجمالي</th> -->

                                    <th class="wd-15p border-bottom-0"> الحاله</th>


                                    <th class="wd-15p border-bottom-0">العمليات</th>
                                </tr>
                            </thead>
                            <tbody v-if="value_list && value_list.length > 0">
                                <tr v-for="(advance, index) in value_list" :key="index">
                                  

                                    <td>{{ advance.staff_name }}</td>
                                    
                                        <td>



                                            {{ advance.date }}

                                        </td>
                                  
                                        <td></td>
                                        <td>  {{ advance.number_hours }}</td>
                                        <td>{{ advance.iteration }}</td>
                                        <td>{{ advance.sanction }}</td>

                                        <td style="color:goldenrod">
                                            <span class="badge text-bg-warning">غير معتمد</span>

                                        </td>
                            

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

                                            </div>
                                            <div class="card-body">
                                                <div class="form">

                                                    <form method="post" @submit.prevent="submitForm"
                                                        enctype="multipart/form-data">
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


                                                                    <tr v-for="index in count" :key="index">



                                                                        <td>

                                                                            <select v-model="staffselected[index]"
                                                                                name="type" id="type" class="form-control"
                                                                                required>
                                                                                <option v-for="staff in staffs"
                                                                                    v-bind:value="staff.id">
                                                                                    {{ staff.name }}
                                                                                </option>
                                                                            </select>

                                                                        </td>


                                                                        <td>


                                                                            <input v-model="quantity[index]" type="number"
                                                                                class="form-control" name="name" id="name"
                                                                                required />
                                                                        </td>

                                                                        <td>

                                                                            <input v-model="date[index]" type="date"
                                                                                class="form-control" name="name" id="name"
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


                                                        <a href="javascript:void" @click="Add_newadvance()"
                                                            class="btn btn-success"><span>تاكيد
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
</template>

<script>
import pagination from "laravel-vue-pagination";
// import operation from '../../../../staff/operation/operation.js';
export default {
  components: {
    pagination,
  },
  // mixins: [operation],
  data() {
    return {


      value_list: {
        type: Object,
        default: null,
      },

 
    };
  },
  mounted() {
    this.list();
    this.counts[0] = 1;
    this.type = 'extra_sanction';
  },
  methods: {

    list(page = 1) {
      this.axios
        .post(`/staff_extra_sanction?page=${page}`)
        .then(({ data }) => {
      
            console.log(data);
          this.value_list = data.list;
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },

   

  },
};
</script>

