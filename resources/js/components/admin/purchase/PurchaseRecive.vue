<template>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div
              class="card"
              id="printme"
              style="outline: auto; outline-color: red; border-radius: 10"
            >
              <div class="card-header">
                <table style="width: 100%;">
                  <thead>
                    <tr>
                      <td rowspan="4" style="text-align: center;line-height: 1px;">
                        <h2>الجمهوريه اليمنيه </h2><br/>
                        <h2> وزاره الدفاع  </h2><br/>
                         <h2> رياسه هيه الاركات </h2><br/>
                            <h2>قياده القوات الجويه والدفاع  </h2><br/>
                           <h2>الدراسات والابحاث </h2><br/>
                           <h2>المخازن </h2><br/>
                     
                      </td>
                      <td rowspan="4" style="text-align: center;line-height: 1px;">  <img
                      :src="`/assets/img/images3.jpg`"
                      height="150px"
                      alt="products image"
                    /></td>
                      <td rowspan="4" style="text-align: center;line-height: 1px;">
                        <h2>رقم السند :{{ supplies[0].supply_id }}</h2><br/>
             
                             
                      <h2>تاريخ السند : {{ supplies[0].date }}</h2><br/>
                   
                      <h2> اسم المورد : {{ supplies[0].name }}
                          {{ supplies[0].last_name }}</h2><br/>
                    
                      </td>
                    </tr>
                    <tr>
                    
             
               
                    </tr>

                    <tr>
                  
                   
                
                    </tr>
                    <tr>
                      <td colspan="1"></td>
               
                      <td  style="text-align: left">
                        <button @click="printDiv('printme')">
                          <i
                            class="fas fa-print"
                            style="font-size: 24px; color: rgb(34, 192, 60)"
                          ></i>
                        </button>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="1"></td>
               
                      <td style="text-align: center;border-radius:10px;background-color:red">
                        <h1>سند استلام واردات</h1>
                      </td>
                             <td></td>
                    </tr>
                  </thead>
                </table>
              </div>
              <div class="card-body">
                <table
           
                  class="table table-bordered text-right"
                  style="width: 100%; font-size:30px;text-align:center"
                >
                  <thead style="background: red">
                    <tr>
                      <th>اسم المنتج</th>
                             <th> المواصفات والطراز</th>
                      <th>الحاله</th>
                      <th class="wd-15p border-bottom-0">الكميه الوارده</th>
                      <!-- <th class="wd-15p border-bottom-0">الكميه المرتحعه</th> -->
                      <th>المخزن</th>
                    
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="supply_details in supply_detail">
                      <td>{{ supply_details.product_name }}</td>
                           <td>{{ purchase_details.desc }}</td>
                      <td>{{ supply_details.status }}</td>
                      <td>{{ supply_details.quantity }}</td>
                      <!-- <td>{{ supply_details.qty_return }}</td> -->
                      <td>{{ supply_details.code }}</td>
                    </tr>
                  </tbody>
                </table>
                <div id="intro" style="text-align: right">
                  <h2>تم استلام المواد المذكوره اعلاه كامله</h2>
                </div>
                <div id="intro" style="text-align: right">
                  <h2>
                    <span>امين المخازن</span> : {{ user }}
                   
                  </h2>
                  <h2><span>التوقيع</span> :</h2>
                </div>
                <div id="intro" style="text-align: left">
                  <h5>{{ timestamp }}</h5>
                  <!-- <h5>امين المخازن:{{ user }}</h5> -->
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
      supplies: 0,
      supply_detail: 0,
      timestamp: "",
      user: "",
    };
  },
  created() {
    setInterval(this.getNow, 1000);
  },
  mounted() {
    let uri = `/invoice_supply/${this.$route.params.id}`;
    this.axios.post(uri).then((response) => {
      console.log(response.data.users.name);
      this.user = response.data.users.name;
      this.supply_detail = response.data.supply_details;
      this.supplies = response.data.supplies;
    });
  },
  methods: {
   
    
  },
  computed: {},
};
</script>

<style scoped>
.table-bordered {
  border: 2px solid black; }
  .table-bordered th, .table-bordered td {
    border: 2px solid black; 
      text-align: center;
  font-size:40px;
  }

  td h2{
    line-height: 20px;
  }
</style>

