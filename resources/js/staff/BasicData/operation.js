
export default {
  data() {

    return {
      count: 1,
      counts: {},
      name:[],
      // ----------------------------
      type:'',
      work_types: '',
      work_system_types:'',
      periods: '',
      period_times:'',
      breaks: '',
  
    }
  },
    methods: {
   
      Add(data) {
        
        this.axios
        .post(`/store_${this.type}`,data)
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
  
  
  