
export default {
  data() {

    return {
      count: 1,
      counts: {},
      // date: new Date().toISOString().substr(0, 10),
      // from_date: new Date().toISOString().substr(0, 10),
      // into_date: new Date().toISOString().substr(0, 10),
    }
  },
    methods: {
   
      Add_new() {
      
        this.axios
        .post(`/store_advance`,this.data_list())
        .then((response) => {
          console.log(response);
          toastMessage("تم الاضافه بنجاح");
          // this.$router.go(0);
        });
      
        // this.$router.go(0);
  
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
      
      addComponent (index) {
        // alert(index);
        this.count += 1;
        this.counts[index] = this.count;
      
      
      },
      disComponent (index) {
        this.count -= 1;
        this.$delete(this.counts, index);
      
      },
    }
  };
  
  
  