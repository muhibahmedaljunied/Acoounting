protree = function(jsonTreeData){

    return {
        core: {
            themes: {
                responsive: false,
            },
            // so that create works
            check_callback: true,
            data: jsonTreeData,
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

    
}
} 

dataevent = function(data){

    let currentObj = this;
      const config = {
        headers: {
          "content-type": "multipart/form-data",
        },
      };


      let formData = new FormData();
      formData.append("text", data.node.text);

      let url = `/${localStorage.getItem('table')}_rename_node/${data.node.id}`;
      axios.post(url, formData).then((response) => {

        currentObj.success = response.data.success;
        currentObj.filename = "";

      }).catch(function (error) {
        currentObj.output = error;
      });




}