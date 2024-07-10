<template>
  <!-- row opened -->
<div class="container-fluid">
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header">

          <span class="h2"> الغياب</span>



          <div style="display: flex;float: left; margin: 5px">

            <a class="btn btn-info btn-sm waves-effect btn-agregar" data-toggle="modal" id="agregar_productos"
              data-target="#addAbsence">
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
                  <th class="wd-15p border-bottom-0"> نوع الغياب</th>
                  <th class="wd-15p border-bottom-0">التاريخ </th>


                  <th class="wd-15p border-bottom-0">العمليات</th>
                </tr>
              </thead>
              <tbody v-if="value_list && value_list.data.length > 0">
                <tr v-for="(absence, index) in value_list.data" :key="index">

                  <td>{{ absence.staff_name }}</td>

                  <td>

                      {{ absence.absence_type_name }}
                    
                  </td>




                  <td>

                      {{ absence.date }}
                     
                  </td>


                


               


                  <td>
                    <button type="button" @click="delete_item(absence.id)" class="btn btn-danger btn-sm waves-effect">
                      <i class="fa fa-trash"></i>
                    </button>


                    <a class="btn btn-info btn-sm waves-effect btn-agregar" data-toggle="modal" id="agregar_productos"
                      data-target="#updateExtra">
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

        <div class="modal fade" id="addAbsence" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <h4 class="modal-title" id="myLargeModalLabel">الغياب</h4>
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


                                    <th> نوع الغياب</th>


                                    <th>التاريخ </th>

                        

                                    <th>اضافه</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr v-for="index in count" :key="index">
                                    <td>
                                      <select style="background-color: beige;" v-model="staffselected[index]" name="type" id="type" class="form-control "
                                        required>
                                        <option style="background-color: beige;" v-for="staff in staffs" v-bind:value="staff.id">
                                          {{ staff.name }}
                                        </option>
                                      </select>
                                    </td>
                                    <td>
                                      <select style="background-color: beige;" v-model="typeselected[index]" name="type" id="type" class="form-control"
                                        required>
                                        <option v-for="absence_type in absence_types" v-bind:value="absence_type.id">
                                          {{ absence_type.name }}
                                        </option>
                                      </select>
                                    </td>

                          
                             


                                    <td>
                                      <input   style="background-color: beige;" v-model="date[index]" type="date" class="form-control" name="name" id="name"
                                        required />
                                    </td>

                                    <td v-if="index == 1">
                                      <a class="btn btn-info btn-sm waves-effect btn-agregar"
                                        v-on:click="addComponent(count)">
                                        <i class="fa fa-plus-circle"></i></a>

                                      <a class="btn btn-info btn-sm waves-effect btn-agregar"
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
        <div class="modal fade" id="updateExtra" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                      <th class="wd-15p border-bottom-0"> اضافه</th>
                                      <th class="wd-15p border-bottom-0">العمليات</th>
                                    </tr>
                                  </thead>
                                  <tbody v-if="value_list && value_list.data.length > 0">
                                    <tr v-for="(absence, index) in value_list.data" :key="index" >


                                      <template v-if="absence.id == 3">


                                        <td>{{ absence.name }}</td>
                                        <td>

                                          <div v-for="(absence_names, index) in absence.absence" :key="index">
                                            {{ absence_names.absence_type.name }}
                                            <hr>
                                          </div>
                                        </td>
                                        <td>

                                          <div v-for="(absence_end_date, index) in absence.absence" :key="index">
                                            {{ absence_end_date.date }}
                                            <hr>

                                          </div>
                                        </td>
                                        <td>

                                          <div v-for="(absence_start_time, index) in absence.absence" :key="index">
                                            {{ absence_start_time.start_time }}
                                            <hr>
                                          </div>
                                        </td>
                                        <td>

                                          <div v-for="(absence_end_time, index) in absence.absence" :key="index">
                                            {{ absence_end_time.end_time }}
                                            <hr>
                                          </div>
                                        </td>
                                        <td>

                                          <div v-for="(absence_end_time, index) in absence.absence" :key="index">
                                            {{ absence_end_time.number_hours }}
                                            <hr>
                                          </div>
                                        </td>
                                        <!-- <td>{{ absence.note }}</td> -->
                                        <td>
                                        <input   type="checkbox" class="btn btn-info waves-effect">
                                    </td>
                                        <td>
                                          <!-- <a data-toggle="modal" data-target="#modal_vaciar" class="btn btn-danger btn-lg waves-effect btn-agregar"><i class="fa fa-trash"></i></a> -->
                                          <button type="button" @click="delete_item(absence.id)"
                                            class="btn btn-danger btn-sm waves-effect">
                                            <i class="fa fa-trash"></i>
                                          </button>


                                          <a class="btn btn-info btn-sm waves-effect btn-agregar" data-toggle="modal"
                                            id="agregar_productos" data-target="#updateExtra">
                                            <i class="fa fa-edit"></i></a>
                                        </td>
                                        
                                      </template>
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
<!-- 
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" @click="Add_new()">حفظ </button>
             
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div> -->
              </div>
            </div>
          </form>
        </div>


      </div>
    </div>
    <!--/div-->
  </div>
</div>
  <!-- /row -->
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

      typeselected: [],
      date: [],
      table: 'absence',
      word_search: "",

    };
  },
  mounted() {
    this.list();
    this.counts[0] = 1;
    this.type = 'absence';
  },
  methods: {
    Add_new() {

      this.Add(
        {
          type: this.type,
          count: this.counts,
          staff: this.staffselected,
          date: this.date,
          absence_type: this.typeselected,

        });


    },

    get_search(word_search) {
      this.axios.post(`/absencesearch`, { word_search: this.word_search }).then(({ data }) => {

        this.absences = data;

      });
    },

    
    list(page = 1) {

      this.axios
        .post(`/staff_absence?page=${page}`,{ type: 'absence'})
        .then(({ data }) => {
          console.log(data);
          this.value_list = data.list;
          this.absence_types = data.absence_types;
          this.staffs = data.staffs;
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },






  },
};
</script>

