<template>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <span class="h2">تفاصيل الوارد</span>
              </div>
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>اسم المنتج</th>
                      <th>الصوره</th>
                      <th>الحاله</th>
                      <th>المواصفات والطراز</th>
                      <th class="wd-15p border-bottom-0">الكميه الوارده</th>
                      <!-- <th class="wd-15p border-bottom-0">الكميه المرتحعه</th> -->
                      <th>المخزن</th>
                             <!-- <th>الرف</th> -->
                    </tr>
                  </thead>
                  <tbody v-if="supply_detail && supply_detail.length > 0">
                    <tr v-for="(supply_details, index) in supply_detail" :key="index"  >
                      <td>{{ index+1}}</td>
                      <td>{{ supply_details.product }}</td>
                      <td>
                        <img
                          :src="`assets/upload/`+ supply_details.image"
                          height="50px"
                          alt="products image"
                        />
                      </td>
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
                  <td align="center" colspan="4"><h3>  لايوجد بيانات </h3></td>
                </tr>
              </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--
            *******************************************************************
            *******************************************************************
                                 MODAL ALERTA VACIAR
            *******************************************************************
            *******************************************************************
            -->

      <!-- /.modal -->

      <!--
            *******************************************************************
            *******************************************************************
                                FIN MODAL ALERTA VACIAR
            *******************************************************************
            *******************************************************************
            -->
    </section>
  </div>
</template>
<script>
export default {
  data() {
    return {
      supply_detail: 0,
    };
  },
  mounted() {
    let uri = `/details_supply/${this.$route.params.id}`;
    this.axios.post(uri).then((response) => {
      this.supply_detail = response.data.supply_details;

  
    });
  },
  methods: {

  },
  computed: {

  },
};
</script>

