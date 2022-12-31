<template>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card" id="printme" style="outline: auto;outline-color:red;border-radius:10;">
              <div class="card-header">
            
                <table style="width: 100% ; outline:double;">
                         <thead>
                    <tr>
                      <td
                        rowspan="4"
                        style="text-align: center; line-height: 1px"
                      >
                        <h2>الجمهوريه اليمنيه</h2>
                        <br />
                        <h2>وزاره الدفاع</h2>
                        <br />
                        <h2>رياسه هيه الاركات</h2>
                        <br />
                        <h2>قياده القوات الجويه والدفاع</h2>
                        <br />
                        <h2>الدراسات والابحاث</h2>
                        <br />
                        <h2>المخازن</h2>
                        <br />
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
                        style="text-align: center; line-height: 1px"
                      >
                        <h2>رقم السند :{{ return_purchases[0].purchase_id }}</h2>
                        <br />

                        <h2>تاريخ السند :{{ return_purchases[0].purchase_date }}</h2>
                        <br />

                        <h2>
                          اسم المورد :  {{ return_purchases[0].name }}
                          {{ return_purchases[0].last_name }}
                         
                        </h2>
                        <br />
                      </td>
                    </tr>
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

                      <td
                        style="
                          text-align: center;
                          border-radius: 10px;
                          background-color: red;
                        "
                      >
                        <h1>  فاتوره مرتجع مشتريات</h1>
                      </td>
                      <td></td>
                    </tr>
                  </thead>
      
                </table>
              </div>
              <div class="card-body">
                <table
                  class="table table-bordered text-right"
                  style="width: 100%"
                >
                  <thead style="background:red">
                    <tr>
                      <th>اسم المنتج</th>
                             <th>الحاله</th>
                      <th class="wd-15p border-bottom-0">الكميه </th>
                      <th class="wd-15p border-bottom-0">الكميه المرتحعه</th>
                            <th>المخزن</th>
               
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="return_details in return_detail">
                      <td>{{ return_details.product }}</td>
                           <td>{{ return_details.status }}</td>
                      <td>{{ return_details.quantity }}</td>
                      <td>{{ return_details.qty_return }}</td>
                        <td>{{ return_details.store }}</td>
                 
                    </tr>
                  </tbody>
                </table>
                <div id = "intro" style = "text-align:left;">
          <h5>{{ timestamp }}</h5>
      </div>
      <div id = "intro" style = "text-align:right;">
          <h5>امين المخازن:{{ user }}</h5>
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
      return_purchases: 0,
      return_detail: 0,
      timestamp: "",
      user: "",
    };
  },
  created() {
    setInterval(this.getNow, 1000);
  },
  mounted() {
    let uri = `/invoice_return_purchase/${this.$route.params.id}`;
    this.axios.post(uri).then((response) => {
      this.user = response.data.users.name;
      this.return_purchases = response.data.return_purchases;
      this.return_detail = response.data.return_details;
    });
  },
  methods: {
  
   
  },
  computed: {},
};
</script>

