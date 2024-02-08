<template>
  <!-- row opened -->
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header">

          <span class="h2">انواع انظمه الدوام</span>
          <div style="display: flex;float: left; margin: 5px">
            <a class="tn btn-info btn-sm waves-effect btn-agregar" data-toggle="modal" id="agregar_productos"
              data-target="#addwork_system_type">
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
                  <th class="wd-15p border-bottom-0">الفتره</th>
                  <th class="wd-15p border-bottom-0">العمليات</th>
                </tr>
              </thead>
              <tbody v-if="value_list && value_list.data.length > 0">
                <tr v-for="(work_system, index) in value_list.data" :key="index">
                  <td>{{ index + 1 }}</td>

                  <td>

                    {{ work_system.work_system_types_name }}
                  </td>

                  <td>

                    {{ work_system.name }}
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


        <div class="modal fade" id="addwork_system_type" tabindex="-1" aria-labelledby="exampleModalLabel"
          aria-hidden="true">
          <form method="post">
            <div class="modal-dialog modal-fullscreen">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">نوع نظام الدوام</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>


                <div class="modal-body">
                  <div class="row row-sm">
                    <div class="col-xl-12">
                      <div class="card">

                        <div class="card-body">
                          <form method="post" enctype="multipart/form-data">

                            <div class="table-responsive">
                              <table class="table table-bordered text-right m-t-30"
                                style="width: 100%; font-size: x-small">
                                <thead>
                                  <tr>

                                    <th> نوع نظام الدوام</th>


                                    <th>نوع الدوام</th>




                                    <th>اضافه</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr v-for="index in count" :key="index">
                                    <td>
                                      <input v-model="name[index]" type="text" class="form-control" name="name" id="name"
                                        required />

                                    </td>


                                    <td>
                                      <select  style="background-color:beige"
                                        v-model="work_type_selected[index]" class="form-control " required>
                                        <option v-for="work_type in work_types" v-bind:value="work_type.id">
                                          {{ work_type.name }}
                                        </option>

                                      </select>
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
        </div>






      </div>


    </div>
  </div>
</template>



<script>

import pagination from "laravel-vue-pagination";
import operation from '../../../../staff/BasicData/operation.js';

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
      work_types:'',
      // work_system_types:'',
      work_type_selected: [],
      

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
        .post(`/store_work_system_type`, {
          count: this.counts,
          name: this.name,
          work_type: this.work_type_selected,

        }
        )
        .then((response) => {
          console.log(response);
          toastMessage("تم الاضافه بنجاح");
          // this.$router.go(0);
        });


    },
   
    list() {
      this.axios
        .post(`/work_system_type`)
        .then((responce) => {

          // console.log('persssssssdddddsiods', responce.work_types);
          this.work_types = responce.data.work_types;
          this.value_list = responce.data.work_system_types;


        })
        .catch(({ response }) => {
          console.error(response);
        });
    },



  },
};
</script>



