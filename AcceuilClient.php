<?php
require("ConnectionDB.php");
require('menuClient.php');

if (isset($_SESSION["id"])) {
    $id = $_SESSION["id"];

    // Récupérer les données de session
    $first_name = isset($_SESSION['nom']) ? $_SESSION['nom'] : '';
    $last_name = isset($_SESSION['prenom']) ? $_SESSION['prenom'] : '';
    $email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
    $tel = isset($_SESSION['Tel']) ? $_SESSION['Tel'] : '';
    $date = isset($_SESSION['date']) ? $_SESSION['date'] : '';
    $CIN = isset($_SESSION['CIN']) ? $_SESSION['CIN'] : '';
    $gender = isset($_SESSION['gender']) ? $_SESSION['gender'] : '';
    $adresse = isset($_SESSION['adresse']) ? $_SESSION['adresse'] : '';
    $prefix = isset($_SESSION['prefix']) ? $_SESSION['prefix'] : '';
} else {
    
    exit(); // Arrêter l'exécution si l'ID n'est pas trouvé
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile</title>
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <style>
   body {
      background-color: #f8f9fa; /* Gris clair */
    }

    form {
      width: 50vw;
      min-width: 300px;
      background-color: rgba(255, 255, 255, 0.9); /* Blanc transparent */
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
    }

    form:hover {
      transform: translateY(-5px);
      box-shadow: 0px 0px 30px rgba(0, 0, 0, 0.2);
    }

    label {
      color: #212529; /* Noir */
      font-weight: bold;
    }

    .form-control {
      background-color: #fff; /* Blanc */
      border-color: #ced4da; /* Couleur de la bordure */
      cursor: not-allowed; /* Curseur non autorisé */
      transition: all 0.3s ease;
    }

    .form-control:focus {
      box-shadow: none; /* Pas d'ombre au focus */
    }

    .form-control[readonly] {
      cursor: default; /* Curseur par défaut */
    }

    .btn-success {
      background-color: #28a745; /* Vert */
      border-color: #28a745; /* Vert */
    }

    .btn-danger {
      background-color: #dc3545; /* Rouge */
      border-color: #dc3545; /* Rouge */
    }

    .btn-success:hover,
    .btn-danger:hover {
      filter: brightness(90%); /* Légère réduction de luminosité au survol */
    }

    h3 {
      color: #060B32; /* Noir */
      margin-top: 30px;
      margin-bottom: 20px;
      font-size: 36px; /* Taille de la police */
      text-align: center; /* Centrer le texte */
      text-transform: uppercase; /* Mettre en majuscules */
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3); /* Ombre portée */
    }

    .btn-save {
      background-color: #ffa000 !important; /* Orange */
      border-color: #ffa000 !important; /* Orange */
      color: white;
    }

    .btn-save:hover {
      background-color: #ffa000 !important; /* Orange foncé pour hover */
      border-color: #ffa000 !important; /* Orange foncé pour hover */
      color: white;
    }

    .container {
      margin-top: 50px; /* Espacement depuis le haut */
    }

    .form-container {
      background-color: #f9f9f9; /* Couleur de fond gris clair */
      border-radius: 10px; /* Coins arrondis */
      padding: 30px; /* Espacement interne */
      box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1); /* Ombre portée */
    }

    .form-title {
      text-align: center; /* Centrer le titre */
      margin-bottom: 30px; /* Espacement depuis le bas */
      font-size: 24px; /* Taille de la police */
      color: #333; /* Couleur de texte */
    }

    .form-label {
      color: #333; /* Couleur de texte */
    }

    /* Ajustement des boutons radio */
    .form-check-input {
      margin-right: 20px; /* Espacement entre les boutons */
      width: 20px; /* Largeur */
      height: 20px; /* Hauteur */
      opacity: 1; /* Opacité */
      transition: transform 0.3s ease; /* Animation de transformation */
    }

    .form-check-input:hover {
      transform: scale(1.2); /* Zoom au survol */
    }

    /* Effet dynamique sur les paragraphes */
    p {
      color: #ffa000; /* Couleur de texte orange */
      font-weight: bold; /* Police en gras */
      transition: color 0.3s ease; /* Animation de changement de couleur */
    }

    p:hover {
      color: #ff5722; /* Changement de couleur au survol */
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="text-center mb-4">
      <h3>Welcome to Electricity Provide, your go-to platform for efficient electricity bill management!</h3>
      <p> Here is Your Personal Information</p>
    </div>

    <div class="container d-flex justify-content-center">
      <form action="" method="post" style="width:50vw; min-width:300px;">
        <div class="row mb-3">
          <div class="col">
            <label class="form-label">Full Name:</label>
            <input type="text" class="form-control" name="first_name" value="<?= $first_name . " " . $last_name ?>" readonly>
          </div>
          <div class="mb-3">
            <label class="form-label">Email:</label>
            <input type="email" class="form-control" name="email" value="<?= $email ?>" readonly>
          </div>
          <div class="mb-3">
            <label class="form-label">Tél:</label>
            <input type="Tel" class="form-control" name="Tel"   value="<?= $prefix . " " . $tel ?>" readonly>
          </div>
          <div class="mb-3">
            <label class="form-label">Date:</label>
            <input type="date" class="form-control" name="date"  value="<?= $date ?>" readonly>
          </div>
          <div class="mb-3">
            <label class="form-label">CIN:</label>
            <input type="text" class="form-control" name="CIN"  value="<?= $CIN ?>" readonly>
          </div>
          <div class="mb-3">
            <label class="form-label">Address:</label>
            <input type="text" class="form-control" name="adresse"  value="<?= $adresse ?>" readonly>
          </div>
          <div class="mb-3">
            <label class="form-label">Gender:</label>
            <input type="text" class="form-control" name="gender"  value="<?= $gender ?>" readonly>
          </div>
          
        </div>
      </form>
    </div>
  </div>
  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>



