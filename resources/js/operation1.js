export default {
  data() {

    // return data;
    return {



      // count_row : '',
      first_row: '',
      purchase_id: [],
      discount: [],
      store_product_id: [],
      cost: [],
      bank: [],
      product: [],
      qty: [],
      unit: [],
      desc: [],
      store: [],
      status: [],
      counts: {},
      total: [],
      customer: [],
      supplier: [],
      check_state: [],
      return_qty: [],
      price: [],
      tax: [],
      treasury: [],
      storem_account: [],
      productm: [],
      intostore: [],
      intostore_id: [],
      account_in_list: [],
      count: 1,
      date: new Date().toISOString().substr(0, 10),
      dateselected: new Date().toISOString().substr(0, 10),
      expiry_date: new Date().toISOString().substr(0, 10),
      table: '',
      type: '',
      type_refresh: '',
      note: "",
      detail: '',
      total_quantity: 0,
      treasuries: '',
      banks: '',
      products: '',
      stores: '',
      statuses: '',
      stores: '',
      statuses: '',
      units: '',
      opening: '',
      availabe_qty: [],
      word_search: '',

      suppliers: '',
      customers: '',
      seen: false,
      id: '',


      grand_total: 0,
      sub_total: 0,
      To_pay: 0,
      total_tax: 0,
      storem: [],
      paid: 0,
      remaining: 0,
      Way_to_pay_selected: 1,





    };
  },
  watch: {
    Way_to_pay_selected(newVal, oldVal) {
      $(`#treeview_json_account`).jstree(true).destroy();
      this.showtree('account', 'tree_account', this.Way_to_pay_selected);

      console.log('alkhm', newVal, oldVal);
    }
  },
  methods: {




    addComponent(index) {
      // alert(index);
      this.count += 1;
      this.counts[index] = this.count;
    },
    disComponent(index) {

      if (index != 1) {

        this.count -= 1;
        this.$delete(this.counts, index - 1);
        console.log('yuuyyusd', index, this.count);

      }

    },

    init() {

      this.grand_total = 0;
      this.sub_total = 0;
      this.total_tax = 0;
      this.total_quantity = 0;

    },


    take_discount() {

      if (this.discounts != 0) {

        this.sub_total = (parseInt(this.discounts) * this.sub_total) / 100;
      }


    },

    credit() {

      if (this.paid == '') {

        this.paid = 0;
      }
      this.remaining = parseInt(this.grand_total) - parseInt(this.paid);
    },

    // check_one(product, index) {







    //   if (this.check_qty(
    //     this.qty[index],
    //     this.unit[index],
    //     product.availabe_qty
    //   ) == 0) {
    //     return 0;
    //   }

    //   this.handle(product, index);

    // },

    check_all_return() {




      for (let index = 0; index < this.detail.length; index++) {

        if (this.check_state_all == true) {


          this.check_state[index] = true;

        } else {

          this.check_state[index] = false;
        }

        this.detail.forEach(element => {

          this.check_one(element, index);
        });





      }


    },


    // handle(product, index) {

    //   // console.log('handle', product, index);account_in_list
    //   this.set_values(product, index);
    //   this.calc_grand_total(index);
    //   this.calc_tax(index);
    //   this.calc_qty(index);

    //   if (this.check_state[index] == false) {


    //     this.$delete(this.counts, index);

    //   }

    //   this.calc_remaining();

    // },

    // calculate_total(index, price = null) {


    //   if (!price) {

    //     price = this.price[index];

    //   }

    //   if (this.unit[index] && this.qty[index] && price) {


    //     this.total[index] = price * this.qty[index] * this.unit[index][1];


    //   } else {

    //     // toastMessage('فشل', "قم بأدخال الوحده", 'error');

    //     this.total[index] = 0;
    //   }


    //   // alert(12);


    // },

    // calculate_total_by_price(index) {



    //   if (this.unit[index] && this.qty[index] && this.price[index]) {


    //     this.total[index] = this.price[index] * this.qty[index] * this.unit[index][1];

    //   } else {

    //     toastMessage('فشل', "قم بأدخال الوحده", 'error');

    //     this.total[index] = 0;
    //   }




    // },


    // calc_grand_total(index) {




    //   if (this.check_state[index] == true) {

    //     if (this.total[index]) {

    //       this.grand_total = parseInt(this.total[index]) + parseInt(this.grand_total);

    //     } else {

    //       this.grand_total = parseInt(0) + parseInt(this.grand_total);
    //     }

    //   }


    //   if (this.check_state[index] == false) {

    //     if (!this.total[index]) { this.total[index] = 0; }
    //     this.grand_total = parseInt(this.grand_total) - parseInt(this.total[index]);


    //   }


    //   this.To_pay = this.grand_total;


    // },



    // calc_tax(index) {



    //   if (this.check_state[index] == true) {

    //     if (this.tax[index]) {

    //       this.total_tax = parseInt(this.tax[index]) + parseInt(this.total_tax);

    //     } else {

    //       this.total_tax = parseInt(0) + parseInt(this.total_tax);
    //     }

    //     this.sub_total = parseInt(this.grand_total) - parseInt(this.total_tax)

    //   }

    //   if (this.check_state[index] == false) {



    //     if (!this.tax[index]) { this.tax[index] = 0; }

    //     this.total_tax = parseInt(this.total_tax) - parseInt(this.tax[index]);
    //     this.sub_total = parseInt(this.grand_total) - parseInt(this.tax[index]);



    //   }


    // },
    // calc_qty(index) {



    //   if (this.check_state[index] == true) {

    //     if (this.qty[index]) {

    //       this.total_quantity = parseInt(this.qty[index]) + parseInt(this.total_quantity);

    //     } else {

    //       this.total_quantity = parseInt(0) + parseInt(this.total_quantity);
    //     }


    //   }


    //   if (this.check_state[index] == false) {

    //     if (!this.qty[index]) { this.qty[index] = 0; }

    //     this.total_quantity = parseInt(this.total_quantity) - parseInt(this.qty[index]);
    //   }

    // },
    calculate_qty(i) {



      if (this.qty[i] && this.unit[i] && this.price[i]) {

        this.total_quantity = parseInt(this.qty[i]) + parseInt(this.total_quantity);

      } else {

        this.total_quantity = parseInt(0) + parseInt(this.total_quantity);
      }


    },

    // calculate_qty_by_cost(i) {


    //   if (this.qty[i] && this.unit[i]) {

    //     this.total_quantity = parseInt(this.qty[i]) + parseInt(this.total_quantity);

    //   } else {

    //     this.total_quantity = parseInt(0) + parseInt(this.total_quantity);
    //   }


    // },

    calculate_remaining() {


      if (this.Way_to_pay_selected == 2) {

        this.remaining = this.grand_total;

      } else {

        this.remaining = 0;

      }

    },


    // -------------------------------------------------------------------------------------------


    calculate_price() {

      this.init();

      for (let index = this.first_row; index <= this.count; index++) {

        if (this.check_state[index] == true) {

          this.calculate_total(index);
          this.calculate_qty(index);
          this.calculate_tax(index);
          // this.calculate_total(index);
          this.calculate_grand_total(index);


        }

      }

      this.credit();
      this.calculate_remaining();


    },


    // calculate_by_cost() {


    //   // console.log(this.detail);
    //   this.init();
    //   for (let index = this.first_row; index <= this.count; index++) {

    //     if (this.check_state[index] == true) {

    //       this.price[index] = this.detail[index].price;
    //       this.calculate(index);
    //       this.calculate_qty(index);
    //       this.calculate_tax(index);
    //       this.calculate_total(index);
    //       this.calculate_grand_total(index);

    //     }
    //   }
    //   this.credit();
    //   this.calculate_remaining();







    // },



    calculate(i) {



      
      if (!price) {

        price = this.price[index];

      }

      
      if (this.unit[i] && this.qty[i] && this.price[i]) {

        if (this.qty[i] <= 0 || this.price[i] <= 0) {

          this.total[i] = 0;
          toastMessage('فشل', "تأكد من البيانات المدخله", 'error');
          return 0;

        }


        this.total[i] = this.price[i] * this.qty[i] * this.unit[i][1];

      } else {

        toastMessage('فشل', "تأكد من البيانات المدخله", 'error');
        this.total[i] = 0;
      }

    },

    // calculate_case_nofounded_price(i) {


    //   if (this.unit[i] && this.qty[i]) {

    //     if (this.qty[i] <= 0 || this.detail[i].price <= 0) {

    //       this.total[i] = 0;
    //       toastMessage('فشل', "تأكد من البيانات المدخله", 'error');
    //       return 0;

    //     }


    //     this.total[i] = this.detail[i].price * this.qty[i] * this.unit[i][1];

    //   } else {

    //     toastMessage('فشل', "تأكد من البيانات المدخله", 'error');
    //     this.total[i] = 0;
    //   }


    // },



    calculate_grand_total(i) {


      if (this.total[i]) {

        this.grand_total = parseInt(this.total[i]) + parseInt(this.grand_total);

      } else {

        this.grand_total = parseInt(0) + parseInt(this.grand_total);
      }

      this.sub_total = parseInt(this.grand_total) - parseInt(this.total_tax)



      this.To_pay = this.grand_total;


    },


    calculate_tax(i) {



      if (this.tax[i]) {

        this.total_tax = parseInt(this.tax[i]) + parseInt(this.total_tax);

      } else {

        this.total_tax = parseInt(0) + parseInt(this.total_tax);
      }

      // console.log('qwsas', this.grand_total, this.sub_total, this.total_tax);


    },









  }
};









