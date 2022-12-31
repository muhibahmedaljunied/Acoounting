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
                <table style="width: 100%">
                  <thead>

                               <right-side :data_style='data_style'></right-side>
                          
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
           
                      <td></td>
                    </tr>
                  </thead>
                </table>
              </div>
              <div class="card-body">
                <table
                  class="table table-bordered text-right"
                  style="width: 100%; font-size: large;text-align:center"
                >
                  <thead style="background: red">
                    <tr>
                        <th>#</th>
                      <th>اسم المنتج</th>
                      <!-- <th class="wd-15p border-bottom-0">كميه الصرف</th> -->
                      <th class="wd-15p border-bottom-0">الكميه المرتحعه</th>
                      <th>الحاله</th>
                                    <th>المواصفات والطراز</th>
                    </tr>
                  </thead>
                  <tbody v-if="cash_detail && cash_detail.length>0">
                    <tr v-for="(cash_details,index) in cash_detail" :key="index">
                      <td>{{index+1}}</td>
                      <td>{{ cash_details.product }}</td>
                      <!-- <td>{{ cash_details.quantity }}</td> -->
                      <td>{{ cash_details.qty_return }}</td>
                      <td>{{ cash_details.status }}</td>
                               <td>{{ cash_details.desc }}</td>
                    </tr>
                  </tbody>
                </table>
          

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
      cashes: 0,
      cash_detail: 0,
      timestamp: "",
      user: "",


            data_style: {
        'right': 'اسم العميل',
        'left': 0,
        'number': 0,
        'date': 0,
        'title': 'سند استلام مرتجع صرف',
           'check':1,
           'user':0,

      },
    };
  },
  created() {
  
    setInterval(getNow, 1000);
  },
  mounted() {
    let uri = `/invoice_return_cash/${this.$route.params.id}`;
    this.axios.post(uri).then((response) => {
      console.log(response.data.cash_return_details);
      this.user = response.data.users.name;

      this.cash_detail = response.data.cash_return_details;
      this.cashes = response.data.cash_returns;


        // -----------------for style----------
      this.data_style.left = this.cashes[0].name;
      this.data_style.number = this.cashes[0].cash_id;
      this.data_style.date = this.cashes[0].date;
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

