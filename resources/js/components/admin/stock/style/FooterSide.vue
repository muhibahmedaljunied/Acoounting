<template>
    
             <div style="line-height: 0px">
                  <div v-if="data_style.check"  id="intro" style="text-align: right">
                    <h4>تم استلام المواد المذكوره اعلاه كامله</h4>
                  </div>
                  <div v-if="data_style.check" id="intro" style="text-align: right">
                    <h4 v-if="data_style.right == 'اسم المورد'">
                      <span>امين المخازن</span> : {{ data_style.user }}

                    </h4>
                    <h4 v-if="data_style.right == 'اسم العميل'">
                      <span> اسم العميل</span> : {{ data_style.left }}

                    </h4>
                    <h4><span>التوقيع</span> :</h4>
                  </div>
                  <div id="intro" style="text-align: left">
                    <h5>{{ timestamp }}</h5>
                    <h3>امين المخازن:{{ data_style.user }}</h3>
                  </div>
                </div>         
</template>
<script>
    export default {
       props: ['data_style'],
        // props: ['title'],
        created: function () {
          
        },
    }
</script>