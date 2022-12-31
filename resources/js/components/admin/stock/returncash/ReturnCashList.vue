<template>
<div>
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header pb-0">
          <span class="h2"> مرتجع الصرف</span>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table text-md-nowrap" id="example1">
              <thead>
                <tr>
                  <td>#</td>
                  <th class="wd-15p border-bottom-0">رقم السند</th>
                  <th class="wd-15p border-bottom-0">العميل</th>
                  <th class="wd-15p border-bottom-0">الكميه</th>
                  <th class="wd-15p border-bottom-0">تاريخ المرتجع</th>
                  <th class="wd-15p border-bottom-0">سبب الارجاع</th>
                  <th class="wd-15p border-bottom-0">العمليات</th>
                </tr>
              </thead>
              <tbody v-if="return_cash && return_cash.length > 0">
                <tr   v-for="(return_cashes, index) in return_cash" :key="index"  >
                     <td>{{index+1}}</td>
                  <td>{{ return_cashes.return_id }}</td>
                  <td>{{ return_cashes.customer_name }}</td>

                  <td>{{ return_cashes.quantity_return }}</td>
                  <td>{{ return_cashes.return_date }}</td>
                  <td>{{ return_cashes.note }}</td>
                  <td>
          
           
        <div class="optionbox">
           <select   @change="changeRoute(index)"  v-model="operationselected[index]"  name="العمليات"  class="form-control" >
      <option   class="btn btn-success"   v-bind:value="['/returncash_details/',return_cashes.return_id,0]">
                      تفاصيل
                    </option>
   
 
      <option   class="btn btn-success" v-bind:value="['/return_cash_invoice/',return_cashes.return_id,1]">
                      سند مرتجع صرف
                 </option>
      <option  class="btn btn-success"  v-bind:value="['/return_cash_recive/',return_cashes.return_id,2]">
                      سند استلام
                   </option>
                     <option
                            class="btn btn-success"
                            v-bind:value="['/return_cash_cancel/', return_cashes.return_id,4]"
                          >
                             الغاء السند
                          </option>
                                 <option  class="btn btn-success"  v-bind:value="['/return_cash_update/',return_cashes.return_id,5]">
                   تعديل السند
                   </option>
    
  </select>
  </div>
                    <!-- <router-link
                      :to="`/return_details_s/${return_cashes.return_id}`"
                      class="btn btn-success"
                    >
                      <span><i class="fa fa-search-plus"></i></span>
                    </router-link>
                    <router-link
                      :to="`/return_cash_invoice/${return_cashes.return_id}`"
                      class="btn btn-success"
                    >
                      <span>سند مرتجع صرف</span>
                    </router-link>
                    <router-link
                      :to="`/return_cash_recive/${return_cashes.return_id}`"
                      class="btn btn-success"
                    >
                      <span>سنداستلام</span>
                    </router-link> -->
                  </td>
                </tr>
              </tbody>
        
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
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
                  <!-- <th class="wd-15p border-bottom-0">رقم المرتجع</th> -->
                  <th class="wd-15p border-bottom-0">المنتج</th>
                      <th class="wd-15p border-bottom-0">الحاله</th>
                                         <th>المواصفات والطراز</th>
                  <th class="wd-15p border-bottom-0">الكميه</th>
                         <th class="wd-15p border-bottom-0">المخزن</th>
             
                </tr>
              </thead>
           
                  <tbody  v-if="return_detail && return_detail.length > 0">
                <tr v-for="return_details in return_detail">
                  <!-- <td>{{ return_details.supply_return_id }}</td> -->
                  <td>{{ return_details.product }}</td>
                   <td>{{ return_details.status }}</td>
                                 <td>{{ return_details.desc }}</td>
                             <td>{{ return_details.qty_return }}</td>
                                    <td>{{ return_details.store }}</td>
                 


        

                  
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
</div>  
</template>
<script>
export default {
  data() {
    return {
      return_cash: "yes",
      operationselected:[],
      return_detail:'',
    };
  },
  mounted() {
    this.axios.post(`/listreturn_cash/${this.$route.params.id}`).then((response) => {
      this.return_cash = response.data.return_cashes;

      this.$root.logo = "CashList";
    });
  },
  methods: {
     changeRoute(index) {
      

        if(this.operationselected[index][2] == 0){
          
           this.axios
          .post(this.operationselected[index][0]+this.operationselected[index][1])
          .then((response) => {

            this.return_detail = response.data.return_details;
            
          })
          .catch(({ response }) => {
            console.error(response);
          });

        }else{

            this.$router.push(this.operationselected[index][0]+this.operationselected[index][1]);
        }
     
            },


   
  },
};
</script>

<style scoped>

.optionbox select {
    background: #E62968;
    color: #fff;
    padding: 10px;
    width: 120px;
    height: 30px;
    border: none;
    font-size: 20px;
    box-shadow: 0 5px 18px rgb(93, 15, 9);
    -webkit-appearance: button;
    outline: none;
}




</style>
