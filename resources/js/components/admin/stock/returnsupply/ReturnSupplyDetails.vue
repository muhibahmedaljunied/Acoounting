<template>
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
       <div class="card-header pb-0">
         
                <span class="h2">تفاصيل مرتجع التوريد</span>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table text-md-nowrap" id="example1">
              <thead>
                <tr>
                  <th class="wd-15p border-bottom-0">#</th>
                  <th class="wd-15p border-bottom-0">المنتج</th>
                     <th class="wd-15p border-bottom-0">الحاله</th>
                                  <th>المواصفات والطراز</th>
                         <th class="wd-15p border-bottom-0"> الكميه المرتجعه</th>
                     <th class="wd-15p border-bottom-0">المخزن</th>
                     
              

                </tr>
              </thead>
              <tbody  v-if="return_detail && return_detail.length > 0">
                <tr v-for="(return_details,index) in return_detail" :key = "index"> 
                  <td>{{ index+1}}</td>
                  <td>{{ return_details.product }}</td>
                   <td>{{ return_details.status }}</td>
                                 <td>{{ return_details.desc }}</td>
                             <td>{{ return_details.qty_return }}</td>
                                    <td>{{ return_details.text }}</td>
                 


        

                  
                </tr>
               
              </tbody>
              <tbody v-else>
 <tr>
                  <td align="center" colspan="3">  <h3>لايوجد اي مرتجعات</h3></td>
                </tr>
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
      return_detail: "yes",
    };
  },
  mounted() {

    let uri = `/returnsupply_details/${this.$route.params.id}`;
    this.axios.post(uri).then((response) => {
     
      this.return_detail = response.data.return_details;

    });
  },
  
};
</script>


