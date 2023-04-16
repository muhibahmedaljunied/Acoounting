<template>
    <!-- row opened -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">

                    <span class="h2"> البنوك</span>


                    <div style="display: flex;float: left; margin: 5px">

                        <a class="tn btn-info btn-sm waves-effect btn-agregar" data-toggle="modal"
                            id="agregar_productos" data-target="#bank">
                            <i class="fa fa-plus-circle"></i></a>


                        <input autocomplete="on" type="text" class="form-control input-text" placeholder="بحث ...."
                            aria-label="Recipient's username" aria-describedby="basic-addon2">


                        <div></div>
                    </div>
                </div>
                <div class="card-body" id="printme">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <!-- <th class="wd-15p border-bottom-0">الرقم الوظيفي</th> -->
                                    <th class="wd-15p border-bottom-0">اسم البنك</th>
                         
                                    <!-- <th class="wd-15p border-bottom-0"> ملاجظه</th> -->


                                    <th class="wd-15p border-bottom-0">العمليات</th>
                                </tr>
                            </thead>
                            <tbody v-if="banks && banks.data.length > 0">
                                <tr v-for="(bank, index) in banks.data" :key="index">
                                    <td>
                                        {{ bank.bank_name }}
                                    </td>

                                   <td></td>

                                    




                                </tr>
                            </tbody>

                        </table>
                    </div>
                </div>
                <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
                    aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none" id="bank">
                    <div class="modal-dialog modal-lg" style="width: 100%">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                    x
                                </button>
                                <div class="col-md-8">
                                    <h4 class="modal-title" id="myLargeModalLabel">البنوك</h4>
                                </div>
                                <div class="col-md-4">
                                    <div class="col-sm-12">
                                        <input type="text" placeholder="بحث" class="form-control" name="buscar_producto"
                                            id="buscar_producto" />
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
                                                    <h3 class="text-center">اضافه بنك</h3>
                                                    <form method="post" >
                                                        <div class="form-group">
                                                            <label for="name"> اسم البنك </label>
                                                            <input  type="text" name="name" id="name"
                                                                class="form-control" />
                                                        </div>
                                                     
                                                        <div class="form-group">
                                                            <label for="status">رقم الحساب</label>
                                                            <input  type="text" name="status"
                                                                id="status" class="form-control" />
                                                        </div>
                                                
                                                        <div class="form-group">
                                                            <label for="status">اسم الحساب</label>
                                                            <input  type="text" name="status"
                                                                id="status" class="form-control" />
                                                        </div>
                                                        <!-- = -->
                                                  
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
          banks: {
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
            this.axios
                .post(`/banks?page=${page}`)
                .then(({ data }) => {
                    console.log(data.banks);

                   

                    this.banks = data.banks;
          
                })
                .catch(({ response }) => {
                    console.error(response);
                });
        },
      

    },
};
</script>

