
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
      expiry_date :new Date().toISOString().substr(0, 10),
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
      total:[],
      customer: [],
      supplier: [],
      suppliers: '',
      customers: '',
      seen: false,
      id:'',
    };
  },
  methods: {

  
    payment() {


      this.axios
        .post(`/pay${this.type}`, {
          type: this.type,
          type_refresh: this.type_refresh,
          supplier_id: this.supplier[0],
          supplier_name: this.supplier[1],
          customer_id: this.customer[0],
          customer_name: this.customer[1],
          date: this.date,

          // -------------------
        

          grand_total: this.grand_total,
          sub_total: this.sub_total,
          discount: this.discount,
          total_tax: this.total_tax,
          type_payment: this.type_payment,
          remaining: this.remaining,
          paid: this.paid,
          // -------------------

          total_quantity: this.total_quantity,
        })
        .then((response) => {

          console.log(response);

          if (response.data.message == "success") {
            toast.fire({
              title: "تم التوريد!",
              text: "Your product has been deleted.",
              button: "Close", // Text on button
              icon: "success", //built in icons: success, warning, error, info
              timer: 3000, //timeOut for auto-close
              buttons: {
                confirm: {
                  text: "OK",
                  value: true,
                  visible: true,
                  className: "",
                  closeModal: true,
                },
                cancel: {
                  text: "Cancel",
                  value: false,
                  visible: true,
                  className: "",
                  closeModal: true,
                },
              },
            });
          }
          // this.$router.go(0);
        });
    },
    Add_return() {

      
      // if (this.return_qty.length != 0) {

      var url = this.type.toLowerCase();
      // alert(this.id);
      this.axios
        .post(`/${url}`, {

          count: this.counts,
          product_id: this.product,
          store_id: this.store,
          unit_id: this.unit,
          desc: this.desc,
          qty: this.qty,
          status_id: this.status,
          // ------
          type: this.type,
          type_refresh: this.type_refresh,
          old: this.detail,
          date: this.dateselected,
          note: this.note,
          id:this.id,
          // return_qty: this.return_qty,
          // total: this.total_quantity,
        

        })
        .then((response) => {
          console.log(response);

          if (response.data.message != 0) {

            // console.log(response)

            this.seen = false;
            toastMessage("تم الارجاع بنجاح");
            // this.$router.go(-1);

          } else {

            toastMessage("فشل", response.data.text);




          }


        });
      // }


    },
    delete_temporale() {
      this.axios.post(`/${this.type}/delete`).then((response) => {
        toastMessage("تم الحذف بنجاح");

        this.$router.go(0);
      });
    },
    delete_one_temporale() {

      var id = $("#vaciar1").val();
      this.axios.post(`/${this.type}/delete/${id}`).then((response) => {
        toastMessage("تم الحذف بنجاح");

        this.$router.go(0);
      });
    },
    addComponent(index) {
      // alert(index);
      this.count += 1;
      this.counts[index] = this.count;
    },
    disComponent(index) {
      this.count -= 1;
      this.$delete(this.counts, index);
    },
    
    Add_new() {

      
      
      this.axios
        .post(`/add_${this.type}`, {
          type: this.type,
          count: this.counts,
          product: this.product,
          store: this.store,
          unit: this.unit,
          desc: this.desc,
          qty: this.qty,
          status: this.status,
          price: this.price,
          total:this.total,
          tax: this.tax,
        })
        .then((response) => {
          // ---------------------------------------------------------------
          console.log(response);


        

          toastMessage("تم الاضافه بنجاح");
          // this.$router.go(0);
        });

      // }
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
  }
};
