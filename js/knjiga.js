$("#dodajForm").submit(function (event) {
  event.preventDefault();
  console.log("Dodavanje nove knjiga");
  const $form = $(this);
  const $input = $form.find("input, button, select");
  const serijalizacija = $form.serialize();
  console.log("serijalizacija", serijalizacija);

  $input.prop("disabled", true);

  req = $.ajax({
    url: "controller/addKnjiga.php",
    type: "post",
    data: serijalizacija,
  });

  req.done(function (res, textStatus, jqXHR) {
    if (res == "Success") {
      alert("Knjiga je uspesno dodata!");
      console.log("Dodata je nova knjiga!");
      location.reload(true);
    } else {
      console.log("Knjiga nije dodata " + res);
      alert("Neuspešno dodavanje knjige!");
    }
    console.log(res);
  });

  req.fail(function (jqXHR, textStatus, errorThrown) {
    console.error("Greška! " + textStatus, errorThrown);
  });
});

$("#btnDodaj").submit(function () {
  $("#staticBackdrop").modal("toggle");
  return false;
});

$(".btnObrisi").click(function () {
  console.log("Brisanje knjiga");

  const id = $(this).attr("id");
  req = $.ajax({
    url: "controller/deleteKnjiga.php",
    type: "post",
    data: { id: id },
  });

  req.done(function (res, textStatus, jqXHR) {
    console.log("res", res);
    if (res == "Success") {
      $("#tr_" + id).remove();
      alert("Obrisana knjga");
      console.log("Obrisano");
    } else {
      console.log("Knjiga nije obrisan " + res);
      alert("Knjiga nije obrisan ");
    }
  });
});

$(".btnIzmeni").click(function () {
  const idEl = $(this).attr("id");
  const id = idEl.split("_")[1];
  const knjiga = knjige.filter(function (knjiga) {
    return knjiga["id"] === id;
  })[0];

  $("#id").val(knjiga["id"]);
  $("#name").val(knjiga["naziv"]);
  $("#date").val(knjiga["datumIzdavanja"]);
  $("#author option").each(function () {
    if ($(this).text() === knjiga["autor"]) {
      $(this).attr("selected", "selected");
    }
  });

  $("#updateKnjigaModal").modal("toggle");
  return false;
});

$("#azurirajForm").submit(function (event) {
  event.preventDefault();
  console.log("Dodavanje nove knjige");
  const $form = $(this);
  var disabled = $form.find(":input:disabled").removeAttr("disabled");
  const $input = $form.find("input, button");
  const serijalizacija = $form.serialize();
  disabled.attr("disabled", "disabled");

  $input.prop("disabled", true);

  req = $.ajax({
    url: "controller/updateKnjiga.php",
    type: "post",
    data: serijalizacija,
  });

  req.done(function (res, textStatus, jqXHR) {
    if (res == "Success") {
      alert("Knjiga je uspesno azurirana!");
      console.log("Knjiga je azurirana!");
      location.reload(true);
    } else {
      console.log("Knjiga nije azurirana " + res);
      alert("Neuspešno azuriranje knjige!");
    }
    console.log(res);
  });

  req.fail(function (jqXHR, textStatus, errorThrown) {
    console.error("Greška! " + textStatus, errorThrown);
  });
});

$("#search-input").on("keyup", function (event) {
  var searchParam = $(this).val();

  knjige.forEach((knjiga) => {
    if (!knjiga.naziv.toLowerCase().includes(searchParam.toLowerCase())) {
      $("#tr_" + knjiga.id).hide();
    } else {
      $("#tr_" + knjiga.id).show();
    }
  });
});

$(".btnPrikazi").click(function () {
  const idEl = $(this).attr("id");
  const id = idEl.split("_")[1];
  const knjiga = knjige.filter(function (knjiga) {
    return knjiga["id"] === id;
  })[0];

  $("#prikazId").val(knjiga["id"]);
  $("#prikazName").val(knjiga["naziv"]);
  $("#prikazDate").val(knjiga["datumIzdavanja"]);

  $("#prikazAuthor option").each(function () {
    if ($(this).text() === knjiga["autor"]) {
      $(this).attr("selected", "selected");
    }
  });

  $("#prikazKnjigaModal").modal("toggle");
  return false;
});

$("#sort-btn").click(function (event) {
  var rows = document.getElementById("knjige-table").rows;
  for (var i = 1; i < rows.length - 1; i++) {
    for (var j = i + 1; j < rows.length; j++) {
      var x = rows[i].getElementsByTagName("td")[1];
      var y = rows[j].getElementsByTagName("td")[1];
      if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
        rows[i].parentNode.insertBefore(rows[j], rows[i]);
      }
    }
  }
});
