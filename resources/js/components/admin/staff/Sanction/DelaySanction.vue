<template>
  <!-- row opened -->
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header">

          <span class="h2"> التاخير</span>
          <div style="display: flex;float: left; margin: 5px">
            <a class="btn btn-info btn-sm waves-effect btn-agregar" data-toggle="modal" id="agregar_productos"
              data-target="#addSD">
              <i class="fa fa-plus-circle"></i></a>

            <input autocomplete="on" v-model="word_search" type="text" class="form-control input-text"
              placeholder="بحث ...." aria-label="Recipient's username" aria-describedby="basic-addon2"
              @input="get_search()">

            <div>

            </div>
          </div>
        </div>

      </div>
    </div>
    <div class="card-body" id="printme">
      <div class="table-responsive">
        <table class="table table-bordered text-center">
          <thead>
            <tr>
              <th class="wd-15p border-bottom-0">#</th>
              <!-- <th class="wd-15p border-bottom-0">اسم الموظف</th> -->
              <th class="wd-15p border-bottom-0">التاخير</th>
              <th class="wd-15p border-bottom-0">المده</th>
              <th class="wd-15p border-bottom-0">عدد مرات التكرار</th>
              <th class="wd-15p border-bottom-0"> طريقه الخصم</th>
              <th class="wd-15p border-bottom-0"> طريقه الاحتساب</th>
              <th class="wd-15p border-bottom-0"> الجزاء</th>
              <!-- <th class="wd-15p border-bottom-0"> الحاله</th> -->


              <th class="wd-15p border-bottom-0">العمليات</th>
            </tr>
          </thead>
          <tbody v-if="value_list && value_list.data.length > 0">
            <tr v-for="(delay_sanction, index) in value_list.data" :key="index">
              <td>{{ index + 1 }}</td>
              <!-- <td>{{ delay_sanction.staff_name }}</td> -->
              <td>{{ delay_sanction.delay }}</td>
              <td>{{ delay_sanction.duration }}</td>
              <td v-if="delay_sanction.iteration == 1"> مره واحده</td>
              <td v-if="delay_sanction.iteration == 2">  مرتين</td>
              <td v-if="delay_sanction.iteration == 3">ثلاث مرات</td>
              <td v-if="delay_sanction.iteration == 4">اربع مرات</td>
              <td v-if="delay_sanction.iteration == 5"> خمس مرات او اكثر</td>
              <td v-if="delay_sanction.iteration == 6"> اي مره</td>

              <td>{{ delay_sanction.discount_name }}</td>
              <td v-if="delay_sanction.discount == 1">قيمه</td>
              <td v-if="delay_sanction.discount == 2">نسبه</td>
              <td>{{ delay_sanction.sanction }}</td>


              <td>
                <!-- <a data-toggle="modal" data-target="#modal_vaciar" class="btn btn-danger btn-lg waves-effect btn-agregar"><i class="fa fa-trash"></i></a> -->
                <button type="button" @click="delete_item(delay_sanction.id)" class="btn btn-danger btn-sm waves-effect">
                  <i class="fa fa-trash"></i>
                </button>
                <a class="btn btn-info btn-sm waves-effect btn-agregar" data-toggle="modal" data-target="#updateSD"
                  id="agregar_productos">
                  <i class="fa fa-edit"></i></a>

              </td>
            </tr>
          </tbody>
          <tbody v-else>
            <tr>
              <td align="center" colspan="6">لايوجد بياتات.</td>
            </tr>
          </tbody>
        </table>
      </div>
      <pagination align="center" :data="value_list" @pagination-change-page="list"></pagination>
    </div>
    <div class="modal fade" id="addSD" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <h4 class="modal-title" id="myLargeModalLabel"> جزاءات التاخير</h4>

                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                      </div>
                    </div>
                    <div class="card-body">
                      <form method="post">

                        <div class="table-responsive">
                          <table class="table table-bordered text-right m-t-30" style="width: 100%; font-size: x-small">
                            <thead>
                              <tr>
                                <!-- <th>اسم الموظف</th> -->
                                <th>التاخير</th>
                                <th>المده</th>
                                <th>عدد مرات التكرار</th>
                                <th> طريقه الخصم</th>
                                <th> طريقه الاحتساب</th>
                                <th> الجزاء</th>







                                <th>اضافه</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr v-for="index in count" :key="index">
                                <!-- 
                                <td>
                                  <select v-model="staffselected[index]" name="type" id="type" class="form-control "
                                    required>
                                    <option v-for="staff in staffs" v-bind:value="staff.id">
                                      {{ staff.name }}
                                    </option>
                                  </select>
                                </td> -->
                                <td>
                                  <select v-model="delayselected[index]" name="type" id="type" class="form-control "
                                    required>
                                    <option v-for="delay in delay_types" v-bind:value="delay.id">
                                      {{ delay.name }}
                                    </option>
                                  </select>
                                </td>

                                <td>
                                  <select v-model="delaypartselected[index]" name="type" id="type" class="form-control "
                                    required>
                                    <option v-for="delay_part in delay_parts" v-bind:value="delay_part.id">
                                      {{ delay_part.name }}
                                    </option>
                                  </select>
                                </td>

                                <td>
                                  <select v-model="iterationselected[index]" name="type" id="type" class="form-control "
                                    required>
                                    <option v-bind:value="1">
                                      مره واحده
                                    </option>

                                    <option v-bind:value="2">
                                      مرتين
                                    </option>

                                    <option v-bind:value="3">
                                      ثلاث مرات
                                    </option>

                                    <option v-bind:value="4">
                                      اربع مرات
                                    </option>

                                    <option v-bind:value="5">
                                      خمس مرات او اكثر
                                    </option>
                                    <option v-bind:value="6">

                                      اي مره 
                                    </option>
                                  </select>
                                </td>
                                <td>
                                  <select v-model="discounttypeselected[index]" name="type" id="type"
                                    class="form-control " required>
                                    <option v-for="discount_type in discount_types" v-bind:value="discount_type.id">
                                      {{ discount_type.name }}
                                    </option>
                                  </select>
                                </td>
                                <td>
                                  <select v-model="discountselected[index]" name="type" id="type" class="form-control "
                                    required>
                                    <option v-bind:value="1">
                                      قيمه
                                    </option>

                                    <option v-bind:value="2">
                                      نسبه
                                    </option>
                                  </select>
                                </td>
                                <td>
                                  <input v-model="sanctionselected[index]" type="text" class="form-control" name="name"
                                    id="name" required />

                                </td>


                                <td v-if="index == 1">
                                  <a class="btn btn-info btn-sm waves-effect btn-agregar" v-on:click="addComponent(count)">
                                    <i class="fa fa-plus-circle"></i></a>

                                  <a class="btn btn-info btn-sm waves-effect btn-agregar" v-on:click="disComponent(count)">
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
              <button type="button" class="btn btn-primary" @click="Add_new()">حفظ </button>
              <!-- <button type="button" class="btn btn-primary btn-lg btn-block" @click="submitForm()"@click="submitForm()">
                        حفظ
                      </button> -->
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </form>
    </div>
    <!-- <div class="modal fade" id="updateSD" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <form method="post">
        <div class="modal-dialog modal-fullscreen">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>


            <div class="modal-body">
              <div class="row row-sm">
                <div class="col-xl-12">
                  <div class="card">
                    <div class="card-header pb-0">
                      <div class="d-flex justify-content-between">
                        <h4 class="modal-title" id="myLargeModalLabel"> جزاءات التاخير</h4>

                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                      </div>
                    </div>
                    <div class="card-body">
                    <form method="post">

                      <div class="table-responsive">
                        <table class="table table-bordered text-right m-t-30" style="width: 100%; font-size: x-small">
                          <thead>
                            <tr>
                              <th>اسم الموظف</th>
                              <th>التاخير</th>
                              <th>المده</th>
                              <th>عدد مرات التكرار</th>
                              <th> طريقه الخصم</th>
                              <th> طريقه الاحتساب</th>
                              <th> الجزاء</th>







                              <th>اضافه</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="index in count" :key="index">

                              <td>
                                <select v-model="staffselected[index]" name="type" id="type" class="form-control "
                                  required>
                                  <option v-for="staff in staffs" v-bind:value="staff.id">
                                    {{ staff.name }}
                                  </option>
                                </select>
                              </td>
                              <td>
                                <select v-model="delayselected[index]" name="type" id="type" class="form-control "
                                  required>
                                  <option v-for="delay in delay_types" v-bind:value="delay.id">
                                    {{ delay.name }}
                                  </option>
                                </select>
                              </td>

                              <td>
                                <select v-model="delaypartselected[index]" name="type" id="type" class="form-control "
                                  required>
                                  <option v-for="delay_part in delay_parts" v-bind:value="delay_part.id">
                                    {{ delay_part.name }}
                                  </option>
                                </select>
                              </td>

                              <td>
                                <select v-model="iterationselected[index]" name="type" id="type" class="form-control "
                                  required>
                                  <option v-bind:value="1">
                                    مره واحده
                                  </option>

                                  <option v-bind:value="2">
                                    مرتين
                                  </option>

                                  <option v-bind:value="3">
                                    ثلاث مرات
                                  </option>

                                  <option v-bind:value="4">
                                    اربع مرات
                                  </option>

                                  <option v-bind:value="5">
                                    خمس مرات او اكثر
                                  </option>
                                </select>
                              </td>
                              <td>
                                <select v-model="discounttypeselected[index]" name="type" id="type" class="form-control "
                                  required>
                                  <option v-for="discount_type in discount_types" v-bind:value="discount_type.id">
                                    {{ discount_type.name }}
                                  </option>
                                </select>
                              </td>
                              <td>
                                <select v-model="discountselected[index]" name="type" id="type" class="form-control "
                                  required>
                                  <option v-bind:value="1">
                                    قيمه
                                  </option>

                                  <option v-bind:value="2">
                                    نسبه
                                  </option>
                                </select>
                              </td>
                              <td>
                                <input v-model="sanctionselected[index]" type="text" class="form-control" name="name"
                                  id="name" required />

                              </td>


                              <td v-if="index == 1">
                                <a class="btn btn-info btn-sm waves-effect btn-agregar" v-on:click="addComponent(count)">
                                  <i class="fa fa-plus-circle"></i></a>

                                <a class="btn btn-info btn-sm waves-effect btn-agregar" v-on:click="disComponent(count)">
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


                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-primary" @click="Add_new()">حفظ </button>
          
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </form>
    </div> -->
  </div>
</template>

<script>


import pagination from "laravel-vue-pagination";
import operation from '../../../../staff/operation/operation.js';
export default {
  components: {
    pagination,
  },
  mixins: [operation],
  data() {
    return {


      value_list: {
        type: Object,
        default: null,
      },

      discountselected: [],
      iterationselected: [],
      discounttypeselected: [],
      sanctionselected: [],
      delayselected: [],
      delaypartselected: [],

      word_search: '',
    };
  },
  mounted() {
    this.list();
    this.counts[0] = 1;
    this.type = 'delay_sanction';
  },
  methods: {

    Add_new() {

      this.Add(
        {
          type: this.type,
          count: this.counts,
          // staff:this.staffselected,
          discount: this.discountselected,
          delay: this.delayselected,
          delay_part: this.delaypartselected,
          iteration: this.iterationselected,
          discount_type: this.discounttypeselected,
          sanction: this.sanctionselected,
        });


    },

    list(page = 1) {
      this.axios
        .post(`/delay_sanction?page=${page}`)
        .then(({ data }) => {

          this.delay_types = data.delay_types;
          this.delay_parts = data.delay_parts;
          this.discount_types = data.discount_types;
          this.staffs = data.staffs;
          this.value_list = data.list;

        })
        .catch(({ response }) => {
          console.error(response);
        });
    },






  },
};
</script>

