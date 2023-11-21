<template>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row row-sm">
          <div class="col-xl-12">
            <div class="card">
              <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                  <span class="h2"> سند صرف</span>
                </div>



              </div>
              <div class="card-body">

                <div class="row">


                  <div class="col-md-4">
                    <h5 class="card-title">رقم الحساب</h5>
                    <div class="custom-search">

                      <input :id="'Sale_store_tree'" type="text" readonly class="custom-search-input">
                      <input :id="'Sale_store_tree_id'" type="hidden" readonly class="custom-search-input">

                      <button class="custom-search-botton" type="button" data-toggle="modal"
                        data-target="#exampleModalStore">
                        <i class="fa fa-plus-circle"></i></button>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <h5 class="card-title">اسم الحساب</h5>
                    <div class="custom-search">

                      <select class="form-control" style="background-color: beige;" name="forma_pago"
                        id="select_account_Sale">

                      </select>

                    </div>
                  </div>


                </div>

                <br>
                <hr>
                <div class="row">

                  
                  <div class="col-md-4"><label for="pagoPrevio">البيان</label> <input type="text" class="form-control"
                      style="background-color: beige;"></div>



                  <div class="col-md-4">
                    <label for="pagoPrevio">التاريخ</label>
                    <input type="date" class="form-control input_cantidad" onkeypress="return valida(event)" />

                  </div>
                </div>
                <br>
                <hr>

                <div class="row">
                  <div class="table-responsive">
                  <table class="table table-bordered text-right" style="width: 100%; font-size: x-large">
                    <thead>
                      <tr>
                 
                        <th> المورد</th>
               
                        <th>المبلغ</th>

                        <th>اضافه</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                  
                        <td>
                          <select name="" id="">
                            <option value="">نقدا</option>
                            <option value="">شيك</option>
                          </select>
                        </td>
                    
                   

                        <td>
                          <input type="number" id="price" class="form-control input_cantidad"
                            onkeypress="return valida(event)" />
                        </td>
                        <td>
                          <input type="checkbox" class="btn btn-info waves-effect" />
                        </td>
                      </tr>
                      <a href="javascript:void" class="btn btn-success"><span>تاكيد العمليه</span></a>

                    </tbody>
                  </table>

                </div>
                </div>
            
                <pagination align="center" :data="sales" @pagination-change-page="list"></pagination>
              </div>
            </div>
          </div>
        </div>


      </div>
    </section>

    <section class="content-body">

    </section>
  </div>
</template>
<script>


export default {
  data() {
    return {};
  },
  mounted() {
    let uri = `/data_for_voucher/${this.$route.params.id}`;
    this.axios.post(uri).then((response) => {
      this.sale_detail = response.data.sale_details;
    });
  },
  methods: {},
  computed: {},
};
</script>

