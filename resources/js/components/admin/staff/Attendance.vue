<template>
  <div>
    <div class="row row-sm">
      <div class="col-lg-12 col-md-12">
        <div class="card" id="basic-alert">
          <div class="card-header"> الحضور والانصراف</div>
          <div class="card-body">

            <div class="text-wrap">
              <div class="example">
                <div class="panel panel-primary tabs-style-1">
                  <div class="tab-menu-heading">
                    <div class="tabs-menu1">
                      <!-- Tabs -->
                      <ul class="nav panel-tabs main-nav-line">


                        <li class="nav-item">
                          <a href="#tab1" class="nav-link" data-toggle="tab">تحضير</a>
                        </li>


                        <li class="nav-item">
                          <a href="#tab2" class="nav-link" data-toggle="tab"> تأخير</a>
                        </li>

                        <li class="nav-item">
                          <a href="#tab3" class="nav-link" data-toggle="tab"> غياب</a>
                        </li>


                        <li class="nav-item">
                          <a href="#tab4" class="nav-link" data-toggle="tab"> انصراق مبكر</a>
                        </li>

                        <li class="nav-item">
                          <a href="#tab5" class="nav-link" data-toggle="tab">اجازه</a>
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







                      <div class="tab-pane active" id="tab1">
                        <attendance></attendance>
                      </div>


                      <div class="tab-pane active" id="tab2">
                        <delay></delay>
                      </div>

                      <div class="tab-pane active" id="tab3">
                        <absence></absence>
                      </div>


                      <div class="tab-pane active" id="tab4">
                        <leaveout></leaveout>
                      </div>

                      <div class="tab-pane" id="tab5">
                        <leave></leave>
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
import Attendance from "./Attendance/Attendance";
import Leave from "./Attendance/Leave";
import Delay from "./Attendance/Delay";
import Absence from "./Attendance/Absence";
import Leaveout from "./Attendance/Leaveout";





export default {
  components: {
    Attendance,
    Leave,
    Delay,
    Absence,
    Leaveout


  },




};

</script>