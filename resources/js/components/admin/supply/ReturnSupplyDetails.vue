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
                  <!-- <th class="wd-15p border-bottom-0">رقم المرتجع</th> -->
                  <th class="wd-15p border-bottom-0">المنتج</th>
                     <th class="wd-15p border-bottom-0">الحاله</th>
                         <th class="wd-15p border-bottom-0"> الكميه المرتجعه</th>
                     <th class="wd-15p border-bottom-0">المخزن</th>
                     
              

                </tr>
              </thead>
              <tbody>
                <tr v-for="return_details in return_detail">
                  <!-- <td>{{ return_details.supply_return_id }}</td> -->
                  <td>{{ return_details.product }}</td>
                   <td>{{ return_details.status }}</td>
                             <td>{{ return_details.qty_return }}</td>
                                    <td>{{ return_details.store }}</td>
                 


        

                  
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
      return_detail: "yes",
    };
  },
  mounted() {

    let uri = `/returnsupply_details/${this.$route.params.id}`;
    this.axios.post(uri).then((response) => {
     
      this.return_detail = response.data.return_details;

    });
  },
  methods: {
    // supply_details(id){
    //     this.axios.post(`supply_details/${id}`).then(response => {
    // 		toast.fire({
    //                           title: "Deleted!",
    //                           text: "Your category has been deleted.",
    //                           button: "Close", // Text on button
    //                           icon: "success", //built in icons: success, warning, error, info
    //                           timer: 3000, //timeOut for auto-close
    //                           buttons: {
    //                               confirm: {
    //                               text: "OK",
    //                               value: true,
    //                               visible: true,
    //                               className: "",
    //                               closeModal: true
    //                               },
    //                               cancel: {
    //                               text: "Cancel",
    //                               value: false,
    //                               visible: true,
    //                               className: "",
    //                               closeModal: true,
    //                               }
    //                           }
    //                       })
    //               // this.$router.push('category')
    // 	})
    // }
  },
};
</script>


