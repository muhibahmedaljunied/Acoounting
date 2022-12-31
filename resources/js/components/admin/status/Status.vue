<template>
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header pb-0">
          <div class="d-flex justify-content-between">
         <span class="h2"> حاله المنتج</span>
          </div>
         
          <div class="d-flex justify-content-right">
          

             <router-link
              to="create_status"
         
              class="tn btn-info btn-lg waves-effect btn-agregar"
              ><i class="fa fa-plus-circle"></i
            ></router-link>

            <button @click="Export()">
              <i
                class="fas fa-file-export"
                style="font-size: 24px; color: #ee335e"
              ></i>
            </button>

            <button @click="Import()">
              <i
                class="fas fa-file-import"
                style="font-size: 24px; color: #22c03c"
              ></i>
            </button>



            <input
              type="search"
              autocomplete="on"
              name="search"
              data-toggle="dropdown"
              role="button"
              aria-haspopup="true"
              aria-expanded="true"
              placeholder="بحث عن مخزن"
              v-model="word_search"
              @input="get_search()"
            />
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table text-md-nowrap" id="example1">
              <thead>
                <tr>
                  <th class="wd-15p border-bottom-0">الرقم</th>
                  <th class="wd-15p border-bottom-0">الاسم</th>
 
                  <th class="wd-15p border-bottom-0">العمليات</th>
                </tr>
              </thead>
              <tbody v-if="status && status.data.length > 0">
                <tr v-for="(statu, index) in status.data" :key="index">
                  <td>{{ statu.id }}</td>
                  <td>{{ statu.name }}</td>
  
                  <td>
                    <button
                      type="button"
                      @click="delete_status(statu.id)"
                      class="btn btn-danger"
                    >
                      <i class="mdi mdi-account-minus"></i>
                    </button>
                    <router-link
                      :to="{ name: 'edit_status', params: { id: statu.id } }"
                      class="btn btn-success"
                      ><i class="mdi mdi-account-minus"></i
                    ></router-link>
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
          <pagination
            align="center"
            :data="status"
            @pagination-change-page="list"
          ></pagination>
        </div>
      </div>
    </div>
    <!--/div-->
  </div>
</template>
<script>
import pagination from "laravel-vue-pagination";
export default {
   components: {
    pagination,
  },

  data() {
    return {
      // store: "yes",

       status: {
        type: Object,
        default: null,
      },

      word_search: "",

    };
  },
  mounted() {
      this.list();
  },
  methods: {
    get_search(word_search) {
      this.axios.post(`/statussearch`,{word_search:this.word_search}).then(({data}) => {
        
        
        this.status = data;
    

      });
    },
      Import() {
      this.axios.post(`/StoreImport`).then(({ data }) => {

 this.list();

 
        
     
      });
    },

    Export() {
      this.axios.post(`/StoreExport`).then((responce ) => {


        console.log(responce.data.data);

 
        
      });

      
    },


    delete_status(id) {
      this.axios.post(`delete_status/${id}`).then((response) => {

          toastMessage("تم الحذف بنجاح");
       
 this.list();

      });
    },
     list(page = 1) {
      this.axios
        .post(`/status?page=${page}`)
        .then(({ data }) => {
          this.status = data;
        })
        .catch(({ response }) => {
          console.error(response);
        });
    },
  },
};
</script>


