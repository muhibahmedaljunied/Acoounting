<template>
    <div>
      <div class="row row-sm">
        <div class="col-lg-12 col-md-12">
          <div class="card" id="basic-alert">
            <div class="card-header">
              مكافئات وجزاءات الحضور والغياب
            </div>
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
                            <a href="#tab1" class="nav-link" data-toggle="tab">  جزاءات غياب الموظف  </a>
                          </li>
                          <li class="nav-item">
                            <a href="#tab2" class="nav-link" data-toggle="tab">   جزاءات تأخير الموظف </a>
                          </li>
  
  
                          <li class="nav-item">
                            <a href="#tab3" class="nav-link" data-toggle="tab">مكافئات اضافي الموظف  </a>
                          </li>
  
                          <li class="nav-item">
                            <a href="#tab4" class="nav-link" data-toggle="tab">   جزاءات انصراف الموظف</a>
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
                          <staff-absence-sanction></staff-absence-sanction>
                        </div>
  
                        <div class="tab-pane" id="tab2">
                          <staff-delay-sanction></staff-delay-sanction>
                        </div> 
  
  
  
  
                        <div class="tab-pane" id="tab3">
                          <staff-extra-sanction></staff-extra-sanction>
                        </div>
  
                        <div class="tab-pane" id="tab4">
                          <staff-leave-sanction></staff-leave-sanction>
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
 
  
  
  
  import StaffDelaySanction from "./StaffSanction/StaffDelaySanction";
  import StaffAbsenceSanction from "./StaffSanction/StaffAbsenceSanction";
  import StaffExtraSanction from "./StaffSanction/StaffExtraSanction";
  import StaffLeaveSanction from "./StaffSanction/StaffLeaveSanction";
  
  
  
  
  export default {
    components: {
     
    
      StaffDelaySanction,
      StaffAbsenceSanction,
      StaffExtraSanction,
      StaffLeaveSanction,
     
  
  
    },
  
  
  
  
  };
  
  </script>