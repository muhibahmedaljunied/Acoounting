<template>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="modal-body" v-if="payable_note_one">
          <table class="table table-bordered text-right" style="width: 100%; font-size: x-large">
            <thead>
              <tr>
                <th>رقم الفاتوره</th>
                <th> طريقه الدفع</th>
                <th>الصندوق</th>
                <th>البنك</th>
                <th>رقم الشيك</th>

                <th>تاريخ السند</th>
                <th>الحساب</th>
                <th>المبلغ المطلوب</th>
                <th>المدفوع</th>
                <th>المتبقي</th>

                <th>اضافه</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="payable_note_ones in payable_note_one">
                <td>
                  <!-- <select
                    class="form-control selectpicker"
                    id="select-country"
                    data-live-search="true"
                  >
                    <option data-tokens="china">China</option>
                    <option data-tokens="malayasia">Malayasia</option>
                    <option data-tokens="singapore">Singapore</option>
                  </select> -->
                  <input type="text" class="form-control input_cantidad" onkeypress="return valida(event)"
                    :value="payable_note_ones.id" readonly />
                </td>
                <td>
                  <select name="" id="">
                    <option value="">نقدا</option>
                    <option value="">شيك</option>
                  </select>
                </td>
                <td>
                  <select name="" id="">
                    <option value=""></option>
                  </select>
                </td>
                <td>
                  <select name="" id="">
                    <option value=""></option>
                  </select>
                </td>
                <td>
                  <select name="" id="">
                    <option value=""></option>
                  </select>
                </td>

                <td>
                  <input type="date" class="form-control input_cantidad" v-model="date"
                    onkeypress="return valida(event)" />
                </td>
                <td>
                  <select name="" id="">
                    <option value=""></option>
                  </select>
                </td>
                <td>
                  <input type="number" id="price" class="form-control input_cantidad"
                    :value="payable_note_ones.remaining" onkeypress="return valida(event)" readonly />
                </td>
                <td>
                  <input type="number" id="price" class="form-control input_cantidad" v-model="paid"
                    onkeypress="return valida(event)" @input="get_total_remaining(payable_note_ones.remaining)" />
                </td>
                <td>
                  <input type="number" id="price" class="form-control input_cantidad" onkeypress="return valida(event)"
                    v-model="total_remaining" />
                </td>
                <td>
                  <input type="checkbox" class="btn btn-info waves-effect" />
                </td>
                <a href="javascript:void" @click="payment(payable_note_ones.remaining,payable_note_ones.id)" class="btn btn-success"><span>تاكيد العمليه</span></a>

              </tr>
              <!-- 
                  <a @click="$router.go(0)" class="btn btn-success"
                    ><span> تراجع</span></a
                  > -->
            </tbody>
          </table>
        </div>
        <div class="modal-body" v-if="payable_notes">
          <table class="table table-bordered text-right" style="width: 100%; font-size: x-large">
            <thead>
              <tr>
                <th>رقم السند</th>
                <th>رقم الفاتوره</th>
                <th>اسم المورد</th>
                <th> طريقه الدفع</th>
                <th>الصندوق</th>
                <th>البنك</th>
                <th>رقم الشيك</th>
                <th>تاريخ السند</th>
                <th>الحساب</th>
                <!-- <th>المبلغ المطلوب</th> -->
                <th>المدفوع</th>
                <!-- <th>المتبقي</th> -->

                <th>العمليات</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="payable_note in payable_notes">
                <td>
             
                  {{payable_note.id}}
                </td>
                <td>
                 
                 {{payable_note.purchase_id}}
                </td>
                <td>
                 
                 {{payable_note.supplier_name}}
               </td>
                <td>
                  <select name="" id="">
                    <option value="">نقدا</option>
                    <option value="">شيك</option>
                  </select>
                </td>
                <td>
                  <select name="" id="">
                    <option value=""></option>
                  </select>
                </td>
                <td>
                  <select name="" id="">
                    <option value=""></option>
                  </select>
                </td>
                <td>
                  <select name="" id="">
                    <option value=""></option>
                  </select>
                </td>

                <td>
{{payable_note.date  }}                
</td>
                <td>
                  <select name="" id="">
                    <option value=""></option>
                  </select>
                </td>
                <!-- <td>
                  <input type="number" id="price" class="form-control input_cantidad"
                    :value="payable_note.remaining" onkeypress="return valida(event)" readonly />
                </td> -->
                <td>
                  {{payable_note.paid}}
                </td>
                <!-- <td>
                  <input type="number" id="price" class="form-control input_cantidad" onkeypress="return valida(event)"
                    v-model="total_remaining" />
                </td> -->
                <td>
                  <!-- <input type="checkbox" class="btn btn-info waves-effect" /> -->
                  <a href="javascript:void" class="btn btn-success"><span> </span></a>

                </td>

              </tr>
              <!-- 
                  <a @click="$router.go(0)" class="btn btn-success"
                    ><span> تراجع</span></a
                  > -->
            </tbody>
          </table>
        </div>
      </div>
    </section>
  </div>
</template>
<script>
// $(function() {
//   $('.selectpicker').selectpicker();
// });

export default {
  data() {
    return {
      payable_note_one: '',
      payable_notes:'',
      total_remaining: 0,
      paid: 0,
      date: new Date().toISOString().substr(0, 10),
    };
  },
  mounted() {
    // console.log(this.$route.params.id);
    if(this.$route.params.id){
      let uri = `/payment_bond/${this.$route.params.id}`;
      this.axios.post(uri).then((response) => {
      this.payable_note_one = response.data.payable_note;

    });
    }else{
      let uri = `/payment_bond`;
      this.axios.post(uri).then((response) => {
      this.payable_notes = response.data.payable_notes;

    });
    }
    
    
  },
  methods: {
    get_total_remaining(remaining) {

      this.total_remaining = remaining - this.paid;

    },
    payment(remaining,purchase) {
      
      let uri = `/payment_bond_store/${this.$route.params.id}`;

      this.axios.post(uri,{
                            total_remaining: this.total_remaining,
                            remaining:remaining,
                            paid:this.paid ,
                            purchase:purchase,
                            date:this.date,
                          }
                          ).then((response) => {
                            console.log(response);

      });

    },

  },

};
</script>

