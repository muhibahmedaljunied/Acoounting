<template>
      <div class="container-fluid">
    <div class="row row-sm">
      <div class="col-lg-12 col-md-12">
        <div class="card" id="basic-alert">
          <div class="card-header">ربط الحسابات</div>
          <div class="card-body">
      
            <div class="text-wrap">
              <div class="example">
                <div class="panel panel-primary tabs-style-1">
                  <div class="tab-menu-heading">
                    <div class="tabs-menu1">
                      <!-- Tabs -->
                      <ul class="nav panel-tabs main-nav-line">

                   

                        <li class="nav-item">
                          <a href="#tab1" class="nav-link" data-toggle="tab"> الموارد البشريه </a>
                        </li>
                          

                        <li class="nav-item">
                          <a href="#tab2" class="nav-link" data-toggle="tab">المبيعات </a>
                        </li>

                        <li class="nav-item">
                          <a href="#tab3" class="nav-link" data-toggle="tab"> المشتريات</a>
                        </li>

                        <li class="nav-item">
                          <a href="#tab4" class="nav-link" data-toggle="tab"> المخازن </a>
                        </li>
                        <!-- <li class="nav-item">
                          <a href="#tab5" class="nav-link" data-toggle="tab"> الماليه </a>
                        </li> -->

                        <li class="nav-item">
                          <a href="#tab6" class="nav-link" data-toggle="tab">  البنوك </a>
                        </li>
                        <li class="nav-item">
                          <a href="#tab7" class="nav-link" data-toggle="tab"> الصناديق  </a>
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
                        <setting-hr></setting-hr>
                      </div>
                
          
             
                      <div class="tab-pane" id="tab2">
                        <setting-sale></setting-sale>
                      </div>

                      <div class="tab-pane" id="tab3">
                        <setting-purchase></setting-purchase>
                      </div>

                      <div class="tab-pane" id="tab4">
                        <setting-warehouse></setting-warehouse>
                      </div>
                      <!-- <div class="tab-pane" id="tab5">
                        <setting-accounting></setting-accounting>
                      </div> -->

                      <div class="tab-pane" id="tab6">
                        <bank></bank>
                      </div>
                      <div class="tab-pane" id="tab7">
                        <treasury></treasury>
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
import SettingHr from "./SettingAccount/SettingHr";
import SettingSale from "./SettingAccount/SettingSale";
import SettingPurchase from "./SettingAccount/SettingPurchase";
import SettingWarehouse from "./SettingAccount/SettingWarehouse";
// import SettingAccounting from "./SettingAccount/SettingAccounting";
import Bank from "./SettingAccount/Bank";
import Treasury from "./SettingAccount/Treasury";





export default {
  components: {
    SettingHr,
    SettingSale,
    SettingPurchase,
    SettingWarehouse,
    // SettingAccounting,
    Bank,
    Treasury

  },

};

</script>
  