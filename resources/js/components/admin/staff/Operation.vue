<template>
  <div>
    <div class="row row-sm">
      <div class="col-lg-12 col-md-12">
        <div class="card" id="basic-alert">
          <div class="card-header">شؤون الموظفين</div>
          <div class="card-body">
      
            <div class="text-wrap">
              <div class="example">
                <div class="panel panel-primary tabs-style-1">
                  <div class="tab-menu-heading">
                    <div class="tabs-menu1">
                      <!-- Tabs -->
                      <ul class="nav panel-tabs main-nav-line">

                   

                        <li class="nav-item">
                          <a href="#tab11" class="nav-link" data-toggle="tab"> اضافه موظف </a>
                        </li>
                          

                        <li class="nav-item">
                          <a href="#tab12" class="nav-link" data-toggle="tab"> دوام الموظف </a>
                        </li>

                        <li class="nav-item">
                          <a href="#tab3" class="nav-link" data-toggle="tab"> اضافي</a>
                        </li>
                        <li class="nav-item">
                          <a href="#tab4" class="nav-link" data-toggle="tab"> خصم</a>
                        </li>
                     
                        <li class="nav-item">
                          <a href="#tab6" class="nav-link" data-toggle="tab">سلف</a>
                        </li>
                  
                        <li class="nav-item">
                          <a href="#tab10" class="nav-link" data-toggle="tab"> بدلات </a>
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


                      <div class="tab-pane" id="tab3">
                        <extra></extra>
                      </div>
                      <div class="tab-pane" id="tab4">
                        <discount></discount>
                      </div>
                    
                      <div class="tab-pane" id="tab6">
                        <advance></advance>
                      </div>
                      <div class="tab-pane" id="tab10">
                        <allowance></allowance>

                      </div>
                      <div class="tab-pane" id="tab11">
                        <personal-information></personal-information>
                      </div>

                      <div class="tab-pane" id="tab12">
                        <staff-work></staff-work>
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

import Allowance from "./Operation/Allowance";
import Advance from "./Operation/Advance";
import Extra from "./Operation/Extra";
import Discount from "./Operation/Discount";
import Loan from "./Operation/Loan";
import TransferBranch from "./Operation/TransferBranch";
import PersonalInformation from "./Operation/PersonalInformation";
import SalaryAllowance from "./Operation/SalaryAllowance";

import StaffWork from "./Operation/StaffWork";



export default {
  components: {
    Advance,
    Extra,
    Discount,
    Loan,
    TransferBranch,
    Allowance,
    PersonalInformation,
    SalaryAllowance,
    StaffWork


  },




};

</script>