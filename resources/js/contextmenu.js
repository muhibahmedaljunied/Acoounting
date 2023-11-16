contextmenu = function (node) {

  var items = {

    renameItem: {
      // The "rename" menu item
      label: "تحرير",
      action: function (data) {
        var rn = $.jstree.reference(data.reference).get_node(data.reference).id;
        $.jstree.reference(data.reference).edit(rn);
        console.log($.jstree.reference(data.reference).get_node(data.reference));

        console.log('Rename');
      },
    },
    deleteItem: {
      // The "delete" menu item
      label: "حذف",
      action: function (data) {

        if (confirm("Are you sure you wish to delete the selected item?")) {

          var rm = $.jstree.reference(data.reference).get_node(data.reference).id;
          axios.post(`/delete_${localStorage.getItem('table')}/${rm}`).then((response) => {
            toastMessage("تم الحذف بنجاح");



          }).catch((error) => {
            console.log(error.response);

            if (error.response.status == 500) {
              // toastMessage("فشل", error.response.data.message);
              toastMessage("فشل", 'لايمكن الحذف لانه مرتبط بعملبات اخري');

            }
          });
        }
        console.log(this.muh);
      },
    },
    addItem: {
      // The "delete" menu item
      label: "اضافه",
      action: function (data) {

        var id = $.jstree.reference(data.reference).get_node(data.reference).id


        axios
          .post(`/${localStorage.getItem('table')}_details_node/${id}`)
          .then(function (response) {


            $("#parent").val(response.data.details[0].id);

            $("#rank").val(response.data.details[0].rank + 1);
            console.log($("#rank").val());

            if (response.data.childs == null) {

              $(`#${localStorage.getItem('table')}_number`).val((id * 10) + 1);
            } else {
              $(`#${localStorage.getItem('table')}_number`).val(response.data.childs + 1)
            }


          })
          .catch(function (error) {
            console.log(error);
          });





      },
    },

  };

  if ($(node).hasClass("folder")) {
    // Delete the "delete" menu item
    delete items.deleteItem;
  }

  return items;
}

