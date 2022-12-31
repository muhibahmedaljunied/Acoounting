<template>
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header pb-0">
         
                <span class="h2">تفاصيل مرتجع الصرف</span>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table text-md-nowrap" id="example1">
              <thead>
                <tr>
                  <td>#</td>
                  <!-- <th class="wd-15p border-bottom-0">رقم المرتجع</th> -->
                  <th class="wd-15p border-bottom-0">المنتج</th>
                      <th class="wd-15p border-bottom-0">الحاله</th>
                                         <th>المواصفات والطراز</th>
                  <th class="wd-15p border-bottom-0">الكميه</th>
                         <th class="wd-15p border-bottom-0">المخزن</th>
             
                </tr>
              </thead>

                     
              <tbody v-if="cash && cash.length > 0">
                <tr v-for="(cashes, index) in cash" :key="index" >
                   <td>{{index+1}}</td>
                  <!-- <td>{{ cashes.cash_return_id }}</td> -->
                  <td>{{ cashes.product }}</td>
                      <td>{{ cashes.status }}</td>
                        <td>{{ cashes.desc }}</td>
                      <td>{{ cashes.qty_return }}</td>
  <td>{{ cashes.store }}</td>

                  
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
      cash: "yes",
    };
  },
  mounted() {
    let uri = `/returncash_details/${this.$route.params.id}`;
    this.axios.post(uri).then((response) => {
      this.cash = response.data.return_details;

      this.$root.logo = "CashList";
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


