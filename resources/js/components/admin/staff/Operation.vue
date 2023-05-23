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

                        <!-- <li class="nav-item">
                          <a href="#tab1" class="nav-link" data-toggle="tab">الغياب</a>
                        </li>
                        <li class="nav-item">
                          <a href="#tab2" class="nav-link" data-toggle="tab">التاخير</a>
                        </li> -->


                        <li class="nav-item">
                          <a href="#tab3" class="nav-link" data-toggle="tab"> الاضافي</a>
                        </li>
                        <li class="nav-item">
                          <a href="#tab4" class="nav-link" data-toggle="tab"> الخصم</a>
                        </li>
                        <!-- <li class="nav-item">
                          <a href="#tab5" class="nav-link" data-toggle="tab">القرض</a>
                        </li> -->
                        <li class="nav-item">
                          <a href="#tab6" class="nav-link" data-toggle="tab">السلف</a>
                        </li>
                        <!-- <li class="nav-item">
                          <a href="#tab7" class="nav-link" data-toggle="tab">العهد</a>
                        </li> -->
                        <!-- <li class="nav-item">
                          <a href="#tab5" class="nav-link" data-toggle="tab">انهاء خدمه موظف</a>
                        </li>
                        <li class="nav-item">
                          <a href="#tab5" class="nav-link" data-toggle="tab"> ملاحظات الموظف</a>
                        </li>
                        <li class="nav-item">
                          <a href="#tab6" class="nav-link" data-toggle="tab">تحويل راتب</a>
                        </li> -->
                        <li class="nav-item">
                          <a href="#tab8" class="nav-link" data-toggle="tab">التحضير</a>
                        </li>
                        <li class="nav-item">
                          <a href="#tab9" class="nav-link" data-toggle="tab">اجازه</a>
                        </li>
                        <li class="nav-item">
                          <a href="#tab10" class="nav-link" data-toggle="tab"> البدلات </a>
                        </li>
                        <li class="nav-item">
                          <a href="#tab11" class="nav-link" data-toggle="tab"> اضافه موظف </a>
                        </li>

                        <li class="nav-item">
                          <a href="#tab12" class="nav-link" data-toggle="tab"> جزاءات الغياب</a>
                        </li>
                        <li class="nav-item">
                          <a href="#tab13" class="nav-link" data-toggle="tab"> جزاءات التأخير</a>
                        </li>


                        <li class="nav-item">
                          <a href="#tab14" class="nav-link" data-toggle="tab"> جزاءات الاضافي</a>
                        </li>

                        <li class="nav-item">
                          <a href="#tab15" class="nav-link" data-toggle="tab"> جزاءات الانصراف المبكر</a>
                        </li>

                        <li class="nav-item">
                          <a href="#tab16" class="nav-link" data-toggle="tab"> طلب اجازه </a>
                        </li>

                    


                        <!-- <li class="nav-item">
                          <a href="#tab12" class="nav-link" data-toggle="tab"> الرواتب والبدلات </a>
                        </li> -->

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

                      <!-- <div class="tab-pane active" id="tab1">
                        <absence></absence>
                      </div>
                      <div class="tab-pane" id="tab2">
                        <delay></delay>

                      </div> -->

                      <div class="tab-pane" id="tab3">
                        <extra></extra>
                      </div>
                      <div class="tab-pane" id="tab4">
                        <discount></discount>
                      </div>
                      <!-- <div class="tab-pane" id="tab5">
                        <loan></loan>
                      </div> -->
                      <div class="tab-pane" id="tab6">
                        <advance></advance>
                      </div>
                      <!-- <div class="tab-pane" id="tab6">
                        <transfer-branch></transfer-branch>
                      </div> -->
                      <div class="tab-pane active" id="tab8">
                        <attendance></attendance>
                      </div>
                      <div class="tab-pane" id="tab9">
                        <leave></leave>
                      </div>
                      <div class="tab-pane" id="tab10">
                        <allowance></allowance>

                      </div>
                      <div class="tab-pane" id="tab11">
                        <personal-information></personal-information>
                      </div>

                      <div class="tab-pane" id="tab12">
                        <absence-sanction></absence-sanction>
                      </div>

                      <div class="tab-pane" id="tab13">
                        <delay-sanction></delay-sanction>
                      </div> 




                      <div class="tab-pane" id="tab14">
                        <extra-sanction></extra-sanction>
                      </div>

                      <div class="tab-pane" id="tab15">
                        <leave-sanction></leave-sanction>
                      </div>

                     <!-- <div class="tab-pane" id="tab16">
                        <leave-sanction></leave-sanction>
                      </div>  -->
                      <!-- 
                      <div class="tab-pane active" id="tab12">
                        <salary-allowance></salary-allowance>
                      </div> -->

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
import Attendance from "./Operation/Attendance";
import Allowance from "./Operation/Allowance";

import Leave from "./Operation/Leave";
// import Absence from "./Operation/Absence";

import Advance from "./Operation/Advance";

// import Delay from "./Operation/Delay";

import Extra from "./Operation/Extra";

import Discount from "./Operation/Discount";

import Loan from "./Operation/Loan";
import TransferBranch from "./Operation/TransferBranch";
import PersonalInformation from "./Operation/PersonalInformation";
import SalaryAllowance from "./Operation/SalaryAllowance";

import DelaySanction from "./Operation/DelaySanction";
import AbsenceSanction from "./Operation/AbsenceSanction";
import ExtraSanction from "./Operation/ExtraSanction";
import LeaveSanction from "./Operation/LeaveSanction";



export default {
  components: {
    Attendance,
    Leave,
    // Absence,
    Advance,
    // Delay,
    Extra,
    Discount,
    Loan,
    TransferBranch,
    Allowance,
    PersonalInformation,
    SalaryAllowance,
    DelaySanction,
    AbsenceSanction,
    ExtraSanction,
    LeaveSanction


  },




};

</script>