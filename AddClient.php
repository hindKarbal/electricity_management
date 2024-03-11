<?php
require('ConnectionDB.php');
require('menuAdmin.php');


if (isset($_POST["submit"])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $tel = $_POST['Tel'];
    $date = $_POST['date'];
    $CIN = $_POST['CIN'];
    $adress = $_POST['adresse'];
    $gender = $_POST['gender'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $prefix= $_POST['prefix'];

    try {
        // Vérifier si l'email existe déjà
        $stmt_check_email = $conn->prepare("SELECT * FROM client WHERE email = :email");
        $stmt_check_email->bindParam(':email', $email);
        $stmt_check_email->execute();
        $existing_user = $stmt_check_email->fetch(PDO::FETCH_ASSOC);

        if ($existing_user) {
            // Afficher un message d'erreur si l'email existe déjà
            echo "Email already exists";
        } else {
            // Insérer les données si l'email n'existe pas déjà
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO client (nom, prenom, email, Tel, prefix , date, CIN, gender, password ,adresse) 
                    VALUES (:first_name, :last_name, :email, :Tel,:prefix,:date, :CIN, :gender, :password , :adress)";

            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':first_name', $first_name);
            $stmt->bindParam(':last_name', $last_name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':Tel', $tel);
            $stmt->bindParam(':prefix', $prefix);
            $stmt->bindParam(':date', $date);
            $stmt->bindParam(':CIN', $CIN);
            $stmt->bindParam(':adress', $adress);
            $stmt->bindParam(':gender', $gender);
            $stmt->bindParam(':password', $hashed_password);

            $stmt->execute();

            header("Location: AllClient.php?msg=New record created successfully");
            exit();
        }
    } catch(PDOException $e) {
        echo "Failed: " . $e->getMessage();
    }
}
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

   <title>Add New Client</title>
   <style>
      body {
         background-color: #f8f9fa; /* Gris clair */
      }

      form {
         width: 50vw;
         min-width: 300px;
         background-color: rgba(255, 255, 255, 0.7); /* Blanc transparent */
         border-radius: 10px;
         padding: 20px;
         box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
      }

      label {
         color: #212529; /* Noir */
         font-weight:bold;
      }

      .form-control {
         background-color: #fff; /* Blanc */
         border-color: #ced4da; /* Bleu marine clair */
      }

      .btn-success {
         background-color: #ffc107; /* Orange */
         border-color: #ffc107; /* Orange */
      }

      .btn-danger {
         background-color: #dc3545; /* Rouge */
         border-color: #dc3545; /* Rouge */
      }

      .btn-success:hover, .btn-danger:hover {
         background-color: #ffa000; /* Orange foncé pour hover */
        
      }
      h3{
       
        color: #060B32; /* Noir */
      margin-top:30px;
      margin-bottom: 20px;
      font-size: 36px; /* Taille de la police */
      text-align: center; /* Centrer le texte */
      text-transform: uppercase; /* Mettre en majuscules */
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3); /* Ombre portée */
      }
      .btn-save {
         background-color: #060B32 !important; /* Orange */
         color:white;
        
      }

      .btn-save:hover {
         background-color: #060B32 !important; /* Orange foncé pour hover */
         border-color: #060B32 !important; /* Orange foncé pour hover */
         color:white;
         padding-right:10px;
      }
      .select-wrapper {
   margin-bottom: 1rem; /* Espacement en bas */
}


.select-wrapper {
   margin-bottom: 1rem; /* Espacement en bas */
}

.select-wrapper .form-control,
.select-wrapper .form-select {
   display: inline-block;
   vertical-align: middle;
   width: calc(50% - 5px); /* 50% de la largeur moins un peu d'espace */
}

.select-wrapper .form-control {
   border-top-right-radius: 0; /* Retirer le coin arrondi supérieur droit */
   border-bottom-right-radius: 0; /* Retirer le coin arrondi inférieur droit */
}

.select-wrapper .form-select {
   border-top-left-radius: 0; /* Retirer le coin arrondi supérieur gauche */
   border-bottom-left-radius: 0; /* Retirer le coin arrondi inférieur gauche */
   background-color: #ffc107; /* Couleur d'arrière-plan orange */
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

.form-control {
    border-color: #ced4da; /* Couleur de la bordure */
}



   </style>
   
</head>

<body>
  

   <div class="container">
    
      <div class="text-center mb-4">
         <h3>Add New User</h3>
         <p class="text-muted">Complete the form below to add a new user</p>
      </div>

      <div class="container d-flex justify-content-center ">
      <form action="" method="post" style="width:50vw; min-width:300px;">
    <div class="row mb-3">
        <div class="col">
            <label class="form-label">First Name:</label>
            <input type="text" class="form-control" name="first_name" placeholder="Albert" required>
        </div>

        <div class="col">
            <label class="form-label">Last Name:</label>
            <input type="text" class="form-control" name="last_name" placeholder="Einstein" required>
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Email:</label>
        <input type="email" class="form-control" name="email" placeholder="name@example.com" required>
    </div>
    <div class="mb-3">
    
        <label class="form-label">Tél:</label>
        <div class="input-group" >
        <div class="select-wrapper">
            <select class="form-select" name="prefix" required>
                  <option value="+212">+212 (Morocco)</option>
                   <option value="+1">+1 (USA)</option>
                   <option value="+44">+44 (UK)</option>
                   <option value="+33">+33 (France)</option>
                   <option value="+49">+49 (Germany)</option>
                   <option value="+86">+86 (China)</option>
                   <option value="+81">+81 (Japan)</option>
                   <option value="+91">+91 (India)</option>
                   <option value="+7">+7 (Russia)</option>
                   <option value="+61">+61 (Australia)</option>
                   <option value="+971">+971 (United Arab Emirates)</option>
                   <option value="+966">+966 (Saudi Arabia)</option>
            </div>
                <!-- Ajoutez d'autres options selon vos besoins -->
            </select>
            <input type="tel" class="form-control" name="Tel" placeholder="Votre numéro de téléphone" pattern="[0-9]{1,15}" maxlength="15"  required>
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label">Date:</label>
        <input type="date" class="form-control" name="date" id="date1" placeholder="la date" required>
    </div>
    <div class="mb-3">
        <label class="form-label">CIN:</label>
        <input type="text" class="form-control" name="CIN" placeholder="entrer votre CIN" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Adress:</label>
        <input type="text" class="form-control" name="adresse" placeholder="entrer l'adresse" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Password:</label>
        <input type="password" class="form-control" name="password" placeholder="entrer le mot de passe" required>
    </div>

    <div class="form-group mb-3">
        <label>Gender:</label>
        
        <div class="d-flex flex-wrap"> <!-- Flexbox pour espacer les boutons radios -->
                    <div class="form-check me-4"> <!-- Espacement à droite pour le premier bouton radio -->
                        <input type="radio" class="form-check-input" name="gender" id="male" value="male" checked="checked">
                        <label for="male" class="form-input-label">Male</label>
                    </div>
                    <div class="form-check"> <!-- Espacement à droite pour le deuxième bouton radio -->
                        <input type="radio" class="form-check-input" name="gender" id="female" value="female">
                        <label for="female" class="form-input-label">Female</label>
                    </div>
                </div>
    </div>

    <div>
        <button type="submit" class="btn btn-save" name="submit">Save</button>
        <button type="reset" class="btn btn-danger" name="submit">Cancel</button>
    </div>
</form>

      </div>
   </div>

   <!-- Bootstrap -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
   <script>
    // Obtenez la date système
    var today = new Date();
    var year = today.getFullYear();
    var month = today.getMonth() + 1; // Les mois commencent à partir de zéro, donc on ajoute 1
    var day = today.getDate();
    
    // Formattez la date système dans le format YYYY-MM-DD pour la comparaison avec la date sélectionnée
    var formattedDate = year + '-' + (month < 10 ? '0' : '') + month + '-' + (day < 10 ? '0' : '') + day;

    // Définissez la valeur maximale de l'input date sur la date système
    document.getElementById('date1').setAttribute('max', formattedDate);
</script>
</body>

</html>