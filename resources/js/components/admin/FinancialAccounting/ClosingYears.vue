<template>
  <div>
    <div class="row row-sm">
      <div class="col-lg-12 col-md-12">
        <div class="card" id="basic-alert">
          <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
              <span class="h2">الاقفالات السنويه</span>
            </div>
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
                          <a href="#tab1" class="nav-link" data-toggle="tab">فتح سنه ماليه جديده</a>
                        </li>
                        <li class="nav-item">
                          <a href="#tab2" class="nav-link" data-toggle="tab">اقفال السنه </a>
                        </li>
                        <!-- <li class="nav-item">
                          <a href="#tab3" class="nav-link" data-toggle="tab"> اقفال الحسابات</a>
                        </li>
                        <li class="nav-item">
                          <a href="#tab4" class="nav-link" data-toggle="tab"> اقفال المخزون</a>
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
                      <div class="tab-pane active" id="tab1">
                        <open-new-period></open-new-period>
                      </div>
                      <div class="tab-pane" id="tab2">
                        <closing-losse-earn></closing-losse-earn>
                      </div>
                      <!-- <div class="tab-pane" id="tab3">
                        <closing-accounts></closing-accounts>
                      </div>

                     <div class="tab-pane" id="tab4">
                        <closing-stock></closing-stock>
                      </div> -->

                       <!-- <div class="tab-pane" id="tab5">
                        <type-income></type-income>
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
// import ClosingAccounts from "./ClosingYear/ClosingAccounts";
import ClosingLosseEarn from "./ClosingYear/ClosingLosseEarn";
// import ClosingStock from "./ClosingYear/ClosingStock";
import OpenNewPeriod from "./ClosingYear/OpenNewPeriod";




export default {
  components: {
    // ClosingAccounts,
    ClosingLosseEarn,
    // ClosingStock,
    OpenNewPeriod,

  },

};

</script>