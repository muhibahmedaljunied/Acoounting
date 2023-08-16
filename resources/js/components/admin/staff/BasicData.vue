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
                          <a href="#tab1" class="nav-link" data-toggle="tab">الفروع</a>
                        </li>
                    
                        <li class="nav-item">
                          <a href="#tab4" class="nav-link" data-toggle="tab">انواع الموظفين</a>
                        </li>
                        <li class="nav-item">
                          <a href="#tab5" class="nav-link" data-toggle="tab">المؤهلات العلميه</a>
                        </li>
                        <li class="nav-item">
                          <a href="#tab6" class="nav-link" data-toggle="tab">الديانه</a>
                        </li>
                        <li class="nav-item">
                          <a href="#tab11" class="nav-link" data-toggle="tab"> الجنسيه</a>
                        </li>

                        <li class="nav-item">
                          <a href="#tab8" class="nav-link" data-toggle="tab"> البدلات</a>
                        </li>
                        <li class="nav-item">
                          <a href="#tab12" class="nav-link" data-toggle="tab">انواع الاجازات</a>
                        </li>
                        <li class="nav-item">
                          <a href="#tab18" class="nav-link" data-toggle="tab">العطل الرسميه</a>
                        </li>
                        <li class="nav-item">
                          <a href="#tab7" class="nav-link" data-toggle="tab">انواع الغياب</a>
                        </li>

                        <!-- <li class="nav-item">
                          <a href="#tab14" class="nav-link" data-toggle="tab"> جزاءات الغياب</a>
                        </li> -->
                       
                        <li class="nav-item">
                          <a href="#tab9" class="nav-link" data-toggle="tab">انواع التاخير</a>
                        </li>

                        <!-- <li class="nav-item">
                          <a href="#tab13" class="nav-link" data-toggle="tab"> جزاءات التأخير</a>
                        </li> -->

                        <li class="nav-item">
                          <a href="#tab10" class="nav-link" data-toggle="tab">انواع الاضافي</a>
                        </li>
                        <li class="nav-item">
                          <a href="#tab19" class="nav-link" data-toggle="tab"> اجزاء الاضافي</a>
                        </li>

                        <!-- <li class="nav-item">
                          <a href="#tab15" class="nav-link" data-toggle="tab"> جزاءات الاضافي</a>
                        </li> -->
                       
                        <!-- <li class="nav-item">
                          <a href="#tab16" class="nav-link" data-toggle="tab"> جزاءات الانصراف المبكر</a>
                        </li> -->

                    
                        <li class="nav-item">
                          <a href="#tab23" class="nav-link" data-toggle="tab"> انواع الدوام </a>
                        </li>
                        <li class="nav-item">
                          <a href="#tab17" class="nav-link" data-toggle="tab"> نظام وفترات الدوام </a>
                        </li>
                        <li class="nav-item">
                          <a href="#tab21" class="nav-link" data-toggle="tab"> فترات الدوام</a>
                        </li>
                        <!-- <li class="nav-item">
                          <a href="#tab22" class="nav-link" data-toggle="tab"> اوقات الاستراحه</a>
                        </li>

                         -->
                  


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
                      <div class="tab-pane active" id="tab1">
                        <branch></branch>
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
                      <!-- <div class="tab-pane" id="tab20">
                        <leave-sanction></leave-sanction>
                      </div> -->

                      <div class="tab-pane" id="tab10">
                        <extra-type></extra-type>
                      </div>
                      <div class="tab-pane" id="tab11">
                        <nationality></nationality>
                      </div>

                      <div class="tab-pane" id="tab12">
                        <vacation-type></vacation-type>
                      </div>

                      
<!-- 
                      <div class="tab-pane" id="tab13">
                        <delay-sanction></delay-sanction>
                      </div> -->


                      <!-- <div class="tab-pane" id="tab14">
                        <absence-sanction></absence-sanction>
                      </div> -->

                      <!-- <div class="tab-pane" id="tab15">
                        <extra-sanction></extra-sanction>
                      </div> -->

                      <!-- <div class="tab-pane" id="tab16">
                        <leave-sanction></leave-sanction>
                      </div> -->

                    
                      <div class="tab-pane" id="tab17">
                        <work-system></work-system>
                      </div>

                      <div class="tab-pane" id="tab18">
                        <official-holiday></official-holiday> 
                      </div>

                      <div class="tab-pane" id="tab19">
                        <extra-part></extra-part> 
                      </div>

                      <div class="tab-pane" id="tab21">
                        <period></period> 
                      </div>


                      <!-- <div class="tab-pane" id="tab22">
                        <break></break> 
                      </div> -->

                      <div class="tab-pane" id="tab23">
                        <work-type></work-type> 
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
import StaffType from "./BasicData/StaffType";
import AbsenceType from "./BasicData/AbsenceType";
import DelayType from "./BasicData/DelayType";
import VacationType from "./BasicData/VacationType";
import ExtraType from "./BasicData/ExtraType";
import Qualifications from "./BasicData/Qualifications";
import Religion from "./BasicData/Religion";
import Allowance from "./BasicData/Allowance";
import Nationality from "./BasicData/Nationality";
// import DelaySanction from "./BasicData/DelaySanction";
// import AbsenceSanction from "./BasicData/AbsenceSanction";
// import ExtraSanction from "./BasicData/ExtraSanction";
import OfficialHoliday from "./BasicData/OfficialHoliday";
import ExtraPart from "./BasicData/ExtraPart";
// import LeaveSanction from "./BasicData/LeaveSanction";
import WorkSystem from "./BasicData/WorkSystem";
import WorkType from "./BasicData/WorkType";
// import Break from "./BasicData/Break";
import Period from "./BasicData/Period";




export default {
  components: {
    Branch,
    StaffType,
    Qualifications,
    Religion,
    AbsenceType,
    Allowance,
    DelayType,
    VacationType,
    // DelaySanction,
    // AbsenceSanction,
    // ExtraSanction,
    ExtraType,
    Nationality,
    OfficialHoliday,
    ExtraPart,
    // LeaveSanction,
    WorkSystem,
    WorkType,
    // Break,
    Period


  },





};

</script>