$(function () {
  //   $("form.ajax").find("input[type=submit]").removeAttr("disabled");

  $("form.ajax").ajaxForm({
    // dataType: "json",
    // method: "post",
    // data: {},

    beforeSend: function () {
      $("form.ajax").animate({ opacity: "0.4" });
      $("form.ajax").find("input[type=submit]").attr("disabled", "true");
    },
    success: function (data) {
      // console.log("OK!")
      $("form.ajax").animate({ opacity: "1" });
      $("form.ajax").find("input[type=submit]").removeAttr("disabled");
      $(".box-alert").remove();
      if (data.success) {
        $("form.ajax").prepend(
          '<div class="box-alert ok ">Sucesss: ' + data.msg + "</div>"
        );
        $("form.ajax")[0].reset();
      } else {
        $("form.ajax").prepend(
          '<div class="box-alert error ">Error: ' + data.msg + "</div>"
        );
      }
      console.log(data);
    },
  });
  // .done(function (data) {
  //   if (!data.success) {
  //     $("form.ajax").prepend(
  //       '<div class="box-alert error ">Error: ' + "500" + "</div>"
  //     );
  //   }
  //   $("form.ajax").find("input[type=submit]").removeAttr("disabled");
  // });
});
