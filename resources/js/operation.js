export default {
  data() {

    // return data;
    return {

      product: [],
      qty: [],
      unit: [],
      desc: [],
      store: [],
      status: [],
      counts: {},
      count: 1,
      date: new Date().toISOString().substr(0, 10),
      dateselected: new Date().toISOString().substr(0, 10),
      expiry_date: new Date().toISOString().substr(0, 10),
      table: '',
      type: '',
      type_refresh: '',
      note: "",
      detail: '',
      Total_quantity: 0,
      total_quantity: 0,
      check_state: [],
      return_qty: [],
      price: [],
      tax: [],
      products: '',
      stores: '',
      statuses: '',
      stores: '',
      statuses: '',
      units: '',
      opening: '',
      availabe_qty: [],
      word_search: '',
      total: [],
      customer: [],
      supplier: [],
      suppliers: '',
      customers: '',
      seen: false,
      id: '',


      grand_total: 0,
      sub_total: 0,
      To_pay: 0,

      total_tax:0,
      storem: [],
      storem_account: [],



      paid: 0,
      remaining: 0,
      Way_to_pay_selected: 1,





    };
  },
  watch: {
    Way_to_pay_selected(newVal, oldVal) {
      $(`#treeview_json_account`).jstree(true).destroy();
      this.showtree('account', 'tree_account', this.Way_to_pay_selected);

      console.log('alkhm',newVal, oldVal);
    }
  },
  methods: {



    // Add_return() {


    //   // if (this.return_qty.length != 0) {

    //   var url = this.type.toLowerCase();
    //   // alert(url);
    //   this.axios
    //     .post(`/${url}`, {

    //       count: this.counts,
    //       unit_id: this.unit,
    //       type: this.type,
    //       type_refresh: this.type_refresh,
    //       old: this.detail,
    //       date: this.dateselected,
    //       note: this.note,
    //       id: this.id,



    //     })
    //     .then((response) => {
    //       console.log(response);

    //       if (response.data.message != 0) {

    //         // console.log(response)

    //         this.seen = false;
    //         toastMessage("تم الارجاع بنجاح");
    //         // this.$router.go(-1);

    //       } else {

    //         toastMessage("فشل", response.data.text);




    //       }


    //     });
    //   // }


    // },
    // delete_temporale() {
    //   this.axios.post(`/${this.type}/delete`).then((response) => {
    //     toastMessage("تم الحذف بنجاح");

    //     this.$router.go(0);
    //   });
    // },
    // delete_one_temporale() {

    //   var id = $("#vaciar1").val();
    //   this.axios.post(`/${this.type}/delete/${id}`).then((response) => {
    //     toastMessage("تم الحذف بنجاح");

    //     this.$router.go(0);
    //   });
    // },
    addComponent(index) {
      // alert(index);
      this.count += 1;
      this.counts[index] = this.count;
    },
    disComponent(index) {
      this.count -= 1;
      this.$delete(this.counts, index);
    },

    credit() {

      console.log('we');
      if (this.paid == '') {

        this.paid = 0;
      }
      this.remaining = parseInt(this.grand_total) - parseInt(this.paid);
    },


    // Add_new() {



    //   this.axios
    //     .post(`/add_${this.type}`, {
    //       type: this.type,
    //       count: this.counts,
    //       product: this.product,
    //       store: this.store,
    //       unit: this.unit,
    //       desc: this.desc,
    //       qty: this.qty,
    //       status: this.status,
    //       price: this.price,
    //       total: this.total,
    //       tax: this.tax,
    //     })
    //     .then((response) => {
    //       // ---------------------------------------------------------------
    //       console.log(response);

    //       toastMessage("تم الاضافه بنجاح");
    //       // this.$router.go(0);
    //     });

    //   // }
    // },


    handle(product,index){

      this.set_values(product, index);
      this.calc_grand_total(index);
      this.calc_tax(index);
      this.calc_qty(index);

      if (this.check_state[index] == false) {

        this.$delete(this.counts, index);

      }

      this.To_pay = this.grand_total;
      this.remaining = this.grand_total;
      this.credit();

    },
    calculate_price(price, qty, index) {
      // console.log(this.unit[index][2]);

      if (this.unit[index][2] == 0) {

        this.total[index] = price * qty;

      }

      if (this.unit[index][2] == 1) {

        this.total[index] = price * this.unit[index][1] * qty;

      }

    },

    calc_grand_total(index) {




      if (this.check_state[index] == true) {

        if (this.total[index]) {

          this.grand_total = parseInt(this.total[index]) + parseInt(this.grand_total);

        } else {

          this.grand_total = parseInt(0) + parseInt(this.grand_total);
        }

      }


      if (this.check_state[index] == false) {

        if (!this.total[index]) { this.total[index] = 0; }
        this.grand_total = parseInt(this.grand_total) - parseInt(this.total[index]);
        // this.total[index] = 0;


      }



    },

    calc_tax(index) {



      if (this.check_state[index] == true) {

        if (this.tax[index]) {

          this.total_tax = parseInt(this.tax[index]) + parseInt(this.total_tax);

        } else {

          this.total_tax = parseInt(0) + parseInt(this.total_tax);
        }

        this.sub_total = parseInt(this.grand_total) - parseInt(this.total_tax)

      }

      if (this.check_state[index] == false) {



        if (!this.tax[index]) { this.tax[index] = 0; }

        this.total_tax = parseInt(this.total_tax) - parseInt(this.tax[index]);
        this.sub_total = parseInt(this.grand_total) - parseInt(this.tax[index]);

        // this.tax[index] = 0;


      }


    },
    calc_qty(index) {



      // this.qty[index] = 0;
      if (this.check_state[index] == true) {

        if (this.qty[index]) {

          this.total_quantity = parseInt(this.qty[index]) + parseInt(this.total_quantity);

        } else {

          this.total_quantity = parseInt(0) + parseInt(this.total_quantity);
        }


      }


      if (this.check_state[index] == false) {

        if (!this.qty[index]) { this.qty[index] = 0; }

        this.total_quantity = parseInt(this.total_quantity) - parseInt(this.qty[index]);
        // this.qty[index] = 0;
      }

    }
  }
};
