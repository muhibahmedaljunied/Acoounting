export default {
    data() {

        // return data;
        return {

            showstore: false,
            showproduct: false,
            showstatus: false,
            showunit: false,
            showdesc: false,
            showdate: false,
            showoperation: false,

            // statusselected: 0,
            // unitselected: 0,
            // productselected: 0,
            // productselectedname: "",
            // storeselectedname: "",
            // storeselected: 0,
            // descselected: "",
            // operationselected: 0,
            // dateselected: 0,
            // typeselected: [],
            // checkselected: '',
            // moveselected: 0,
            // moveselected: [],
            // indexselectedproduct: '',
            // indexselectedstore: '',
            type_report: 0,
            from_date: "2021-11-24",
            to_date: new Date().toISOString().substr(0, 10),

        };
    },
    methods: {

        printDiv(printme) {
            var printContents = document.getElementById(printme).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;
            var a = window.open("", "", "height=1000, width=1000");
            a.document.write('<html dir="rtl"><body >');

            a.document.write(printContents);
            a.document.write(`
              <style>
              .table-bordered {
                  border: 1px solid black;
               }
               .table-responsive{
                display: block;
                width: 100%;
                overflow-x: auto;
               }
              .table-bordered th, .table-bordered td {
          
                  border: 1px solid black;
              }
              table {border-spacing: 0;}
              td {text-align:center;}
              </style>
              </body></html>
              `);




            a.document.close();
            a.print();

            document.body.innerHTML = originalContents;


        },
        report_style(printme, name) {

            var printContents = document.getElementById(printme).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;
            var a = window.open("", "", "height=1000, width=1000");
            a.document.write('<html dir="rtl">');
            a.document.write("<body >");

            a.document.write(`<div class="invoice-box">
                     <table  style="width: 100%;border: 2px solid black;">
                                <thead>
                                        <tr>
                                    <td
                                      rowspan="4"
                                      style="text-align: center; line-height: 0px"
                                    > <br />
                                      <h4>الجمهوريه اليمنيه</h4>
                                   
                                      <h4>وزاره الدفاع</h4>
                                  
                                    <h4>رئاسه هيئه الاركات</h4>
                           
                              <h4>قياده القوات الجويه والدفاع</h4>
                                    
                                      <h4>الدراسات والابحاث</h4>
                                  
                                      <h4>المخازن</h4>
                                 
                                    </td>
                                    <td
                                      rowspan="4"
                                      style="text-align: center; line-height: 0px"
                                    >
                                      <img
                                        src='/assets/img/images3.jpg'
                                        height="100px"
                                        alt="products image"
                                      />
                                      <h3>${name}</h3>
                                    </td>
                                    <td
                                      rowspan="4"
                                      style="text-align: center; line-height: 0px"
                                    >
                                     
                                          <h4>التاريخ:_______________</h4>
                                          <h4>فاكس____________________<h4>
                                          <h4> الهاتف_________________<h4>
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
                               
                                </thead>
                              </table>
                 
                    </div>`);

            a.document.write(printContents);
            a.document.write(`<style>.table-bordered {
                border: 1px solid black; }
                .table-bordered th, .table-bordered td {
                  border: 1px solid black; 
                    text-align: center;
                font-size:large;
                }</style>`);

            a.document.write(`<style> table {
                                     
                                      border-spacing: 0;
                                      color: #4a4a4d;
                                      font: 14px/1.4 "Helvetica Neue", Helvetica, Arial, sans-serif;
                                    }
                                    th,
                                    td {
                                      // padding: 10px 15px;
                                      // vertical-align: middle;
                                      text-align: right;
                                    }
                                 
                          
                                    </style>`);
            a.document.write("</body></html>");
            a.document.close();
            a.print();

            document.body.innerHTML = originalContents;

        },

    }
};





