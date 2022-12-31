<template>
<div>
  <div class="row row-sm">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header pb-0">
        
           <div class="d-flex justify-content-right">
        <span class="h2"> مرتجع التوريد</span>
          </div>
        </div>
    

          <div class="d-flex justify-content-right">
        
            
            <div class="form-group">
            <input
              type="search"
              autocomplete="on"
              name="search"
              role="button"
              placeholder="بحث  بالرقم"
              v-model="word_search"
              @input="get_search()"
            />
          </div>  
        </div>

        <div class="card-body">
          <div class="table-responsive">
            <table class="table text-md-nowrap" id="example1">
              <thead>
                <tr>
                   <!-- <th class="wd-15p border-bottom-0">رقم التوريد</th> -->
                  <th class="wd-15p border-bottom-0">رقم السند</th>
                  <th class="wd-15p border-bottom-0">المورد</th>
                    <th class="wd-15p border-bottom-0"> الكميه المرتجعه</th>
                  <th class="wd-15p border-bottom-0">تاريخ المرتجع</th>
                  <th class="wd-15p border-bottom-0">سبب الارجاع </th>

                  <th class="wd-15p border-bottom-0">العمليات</th>
                </tr>
              </thead>
              <tbody v-if="return_supplies && return_supplies.length > 0">
                <tr
                  v-for="(return_supply, index) in return_supplies"
                  :key="index"
                >
                 <!-- <td>{{ return_supply.supply_id }}</td> -->
                  <td>{{ return_supply.return_id }}</td>
                  <td>{{ return_supply.supplier_name }}</td>
 <td>{{ return_supply.quantity_return }}</td>
                  <td>{{ return_supply.return_date }}</td>
 <td>{{ return_supply.note }}</td>
                  <td>
                           <div class="optionbox">

           <select   @change="changeRoute(index)"  v-model="operationselected[index]"  name="العمليات"  class="form-control" >
      <option   class="btn btn-success"   v-bind:value="['/returnsupply_details/',return_supply.return_id,0]">
                      تفاصيل
                    </option>
   
 
      <option   class="btn btn-success" v-bind:value="['/return_supply_invoice/',return_supply.return_id,1]">
                      سند مرتجع توريد
                 </option>
      <option  class="btn btn-success"  v-bind:value="['/return_supply_recive/',return_supply.return_id,2]">
                      سند استلام
                   </option>
                    <option
                            class="btn btn-success"
                            v-bind:value="['/return_supply_cancel/', return_supply.return_id,3]"
                          >
                             الغاء السند
                          </option>
                               <option  class="btn btn-success"  v-bind:value="['/return_supply_update/',return_supply.supply_id,4]">
                   تعديل السند
                   </option>
    
  </select>
  </div>

                    <!--
                     <router-link
                    :to="`/return_supply_invoice/${return_supply.return_id}`"
                        class="btn btn-success">
                    
                      <span>سند مرتجع توريد</span>
                    </router-link>
                      <router-link
                    :to="`/return_supply_recive/${return_supply.return_id}`"
                        class="btn btn-success">
                    
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
         
                <span class="h2">تفاصيل مرتجع التوريد</span>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table text-md-nowrap" id="example1">
              <thead>
                <tr>
                  <th class="wd-15p border-bottom-0">#</th>
                  <!-- <th class="wd-15p border-bottom-0">رقم المرتجع</th> -->
                  <th class="wd-15p border-bottom-0">المنتج</th>
                     <th class="wd-15p border-bottom-0">الحاله</th>
                                  <th>المواصفات والطراز</th>
                         <th class="wd-15p border-bottom-0"> الكميه المرتجعه</th>
                     <th class="wd-15p border-bottom-0">المخزن</th>
                     
              

                </tr>
              </thead>
              <tbody  v-if="return_detail && return_detail.length > 0">
                <tr v-for="(return_details,index) in return_detail" :key = "index">
                  <td>{{index+1}}</td>
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
      // return_supply: "yes",

      return_supplies: {
        type: Object,
        default: null,
      },
      word_search: "",
      operationselected:[],
      return_detail:'',

    };
  },
  mounted() {
   
    this.axios
        .post(`/listreturn_supply/${this.$route.params.id}`)
        .then((response) => {

          this.return_supplies = response.data.return_supplies;
          
        })
        .catch(({ response }) => {
          console.error(response);
        });

    // this.list();
  },
  methods: {
      changeRoute(index) {
      
       
        // alert(index);
       console.log(this.operationselected[index][0]);
               

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
    // get_search(word_search) {
    //   this.axios
    //     .post(`/listreturn_supplysearch`, { word_search: this.word_search })
    //     .then(({ data }) => {
    //       this.return_supplies = data.return_supplies;

         
    //     });
    // },
    // list(page = 1) {
     
    // },

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


