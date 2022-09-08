$(function () {
  // alert('...');
  // $("form.ajax").find("input[type=submit]").removeAttr("disabled");

  if ($("[name=tipo_cliente]").val() == "fisico") {
    $("#inscricao").mask("999.999.999-99");
    $("#inscricao").attr("placeholder", "000.000.000-00");
  } else {
    $("#inscricao").mask("99.999.999/9999-99");
    $("#inscricao").attr("name", "cnpj");
    $("#inscricao").attr("placeholder", "00.000.000/0000-00");
    $("[for=inscricao]").html("CNPJ:");
  }

  $("[name=tipo_cliente]").change(function () {
    var Val = $(this).val();
    // console.log(Val);
    if (Val == "fisico") {
      $("#inscricao").mask("999.999.999-99");
      $("#inscricao").attr("name", "cpf");
      $("#inscricao").attr("placeholder", "000.000.000-00");
      $("[for=inscricao]").html("CPF:");
    } else if (Val == "juridico") {
      $("#inscricao").mask("99.999.999/9999-99");
      $("#inscricao").attr("name", "cnpj");
      $("#inscricao").attr("placeholder", "00.000.000/0000-00");
      $("[for=inscricao]").html("CNPJ:");
    }
  });

  $("[name=parcelas],[name=intervalo]").mask("99");
  $("[name=parcelas],[name=intervalo]").attr("placeholder", "01");
  $("[mask=brl]").attr("placeholder", "R$ 0,00");
  $("[mask=brl]").maskMoney({
    prefix: "R$ ",
    allowNegative: true,
    thousands: ".",
    decimal: ",",
    affixesStay: false,
  });
  $("input.datepicker").Zebra_DatePicker();
});
