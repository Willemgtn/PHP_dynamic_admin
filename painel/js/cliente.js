$(function () {
  // alert("...");
  $("a.btn.delete").click(function (e) {
    e.preventDefault();
    var el = $(this).parent().parent();
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
