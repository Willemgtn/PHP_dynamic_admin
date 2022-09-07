$(function () {
  $("form.ajax").find("input[type=submit]").removeAttr("disabled");

  $("form.ajax")
    .ajaxForm({
      dataType: "json",
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
          if ($("form.ajax").attr("resetar")) {
            $("form.ajax")[0].reset();
          }
        } else {
          $("form.ajax").prepend(
            '<div class="box-alert error ">Error:: ' + data.msg + "</div>"
          );
        }
        console.log(data);
      },
    })
    .done(function (data) {
      if (!data.success) {
        $("form.ajax").prepend(
          '<div class="box-alert error ">Error: ' + "500" + "</div>"
        );
      }
      $("form.ajax").find("input[type=submit]").removeAttr("disabled");
    });
});

$(function () {
  // alert("...");
  $("a.btn.delete").click(function (e) {
    e.preventDefault();
    var el = $(this).parent().parent();
    var url = $(this).attr("href");
    $.ajax({
      url: "./api/clientes.php?delete",
      data: {
        id: $(this).attr("item_id"),
      },
      method: "post",
    }).done(function () {
      el.fadeOut();
    });
    return false;
  });
});
