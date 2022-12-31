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
                          <a href="#tab1" class="nav-link" data-toggle="tab"
                            >الفروع</a
                          >
                        </li>
                        <li class="nav-item">
                          <a href="#tab2" class="nav-link" data-toggle="tab"
                            >الاقسام</a
                          >
                        </li>
                        <li class="nav-item">
                          <a href="#tab3" class="nav-link" data-toggle="tab"
                            >المسمي الوظيفي</a
                          >
                        </li>
                        <li class="nav-item">
                          <a href="#tab4" class="nav-link" data-toggle="tab"
                            >انواع الموظفين</a
                          >
                        </li>
                        <li class="nav-item">
                          <a href="#tab5" class="nav-link" data-toggle="tab"
                            >المؤهلات العلميه</a
                          >
                        </li>
                         <li class="nav-item">
                          <a href="#tab6" class="nav-link" data-toggle="tab"
                            >الديانه</a
                          >
                        </li>

                           <li class="nav-item">
                          <a href="#tab7" class="nav-link" data-toggle="tab"
                            >انواع الغياب</a
                          >
                        </li>
                        <li class="nav-item">
                          <a href="#tab8" class="nav-link" data-toggle="tab"
                            >البدلات</a
                          >
                        </li>
                        <li class="nav-item">
                          <a href="#tab9" class="nav-link" data-toggle="tab"
                            >انواع التاخير</a
                          >
                        </li>
                        <li class="nav-item">
                          <a href="#tab10" class="nav-link" data-toggle="tab"
                            >انواع الاضافي</a
                          >
                        </li>
                        <li class="nav-item">
                          <a href="#tab11" class="nav-link" data-toggle="tab"
                            > الجنسيه</a
                          >
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
                      <div class="tab-pane active" id="tab1"> <branch></branch></div>
                      <div class="tab-pane" id="tab2">
             <department></department>
                      </div>
                      <div class="tab-pane" id="tab3">
                              <job></job>
                      </div>
                      <div class="tab-pane" id="tab4">
                         <staff-type></staff-type>
                      </div>
                      <div class="tab-pane" id="tab5">
                        <qualifications></qualifications>
                      </div>
                       <div class="tab-pane" id="tab6">
                        <religion></religion>
                      </div>
                    

     <div class="tab-pane" id="tab7">
                        <absence-type></absence-type>
                      </div>
                       <div class="tab-pane" id="tab8">
                        <allowance></allowance>
                      </div>
                       <div class="tab-pane" id="tab9">
                        <delay-type></delay-type>
                      </div>
                      
                       <div class="tab-pane" id="tab10">
                        <extra-type></extra-type>
                      </div>
                       <div class="tab-pane" id="tab11">
                        <nationality></nationality>
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
import Branch from "./BasicData/Branch";

import Department from "./BasicData/Department";

import Job from "./BasicData/Job";

import StaffType from "./BasicData/StaffType";
import Qualifications from "./BasicData/Qualifications";
import Religion from "./BasicData/Religion";
import AbsenceType from "./BasicData/AbsenceType";
import Allowance from "./BasicData/Allowance";
import DelayType from "./BasicData/DelayType";

import ExtraType from "./BasicData/ExtraType";
import Nationality from "./BasicData/Nationality";


export default {
  components: {
    Branch,
    Department,
    Job,
    StaffType,
    Qualifications,
    Religion,
    AbsenceType,
    Allowance,
    DelayType,

    ExtraType,
    Nationality
   

  },





};
 
</script>