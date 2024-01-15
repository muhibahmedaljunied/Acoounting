<template>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <span class="h2">تفاصيل لبيع</span>
               
               
              </div>
              <div class="card-body">
                  <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <!-- <th>الرقم</th> -->
                      <th>اسم المنتج</th>
                      <th> المواصفات والطراز</th>
 <th>الحاله</th>
   <th>المخزن</th>
                               <th class="wd-15p border-bottom-0">  الكميه المباعه</th>
                                      <th class="wd-15p border-bottom-0"> السعر </th>
                                <th class="wd-15p border-bottom-0">  الاجمالي   </th>
                   <!-- <th class="wd-15p border-bottom-0">  الكميه المرتحعه</th> -->
              
                    </tr>
                  </thead>
                  <tbody>
                    <tr  v-for="cash_details in cash_detail">
                      <!-- <td>{{ cash_details.id }}</td> -->
                      <td>{{ cash_details.product }}</td>

                        <td>{{ cash_details.desc }}</td>
                           <td>{{ cash_details.status }}</td>
                          <td>{{ cash_details.store }}</td>
                         
                      <td>{{ cash_details.qty }}</td>
                                 <td>{{ cash_details.price }}</td>
                          <td>{{ cash_details.total }}</td>
                            <!-- <td>{{ cash_details.qty_return }}</td> -->
                
                    </tr>

                    <tr>
                      <td colspan="7" style="text-align:center;color:red;font-size:large">الاجمالي</td>
<td>{{total}}</td>
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
      </div>
     
    </section>
  </div>
</template>
<script>
export default {
  data() {
    return {
     
      cash_detail: 0,
      total:0,
    };
  },
  mounted() {
      let uri = `/details_cash/${this.$route.params.id}`;
    this.axios.post(uri).then((response) => {
      this.cash_detail = response.data.cash_details;

      this.cash_detail.forEach((item) => {
            this.total =parseInt(item.total) + parseInt(this.total);
          });

    });
  },
  methods: {
  
  },

};
</script>

