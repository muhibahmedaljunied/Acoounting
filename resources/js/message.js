function toastMessage(title=null,text=null){


  return toast.fire({
    title: title,
    text:text,
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


