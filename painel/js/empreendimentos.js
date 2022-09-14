$(function () {
  $(".cardsWrapper").sortable({
    //

    start: function () {
      var el = $(this);
      //   el.find("div.boxes").css("border-style", "dashed");
      el.find("div.boxes").css("border", "2px dashed black");
    },
    update: function (event, ui) {
      var data = $(this).sortable("serialize");
      data += "&tipo=ordenar";
      //   console.log(data);

      var el = $(this);
      el.find("div.boxes").css("border", "1px solid black");

      $.ajax({
        url: "./api/empreendimentos.php",
        method: "post",
        data: data,
      }).done(function (data) {
        console.log(data);
      });
    },
  });
});
