initial = function () {

// alert('sdsd');
  this.axios.post(`/tree_${localStorage.getItem('table')}`).then((response) => {
    this.trees = response.data.stores;
    
    this.jsonTreeData = response.data.stores;
    this.last_nodes = response.data.last_nodes;

    $(`#${localStorage.getItem('table')}_number_first_level`).val(response.data.last_nodes + 1);

    $(`#${localStorage.getItem('table')}_json`).jstree(protree(this.jsonTreeData)).on('rename_node.jstree', function (e, data) { dataevent(data) }).on("changed.jstree", function (e, data) {


    });

  });
}

  addnode_first = function (node_first_level) {

    let currentObj = this;
    const config = {
      headers: {
        "content-type": "multipart/form-data",
      },
    };
    // form data
    let formData = new FormData();
    formData.append("id", $(`#${localStorage.getItem('table')}_number_first_level`).val());
    formData.append("parent", 0);

    formData.append("rank", 1);
    formData.append("text", node_first_level);

    // send upload request
    this.axios
      .post(`${localStorage.getItem('table')}_store_first_level`, formData, config)
      .then(function (response) {
        currentObj.success = response.data.success;
        currentObj.filename = "";

        toastMessage("تم الاضافه بنجاح");

      })
      .catch(function (error) {
        currentObj.output = error;
      });
      // this.$router.go(0);
  }

  
   addnode =  function (text) {
 
    console.log(text)

    let currentObj = this;
    const config = {
      headers: {
        "content-type": "multipart/form-data",
      },
    };
    // form data
    let formData = new FormData();
    formData.append(`${localStorage.getItem('table')}_id`, $(`#${localStorage.getItem('table')}_number`).val());
    formData.append("text", text);
    formData.append(`${localStorage.getItem('table')}_name_en`, this.store_name_en);
    formData.append("parent", $("#parent").val());
    formData.append("rank", $("#rank").val());
 
      this.axios
      .post(`store_${localStorage.getItem('table')}`, formData, config)
      .then(function (response) {
        console.log(response);
        currentObj.success = response.data.success;
        currentObj.filename = "";

        toastMessage("تم الاضافه بنجاح");
        console.log(1);
      })
      .catch(function (error) {
        currentObj.output = error;
      });



  };

  updatenode = function (id, text) {

    // alert(text);

    let currentObj = this;
    const config = {
      headers: {
        "content-type": "multipart/form-data",
      },
    };
    // form data
    let formData = new FormData();
    formData.append(`id`, $(`#${localStorage.getItem('table')}_number`).val());
    formData.append("text", text);
    // formData.append("store_name_en", this.store_name_en);
    formData.append("parent_id", $("#update_parent").val());
    formData.append("rank", $("#update_rank").val());
    // if(file != 0){
    //   formData.append("image", file);
    // }

    // send upload request
    this.axios
      .post(`${localStorage.getItem('table')}_update_node/${id}`, formData, config)
      .then(function (response) {
        currentObj.success = response.data.success;
        currentObj.filename = "";

        toastMessage("تم التعديل بنجاح");
        this.$router.go(0);

      })
      .catch(function (error) {
        currentObj.output = error;
      });



    
  }



