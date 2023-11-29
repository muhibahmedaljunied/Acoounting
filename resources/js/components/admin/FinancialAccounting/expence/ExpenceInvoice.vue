<template>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card" id="printme" style="outline: auto; outline-color: red; border-radius: 10">
              <div class="card-header">
                <div class="table-responsive">
                  <table style="width: 100%">
                    <thead>

              

                      <tr></tr>

                      <tr></tr>
                      <tr>
                        <td colspan="1"></td>

                        <td style="text-align: left">
                          <button @click="prints('printme')">
                            <i class="fas fa-print" style="font-size: 24px; color: rgb(34, 192, 60)"></i>
                          </button>
                        </td>
                      </tr>
             
                    </thead>
                  </table>
                </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered text-right"
                    style="width: 100%; font-size: large ;text-align:center">
                    <thead style="background: red">
                      <tr>
                        <td>#</td>
                        <th>اسم المنتج</th>
                        <th>الحاله</th>
                        <th>المواصفات والطراز</th>
                        <th class="wd-15p border-bottom-0">الكميه الوارده</th>
                        <!-- <th class="wd-15p border-bottom-0">الكميه المرتحعه</th> -->
                        <th>المخزن</th>
                        <!-- <th>الرف</th> -->
                      </tr>
                    </thead>
                    <tbody v-if="supply_detail && supply_detail.length">
                      <tr v-for="(supply_details, index) in supply_detail" :key="index">
                        <td>{{ index + 1 }}</td>
                        <td>{{ supply_details.product }}</td>
                        <td>{{ supply_details.status }}</td>
                        <td>{{ supply_details.desc }}</td>
                        <td>{{ supply_details.qty }}</td>
                        <!-- <td>{{ supply_details.qty_return }}</td> -->
                        <td>{{ supply_details.store }}</td>
                        <!-- <td>{{ supply_details.shelve_name }}</td> -->
                      </tr>
                    </tbody>
                    <tbody v-else>
                      <tr>
                        <td align="center" colspan="4">
                          <h3> لايوجد بيانات </h3>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                 <footer-side :data_style='data_style'></footer-side>
           
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
