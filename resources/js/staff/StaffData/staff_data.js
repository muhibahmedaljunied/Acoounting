
export default {
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

      
  
      
    
    }
  };
  
  
  