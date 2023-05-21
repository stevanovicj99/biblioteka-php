<?php
require "database/dbBroker.php";
require "model/knjiga.php";
require "model/autor.php";

session_start();
if (empty($_SESSION['id'])) {
  header('Location: index.php');
  exit();
}

$result = Knjiga::getAll($connection);
if (!$result) {
  echo "Greska!<br>";
  exit();
}

$autori = Autor::getAllByName($connection);

if (!$autori) {
  echo "Greska!<br>";
  exit();
}

$autoriNiz = [];
while ($red = $autori->fetch_array()) {
  $autoriNiz[] = $red;
}

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Biblioteka</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="css/styleall.css">

</head>

<body>
  <div class="home">
    <nav class="navMenu2">
      <a href="autori.php">Autori</a>
      <a href="knjige.php">Knjige</a>
      <a href="logout.php" id="odjava">Odjavi se</a>
      <div class="dot"></div>
    </nav>
  </div>

  <div class="row">
    <div class="col md-4">
      <div class="input-group search-class" id="search">
        <span class="input-group-text" id="basic-addon1">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="search-icon" viewBox="0 0 16 16">
            <path d="M6.5 13a6.474 6.474 0 0 0 3.845-1.258h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.008 1.008 0 0 0-.115-.1A6.471 6.471 0 0 0 13 6.5 6.502 6.502 0 0 0 6.5 0a6.5 6.5 0 1 0 0 13Zm0-8.518c1.664-1.673 5.825 1.254 0 5.018-5.825-3.764-1.664-6.69 0-5.018Z" />
          </svg>
        </span>
        <input type="text" class="form-control" id="search-input" placeholder="Pretraži" aria-label="search" aria-describedby="basic-addon1">
      </div>
    </div>
    <div class="col md-4">
      <button type="button" class="btn btn-warning sort-btn" id="sort-btn"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-alpha-down" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M10.082 5.629 9.664 7H8.598l1.789-5.332h1.234L13.402 7h-1.12l-.419-1.371h-1.781zm1.57-.785L11 2.687h-.047l-.652 2.157h1.351z" />
          <path d="M12.96 14H9.028v-.691l2.579-3.72v-.054H9.098v-.867h3.785v.691l-2.567 3.72v.054h2.645V14zM4.5 2.5a.5.5 0 0 0-1 0v9.793l-1.146-1.147a.5.5 0 0 0-.708.708l2 1.999.007.007a.497.497 0 0 0 .7-.006l2-2a.5.5 0 0 0-.707-.708L4.5 12.293V2.5z" />
        </svg></button>
    </div>
    <div class="col md-4">
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop" id="nova">Nova knjiga</button>
    </div>
  </div>



  <table class="table table-hover" id="knjige-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Naziv</th>
        <th>Datum izdavanja</th>
        <th>Autor</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php
      $knjige = [];
      while ($red = $result->fetch_array()) {
        $knjige[] = $red;
      ?>
        <tr id="tr_<?php echo $red['id'] ?>">
          <td><?php echo $red["id"] ?></td>
          <td><?php echo $red["naziv"] ?></td>
          <td><?php echo $red["datumIzdavanja"] ?></td>
          <td><?php echo $red["autor"] ?></td>
          <td>
            <a href="#" class="btnIzmeni" id="izmeni_<?php echo $red['id'] ?>"><i class="fa-solid fa-pencil"></i></a>
            <a href="#" class="btnObrisi" id="<?php echo $red['id'] ?>"><i class="fa-solid fa-trash"></i></a>
            <a href="#" class="btnPrikazi" id="prikaz_<?php echo $red['id'] ?>"><i class="fa-solid fa-eye"></i></a>
          </td>
        </tr>
      <?php
      }
      ?>
    </tbody>

  </table>


  <!-- Modal -->
  <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Kreiranje nove knjige</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form class="row g-3" action="#" method="post" id="dodajForm">

            <fieldset disabled>
              <div class="col-md-4">
                <label for="validationCustom01" class="form-label">ID:</label>
                <input type="text" class="form-control" id="validationCustom01" value="" required>
              </div>
            </fieldset>
            <div class="col-md-4">
              <label for="validationCustom02" class="form-label">Naziv:</label>
              <input type="text" name="naziv" class="form-control" id="validationCustom02" placeholder="Unesi naziv" required>
            </div>

            <div class="col-md-4">
              <label for="validationCustom03" class="form-label">Datum izdavanja:</label>
              <input type="date" name="datumIzdavanja" class="form-control" id="validationCustom03" placeholder="" required>
            </div>

            <div class="col-md-4">
              <label for="validationCustom04" class="form-label">Autor:</label>
              <select class="form-select" name="autor" aria-label="Default select example">
                <option selected>Izaberi autora</option>
                <?php
                foreach ($autoriNiz as $autor) :
                ?>
                  <option value="<?php echo $autor['id'] ?>"><?php echo $autor["autorImePrezime"] ?></option>
                <?php endforeach;   ?>
              </select>
            </div>
            <div class="modal-footer">
              <button class="btn btn-primary" id="btnDodaj" type="submit">Sačuvaj</button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>

  <!--update knjiga-->
  <div class="modal fade" id="updateKnjigaModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Ažuriranje knjige</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form class="row g-3" action="#" method="post" id="azurirajForm">

            <!-- <fieldset disabled> -->
            <div class="col-md-4">
              <label for="id" class="form-label">ID:</label>
              <input type="text" class="form-control" name="id" id="id" required disabled>
            </div>
            <!-- </fieldset> -->
            <div class="col-md-4">
              <label for="naziv" class="form-label">Naziv:</label>
              <input type="text" name="naziv" class="form-control" id="name" placeholder="Unesi naziv" required>
            </div>

            <div class="col-md-4">
              <label for="datumIzdavanja" class="form-label">Datum izdavanja:</label>
              <input type="date" name="datumIzdavanja" class="form-control" id="date" placeholder="" required>
            </div>

            <div class="col-md-4">
              <label for="autor" class="form-label">Autor:</label>
              <select class="form-select" name="autor" aria-label="Default select example" id="author">
                <option selected>Izaberi autora</option>
                <?php
                foreach ($autoriNiz as $autor) :
                ?>
                  <option value="<?php echo $autor['id'] ?>"><?php echo $autor["autorImePrezime"] ?></option>
                <?php endforeach;   ?>
              </select>
            </div>
            <div class="modal-footer">
              <button class="btn btn-primary" id="btnAzuriraj" type="submit">Sačuvaj</button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>


  <!--prikaz knjiga-->
  <div class="modal fade" id="prikazKnjigaModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Prikaz knjige</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form class="row g-3" action="#" method="post" id="prikazForm">

            <!-- <fieldset disabled> -->
            <div class="col-md-4">
              <label for="id" class="form-label">ID:</label>
              <input type="text" class="form-control" name="id" id="prikazId" required disabled>
            </div>
            <!-- </fieldset> -->
            <div class="col-md-4">
              <label for="naziv" class="form-label">Naziv:</label>
              <input type="text" name="naziv" class="form-control" id="prikazName" placeholder="Unesi naziv" required disabled>
            </div>

            <div class="col-md-4">
              <label for="datumIzdavanja" class="form-label">Datum izdavanja:</label>
              <input type="date" name="datumIzdavanja" class="form-control" id="prikazDate" placeholder="" required disabled>
            </div>

            <div class="col-md-4">
              <label for="autor" class="form-label">Autor:</label>
              <select class="form-select" name="autor" aria-label="Default select example" id="prikazAuthor" disabled>
                <option selected>Izaberi autora</option>
                <?php
                foreach ($autoriNiz as $autor) :
                ?>
                  <option value="<?php echo $autor['id'] ?>"><?php echo $autor["autorImePrezime"] ?></option>
                <?php endforeach;   ?>
              </select>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/8dc9a798ed.js" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script>
    var knjige = <?php echo json_encode($knjige); ?>;
  </script>
  <script src="js/knjiga.js"></script>
</body>

</html>