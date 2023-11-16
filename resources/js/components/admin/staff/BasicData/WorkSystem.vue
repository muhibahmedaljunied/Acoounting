<template>
  <!-- row opened -->
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header">

          <span class="h2"> نظام الدوام</span>
          <div style="display: flex;float: left; margin: 5px">
            <a class="tn btn-info btn-sm waves-effect btn-agregar" data-toggle="modal" id="agregar_productos"
              data-target="#addwork">
              <i class="fa fa-plus-circle"></i></a>

            <input autocomplete="on" type="text" class="form-control input-text" placeholder="بحث ...."
              aria-label="Recipient's username" aria-describedby="basic-addon2" @input="get_search()">

            <div>

            </div>
          </div>
        </div>

        <div class="card-body" id="printme">
          <div class="table-responsive">
            <table class="table table-bordered text-center">
              <thead>
                <tr>
                  <th class="wd-15p border-bottom-0">#</th>
                  <th class="wd-15p border-bottom-0">نظام الدوام</th>
                  <th class="wd-15p border-bottom-0"> نوع الدوام</th>
                  <th class="wd-15p border-bottom-0"> من</th>
                  <th class="wd-15p border-bottom-0"> الي</th>

                  <th class="wd-15p border-bottom-0">ايام العمل</th>


                  <th class="wd-15p border-bottom-0">العمليات</th>
                </tr>
              </thead>
              <tbody v-if="value_list && value_list.data.length > 0">
                <tr v-for="(work_system, index) in value_list.data" :key="index">
                  <td>{{ index + 1 }}</td>

                  <td >

                    {{ work_system.name }}
                  </td>

                  <td>

                    {{ work_system.type }}
                  </td>
             

                  <td >

                    {{ work_system.from_time }}
                  </td>

                  <td >

                    {{ work_system.into_time }}
                  </td>



                  <td>
                    <span v-for="days in work_system.days">

                      <span v-if="days == 1">سبت </span>
                      <span v-if="days == 2">احد </span>
                      <span v-if="days == 3">اثنين </span>
                      <span v-if="days == 4">ثلاثاء </span>
                      <span v-if="days == 5">اربعاء </span>
                      <span v-if="days == 6">خميس </span>
                      <span v-if="days == 7">جمعه </span>

                    </span>

                  </td>


                  <td>
                    <!-- <a data-toggle="modal" data-target="#modal_vaciar" class="tn btn-danger btn-lg waves-effect btn-agregar"><i class="fa fa-trash"></i></a> -->
                    <button type="button" @click="delete_work_system(work_system.id)"
                      class="btn btn-sm waves-effect btn-danger">
                      <i class="fa fa-trash"></i>
                    </button>

                    <router-link :to="{
                      name: 'edit_branch',
                      params: { id: work_system.id },
                    }" class="edit btn btn-sm waves-effect btn-success">
                      <i class="fa fa-edit"></i></router-link>
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
        </div>


        <div class="modal fade" id="addwork" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <form method="post">
            <div class="modal-dialog modal-fullscreen">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">نظام الدوام</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>


                <div class="modal-body">

                  <div class="row row-sm">

                    <div class="col-md-3">
                      <label for="status"> نظام الدوام</label>
                      <input type="text" class="form-control " style="background-color:beige"  v-model="work_system_value"/>
                    </div>
                    <div class="col-md-3">
                      <label for="status"> نوع الدوام</label>
                    
                      <select style="background-color:beige" v-model="work_type_selected"
                                        class="form-control " required>
                                        <option v-for="work_type in work_types" v-bind:value="work_type.id">
                                          {{ work_type.name }}
                                        </option>

                                      </select>
                    </div>



                  </div>
                  <br>

                  <div class="row row-sm">

                    <div class="col-xl-12">
                      <!-- <form method="post"> -->
                      <div class="card">
                    
                        <div class="card-body">

                          <form method="post"  enctype="multipart/form-data">

                            <div class="table-responsive">
                              <table class="table table-bordered text-right m-t-30"
                                style="width: 100%; font-size: x-small">
                                <thead>
                                  <tr>

                                    <!-- <th> نوع الدوام</th> -->


                                    <th>الوقت</th>

                                    <th>ايام العمل</th>



                                    <th>اضافه</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr v-for="index in count" :key="index">
                              
                                  
                              
                                      <!-- <select style="background-color:beige" v-model="work_type_selected[index]"
                                        class="form-control " required>
                                        <option v-for="work_type in work_types" v-bind:value="work_type.id">
                                          {{ work_type.name }}
                                        </option>

                                      </select> -->
                     

                                    <td>
                                      <select v-model="period_selected[index]" class="form-control " required>
                                        <option v-for="period in periods" v-bind:value="period.id">
                                          من {{ period.from_time }}الي{{ period.into_time }}
                                        </option>

                                      </select>

                                    </td>
                                    <td>
                                      <input type="checkbox" name='fieldset1' id="fieldset1" v-model="fieldset1[index]"
                                        @change="check($event, fieldset1[index], index, 1)" />
                                      <label for="radio-example-one">سبت </label>

                                      <input type="checkbox" name='fieldset2' id="fieldset2" v-model="fieldset2[index]"
                                        @change="check($event, fieldset2[index], index, 2)" />
                                      <label for="radio-example-two">احد </label>

                                      <input type="checkbox" name='fieldset3' id="fieldset3" v-model="fieldset3[index]"
                                        @change="check($event, fieldset3[index], index, 3)" />
                                      <label for="radio-example-three">اثنين</label>

                                      <input type="checkbox" name='fieldset3' id="fieldset4" v-model="fieldset4[index]"
                                        @change="check($event, fieldset4[index], index, 4)" />
                                      <label for="radio-example-three">ثلاثاء</label>

                                      <input type="checkbox" name='fieldset3' id="fieldset5" v-model="fieldset5[index]"
                                        @change="check($event, fieldset5[index], index, 5)" />
                                      <label for="radio-example-three">اربعاء</label>


                                      <input type="checkbox" name='fieldset3' id="fieldset6" v-model="fieldset6[index]"
                                        @change="check($event, fieldset6[index], index, 6)" />
                                      <label for="radio-example-three">خميس</label>



                                      <input type="checkbox" name='fieldset3' id="fieldset7" v-model="fieldset7[index]"
                                        @change="check($event, fieldset7[index], index, 7)" readonly />
                                      <label for="radio-example-three">جمعه</label>


                                





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
                  <button type="button" class="btn btn-primary" @click="Add_new()">حفظ </button>
         
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </form>
        </div>






      </div>


    </div>
  </div>
</template>



<script>

import pagination from "laravel-vue-pagination";
import operation from '../../../../../js/staff/BasicData/operation.js';

export default {
  components: {
    pagination,
  },
  mixins: [operation],
  data() {
    return {

      values: [

      ],

      value_list: {
        type: Object,
        default: null,
      },

      all_values: [],
      // work_systems: '',
      work_system_value:'',
      work_type_selected: [],
      period_selected: [],
      rest_selected: [],
      
      fieldset1: [],
      fieldset2: [],
      fieldset3: [],
      fieldset4: [],
      fieldset5: [],
      fieldset6: [],
      fieldset7: [],

    };
  },
  mounted() {
    this.list();
    this.counts[0] = 1;
    this.type = 'work_system';


  },
  methods: {


    Add_new() {

      this.axios
        .post(`/store_work_system`, {
          count: this.counts,
          type: this.type,
          name:this.work_system_value,
          work_type: this.work_type_selected,
          period: this.period_selected,
          // rest: this.rest_selected,
          day: this.all_values,

        }
        )
        .then((response) => {
          console.log(response);
          toastMessage("تم الاضافه بنجاح");
          // this.$router.go(0);
        });


    },
    check(e, fild, index, id) {
      // this.values[1][0] = 0;
      // console.log(this.values[1][0]);



      if (fild == true) {


        if (e.target.id == `fieldset1`) { this.values[1] = id; }
        if (e.target.id == 'fieldset2') { this.values[2] = id; }
        if (e.target.id == 'fieldset3') { this.values[3] = id; }
        if (e.target.id == 'fieldset4') { this.values[4] = id; }
        if (e.target.id == 'fieldset5') { this.values[5] = id; }
        if (e.target.id == 'fieldset6') { this.values[6] = id; }
        if (e.target.id == 'fieldset7') { this.values[7] = id; }


      }
      else {


        if (e.target.id == `fieldset1`) { this.values[1] = 0; }
        if (e.target.id == 'fieldset2') { this.values[2] = 0; }
        if (e.target.id == 'fieldset3') { this.values[3] = 0; }
        if (e.target.id == 'fieldset4') { this.values[4] = 0; }
        if (e.target.id == 'fieldset5') { this.values[5] = 0; }
        if (e.target.id == 'fieldset6') { this.values[6] = 0; }
        if (e.target.id == 'fieldset7') { this.values[7] = 0; }


      }

      this.all_values[index] = this.values;

      console.log(this.all_values);

    },
    list() {
      this.axios
        .post(`/work_system`)
        .then((responce) => {

          console.log('work_system',responce.data.work_systems);
          this.value_list = responce.data.work_systems;
          this.work_types = responce.data.work_types;
          this.periods = responce.data.periods;
          // this.breaks = responce.data.breaks;
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },



  },
};
</script>



