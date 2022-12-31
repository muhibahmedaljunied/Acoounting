data = {

  vm : '',
  type: '',
  count: 1,
  counts: {},
  check_state: [],
  qty: [],
  total_quantity: 0,
  grand_total: 0,
  sub_total: 0,
  To_pay: 0,
  discount: 0,
  total_tax: 0,
  customer: [],
  supplier: [],
  suppliers: '',
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

};



Add_new_for_staff = function (vm) {
  // console.log('muhib');
  data.vm = vm;
  vm.axios.post(`/store_${data.vm.type}`, attendance_fun()).then((response) => {
    console.log(response);
    toastMessage("تم الاضافه بنجاح");
    // vm.$router.go(0);
  });

  // vm.axios.post(`/store_${data.type}`, data).then((response) => {
  //     console.log(response);
  //     toastMessage("تم الاضافه بنجاح");
  //     // vm.$router.go(0);
  //   });

  // }
};

attendance_fun = function () {

  return {type: data.vm.type, 
    count: data.vm.counts,
    staff: data.vm.staff,
    attendance_date: data.vm.date,
    status_attendance: data.vm.status,
    time_in: data.vm.time_in,
    time_out: data.vm.time_out}
 
};

advance_fun = function () {


};


discount_fun = function () {


};


addComponent = function (vm, index) {
  // alert(index);
  vm.count += 1;
  vm.counts[index] = vm.count;


};
disComponent = function (vm, index) {
  vm.count -= 1;
  vm.$delete(vm.counts, index);

};



