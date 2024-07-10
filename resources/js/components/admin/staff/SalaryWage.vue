<template>
  <div>
    <div class="row row-sm">
      <div class="col-lg-12 col-md-12">
        <div class="card" id="basic-alert">
          <div class="card-header"> الرواتب والاجور</div>
          <div class="card-body">
      
            <div class="text-wrap">
              <div class="example">
                <div class="panel panel-primary tabs-style-1">
                  <div class="tab-menu-heading">
                    <div class="tabs-menu1">
                      <!-- Tabs -->
                      <ul class="nav panel-tabs main-nav-line">

                   

                          


                        <li class="nav-item">
                          <a href="#tab1" class="nav-link" data-toggle="tab"> خصم</a>
                        </li>
                     
                        <li class="nav-item">
                          <a href="#tab2" class="nav-link" data-toggle="tab">سلف</a>
                        </li>
                  
                        <li class="nav-item">
                          <a href="#tab3" class="nav-link" data-toggle="tab"> بدلات </a>
                        </li>

                        <!-- <li class="nav-item">
                          <a href="#tab3" class="nav-link" data-toggle="tab"> مكافئات </a>
                        </li> -->
                    
                        <li class="nav-item">
                          <a href="#tab4" class="nav-link" data-toggle="tab">  الراتب </a>
                        </li>

                         
                  

                 


                      </ul>
                    </div>
                  </div>
                  <div class="
                          panel-body
                          tabs-menu-body
                          main-content-body-right
                          border-top-0 border
                        ">
                    <div class="tab-content">


                      <div class="tab-pane" id="tab1">
                        <discount></discount>
                      </div>
                    
                      <div class="tab-pane" id="tab2">
                        <advance></advance>
                      </div>
                      <div class="tab-pane" id="tab3">
                        <allowance></allowance>

                      </div>
                    
                      <div class="tab-pane" id="tab4">
                        <salary></salary>

                      </div>
             

               

                    </div>
                  </div>
                </div>

                <!-- End Prism Precode -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>

import Allowance from "./SalaryWage/Allowance";
import Advance from "./SalaryWage/Advance";
import Discount from "./SalaryWage/Discount";
import Salary from "./SalaryWage/Salary";

export default {
  components: {
    Advance,
    Discount,
    Allowance,
    Salary
  },




};

</script>