<?php
require('menuLog.php');
if (isset($_GET['error']) && $_GET['error'] == '1') {
  echo '<div class="alert alert-warning alert-dismissible fade show mx-auto" role="alert" style="width: 1080px; margin-top: 20px;">' . 
'donnees incorrectes :Verifier votre login ou mot de pass' . 
'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <style>
    body {
      background: url('images/image4.webp') no-repeat center center fixed;
      background-size: cover;
      transition: filter 0.5s ease; /* Transition pour le flou */
    }
    .card {
      background-color: rgba(255, 255, 255, 0.2); /* Fond semi-transparent */
      border: none;
      border-radius: 20px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease; /* Transition pour la transformation */
    }
    .card-header,
    .card-body {
      background-color: transparent; /* Fond transparent */
    }
    .card-header {
      border-radius: 20px 20px 0 0;
      text-align: center;
      padding: 30px 0;
    }
    .card-title {
      font-size: 36px;
      font-weight: bold;
      color: #fd7e14; /* Couleur du texte */
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Ombre du texte */
    }
    .card-body {
      padding: 40px;
      transform: translateY(0); /* Initial translation */
      transition: transform 0.3s ease; /* Transition pour la transformation */
    }
    .form-control {
      border: 1px solid rgba(0, 0, 0, 0.5); /* Bordure semi-transparente */
      border-radius: 5px;
      background-color: rgba(255, 255, 255, 0.1); /* Fond semi-transparent */
      color: #000; /* Couleur du texte */
    }
    .form-control:focus {
      border-color: rgba(0, 0, 0, 0.7); /* Bordure semi-transparente lors du focus */
      background-color: rgba(255, 255, 255, 0.4); /* Fond semi-transparent lors du focus */
    }
    .btn-primary {
      background-color: #fd7e14; /* Orange */
      border: none;
      border-radius: 5px;
      padding: 12px 24px;
      font-weight: bold;
      text-transform: uppercase;
      letter-spacing: 1px; /* Espacement entre les lettres */
      transition: background-color 0.3s ease; /* Transition pour la couleur de fond */
    }
    .btn-primary:hover {
      background-color: #faa77f; /* Orange plus clair au survol */
    }
    .form-label {
      color: #000; /* Noir */
      font-weight: bold;
      font-size: 16px;
      transition: color 0.3s ease; /* Transition pour la couleur du texte */
    }
    .form-group:hover .form-label {
      color: #000; /* Bleu au survol du groupe de formulaire */
    }
    .card:hover .card-body {
      transform: translateY(-10px); /* Translation vers le haut au survol */
    }
  </style>
</head>
<body>

  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Login</h3>
          </div>
          <div class="card-body">
            <form action="loginAdmin.php" method="POST">
              <div class="form-group">
                <label for="username" class="form-label">Email</label>
                <input type="text" name="username" id="username" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
              </div>
              <div class="form-group">
                <div class="form-check">
                  <input type="checkbox" class="form-check-input" id="showPasswordCheckbox" onclick="showPassword()">
                  <label class="form-check-label" for="showPasswordCheckbox">Show Password</label>
                </div>
              </div>
              <button type="submit" name="submit" class="btn btn-primary btn-block">Login</button>
             
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>
  
  <script>
    function showPassword() {
      var passwordField = document.getElementById("password");
      if (passwordField.type === "password") {
        passwordField.type = "text";
      } else {
        passwordField.type = "password";
      }
    }
  </script>
  
  </body>
</html>