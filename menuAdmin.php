<?php

if (!isset($_SESSION)) {
  session_start(); // Démarrer une session si aucune n'est active
}
  $nom = $_SESSION['nom'];
  $prenom = $_SESSION['prenom'];

  // Le reste de votre code pour afficher les informations de l'utilisateur...


?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    <style>
    
    /* Style du menu de navigation */
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
    }
    .custom-navbar {
      background-color: #060B32; /* Couleur de la barre de navigation */
      box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Ombre légère */
    }
    .navbar-brand {
      color: #ffac4b; /* Orange */
      font-weight: bold;
      font-size: 24px;
    }
    .navbar-brand:hover {
      color: #ffac4b; /* Bleu foncé */
    }
    .navbar-nav .nav-link {
      color: #ffac4b !important; /* Orange */
      font-weight: bold;
      transition: transform 0.3s ease; /* Transition pour l'animation */
    }
    .navbar-nav .nav-link:hover {
      transform: translateY(-3px); /* Animation de déplacement vers le haut */
      color: #0056b3 !important; /* Bleu foncé */
    }
    .navbar-nav .active > .nav-link {
      background-color: transparent; /* Fond transparent */
      color: #ffac4b !important; /* Orange */
    }
    .navbar-nav .nav-item {
      margin-right: 20px; /* Ajout d'espace entre les liens */
    }
    .user-icon {
      background-color: #ffac4b; /* Orange */
      color: #fff; /* Blanc */
      border-radius: 50%; /* Rendre le cercle */
      width: 36px; /* Taille du cercle */
      height: 36px; /* Taille du cercle */
      text-align: center; /* Alignement du texte au centre */
      line-height: 36px; /* Alignement vertical du texte */
      margin-right: 10px; /* Espacement à droite */
      font-size: 18px; /* Taille de la police */
    }
    .user-text {
      color: #ffac4b; /* Orange */
      font-weight: bold;
      font-size: 18px; /* Taille de la police */
      text-transform: uppercase; /* Convertir en majuscules */
      letter-spacing: 1px; /* Espacement entre les lettres */
    }
    span{
        color:#ffac4b;
    }

  </style>

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<span class="user-icon"><?php echo substr($nom, 0, 1) . substr($prenom, 0, 1); ?></span>
  <span class="user-text"><?php echo $nom . " " . $prenom; ?></span>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link active" href="AccueilAdmin.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="AllClient.php">manage customers</a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="ReclamationAdmin.php">Complaints</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="ConsomationAnnuelle.php">Annual consumption</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="anomali.php">Anomaly</a>
      </li>
      <li class="nav-item">
      <a class="nav-link" href="logout.php">Logout</a>
      </li>
    </ul>
  </div>
</nav>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
