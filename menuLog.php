
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Navigation Menu</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="nav.css">
  <style>
    
    /* Style du menu de navigation */
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
    }
    nav {
      background-color: #FFA500; /* Bleu foncé */
      box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Ombre légère */
    }
    .navbar-brand {
      color: #ffac4b; /* Orange */
      font-weight: bold;
      font-size: 24px;
    }
    .navbar-brand:hover {
      color: #FFA500; /* Bleu foncé */
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
  <a class="navbar-brand" href="#"><span>E</span>lectricity<span>P</span>rovider</a> <!-- Remplacez "Electricity Provider" par le nom de votre entreprise -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link active" href="Aceuil.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Aceuil.php">About</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Aceuil.php">Contact</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="LoginAd.php">Login</a>
      </li>
    </ul>
    
  </div>
</nav>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Font Awesome -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>

</body>
</html>



