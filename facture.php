<?php
require("ConnectionDB.php");
require("menuClient.php");

$id = $_SESSION['id'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <title>Facture</title>
  <style>
    body {
      background-color: #fafafa; /* Gris plus foncé */
    }

    .navbar {
      background-color: #060B32; /* Noir */
    }

    .navbar-brand {
      color: #ffac4b; /* Orange */
      font-weight: bold;
    }

    .navbar-nav .nav-link {
      color: #dee2e6; /* Gris */
    }

    .container {
      margin-top: 50px; /* Marge en haut pour la carte */
      background-color: #808080; /* Transparent */
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.5); /* Ombre plus prononcée */
    }
    .container:hover {
      transform: scale(1.02); /* Augmentation de l'échelle au survol */
      box-shadow: 0px 0px 30px rgba(0, 0, 0, 0.5); /* Ombre plus prononcée */
    }

    .btn-add {
  background-color: #ffac4b;
  border-color: #ffac4b;
  color: #fff;
  padding: 10px 20px;
  border-radius: 25px;
}


    .btn-add:hover {
      background-color: #ffac4b; /* Orange */
      border-color: #ffac4b; /* Orange */
      transform: scale(1.05); /* Augmentation de l'échelle au survol */
      box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.5); /* Ombre plus prononcée */
     
    }

    .btn-edit {
      color: #28a745; /* Vert */
    }

    .btn-delete {
      color:  #060B32; /* Rouge */
    }

    /* Style pour l'en-tête du tableau */
    .table-dark thead th {
      background-color: #060B32; /* Noir */
      color: #fff; /* Blanc */
      border-color: #000; /* Noir */
      font-weight: bold;
      text-transform: uppercase;
    }
    .search-container {
  margin-top: 20px; /* Espace en haut */
  margin-bottom: 20px; /* Espace en bas */
  position: relative; /* Position relative pour que le bouton puisse être positionné par rapport à ce conteneur */
  text-align: center; /* Centrer le contenu */
  justify-content: space-between;

}



#searchInput:focus {
  background-color: #fafafa; /* Couleur de fond lorsqu'elle est en focus */
}

/* Style du bouton de recherche */
#searchButton {
  background-color: #007bff; /* Couleur de fond du bouton */
  color: white; /* Couleur du texte du bouton */
  border: none; /* Suppression de la bordure */
  padding: 12px 20px; /* Espace à l'intérieur du bouton */
  border-radius: 25px; /* Coins arrondis du bouton */
  cursor: pointer; /* Curseur pointeur */
}

/* Style du bouton de recherche au survol */
#searchButton:hover {
  background-color: #0056b3; /* Couleur de fond du bouton au survol */
}

.search-wrapper {
  position: relative;
}

  .hidden {
  display: none;
}
#mytable{
  display: none;
}
.search-image {
  position: absolute;
  right: 40px; /* Positionnement à droite de l'input */
  top: 50%;
  transform: translateY(-50%);
  width: 20px; /* Taille de l'image */
  height: 20px;
}

    /* Style pour le titre */
  

    /* Style pour la section de statistiques */
    .statistics {
      background-color: #ffac4b; /* Orange */
      color: #060B32; /* Noir */
      padding: 10px;
      border-radius: 10px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2); /* Ombre légère */
      max-width: 250px; /* Largeur maximale */
      text-align:center;
      margin-top: 20px; /* Marge en haut */
    }
    
    h1 {
      color: #060B32; /* Noir */
      margin-top:30px;
      margin-bottom: 20px;
      font-size: 36px; /* Taille de la police */
      text-align: center; /* Centrer le texte */
      text-transform: uppercase; /* Mettre en majuscules */
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3); /* Ombre portée */
    }
    .statistics:hover {
      transform: scale(1.05); /* Augmentation de l'échelle au survol */
      box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.5); /* Ombre plus prononcée */
    }
    tr {
    background-color: white;
}



.search-container {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

#searchInput {
  width: 300px;
  padding: 12px;
  border: none;
  border-radius: 25px;
  font-size: 16px;
  background-color: #303030;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  outline: none;
  margin-right: 10px; /* Espacement entre l'input et l'image */
}

.search-wrapper {
  position: relative;
}



.btn-add {
  background-color: #ffac4b;
  border-color: #ffac4b;
  color: #fff;
  padding: 10px 20px;
  border-radius: 25px;
  text-decoration: none;
}
  </style>
</head>

<body>
  <h1>Your invoices</h1> 

  <div class="container">
    <?php
    if (isset($_GET["msg"])) {
      $msg = $_GET["msg"];
      echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
      ' . $msg . '
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
    ?>
   <div class="search-container">
   <div class="search-wrapper">
  <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Search for names...">
  <img src="images/seo.png" class="search-image" alt="Search Image">
   </div>
     <a  class="btn btn-add mb-3">View your invoices</a> 
  </div>


    <table class="table table-hover text-center" id="myTable">
      <thead class="table-dark">
        <?php
  try {
    $stmt = $conn->prepare("SELECT facture.id_facture, facture.etat AS facture_etat,facture.pdf, consomation.date, facture.prix_TTC, consomation.etat AS consomation_etat, consomation.quantite
        FROM facture 
        INNER JOIN consomation ON facture.id_consomation = consomation.id_c 
        WHERE facture.id_client =$id");
    $stmt->execute();
    $clients = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
        <tr>
          <th scope="col">Bill Number</th>
          <th scope="col">Date</th>
          <th scope="col">Consumption</th>
          <th scope="col">Price</th>
          <th scope="col">State</th>
          <th scope="col">Pdf</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($clients as $row): ?>
          <tr>
            <td><?= $row["id_facture"] ?></td>
            <td><?= $row["date"] ?></td>
            <td><?= $row["quantite"] ?></td>
            <td><?= $row["prix_TTC"] ?></td>
            <td><?= $row["facture_etat"] ?></td>
            <td>
                    <?php if ($row["consomation_etat"] === 'valide'): ?>
                        <a href="telecharger.php?id=<?= $row["id_facture"] ?>">Télécharger PDF</a>
                    <?php elseif ($row["consomation_etat"] === 'en attente'): ?>
                        <?= $row["pdf"] ?>
                    <?php endif; ?>
                </td>

            
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    
  </div>

  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  <script>


function filterTable() {
  var input, filter, table, tr, td, th, i, j, txtValue, visibleRows;
  input = document.getElementById("searchInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  th = table.getElementsByTagName("th"); // Get the table header elements
  visibleRows = 0; // Initialize the counter for visible rows

  // Loop through all table rows, and hide those that don't match the search query
  for (i = 1; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td");
    var matchFound = false;
    for (j = 0; j < td.length; j++) {
      txtValue = td[j].textContent || td[j].innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        matchFound = true;
        break;
      }
    }

    if (matchFound) {
      // Increment the counter if a match is found
      visibleRows++;
      // Show the row
      tr[i].style.display = "";
    } else {
      // Hide the row if no match is found
      tr[i].style.display = "none";
    }
  }

  // Show or hide the header based on the number of visible rows
 

  // Show the table if there are visible rows, otherwise hide it
  table.style.display = (visibleRows > 0) ? "" : "none";
}

</script>
</body>

</html>
