<template>
  <!-- row opened -->
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header">

          <span class="h2"> الاضافي</span>



          <div style="display: flex;float: left; margin: 5px">

            <a class="tn btn-info btn-sm waves-effect btn-agregar" data-toggle="modal" id="agregar_productos"
              data-target="#addExtraupdate">
              <i class="fa fa-edit"></i></a>


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
                  <th class="wd-15p border-bottom-0"> نوع الاضافي</th>
                  <th class="wd-15p border-bottom-0">التاريخ </th>

                  <th class="wd-15p border-bottom-0">وقت البدء</th>
                  <th class="wd-15p border-bottom-0">وقت الانتعاء</th>
                  <th class="wd-15p border-bottom-0"> المده</th>
                  <!-- <th class="wd-15p border-bottom-0"> اجر الساعه</th>
                  <th class="wd-15p border-bottom-0"> اجر اليةم</th> -->
                  <th class="wd-15p border-bottom-0"> ملاجظه</th>


                  <th class="wd-15p border-bottom-0">العمليات</th>
                </tr>
              </thead>
              <tbody v-if="value_list && value_list.data.length > 0">
                <tr v-for="(extra, index) in value_list.data" :key="index">

                  <td>{{ extra.name }}</td>

                  <td>

                    <div v-for="(extra_names, index) in extra.extra" :key="index">
                      {{ extra_names.extra_type.name }}
                      <hr>
                    </div>
                  </td>




                  <td>

                    <div v-for="(extra_end_date, index) in extra.extra" :key="index">
                      {{ extra_end_date.date }}
                      <hr>

                    </div>
                  </td>


                  <td>

                    <div v-for="(extra_start_time, index) in extra.extra" :key="index">
                      {{ extra_start_time.start_time }}
                      <hr>
                    </div>
                  </td>

                  <td>

                    <div v-for="(extra_end_time, index) in extra.extra" :key="index">
                      {{ extra_end_time.end_time }}
                      <hr>
                    </div>
                  </td>
                  <td>

                    <div v-for="(extra_end_time, index) in extra.extra" :key="index">
                      {{ extra_end_time.number_hours }}
                      <hr>
                    </div>
                  </td>


                  <!-- <td>

                    <div v-for="(extra_end_time, index) in extra.extra" :key="index">
                      {{ extra_end_time.number_hours }}

                      <button type="button" @click="delete_item(extra.id)" class="btn btn-danger">
                      <i class="fa fa-trash"></i>
                    </button>

                    <router-link :to="{
                      name: 'edit_extra',
                      params: { id: extra.id },
                    }" class="edit btn btn-success">
                      <i class="fa fa-edit"></i>
                    </router-link>
                      <hr>
                    </div>
                  </td> -->

                  <!-- <td>
                   
                   <div v-for="(extra_end_time, index) in extra.extra" :key="index">
                     {{ extra_end_time.end_time }}
                     <hr>
                   </div>
                   </td>

                   <td>
                   
                   <div v-for="(extra_end_time, index) in extra.extra" :key="index">
                     {{ extra_end_time.end_time }}
                     <hr>
                   </div>
                   </td> -->
                  <td>{{ extra.note }}</td>


                  <td>
                    <!-- <a data-toggle="modal" data-target="#modal_vaciar" class="tn btn-danger btn-lg waves-effect btn-agregar"><i class="fa fa-trash"></i></a> -->
                    <button type="button" @click="delete_item(extra.id)" class="btn btn-danger btn-sm waves-effect">
                      <i class="fa fa-trash"></i>
                    </button>


                    <a class="tn btn-info btn-sm waves-effect btn-agregar" data-toggle="modal" id="agregar_productos"
                      data-target="#addExtra">
                      <i class="fa fa-edit"></i></a>
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

        <div class="modal fade" id="addExtra" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <h4 class="modal-title" id="myLargeModalLabel">الاضافي</h4>
                            <i class="mdi mdi-dots-horizontal text-gray"></i>
                          </div>
                        </div>

                        <div class="card-body">
                          <form method="post" @submit.prevent="submitForm" enctype="multipart/form-data">

                            <div class="table-responsive">
                              <table class="table table-bordered text-right m-t-30"
                                style="width: 100%; font-size: x-small">
                                <thead>
                                  <tr>

                                    <th>اسم المؤظف</th>


                                    <th>نوع الاضافي </th>


                                    <th>التاريخ </th>

                                    <th> وقت البدء</th>
                                    <th>وقت الانتهاء</th>
                                    <th class="wd-15p border-bottom-0"> المده</th>

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
                                      <select v-model="typeselected[index]" name="type" id="type" class="form-control"
                                        required>
                                        <option v-for="extra_type in extra_types" v-bind:value="extra_type.id">
                                          {{ extra_type.name }}
                                        </option>
                                      </select>
                                    </td>

                                    <td>
                                      <input v-model="date[index]" type="date" class="form-control" name="name" id="name"
                                        required />
                                    </td>
                                    <td>
                                      <input v-model="start_time[index]" type="time" class="form-control" name="name"
                                        id="name" />
                                    </td>
                                    <td>
                                      <input v-model="end_time[index]" type="time" class="form-control" name="name"
                                        id="name" />
                                    </td>

                                    <td>
                                      <input v-model="duration[index]" type="number" class="form-control" name="name"
                                        id="name" />
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
                  <button type="button" class="btn btn-primary" @click="submitForm()">حفظ </button>
                  <!-- <button type="button" class="btn btn-primary btn-lg btn-block" @click="submitForm()"@click="submitForm()">
                        حفظ
                      </button> -->
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </form>
        </div>
        <!-- <div class="modal fade" id="updateExtra" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <h4 class="modal-title" id="myLargeModalLabel">الاضافي</h4>
                            <i class="mdi mdi-dots-horizontal text-gray"></i>
                          </div>
                        </div>
                       
                        <div class="card-body">
                        <form method="post" @submit.prevent="submitForm" enctype="multipart/form-data">

                          <div class="table-responsive">
                            <table class="table table-bordered text-right m-t-30" style="width: 100%; font-size: x-small">
                              <thead>
                                <tr>

                                  <th>اسم المؤظف</th>


                                  <th>نوع الاضافي </th>


                                  <th>التاريخ </th>

                                  <th> وقت البدء</th>
                                  <th>وقت الانتهاء</th>
                                  <th class="wd-15p border-bottom-0"> المده</th>
                            
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
                                    <select v-model="typeselected[index]" name="type" id="type" class="form-control"
                                      required>
                                      <option v-for="extra_type in extra_types" v-bind:value="extra_type.id">
                                        {{ extra_type.name }}
                                      </option>
                                    </select>
                                  </td>

                                  <td>
                                    <input v-model="date[index]" type="date" class="form-control" name="name" id="name"
                                      required />
                                  </td>
                                  <td>
                                    <input v-model="start_time[index]" type="time" class="form-control" name="name"
                                      id="name" />
                                  </td>
                                  <td>
                                    <input v-model="end_time[index]" type="time" class="form-control" name="name"
                                      id="name" />
                                  </td>

                                  <td>
                                    <input v-model="duration[index]" type="number" class="form-control" name="name"
                                      id="name" />
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


               
                    </div>
                  </div>
                </div>

                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" @click="submitForm()">حفظ </button>
                
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </form>
        </div> -->


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
      extra_types: "",
      staffs: '',
      // staffselected: '',
      // typeselected: '',

      start_time: '',
      end_time: '',
      note: '',
      name: '',

      value_list: {
        type: Object,
        default: null,
      },
      staffselected: [],
      typeselected: [],
      date: [],

      start_time: [],
      end_time: [],
      duration: [],
      table: 'extra',
      word_search: "",

    };
  },
  mounted() {
    this.list();
    this.counts[0] = 1;
    this.type = 'extra';
  },
  methods: {

    get_search(word_search) {
      this.axios.post(`/extrasearch`, { word_search: this.word_search }).then(({ data }) => {

        this.extras = data;

      });
    },

    list(page = 1) {
      this.axios
        .post(`/extra?page=${page}`)
        .then(({ data }) => {
          this.value_list = data.list;
          this.extra_types = data.extra_types;
          this.staffs = data.staffs;
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },

    Add_newextra() {
      console.log(this.counts);
      this.axios
        .post(`/store_extra`, {
          type: this.type,
          count: this.counts,
          staff: this.staffselected,
          extra_type: this.typeselected,
          date: this.date,
          start_time: this.start_time,
          end_time: this.end_time,
          duration: this.duration,

        })
        .then((response) => {
          // ---------------------------------------------------------------
          console.log(response);



          toastMessage("تم الاضافه بنجاح");
          // this.$router.go(0);
        });

      // this.$router.go(0);

    },




  },
};
</script>

