<template>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card" id="printme" style="outline: auto;outline-color:red;border-radius:10;">
              <div class="card-header">
               
               <table style="width: 100%">
                  <thead>
                               <right-side :data_style='data_style'></right-side>
               <!-- <tr>
                      <td
                        rowspan="4"
                        style="text-align: center; line-height: 3px"
                      >
                        <h2>الجمهوريه اليمنيه</h2>
                    
                        <h2>وزاره الدفاع</h2>
                  
                         <h2>رئاسه هيئه الاركات</h2>
                    
                        <h2>قياده القوات الجويه والدفاع</h2>
                  
                        <h2>الدراسات والابحاث</h2>
                       
                        <h2>المخازن</h2>
                     
                      </td>
                      <td
                        rowspan="4"
                        style="text-align: center; line-height: 1px"
                      >
                        <img
                          :src="`/assets/img/images3.jpg`"
                          height="150px"
                          alt="products image"
                        />
                      </td>
                      <td
                        rowspan="4"
                        style="text-align: center; line-height: 3px"
                      >
                        <h2>رقم السند :{{ return_supplies[0].supply_id }}</h2>
                   \

                        <h2>تاريخ السند : {{ return_supplies[0].date }}</h2>
                      \

                        <h2>اسم المورد : {{ return_supplies[0].name }}</h2>
                      </td>
                    </tr> -->
                    <tr></tr>

                    <tr></tr>
                    <tr>
                      <td colspan="1"></td>

                      <td style="text-align: left">
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

                      <!-- <td
                        style="
                          text-align: center;
                          border-radius: 10px;
                          background-color: red;
                        "
                      >
                        <h1>سند استلام مرتحع  توريد</h1>
                      </td> -->
                      <td></td>
                    </tr>
                  </thead>
                </table>
              </div>
              <div class="card-body">
                <table
                  class="table table-bordered text-right"
                  style="width: 100%;font-size:large;text-align:center"
                >
                  <thead style="background:red">
                    <tr>
                      <th>اسم المنتج</th>
                             <th>الحاله</th>
                                               <th>المواصفات والطراز</th>
                      <!-- <th class="wd-15p border-bottom-0">الكميه الوارده</th> -->
                      <th class="wd-15p border-bottom-0">الكميه المرتحعه</th>
                            <th>المخزن</th>
               
                    </tr>
                  </thead>
                  <tbody v-if="return_detail && return_detail.length " :key="index">
                    <tr v-for="return_details in return_detail">
                      <td>{{ return_details.product }}</td>
                           <td>{{ return_details.status }}</td>
                                           <td>{{ return_details.desc }}</td>
                      <!-- <td>{{ return_details.supply_qty }}</td> -->
                      <td>{{ return_details.qty_return }}</td>
                        <td>{{ return_details.store }}</td>
                 
                    </tr>
                  </tbody>
                 </table>
                <!-- <div id="intro" style="text-align: right">
                  
                  <h2>تم استلام المواد المذكوره اعلاه كامله </h2>

                </div>
                <div id="intro" style="text-align: right">
                  
                  <h2><span>اسم المورد</span> : {{ return_supplies[0].name }} 
                       {{ return_supplies[0].last_name }}
                          </h2>
                  <h2> <span>التوقيع</span> : </h2>
                </div>
                 <div id="intro" style="text-align: left">
                  <h5>{{ timestamp }}</h5>
                  <h3>امين المخازن:{{ user }}</h3>
                </div> -->

                         <footer-side :data_style='data_style'></footer-side>
    
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
<script>

import RightSide from "../Style/RightSide";
import FooterSide from "../Style/FooterSide";
export default {
   components: {
    RightSide,
    FooterSide,

  },
  data() {
    return {
      return_supplies: 0,
      return_detail: 0,
       timestamp: "",
       user:'',

             data_style: {
        'right': 'اسم المورد',
        'left': 0,
        'number': 0,
        'date': 0,
        'title': 'سند استلام مرتحع  توريد',
           'check':1,
           'user':0,

      },
    };
  },
  created() {
      
       setInterval(getNow, 1000);
  },
  mounted() {
    let uri = `/invoice_return_supply/${this.$route.params.id}`;
    this.axios.post(uri).then((response) => {
        console.log(response.data.supply_returns);
        this.user = response.data.users.name;
      this.return_supplies = response.data.return_supplies;
      this.return_detail = response.data.return_details;



        // -----------------for style----------
      this.data_style.left = this.return_supplies[0].name;
      this.data_style.number = this.return_supplies[0].supply_id;
      this.data_style.date = this.return_supplies[0].date;
      this.data_style.user = this.user;
      // --------------------------
    });
  },
  methods: {
    
    printDiv(printme) {

       printDiv(printme);
   },
  },
  computed: {},
};
</script>
<style scoped>

  td h2{
    line-height: 20px;
  }
</style>

