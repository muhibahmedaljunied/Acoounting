<template>
  <div>
    <div class="row row-sm">
          
      <div class="col-lg-12 col-md-12">
        <div class="card" id="basic-alert">
          <div class="card-body">
            <!-- <div>
					<h6 class="card-title mb-1">Basic Style Tabs</h6>
					<p class="text-muted card-sub-title">It is Very Easy to Customize and it uses in your website apllication.</p>
				</div> -->
            <div class="text-wrap">
              <div class="example">
          
                <div class="panel panel-primary tabs-style-1">
                  <div class="tab-menu-heading">
                    <div class="tabs-menu1">
                      <!-- Tabs -->
                      <ul class="nav panel-tabs main-nav-line">
                        <li class="nav-item">
                      <a href="#tab2" class="nav-link" data-toggle="tab"
                            > الموظفين</a

                          >
                        </li>
                         <li class="nav-item">
                       <a href="#tab1" class="nav-link" data-toggle="tab"
                            > السلف</a
                          >
                        
                        </li>
                    
                     
                        <li class="nav-item">
                        <a href="#tab3" class="nav-link" data-toggle="tab"
                            >الاجازات</a
                          >
                        </li>
                     

                         <li class="nav-item">
                        <a href="#tab4" class="nav-link" data-toggle="tab"
                            > الرواتب</a
                          >
                        </li>

                        <li class="nav-item">
                        <a href="#tab5" class="nav-link" data-toggle="tab"
                            >الحضور والغياب</a
                          >
                        </li>

                        <li class="nav-item">
                          <a href="#tab6" class="nav-link" data-toggle="tab"> الاضافي</a>
                        </li>
                        <li class="nav-item">
                          <a href="#tab7" class="nav-link" data-toggle="tab"> الخصم</a>
                        </li>
                        <li class="nav-item">
                          <a href="#tab8" class="nav-link" data-toggle="tab">الجزاء والعقوبات</a>
                        </li>

                      
                      
                      </ul>
                    </div>
                  </div>
                  <div
                    class="
                      panel-body
                      tabs-menu-body
                      main-content-body-right
                      border-top-0 border
                    "
                  >
                    <div class="tab-content">
                      <div class="tab-pane active" id="tab1"> <advance></advance></div>
                    
                      <div class="tab-pane" id="tab2">
                             <personal-information></personal-information>
                      </div>
                        <div class="tab-pane" id="tab3">
                             <holiday></holiday>
             
                      </div>

                         <div class="tab-pane" id="tab4">
                             <salary-details></salary-details>
             
                      </div>

                      <div class="tab-pane" id="tab5">
                             <attendance></attendance>
             
                      </div>

                      <div class="tab-pane" id="tab6">
                        <extra></extra>
                      </div>
                      <div class="tab-pane" id="tab7">
                        <discount></discount>
                      </div>
                      <!-- <div class="tab-pane" id="tab8">
                        <loan></loan>
                      </div> -->
                
                    
                  </div>
                </div>
              </div>
           
        
              <!-- Prism Code -->
              <!-- <figure class="highlight clip-widget" id="tabs">
                <pre><code class="language-markup"></code></pre>
                <div class="clipboard-icon" data-clipboard-target="#tabs">
                  <i class="las la-clipboard"></i>
                </div>
              </figure> -->
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
import Advance from "./StaffData/Advance";

import Holiday from "./StaffData/Holiday";

import PersonalInformation from "./StaffData/PersonalInformation";

import SalaryDetails from "./StaffData/SalaryDetails";
import Attendance from "./StaffData/Attendance";

import Extra from "./StaffData/Extra";

import Discount from "./StaffData/Discount";

import Loan from "./StaffData/Loan";




export default {
  components: {
    Advance,
    Holiday,
    PersonalInformation,
    SalaryDetails,
    Attendance,
    Extra,
    Discount,
    Loan
  
  

  },




};
 
</script>