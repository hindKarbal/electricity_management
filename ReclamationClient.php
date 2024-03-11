<?php
require('ConnectionDB.php');
require('menuClient.php');


$id = $_SESSION['id'];
if (isset($_POST["submit"])) {
    $type = $_POST['type'];
    $date = $_POST['month'];
    $autre = $_POST['autre'];
    $numeroFacture = $_POST['numcontrat'];
    $etat = "non traite";
    $message = $_POST['message'];
   
     
        
   
    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $sql = "INSERT INTO Reclamation (id_client, type, autre, date, numcontrat, etat,message) 
        VALUES (:id_client, :type, :autre, :date, :num, :etat,:message)";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':id_client', $id);
$stmt->bindParam(':type', $type);
$stmt->bindParam(':autre', $autre);
$stmt->bindParam(':date', $date);
$stmt->bindParam(':num', $numeroFacture);
$stmt->bindParam(':etat', $etat); // Lier la variable $etat ici
$stmt->bindParam(':message', $message);
$stmt->execute();

echo '<div class="alert alert-success alert-dismissible fade show mx-auto" role="alert" style="width: 1080px; margin-top: 20px;">' . 
'Votre Reclamation a été bien enregistré' . 
'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';

 
       
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <title>Complaints</title>
    <style>
        body {
            background-color: #f8f9fa; /* Gris clair */
        }

        .container {
            background-color: #808080; /* Gris */
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
            transition: transform 0.3s ease-in-out; /* Effet de transition sur le survol */

        }

        .container1 {
            background-color: #808080; /* Gris */
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
            transition: transform 0.3s ease-in-out; /* Effet de transition sur le survol */
            width: 800px;
            margin-left: 280px;
        }

        .container:hover {
            transform: scale(1.02); /* Effet d'agrandissement sur le survol */
        }

        .text-center {
            color: #060B32; /* Noir */
        }

        .form-label {
            color: #212529; /* Noir */
        }

        .form-control {
            background-color: #fff; /* Blanc */
            border-color: #ced4da; /* Bleu marine clair */
        }

        .btn-success {
            background-color: #060B32; /* Orange */
            border-color: #060B32; /* Orange */
            font-size: 1.2rem; /* Taille de police plus grande */
            margin-right: 10px; /* Espacement entre les boutons */
            transition: background-color 0.3s ease; /* Effet de transition sur le changement de couleur */
        }

        .btn-danger {
            background-color: #ff6b6b; /* Rouge clair */
            border-color: #ff6b6b; /* Rouge clair */
            font-size: 1.2rem; /* Taille de police plus grande */
            transition: background-color 0.3s ease; /* Effet de transition sur le changement de couleur */
        }

        .btn-success:hover {
            background-color: #ffa000; /* Orange foncé pour survol */
        }

        .btn-danger:hover {
            background-color: #ff3b3b; /* Rouge foncé pour survol */
        }

        .form-check-input {
            margin-right: 10px; /* Espacement entre les boutons radios */
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

        .text {
            text-align: center;
            color: #000;
            font-weight: bold;
        }

        label {
            font-weight: bold;
        }

    </style>
</head>

<body>
    <h3>Complaints section</h3>
    <p class="text">This page is dedicated for you to voice your complaints</p>
    <div class="container1">
        <div class="text-center mb-4">


        </div>

        <div class="container d-flex justify-content-center">
            <form action="" method="post" style="width:50vw; min-width:300px;" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Type:</label>
                    <select class="form-select custom-select-bg-orange" id="type" name="type"
                        style="background-color: #ffa000;">
                        
                        <option value="fuite interne">internal leak</option>
                        <option value="fuite externe">external leak</option>
                        <option value="facture">invoice</option>
                        <option value="autre">other</option>
                    </select>
                </div>
                
                <div class="mb-3" id="autre" style="display: none;">
                    <label class="form-label">Others:</label>
                    <input type="textarea" class="form-control" name="autre" placeholder=" autre type" >
                </div>
                <div class="mb-3" id="numcontrat" style="display: none;">
                    <label class="form-label">invoice number:</label>
                    <input type="text" class="form-control" name="numcontrat" placeholder=" num contrat" >
                </div>
                <div class="mb-3" id="date" style="display: none;">
                    <label class="form-label">Date:</label>
                    <input type="date" class="form-control"  name="month" id="date1" placeholder="la date factutre" >
                </div>
                <div class="mb-3" id="message" style="display: none;">
                    <label class="form-label">Complaint:</label>
                    <input type="textarea" class="form-control" name="message" placeholder=" enter votre reclmation" >
                </div>
                <div>
                    <button type="submit" class="btn btn-success" name="submit">Complaint</button>
                    <button type="reset" class="btn btn-danger" name="submit">Cancel</button>
                </div>
            </form>
        </div>
    </div>


    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
    // Cache les champs "Numero Contrat", "Date", "Autre" et "Message" au chargement de la page
    var num = document.getElementById("numcontrat");
    var date = document.getElementById("date");
    var autre = document.getElementById("autre");
    var message = document.getElementById("message");

    // Ajoute un écouteur d'événements sur le menu déroulant "Type"
    document.getElementById("type").addEventListener("change", function () {
        // Affiche ou cache les champs en fonction de la sélection dans le menu déroulant
        if (this.value === "facture") {
            num.style.display = "block";
            date.style.display = "block";
            autre.style.display = "none";
        } else if (this.value === "autre") {
            autre.style.display = "block";
            num.style.display = "none";
            date.style.display = "none";
        } else {
            num.style.display = "none";
            date.style.display = "none";
            autre.style.display = "none";
        }

        // Toujours afficher le champ "Message" dans tous les cas
        message.style.display = "block";
    });
});
    </script>
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
