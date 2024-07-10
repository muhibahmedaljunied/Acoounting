export default {
    data() {
      return {
  
        date: new Date().toISOString().substr(0, 10),
        dateselected: new Date().toISOString().substr(0, 10),
        expiry_date: new Date().toISOString().substr(0, 10),
        purchase_id: [],
        discount: [],
        store_product_id: [],
        cost: [],
        bank: [],
        product: [],
        typeselected: [],
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
        row_counter: '',
        first_row: '',
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
  
        operation_status: 1,
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
        this.count += 1;
        this.counts[index] = this.count;
        // this.calculate();
      },
      disComponent(index) {
  
        if (index != 1) {
  
          this.count -= 1;
          this.$delete(this.counts, index - 1);
  
        }
        // this.calculate();
      },
  
      init() {
  
        this.grand_total = 0;
        this.sub_total = 0;
        this.total_tax = 0;
        this.total_quantity = 0;
        this.remaining = 0;
        this.paid = 0;
        this.To_pay = 0;
  
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
  
  
      calculate_qty() {
  
  
  
        if (this.qty[this.row_counter]) {
  
          this.total_quantity = parseInt(this.qty[this.row_counter]) + parseInt(this.total_quantity);
  
        } else {
  
          this.total_quantity = parseInt(0) + parseInt(this.total_quantity);
        }
  
  
      },
  
  
  
      calculate_remaining() {
  
  
        if (this.Way_to_pay_selected == 2) {
  
          this.remaining = this.grand_total;
  
        } else {
  
          this.remaining = 0;
  
        }
  
      },
  
  
      // -------------------------------------------------------------------------------------------
  
  
      handle_top() {
  
        // if (!this.check_qty()) {return 0;}

        if (this.type != 'Purchase') {
  
          this.set_values();
        }


        this.set_price();
        this.calculate_total_with_check();
  
      },
      handle_down() {
  
  
  
        this.calculate_qty();
        this.calculate_tax();
        this.calculate_grand_total();
        this.credit();
        this.calculate_remaining();
  
      },
      calculate() {
  
  
  
        if (this.type == 'Purchase') {
  
          var count = this.count;
        }else{

          var count = this.detail.length;
        }

       
        this.init();
  
        for (let index = this.first_row; index <= count; index++) {
  
          this.row_counter = index;
          if (this.type == 'Purchase') {
  
            this.check_state[this.row_counter] = true;
          }
  
          if (this.check_state[index] == true) {
  
  
            this.handle_top();
  
            if (this.operation_status == 0) {
  
              toastMessage('فشل', `${index}تأكد من البيانات المدخله`, 'error');
              this.operation_status = 1;
         
             
  
            }else{

              this.handle_down();

            }
  
  
          }
  
        }
  
  
      },
  
  
      
  
      set_price() {
  
        if (!this.price[this.row_counter]) {
  
            this.price[this.row_counter] = this.detail[this.row_counter].price;
  
        }
  
      },
      calculate_total_with_check() {
  
  
  
  
        if (this.unit[this.row_counter] && this.qty[this.row_counter] && this.price[this.row_counter]) {
  
          if (this.qty[this.row_counter] <= 0 || this.price[this.row_counter] <= 0) {
  
            this.total[this.row_counter] = 0;
            this.operation_status = 0;
  
  
          } else {
  
  
            this.operation_status = 1;
            this.total[this.row_counter] = this.price[this.row_counter] * this.qty[this.row_counter] * this.unit[this.row_counter][1];
  
  
          }
  
  
  
        } else {
  
          this.total[this.row_counter] = 0;
          this.operation_status = 0;
        }
  
        // console.log('yes', this.unit[this.row_counter][1], this.qty[this.row_counter], this.price[this.row_counter], this.operation_status);
  
  
  
  
  
  
      },
      calculate_total(i, price=null) {
  
  
  
  
        if (this.check_state[i] != true) {
  
          if (!price) {
  
            price = this.price[i];
  
          }
  
  
          console.log('almuhib', price);
          if (this.unit[i] && this.qty[i] && price) {
  
            if (this.qty[i] <= 0 || price <= 0) {
  
              this.total[i] = 0;
              // this.operation_status = 0;
            }
  
  
            this.total[i] = price * this.qty[i] * this.unit[i][1];
  
          } else {
  
            // this.operation_status = 0;
            this.total[i] = 0;
          }
  
  
  
        }
  
  
      },
  
  
  
  
  
  
      calculate_grand_total() {
  
  
  
  
        if (this.total[this.row_counter]) {
  
          this.grand_total = parseInt(this.total[this.row_counter]) + parseInt(this.grand_total);
  
        } else {
  
          this.grand_total = parseInt(0) + parseInt(this.grand_total);
        }
  
        this.sub_total = parseInt(this.grand_total) - parseInt(this.total_tax)
  
  
  
        this.To_pay = this.grand_total;
  
  
      },
  
  
      calculate_tax() {
  
  
  
        if (this.tax[this.row_counter]) {
  
          this.total_tax = parseInt(this.tax[this.row_counter]) + parseInt(this.total_tax);
  
        } else {
  
          this.total_tax = parseInt(0) + parseInt(this.total_tax);
        }
  
  
      },
  
    }
  };
  