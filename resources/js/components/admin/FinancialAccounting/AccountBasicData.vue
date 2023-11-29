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
                          <a href="#tab1" class="nav-link" data-toggle="tab">البنوك</a>
                        </li>
                        <li class="nav-item">
                          <a href="#tab2" class="nav-link" data-toggle="tab">العملات</a>
                        </li>
                        <li class="nav-item">
                          <a href="#tab3" class="nav-link" data-toggle="tab"> الصناديق</a>
                        </li>

                        <li class="nav-item">
                          <!-- <a href="#tab4" class="nav-link" data-toggle="tab"> انواع المصروفات</a>
                        </li>

                        <li class="nav-item">
                          <a href="#tab5" class="nav-link" data-toggle="tab"> انواع الايرادات</a> -->
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
                        <bank></bank>
                      </div>
                      <div class="tab-pane" id="tab2">
                        <currency></currency>
                      </div>
                      <div class="tab-pane" id="tab3">
                        <treasury></treasury>
                      </div>

                      <!-- <div class="tab-pane" id="tab4">
                        <type-expence></type-expence>
                      </div>

                      <div class="tab-pane" id="tab5">
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
import Bank from "./BasicData/Bank";
import Currency from "./BasicData/Currency";
import Treasury from "./BasicData/Treasury";
// import TypeExpence from "./BasicData/TypeExpence";
// import TypeIncome from "./BasicData/TypeIncome";




export default {
  components: {
    Bank,
    Currency,
    Treasury,
    // TypeExpence,
    // TypeIncome

  },

};

</script>