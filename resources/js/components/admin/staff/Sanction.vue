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
                            <a href="#tab16" class="nav-link" data-toggle="tab"> جزاءات  الموظف</a>
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
  
                        <div class="tab-pane" id="tab16">
                          <staff-sanction></staff-sanction>
                        </div>
  
                      </div>
                    </div>
                  </div>
  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  <script>
 
  
  
  
  import DelaySanction from "./Sanction/DelaySanction";
  import AbsenceSanction from "./Sanction/AbsenceSanction";
  import ExtraSanction from "./Sanction/ExtraSanction";
  import LeaveSanction from "./Sanction/LeaveSanction";
  import StaffSanction from "./Sanction/StaffSanction";
  
  
  
  export default {
    components: {
     
    
      DelaySanction,
      AbsenceSanction,
      ExtraSanction,
      LeaveSanction,
      StaffSanction
  
  
    },
  
  
  
  
  };
  
  </script>