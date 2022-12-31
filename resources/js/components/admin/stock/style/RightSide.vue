<template>
<tr>
        <td rowspan="4" style="text-align: center;line-height: 0px;">
                        <h4>الجمهوريه اليمنيه </h4>
                        <h4> وزاره الدفاع </h4>
                        <h4>رئاسه هيئه الاركات</h4>
                        <h4>قياده القوات الجويه والدفاع </h4>
                        <h4>الدراسات والابحاث </h4>
                        <h4>المخازن </h4>

                      </td>
                <td rowspan="4" style="text-align: center;line-height: 0px;"> <img
                          :src="`/assets/img/images3.jpg`" height="100px" alt="products image" />
                       <h3>{{data_style.title}}</h3> 
                     
                      </td>
                     <td rowspan="4" style="text-align: center;line-height: 0px">
                        <h4>رقم السند :{{data_style.number}}</h4>


                        <h4>تاريخ السند :{{data_style.date}} </h4>

                        <h4>  {{data_style.right}} :{{data_style.left}}
                          </h4>

                      </td>  
                      </tr> 
                      
</template>
<script>
    export default {
        props: ['data_style'],
        // props: ['title'],
        created: function () {
          
        },
    }
</script>