

data = {

  text_message: '',
  type: '',
  type_refresh: '',
  count: 1,
  counts: {},
  intostore: [],
  intostore_id: [],
  product_name: [],
  product: [],
  products: '',
  word_search: '',
  check_state: [],
  qty: [],
  availabe_qty: [],
  price: [],
  tax: [],
  desc: [],
  stores: '',
  statuses: '',
  total_quantity: 0,
  grand_total: 0,
  sub_total: 0,
  To_pay: 0,
  discount: 0,
  total_tax: 0,
  customer: [],
  // supplier: [],
  // suppliers: '',
  customers: '',
  date: new Date().toISOString().substr(0, 10),
  status: [],
  store: [],
  temporale: 1,
  type_payment: 0,
  Way_to_pay_selected: 1,
  show: false,
  paid: 0,
  remaining: 0,
  return_qty: [],
  note: '',
  not_qty: true,
  seen: false,
  detail: '',
  id: '',


  // ----------------------------
  // supply_detail: "",
  // supply_id: "",
  //---------------------------- 
  // cash_detail: 0,
  // cash_id: "",
  // ---------------------------------------------------
  // purchase_detail: 0,
  // purchase_id: "",
  // -----------------------------------
  // sale_detail: 0,
  // sale_id: "",
  // ---------------------------------

  // dateselected: new Date().toISOString().substr(0, 10),



};

// data_for_expence = {
//   expence_type: vm.expence_type,
//   expence_qty: vm.qty,
// };

// data_for_supply_and_cash = {
//   type: vm.data_send.type,
//   count: vm.data_send.counts,
//   product: vm.data_send.product,
//   store: vm.data_send.store,
//   desc: vm.data_send.desc,
//   qty: vm.data_send.qty,
//   status: vm.data_send.status,

// }

// data_for_purchase_and_sale = {
//   type: vm.type,
//   count: vm.counts,
//   product: vm.product,
//   store: vm.store,
//   desc: vm.desc,
//   qty: vm.qty,
//   status: vm.status,
//   price: vm.price,
//   tax: vm.tax,
// }

Add_new = function (vm) {

  
  


  vm.axios
    .post(`/add_${vm.type}`,{
      type: vm.type,
      count: vm.counts,
      product: vm.product,
      // product_name: vm.product_name,
      store: vm.store,
      desc: vm.desc,
      qty: vm.qty,
      status: vm.status,
      price: vm.price,
      tax: vm.tax,
    })
    .then((response) => {
      // ---------------------------------------------------------------
      console.log(response);


      vm.temporale = response.data;
      vm.temporale.forEach((item) => {
        vm.total_quantity = item.tem_qty + vm.total_quantity;

        this.grand_total = item.subtotal + this.grand_total;
        this.To_pay = item.subtotal + this.To_pay;

        this.total_tax = item.tax + this.total_tax;

        //  console.log(this.total_tax);


      });

      toastMessage("تم الاضافه بنجاح");
      // vm.$router.go(0);
    });

  // }
};


payment = function (vm) {
  // alert('erer');

  this.axios
    .post(`/pay${vm.type}`, {
      type: vm.type,
      type_refresh: vm.type_refresh,
      supplier_id: vm.supplier[0],
      supplier_name: vm.supplier[1],
      customer_id: vm.customer[0],
      customer_name: vm.customer[1],
      date: vm.date,

      // -------------------

      grand_total: vm.grand_total,
      sub_total: vm.sub_total,
      discount: vm.discount,
      total_tax: vm.total_tax,
      type_payment: vm.type_payment,
      remaining: vm.remaining,
      paid: vm.paid,
      // -------------------

      total_quantity: vm.total_quantity,
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
      // vm.$router.go(0);
    });
};

Add_return = function (vm) {

  // console.log(
  //             vm.total_quantity,
  //             vm.supply_detail,
  //             vm.date, 
  //             vm.note
  //             )

  // if (vm.return_qty.length != 0) {

  this.axios
    .post(`/${vm.type}return`, {
      // old: vm.supply_detail,
      old: vm.detail,
      date: vm.date,
      note: vm.note,
      // supply_id: vm.supply_id,
      id: vm.id,
      return_qty: vm.return_qty,
      total: vm.total_quantity,
      type: vm.type,
      type: vm.type_refresh,

    })
    .then((response) => {
      console.log(response.data);

      if (response.data.message != 0) {

        // console.log(response)

        this.seen = false;
        toastMessage("تم الارجاع بنجاح");
        this.$router.go(-1);

      } else {

        toastMessage("فشل", response.data.text);




      }


    });
  // }


};

showtree = function (vm) {


  vm.axios.post(`/tree_product`).then((response) => {
    vm.jsonTreeDataProduct = response.data.products;


    $('#treeview_json_product').jstree({
      core: {
        themes: {
          responsive: false,
        },
        // so that create works
        check_callback: true,
        data: vm.jsonTreeDataProduct,
      },
      types: {
        default: {
          icon: "fa fa-folder text-primary",
        },
        file: {
          icon: "fa fa-file  text-primary",
        },
      },
      checkbox: {
        three_state: false,

      },
      state: {
        key: "demo2"
      },
      search: {
        case_insensitive: true,
        show_only_matches: true
      },
      plugins: ["checkbox",
        "contextmenu",
        "dnd",
        "massload",
        "search",
        "sort",
        "state",
        "types",
        "unique",
        "wholerow",
        "changed",
        "conditionalselect"],
      contextmenu: {
        items: contextmenu
      },






    }).on("changed.jstree", function (e, data) {

      console.log(data.node.id);
      $(`.modal-title-product`).val(data.node.id)
      //  modal-title-store

    });

  });
  vm.axios.post(`/tree_store`).then((response) => {
    vm.jsonTreeDataStore = response.data.stores;


    $('#treeview_json_store').jstree({
      core: {
        themes: {
          responsive: false,
        },
        // so that create works
        check_callback: true,
        data: this.jsonTreeDataStore,
      },
      types: {
        default: {
          icon: "fa fa-folder text-primary",
        },
        file: {
          icon: "fa fa-file  text-primary",
        },
      },
      checkbox: {
        three_state: false,

      },
      state: {
        key: "demo2"
      },
      search: {
        case_insensitive: true,
        show_only_matches: true
      },
      plugins: ["checkbox",
        "contextmenu",
        "dnd",
        "massload",
        "search",
        "sort",
        "state",
        "types",
        "unique",
        "wholerow",
        "changed",
        "conditionalselect"],
      contextmenu: {
        items: contextmenu
      },






    }).on("changed.jstree", function (e, data) {

      console.log(data.node.id);
      $(`.modal-title-store`).val(data.node.id)
      //  modal-title-store
    });

  });
};

