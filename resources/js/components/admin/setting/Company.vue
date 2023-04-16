<template>
    <!-- row opened -->
    <div class="container-fluid">
        <div class="card">

            <div class="card-header">
                <h2>بيانات الشركه</h2>
            </div>
            <div class="card-body">
                <div class="row row-sm">


                    <div class="col-xl-12">
                        <div class="card">


                            <form method="post">

                                <div class="card-body">
                                    <div class="form">
                                        <!-- <h3 class="text-center">اضافه منتج</h3> -->


                                        <div class="form-group">
                                            <!-- <ul>
        <div v-for="error in errors">
          <li>{{ error[0] }}</li>
        </div>
      </ul> -->
                                        </div>

                                      
                                        <div class="form-group">
                                            <label for="Product">اسم الشركه</label>
                                            <input type="text" name="Product" id="product" class="form-control"
                                                required /><span style="color:red"></span>

                                        </div>

                                

                                        <div class="form-group">
                                            <label for="filePhoto">الصوره</label>
                                            <input type="file" name="image" class="form-control-file" id="filePhoto" />
                                            <img src="" id="previewHolder" width="150px" />
                                        </div>



                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="button" class="btn btn-primary btn-lg btn-block"> حفظ </button>
                                </div>
                            </form>
                        </div>
                    </div>




                    <!--/div-->
                </div>



                <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog"
                    aria-labelledby="mySmallModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            حذف
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>

</template>



