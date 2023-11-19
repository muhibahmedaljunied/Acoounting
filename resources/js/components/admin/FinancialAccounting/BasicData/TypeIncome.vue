<template>
    <!-- row opened -->
    <div class="row row-sm">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header">
       
              <span class="h2"> انواع الايرادات</span>
    
  
            <div style="display: flex;float: left; margin: 5px">
     
              <a class="tn btn-info btn-sm waves-effect btn-agregar" data-toggle="modal" id="agregar_productos"
                data-target="#income_c">
                <i class="fa fa-plus-circle"></i></a>
  
  
                <input autocomplete="on"  type="text" class="form-control input-text"
                placeholder="بحث ...." aria-label="Recipient's username" aria-describedby="basic-addon2"
            >
  
  
              <div></div>
            </div>
          </div>
          <div class="card-body" id="printme">
            <div class="table-responsive">
              <table class="table table-bordered text-center">
                <thead>
                  <tr>
                    <!-- <th class="wd-15p border-bottom-0">الرقم الوظيفي</th> -->
                    <th class="wd-15p border-bottom-0">اسم الايراد</th>
           
                    <th class="wd-15p border-bottom-0"> ملاجظه</th>
  
  
                    <th class="wd-15p border-bottom-0">العمليات</th>
                  </tr>
                </thead>
                <tbody >
                  <tr >
                    <td></td>
  
                    <td>
                     
                     <div >
                       
                       <hr>
                     </div>
                     </td>
  
                  
                     <td>
                                        <button data-toggle="modal" data-target="#modal_vaciar1"
                                    
                                            class="tn btn-danger btn-sm waves-effect btn-agregar">
                                            <i class="fa fa-trash"></i></button>
                                 
                                        <router-link to="/temporale_supply"
                                            class="tn btn-info btn-sm waves-effect btn-agregar" data-toggle="tooltip"
                                            title="تعديل">
                                            <i class="fa fa-edit"></i></router-link>
                                    </td>
  
                    
                  </tr>
                </tbody>
             
              </table>
            </div>
          </div>
          <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true" style="display: none" id="income_c">
            <div class="modal-dialog modal-lg" style="width: 100%">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    x
                  </button>
                  <div class="col-md-8">
                    <h4 class="modal-title" id="myLargeModalLabel">انواع الايرادات</h4>
                  </div>
                  <div class="col-md-4">
                    <div class="col-sm-12">
                      <input type="text" placeholder="بحث" class="form-control" name="buscar_producto"
                        id="buscar_producto"  />
                    </div>
                  </div>
                </div>
                <div class="modal-body">
                    <div class="row row-sm">
                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-header pb-0">
                                                <div class="d-flex justify-content-between">
                                                    <h4 class="card-title mg-b-0">SIMPLE TABLE</h4>
                                                    <i class="mdi mdi-dots-horizontal text-gray"></i>
                                                </div>
                                                <p class="tx-12 tx-gray-500 mb-2">
                                                    Example of Valex Simple Table. <a href="">Learn more</a>
                                                </p>
                                            </div>
                                            <div class="card-body">
                                                <div class="form">
                                                    <h3 class="text-center">اضافه نوع الايراد</h3>
                                                    <form method="post" >
                                                        <div class="form-group">
                                                            <label for="name"> الاسم </label>
                                                            <input  type="text" name="name" id="name"
                                                                class="form-control" />
                                                        </div>
                                                     
                                                       

                                                       
                                                
                                                
                                                      
                                                  
                                                        <button type="submit" class="btn btn-primary btn-lg btn-block">
                                                            Add
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
  export default {
      components: {
          pagination,
      },
      data() {
  
          return {
            incomes: {
          type: Object,
          default: null,
        },
              word_search:'',
          }
    
      },
      mounted() {
          this.list();
  
  
      },
  
      methods: {
      
  
           
         
  
         
          list(page = 1) {
              // this.axios
              //     .post(`/income_type?page=${page}`)
              //     .then(({ data }) => {
              //         console.log(data.incomes);
  
                     
  
              //         this.incomes = data.incomes;
             
              //     })
              //     .catch(({ response }) => {
              //         console.error(response);
              //     });
          },
        
  
      },
  };
  </script>
  
  