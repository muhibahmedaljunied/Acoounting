
export default {
  data() {

    return {
      count: 1,
      counts: {},
      check_attend: [],
      duration: [],
      delay: [],
      leave: [],

      period_selected:0,
      start_period_selected:0,
      end_period_selected:0,

      staff_selected:0,
      work_selected: 0,
      work_systems: 0,

      fieldset1: [],
      fieldset2: [],
      fieldset3: [],


      type: '',

      staff: [],
      status: [],
      time_in: [],
      time_out: [],
      check_state: [],

      date: [],
      staff_id: '',
      attendance_date: [],
      attendance_status: '',
      check_in: [],
      check_out: [],
      attendance_in_out:'',

      from_date: new Date().toISOString().substr(0, 10),
      into_date: new Date().toISOString().substr(0, 10),



    }
  },
  methods: {
    select_staff() {
      console.log(this.staff_selected);
      this.axios
        .post(`/${this.table}/select_staff`, {

          id: this.staff_selected,

        })
        .then(({ data }) => {
          console.log(data);
          this.list_data = data.list;
        });
    },
    Add_new() {
      // console.log('muhib');

      this.axios.post(`/store_${this.type}`, {
        type: this.type,
        count: this.counts,
        // work:this.work_selected,
        period:this.period_selected,
        staff: this.staff,
        attendance_date: this.date,
        attendance_status: this.status,
        time_in: this.time_in,
        time_out: this.time_out,
        duration:this.duration,
        delay:this.delay,
        leave:this.leave,
        attendance_in_out:this.attendance_in_out,

      }).then((response) => {

        console.log(response);
        toastMessage("تم الاضافه بنجاح");
        // vm.$router.go(0);
      });

    },
    
    get_search(word_search) {
      this.axios
        .post(`/extra_typesearch`, { word_search: this.word_search })
        .then(({ data }) => {
          this.list = data.list;

          // this.$root.logo = "Category";
        });
    },


    delete(id) {
      this.axios
        .post(`delete_${this.table}/${id}`)
        .then((response) => {
          toastMessage("تم الحذف بنجاح");

          this.list();
          // this.$router.push('category')
        })
        .catch((error) => {
          console.log(error.response);

          if (error.response.status == 500) {
            toast.fire({
              title: " فشل",
              text: error.response.data.message,
              button: "Close", // Text on button
              icon: "error", //built in icons: success, warning, error, info
              timer: 5000, //timeOut for auto-close
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
        });
    },

    addComponent(index) {

      this.count += 1;
      this.counts[index] = this.count;


    },
    disComponent(index) {
      this.count -= 1;
      this.$delete(this.counts, index);

    },
  }
};


