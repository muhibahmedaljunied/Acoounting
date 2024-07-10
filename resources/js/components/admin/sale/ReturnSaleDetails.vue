<template>
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header pb-0">

          <span class="h2">تفاصيل مرتجع المبيعات</span>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table text-md-nowrap" id="example1">
              <thead>
                <tr>
                  <!-- <th class="wd-15p border-bottom-0">رقم المرتجع</th> -->
                  <th class="wd-15p border-bottom-0">المنتج</th>

                  <th> المواصفات والطراز</th>
                  <th>الحاله</th>
                  <th>المخزن</th>
                  <th>الرف</th>

                  <th class="wd-15p border-bottom-0">الكميه</th>
                  <th class="wd-15p border-bottom-0">المخزن</th>
                  <th class="wd-15p border-bottom-0"> الرف</th>


                </tr>
              </thead>
              <tbody>
                <tr v-for="sales in sale">
                  <!-- <td>{{ sales.sale_return_id }}</td> -->
                  <td>{{ sales.product_name }}</td>
                  <td>{{ sales.desc }}</td>
                  <td>{{ sales.status }}</td>
                  <td>{{ sales.store }}</td>
                  <td>{{ sales.qty_return }}</td>
                  <td>{{ sales.store }}</td>


                </tr>
                <!-- <a 
                      @click="$router.go(-1)"
                      class="btn btn-success"
                      ><span> تراجع</span></a
                    > -->
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      sale: "yes",
    };
  },
  mounted() {
    let uri = `/returnsale_details/${this.$route.params.id}`;
    this.axios.post(uri).then((response) => {
      this.sale = response.data.return_details;


    });
  },
  methods: {

  },
};
</script>


