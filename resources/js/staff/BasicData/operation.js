
export default {
  data() {

    return {
     
      type:'',
      name:[],
      count: 1,
      counts: {},

     

      work_type_selected: [],
      period_selected: [],
      rest_selected: [],
      work_types: '',
      periods: '',
      breaks: '',
      fieldset1: [],
      fieldset2: [],
      fieldset3: [],
      fieldset4: [],
      fieldset5: [],
      fieldset6: [],
      fieldset7: [],


    }
  },
    methods: {
   
      Add_new() {
        
        // console.log(this.all_values);
        this.axios
        .post(`/store_${this.type}`,{
          count:this.counts,
          name:this.name,
          type:this.type,
          work_type:this.work_type_selected,
          period:this.period_selected,
          rest:this.rest_selected,
          day:this.all_values,
        
        })
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
  
  
  