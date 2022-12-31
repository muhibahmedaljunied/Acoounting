<template>
  <div class="content">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <div class="page-title-box">
            <h4 class="page-title">تقرير مرتجع الصرف</h4>
          </div>
        </div>
      </div>
      <!-- end row -->

      <div class="row">
        <div class="col-sm-12">
          <div class="card-box">
            <br /><br />
            <div class="invoice-box">
              <div class="form-group">
                <div class="row">
                  <div class="col-md-2">
                    <label for="status">اختر التقرير</label>
                    <select
                      v-model="typeselected"
                      name="status"
                      id="status"
                      class="form-control"
                      @change="onreportchange"
                    >
                      <option value="1">حسب العميل</option>
                      <option value="2">حسب المنتج</option>
                      <!-- <option value="3">حسب المخزن</option> -->
                    </select>
                  </div>

                  <div class="col-md-2" v-show="showcustomer">
                    <label for="status">العميل</label>
                    <select
                      v-model="customerselected"
                      name="status"
                      id="status"
                      class="form-control"
                    >
                      <option value="100">All</option>
                      <option
                        v-for="customers in customer"
                        v-bind:value="customers.id"
                      >
                        {{ customers.name }}
                      </option>
                    </select>
                  </div>

                  <div class="col-md-2" v-show="showproduct">
                    <label for="status">المنتج</label>
                    <select
                      v-model="productselected"
                      name="status"
                      id="status"
                      class="form-control"
                    >
                      <option value="100">All</option>
                      <option
                        v-for="products in product"
                        v-bind:value="products.id"
                      >
                        {{ products.name }}
                      </option>
                    </select>
                  </div>

                  <div class="col-md-2">
                    <label for="status">حاله المنتج</label>
                    <select v-model='statusselected'  name="status" id="status" class="form-control">
                      <option  v-bind:value="1">سليم</option>
                      <option   v-bind:value="0"> تالف</option>
                                            <option   v-bind:value="2"> جديد</option>
                      <option   v-bind:value="3"> مستخدم</option>

                    </select>
                  </div>
                  <!-- <div class="col-md-2" v-show="showstore">
                    <label for="status">المخزن</label>
                    <select
                      v-model="storeselected"
                      name="status"
                      id="status"
                      class="form-control"
                    >
                      <option value="100">All</option>
                      <option v-for="stores in store" v-bind:value="stores.id">
                        {{ stores.code }}
                      </option>
                    </select>
                  </div> -->
                

                  <div class="col-md-2">
                    <label for="desde">من <code>X</code> تاريخ</label>
                    <input
                      type="date"
                      class="form-control hasDatepicker"
                      id="modal_reporte_venta_inicio"
                      name="modal_reporte_venta_inicio"
                      v-model="from_date"
                      onkeypress="return controltag(event)"
                      style="background-color: white"
                    />
                  </div>
                  <div class="col-md-2">
                    <label for="hasta">الي <code>X</code> تاريخ</label>
                    <input
                      type="date"
                      class="form-control hasDatepicker"
                      id="modal_reporte_venta_final"
                      name="modal_reporte_venta_final"
                      v-model="to_date"
                      onkeypress="return controltag(event)"
                      style="background-color: white"
                    />
                  </div>
                  <div class="col-md-2">
                    <label for="hasta">بحث</label><br />

                    <a  href="javascript:void" @click="
                        Search(customerselected, productselected, storeselected)
                      " data-toggle="modal" id="agregar_productos" data-target="#modal_refund" class="tn btn-info btn-lg waves-effect btn-agregar"><span>بحث </span></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-12">
          <div class="card-box">
            <!-- <a
              href="http://127.0.0.1:8007/pdf_reporte_ventas/2021-11-01/2021-11-24/todas"
              class="btn btn-danger"
              ><i class="fa fa-print"></i> PDF
            </a> -->
            <!-- <a
              href="http://127.0.0.1:8007/csv_reporte_ventas/2021-11-01/2021-11-24/todas"
              class="btn btn-success pull-left"
              ><i class="fa fa-file-excel-o"></i> CSV
            </a> -->

            <br /><br />
            <div class="invoice-box">
              <table style="width: 100%" cellspacing="0" cellpadding="0">
                <tbody>

                    <!-- <tr class="total">
                    <td colspan="7">
                      <br />
                      <table style="width: 100%">
                        <tbody>
                          <tr style="font-size: 11pt">
                            <td style="text-align: right">
                              PRODUCTS
                              <i
                                class="fa fa-info-circle estilo_tool"
                                data-toggle="tooltip"
                                data-placement="right"
                                title=""
                                data-original-title="Total quantity of products registered in the invoices."
                              ></i>
                            </td>
                            <td>14</td>
                          </tr>

                          <tr style="font-size: 11pt">
                            <td style="text-align: right">
                              TOTAL
                              <i
                                class="fa fa-info-circle estilo_tool"
                                data-toggle="tooltip"
                                data-placement="right"
                                title=""
                                data-original-title="Total of all the invoices found, with the tax included, but without discounts."
                              ></i>
                            </td>
                            <td>4,480,000.00 USD</td>
                          </tr>
                        </tbody>
                      </table>
                    </td>
                  </tr> -->

                  <tr>
                    <td colspan="7" class="rango_titulo">
                      <u></u> من <u>{{from_date}}</u> الي <u>{{to_date}}</u>
                    </td>
                  </tr>

                  <tr class="heading" style="font-size: 10pt">
                    <td>#</td>

                    <td >المنتج</td>

                    <td>العميل</td>
                     <!-- <td>المخزن</td> -->
<td>الكميه</td>
                    <td>التاريخ</td>

                    <td>الحاله</td>
                  </tr>

                  <tr class = 'item' v-for="datas in report.data">

                    <td>{{datas.id}}</td>
                    <td>{{datas.product_name}}</td>

                    <td >{{datas.customer_name}}</td>
                     <!-- <td >{{datas.code}}</td> -->
<td >{{datas.quantity}}</td>
                    <td>{{datas.date}}</td>


                    <td>{{datas.status}}</td>
                  </tr>


                
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- end row -->
    </div>
    <!-- container -->
  </div>
</template>
<script>
export default {
  data() {
    return {
      customer: "yes",
      product: "",
      // store: "",
      showcustomer:false,
      showproduct:false,
      // showstore:false,
        statusselected: 1,

      customerselected: 1,
      productselected: 1,
      // storeselected: 1,
      typeselected:1,
      type_report:0,
      from_date:'2021-11-24',
      to_date:'2021-11-24',
      //   statusselected: "",

      report:{
           
           data:"",
      },

      default:100,
    };
  },
  mounted() {
    this.axios.post("/Repocashreturn").then((response) => {
      this.customer = response.data.customer;
      this.product = response.data.product;
      // this.store = response.data.store;
      //   this.status = response.data.status;
      //   console.log(response.data);
    });
  },
 created() {
    this.axios.post("/data_for_cash_return").then((response) => {
      this.customer = response.data.customer;
      // this.type_product = response.data.type_product;
      this.category = response.data.category;
    });
  },
   methods: {

    onreportchange(e){
      let input = e.target; 
      // alert(input.value);
      this.type_report = input.value;
      
      if(input.value == 1){

           this.showcustomer = true;
           this.customerselected=1,
// -------------------------------------
           this.productselected=0,
          //  this.storeselected=0,
// -------------------------------------

           this.showproduct = false;
          //  this.showstore = false;
      }

       if(input.value == 2){

           this.showproduct = true;
            this.productselected=1,

// -------------------------------------
            this.customerselected=0,
          //  this.storeselected=0,
// -------------------------------------
      

           this.showcustomer = false;
          //  this.showstore = false;
      }

       if(input.value == 3){

           this.showstore = true;
          //  this.storeselected=1,
// -------------------------------------
           this.customerselected=0,
           this.productselected=0,
// -------------------------------------
           this.showcustomer = false;
           this.showproduct = false;
      }
    },
    Search() {
      this.axios.post(`/repocashreturn_by_customer`,{customer_id:this.customerselected,product_id:this.productselected,from_date:this.from_date,to_date:this.to_date}).then((response) => {
       
 this.report.data = response.data.repocash;
       console.log(response.data);
      });
    },
    

   
  },
};
</script>


