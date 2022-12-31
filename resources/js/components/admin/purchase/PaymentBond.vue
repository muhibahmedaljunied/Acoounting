<template>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="modal-body">
          <table
            class="table table-bordered text-right"
            style="width: 100%; font-size: x-large"
          >
            <thead>
              <tr>
                <th>رقم الفاتوره</th>
                <th>نوع السند</th>
                <th>الصندوق</th>
                <th>البنك</th>
                <th>رقم الشيك</th>

                <th>تاريخ السند</th>
                <th>الحساب</th>
                <th>المبلغ</th>

                <th>اضافه</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>
                  <select
                    class="form-control selectpicker"
                    id="select-country"
                    data-live-search="true"
                  >
                    <option data-tokens="china">China</option>
                    <option data-tokens="malayasia">Malayasia</option>
                    <option data-tokens="singapore">Singapore</option>
                  </select>
                </td>
                <td>
                  <select name="" id="">
                    <option value="">نقدا</option>
                      <option value="">شيك</option>
                  </select>
                </td>
                <td>
                  <select name="" id="">
                    <option value=""></option>
                  </select>
                </td>
                <td>
                  <select name="" id="">
                    <option value=""></option>
                  </select>
                </td>
                <td>
                  <select name="" id="">
                    <option value=""></option>
                  </select>
                </td>

                <td>
                  <input
                    type="date"
                    class="form-control input_cantidad"
                    onkeypress="return valida(event)"
                  />
                </td>
                <td>
                  <select name="" id="">
                    <option value=""></option>
                  </select>
                </td>
                <td>
                  <input
                    type="number"
                    id="price"
                    class="form-control input_cantidad"
                    onkeypress="return valida(event)"
                  />
                </td>
                <td>
                  <input type="checkbox" class="btn btn-info waves-effect" />
                </td>
              </tr>
              <a href="javascript:void" class="btn btn-success"
                ><span>تاكيد العمليه</span></a
              >
              <!-- 
                  <a @click="$router.go(0)" class="btn btn-success"
                    ><span> تراجع</span></a
                  > -->
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
// $(function() {
//   $('.selectpicker').selectpicker();
// });

  export default {
    data() {
      return {
       
      };
    },
    mounted() {
      let uri = `/data_for_voucher/${this.$route.params.id}`;
      this.axios.post(uri).then((response) => {
        this.sale_detail = response.data.sale_details;

      });
    },
    methods: {
 

    },
  
  };
</script>

