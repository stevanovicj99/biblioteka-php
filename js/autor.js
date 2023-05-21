$("#dodajForm").submit(function (event) {
  event.preventDefault();
  console.log("Dodavanje novog autora");
  const $form = $(this);
  const $input = $form.find("input, button");
  const serijalizacija = $form.serialize();
  console.log(serijalizacija);

  $input.prop("disabled", true);

  req = $.ajax({
    url: "controller/addAutor.php",
    type: "post",
    data: serijalizacija,
  });

  req.done(function (res, textStatus, jqXHR) {
    if (res == "Success") {
      alert("Autor je uspesno dodat!");
      console.log("Dodat je novi autor!");
      location.reload(true);
    } else {
      console.log("Autor nije dodat " + res);
      alert("Neuspešno dodavanje autora!");
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

$(".btnIzmeni").click(function () {
  const idEl = $(this).attr("id");
  const id = idEl.split("_")[1];
  const autor = autori.filter(function (autor) {
    return autor["id"] === id;
  })[0];

  $("#id").val(autor["id"]);
  $("#firstName").val(autor["ime"]);
  $("#lastName").val(autor["prezime"]);
  $("#bDay").val(autor["datumRodjenja"]);

  $("#updateAutorModal").modal("toggle");
  return false;
});

$(".btnObrisi").click(function () {
  console.log("Brisanje autora");

  const id = $(this).attr("id");
  req = $.ajax({
    url: "controller/deleteAutor.php",
    type: "post",
    data: { id: id },
  });

  req.done(function (res, textStatus, jqXHR) {
    console.log("res", res);
    if (res == "Success") {
      $("#tr_" + id).remove();
      alert("Obrisan autor");
      console.log("Obrisano");
    } else {
      console.log("Autor nije obrisan " + res);
      alert("Autor nije obrisan ");
    }
    console.log(res);
  });
});

$("#azurirajForm").submit(function (event) {
  event.preventDefault();
  console.log("Dodavanje novog autora");
  const $form = $(this);
  var disabled = $form.find(":input:disabled").removeAttr("disabled");
  const $input = $form.find("input, button");
  const serijalizacija = $form.serialize();
  disabled.attr("disabled", "disabled");

  $input.prop("disabled", true);

  req = $.ajax({
    url: "controller/updateAutor.php",
    type: "post",
    data: serijalizacija,
  });

  req.done(function (res, textStatus, jqXHR) {
    if (res == "Success") {
      alert("Autor je uspesno azuriran!");
      console.log("Azuriran je autor!");
      location.reload(true);
    } else {
      console.log("Autor nije azuriran " + res);
      alert("Neuspešno azuriranje autora!");
    }
    console.log(res);
  });

  req.fail(function (jqXHR, textStatus, errorThrown) {
    console.error("Greška! " + textStatus, errorThrown);
  });
});

$("#search-input").on("keyup", function (event) {
  var searchParam = $(this).val();

  autori.forEach((autor) => {
    if (
      !autor.ime.toLowerCase().includes(searchParam.toLowerCase()) &&
      !autor.prezime.toLowerCase().includes(searchParam.toLowerCase())
    ) {
      $("#tr_" + autor.id).hide();
    } else {
      $("#tr_" + autor.id).show();
    }
  });
});

$(".btnPrikazi").click(function () {
  const idEl = $(this).attr("id");
  const id = idEl.split("_")[1];
  const autor = autori.filter(function (autor) {
    return autor["id"] === id;
  })[0];

  $("#idPrikaz").val(autor["id"]);
  $("#firstNamePrikaz").val(autor["ime"]);
  $("#lastNamePrikaz").val(autor["prezime"]);
  $("#bDayPrikaz").val(autor["datumRodjenja"]);

  $("#prikazModalAutor").modal("toggle");
  return false;
});

$("#sort-btn").click(function (event) {
  var rows = document.getElementById("autori-table").rows;
  for (var i = 1; i < rows.length - 1; i++) {
    for (var j = i + 1; j < rows.length; j++) {
      var x = rows[i].getElementsByTagName("td")[2];
      var y = rows[j].getElementsByTagName("td")[2];
      if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
        rows[i].parentNode.insertBefore(rows[j], rows[i]);
      }
    }
  }
});
