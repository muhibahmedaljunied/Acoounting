<template>
  <div>


    <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <!-- <form method="post" @submit.prevent="submitForm"> -->

        <div class="card-header pb-0">
          <div class="d-flex justify-content-between">
            <span class="h2"> قيود اليوميه</span>
          </div>
        </div>
        <div class="card-body" id="printme">
     

          <div class="table-responsive">
            <table class="table table-bordered text-center">
              <thead>
                <tr>
                  <th class="wd-15p border-bottom-0">رقم الحساب</th>
                  <th class="wd-15p border-bottom-0">اسم الحساب</th>
                  <th class="wd-15p border-bottom-0">البيان</th>
                  <th class="wd-15p border-bottom-0">مدين</th>
                  <th class="wd-15p border-bottom-0">داين</th>
       
                </tr>
              </thead>
              <tbody>
                <tr v-for="(daily, index) in value_list" :key="index">
                  <!-- <tr > -->
                  <td>
                  {{ daily.account_id }}
                  </td>
                  <td>

                    {{ daily.text }}

                  </td>
                  <td>
  
                    {{ daily.description }}
                  </td>
                  <td>
                    {{ daily.debit }}
                  </td>
                  <td>
                    {{ daily.credit }}
                  </td>
             

              
                </tr>
             
              </tbody>
            </table>
          </div>
   
        </div>
      </div>
    </div>


  
    <!-- </form> -->
  </div>
  </div>

</template>
<script>


export default {

  data() {
    return {

      value_list:'',

    };
  },
  props: ['data'],

  mounted() {
    this.list();



  },

  methods: {

    list(){

      this.axios
          .post(`/payment_bond_daily/${this.data}`)
          .then(({ data }) => {
            console.log('daily',data.daily_details);
            this.value_list = data.daily_details;
          })
          .catch(({ response }) => {
            console.error(response);
          });
    },
   
  },
};
</script>




