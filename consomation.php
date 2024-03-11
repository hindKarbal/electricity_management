<?php
require('ConnectionDB.php');
require('menuClient.php');
require('fpdf/fpdf.php');


$id = $_SESSION['id'];

if (isset($_POST["submit"])) {
    $date = $_POST['date'];
    $quantite = $_POST['quantite'];    
    if (isset($_FILES['compteur']) && $_FILES['compteur']['error'] === UPLOAD_ERR_OK) {
        // Lire le contenu du fichier téléchargé
        $compteurContent = file_get_contents($_FILES['compteur']['tmp_name']);
    } else {
        // Gérer l'erreur si aucun fichier n'a été téléchargé
        exit();
    }
    $month = date('m', strtotime($date));
  $year = date('Y', strtotime($date));

// Vérifier si une date avec le même mois et la même année existe déjà dans la base de données
$sql_check_month_year = "SELECT COUNT(*) as count FROM consomation WHERE id_client = :id AND YEAR(date) = :year AND MONTH(date) = :month";
$stmt_check_month_year = $conn->prepare($sql_check_month_year);
$stmt_check_month_year->bindParam(':id', $id);
$stmt_check_month_year->bindParam(':year', $year);
$stmt_check_month_year->bindParam(':month', $month);
$stmt_check_month_year->execute();
$row = $stmt_check_month_year->fetch(PDO::FETCH_ASSOC);

    if ($row['count'] > 0) {
        
        echo '<div class="alert alert-danger alert-dismissible fade show mx-auto" role="alert" style="width: 1080px; margin-top: 20px;">' . 
            'you have already input a consumption of that date ' . 
            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
    }


    else{
    // Récupération de la quantité du mois précédent depuis la base de données
    $previousMonth = date('Y-m', strtotime('-1 month', strtotime($date)));
    $sql_previous_quantity = "SELECT quantite FROM consomation WHERE id_client = :id AND DATE_FORMAT(date, '%Y-%m') = :previousMonth";
    $previous_quantity = 0 ;
    $stmt_previous_quantity = $conn->prepare($sql_previous_quantity);
    $stmt_previous_quantity->bindParam(':id', $id);
    $stmt_previous_quantity->bindParam(':previousMonth', $previousMonth);
    $stmt_previous_quantity->execute();
    $previous_quantity_row = $stmt_previous_quantity->fetch(PDO::FETCH_ASSOC);
    if ($previous_quantity_row !== false) {
        $previous_quantity = $previous_quantity_row['quantite'];
    }
  

    $diff=$quantite-$previous_quantity;
    

    // Vérification des conditions
    if ($quantite < $previous_quantity ) {
        $etat = 'en attente';
        

    } else {
        $etat = 'valide'; // ou tout autre état approprié
    }
    
    // Insertion des données dans la table consommation après vérification
    try {

      

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $sql = "INSERT INTO consomation (id_client, quantite, date, compteur, etat) 
                VALUES (:id_client, :quantite, :date, :compteur, :etat)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':quantite', $quantite);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':id_client', $id);
        $stmt->bindParam(':compteur', $compteurContent, PDO::PARAM_LOB);
        $stmt->bindParam(':etat', $etat);
        $stmt->execute();

        // Si l'état est valide, insérer les données dans la table facture
        if ($etat === 'valide') {
            // Récupérer l'ID de la dernière consommation insérée

            $sql = "SELECT MAX(id_c) AS max_id FROM consomation";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $consomation_id = $row['max_id'];

             // Calculer le prix HT en fonction de la quantité
             if ($diff >= 0 && $diff <= 100) {
                $prix_ht = 0.8 * $diff;
            } elseif ($diff >= 101 && $diff <= 200) {
                $prix_ht = 0.9 * $diff;
            } else {
                $prix_ht = 1 * $diff;
            }
        

            // Calculer le prix TTC
            $prix_ttc = $prix_ht +  0.14 * $prix_ht;
            $etat="non paye";
            // Insérer les données dans la table facture
            $stmt_facture = $conn->prepare("INSERT INTO facture (id_client, prix_HT, prix_TTC, id_consomation,etat,  pdf) 
            VALUES (:id_client, :prix_ht, :prix_ttc, :id_consomation,:etat,  :pdf)");
           $stmt_facture->bindParam(':id_client', $id);
           $stmt_facture->bindParam(':prix_ht', $prix_ht);
           $stmt_facture->bindParam(':prix_ttc', $prix_ttc);
           $stmt_facture->bindParam(':etat', $etat);
           $stmt_facture->bindParam(':id_consomation', $consomation_id);
           $stmt_facture->bindParam(':pdf', $pdf_content, PDO::PARAM_LOB);
           $stmt_facture->execute();
            
            // Générer le PDF
 $pdf = new FPDF('P', 'mm', 'A4'); // 210x297 => 210 - 20 = 190

$pdf->AddPage();


//--------------recuperation des donnes------
$sql = "SELECT 
client.nom, client.prenom, client.prefix, client.Tel, client.email, client.adresse, YEAR(consomation.date) as annee,MONTH(consomation.date) as mois,
consomation.quantite, consomation.compteur,
facture.prix_HT, facture.prix_TTC, facture.id_facture , facture.etat
FROM 
client
INNER JOIN 
consomation ON client.id = consomation.id_client
INNER JOIN 
facture ON consomation.id_c = facture.id_consomation
WHERE 
client.id = :id and consomation.id_c =  :consomation_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->bindParam(':consomation_id', $consomation_id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$date = date('Y-m-d');
$annee = $result['annee'];
$mois = $result['mois'];
$etat = $result['etat'];
// 1ère Ligne

$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(255, 127, 0);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(190, 6, 'Electricity Provider: ',0, 1,'C', true );


// 2ème ligne 

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(35,8, utf8_decode('FACTURE N° :'), 0 , 0);
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(255,0,0);
$pdf->Cell(40,8, utf8_decode($result['id_facture']), 0 , 1);  // Fin de la ligne
$pdf->Ln(7);

// Début de la 3ème ligne
$pdf->SetFont('Arial', 'B', 10); // Changement de la police et de la taille
$pdf->SetTextColor(0,0,0);
$pdf->Cell(60,6, utf8_decode('Tetouan le  '.$date), 0 , 1);
$pdf->SetFont('Arial', '', 12); // Revenir à la police normale
$pdf->SetTextColor(0); // Revenir à la couleur par défaut (noir)
$pdf->Cell(80, 6, '', 0, 0); // Cellule vide
$pdf->Cell(60, 6, '', 0, 1); // Fin de la ligne
// Début de la 4ème ligne
$pdf->SetFont('Arial', 'B', 10); // Changement de la police et de la taille
$pdf->SetTextColor(0, 0, 0); // Changement de la couleur (orange)
$pdf->Cell(50, 6, utf8_decode('93000, Tétouan'), 0, 0); // Cellule avec nouvelle configuration
$pdf->SetFont('Arial', '', 12); // Revenir à la police normale
$pdf->SetTextColor(0); // Revenir à la couleur par défaut (noir)
$pdf->Cell(80, 6, '', 0, 0); // Cellule vide
$pdf->Cell(60, 6, '', 0, 1); // Fin de la ligne

// Début de la 5ème ligne
$pdf->SetFont('Arial', 'B', 10); // Changement de la police et de la taille
$pdf->SetTextColor(0, 0, 0); // Changement de la couleur (orange)
$pdf->Cell(50, 6, utf8_decode('Téléphone :'), 0, 0); // Cellule avec nouvelle configuration
$pdf->SetFont('Arial', '', 12); // Revenir à la police normale
$pdf->SetTextColor(0); // Revenir à la couleur par défaut (noir)
$pdf->Cell(80, 6, utf8_decode('+212 706 630 709'), 0, 0); // Cellule avec nouvelle configuration
$pdf->Cell(60, 6, '', 0, 1); // Fin de la ligne

// Début de la 6ème ligne
$pdf->SetFont('Arial', 'B', 10); // Changement de la police et de la taille
$pdf->SetTextColor(0, 0, 0); // Changement de la couleur (orange)
$pdf->Cell(50, 6, 'Adresse Email :', 0, 0); // Cellule avec nouvelle configuration
$pdf->SetFont('Arial', '', 12); // Revenir à la police normale
$pdf->SetTextColor(0); // Revenir à la couleur par défaut (noir)
$pdf->Cell(80, 6, utf8_decode('electricityProvider@gmail.com'), 0, 0); // Cellule avec nouvelle configuration
$pdf->Cell(60, 6, '', 0, 1); // Fin de la ligne
$pdf->Ln(10); // Espacement
// Début de la 7ème ligne
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(255, 127, 0);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(190, 6, 'CLIENT(E) : ',0, 1,'C', true );

// Début des informations du client
$pdf->SetFont('Arial', 'B', 10); // Changement de la police et de la taille
$pdf->SetTextColor(0, 0, 0); // Changement de la couleur (orange)
$pdf->Cell(50,6,'Nom :', 0 , 0);
$pdf->SetFont('Arial', '', 12); // Revenir à la police normale
$pdf->SetTextColor(0); // Revenir à la couleur par défaut (noir)
$pdf->Cell(65,6,utf8_decode($result['nom']), 0 , 1);
$pdf->Cell(60, 6, '', 0, 1); // Fin de la ligne


$pdf->SetFont('Arial', 'B', 12); // Changement de la police et de la taille
$pdf->SetTextColor(0, 0, 0); // Changement de la couleur (orange)
$pdf->Cell(50,6,utf8_decode('Prénom :'), 0 , 0);
$pdf->SetFont('Arial', '', 12); // Revenir à la police normale
$pdf->SetTextColor(0); // Revenir à la couleur par défaut (noir)
$pdf->Cell(65,6,utf8_decode($result['prenom']), 0 , 1);
$pdf->Cell(60, 6, '', 0, 1); // Fin de la ligne


$pdf->SetFont('Arial', 'B', 12); // Changement de la police et de la taille
$pdf->SetTextColor(0, 0, 0); // Changement de la couleur (orange)
$pdf->Cell(50,6,utf8_decode('Adresse :'), 0 , 0);
$pdf->SetFont('Arial', '', 12); // Revenir à la police normale
$pdf->SetTextColor(0); // Revenir à la couleur par défaut (noir)
$pdf->Cell(65,6,utf8_decode($result['adresse']), 0 , 1);
$pdf->Cell(60, 6, '', 0, 1); // Fin de la ligne


$pdf->SetFont('Arial', 'B', 12); // Changement de la police et de la taille
$pdf->SetTextColor(0, 0, 0); // Changement de la couleur (orange)
$pdf->Cell(50,6,utf8_decode('Email :'), 0 , 0);
$pdf->SetFont('Arial', '', 12); // Revenir à la police normale
$pdf->SetTextColor(0); // Revenir à la couleur par défaut (noir)
$pdf->Cell(65,6,utf8_decode($result['email']), 0 , 1);
$pdf->Cell(60, 6, '', 0, 1); // Fin de la ligne


// Partie du tableau des inforamtions de payement
$pdf->SetFillColor(220,220,220);
$pdf->SetDrawColor(220,220,220);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(20, 11, utf8_decode('Quantité'),1, 0,'C', true );
$pdf->Cell(20, 11, utf8_decode('Unite'),1, 0,'C', true );
$pdf->Cell(35, 11, utf8_decode('Prix Unitaire'),1, 0,'C', true );
$pdf->Cell(20, 11, utf8_decode('%TVA'),1, 0,'C', true );
$pdf->Cell(30, 11, utf8_decode('Prix HT'),1, 0,'C', true );
$pdf->Cell(30, 11, utf8_decode('Prix TTC'),1, 0,'C', true );
$pdf->Cell(35, 11, utf8_decode('Mois'),1, 1,'C', true ); // Fin de la ligne

// Les dnnées dans le tableau

$pdf->SetFillColor(255,255,255);
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(20, 60, utf8_decode($diff),1, 0,'C', true );
$pdf->Cell(20, 60, utf8_decode('KWH'),1, 0,'C', true );

if ($diff >= 0 && $diff <= 100) {
    $cts = 0.8;
} elseif ($diff >= 101 && $diff <= 200) {
    $cts = 0.9 ;
} else {
    $cts = 1 ;
}





$pdf->Cell(35, 60, utf8_decode( $cts.'DH'),1, 0,'C', true );
$pdf->Cell(20, 60, utf8_decode('14%'),1, 0,'C', true );
$pdf->Cell(30, 60, utf8_decode($result['prix_HT']),1, 0,'C', true );
$pdf->Cell(30, 60, utf8_decode($result['prix_TTC']),1, 0,'C', true );
$pdf->Cell(35, 60, utf8_decode($annee.'/'.$mois),1, 1,'C', true );

// Prix Total à payer 
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(125, 11,'',0, 0,'C', true );
$pdf->SetFillColor(215,215,215);
$pdf->Cell(30, 11,utf8_decode('Total : '),1, 0,'C', true );
$pdf->SetTextColor(255,0,0);
$pdf->SetFillColor(255,255,255);
$pdf->Cell(35, 11,$result['prix_TTC'],1, 1,'C', true );
$pdf->Ln(4);

// Partie de la photo du compteur 
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(90, 11,'Photo du compteur :',0, 1,'L', true );

// Ajouter une ligne vide pour créer de l'espace
$pdf->Ln(10);

// Récupérez les données de l'image de la base de données
$imageData = $result['compteur'];

// Chemin vers le dossier temporaire pour stocker l'image
$uploadDir = 'uploads/';

// Assurez-vous que le dossier existe, sinon créez-le
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Générez un nom de fichier unique pour l'image
$imageFileName = uniqid('image_');

// Examinez les premiers octets des données pour déterminer le type d'image
if (strpos($imageData, "\xFF\xD8") === 0) {
    // Les premiers octets indiquent une image JPEG
    $imageType = IMAGETYPE_JPEG;
    $imageFileName .= '.jpg';
} elseif (strpos($imageData, "\x89\x50\x4E\x47\x0D\x0A\x1A\x0A") === 0) {
    // Les premiers octets indiquent une image PNG
    $imageType = IMAGETYPE_PNG;
    $imageFileName .= '.png';
} elseif (strpos($imageData, "GIF") === 0) {
    // Les premiers octets indiquent une image GIF
    $imageType = IMAGETYPE_GIF;
    $imageFileName .= '.gif';
} else {
    // Si le type d'image ne peut pas être déterminé, utilisez un type par défaut
    $imageType = IMAGETYPE_JPEG;
    $imageFileName .= '.jpg';
}

// Chemin complet vers le fichier image
$imagePath = $uploadDir . $imageFileName;

// Écrivez les données de l'image dans le fichier
file_put_contents($imagePath, $imageData);

// Ajoutez l'image dans le PDF en utilisant le format approprié
switch ($imageType) {
    case IMAGETYPE_JPEG:
        $pdf->Image($imagePath, 15, 220, 55, 30);
        break;
   
    case IMAGETYPE_PNG:
        $pdf->Image($imagePath, 15, 220, 55, 30);
        break;
    case IMAGETYPE_GIF:
        $pdf->Image($imagePath, 15, 220, 55, 30);
        break;
    // Ajoutez d'autres cas pour d'autres types d'images pris en charge si nécessaire
}

// Supprimez le fichier image après utilisation
unlink($imagePath);





$pdf->Ln(20);

// Texte de remeciement  
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(190, 9,'Electricity Provider vous remercie !',0, 0,'C', true );
$pdf->Ln(10);

// Pied de page 
$pdf->SetFillColor(255, 127, 0);
$pdf->Cell(190, 8, '',0, 0,'C', true );
$pdf_content = $pdf->Output('S'); // Sauvegarde du contenu du PDF dans une variable



            // Mettre à jour le champ PDF dans la table facture avec le contenu du PDF
            $stmt_update_pdf = $conn->prepare("UPDATE facture SET pdf = :pdf  WHERE id_consomation = :id_consomation");
            $stmt_update_pdf->bindParam(':pdf', $pdf_content, PDO::PARAM_LOB);
            $stmt_update_pdf->bindParam(':id_consomation', $consomation_id);
            $stmt_update_pdf->execute();
           
            echo '<div class="alert alert-success alert-dismissible fade show mx-auto" role="alert" style="width: 1080px; margin-top: 20px;">' . 
                        'You can check your invoice space to view the invoice ' . 
                        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>';
           
            



        } 
        else {
           
            $consomation_id = $conn->lastInsertId();
            // Si l'état est en attente, stocker les informations dans la table facture avec l'état en attente et le PDF en cours de traitement
            $pdf = 'En cours de traitement';
            $etat ="non paye";
            $stmt_facture = $conn->prepare("INSERT INTO facture (id_client, prix_HT, prix_TTC, id_consomation,  pdf ,etat) 
            VALUES (:id_client, :prix_ht, :prix_ttc, :id_consomation,  :pdf , :etat)");
            $stmt_facture->bindParam(':id_client', $id);
            $stmt_facture->bindParam(':prix_ht', $prix_ht);
            $stmt_facture->bindParam(':prix_ttc', $prix_ttc);
            $stmt_facture->bindParam(':etat', $etat);
            $stmt_facture->bindParam(':id_consomation', $consomation_id);
            $stmt_facture->bindParam(':pdf', $pdf);
            $stmt_facture->execute();
           
            // Afficher un message de confirmation
           
            echo '<div class="alert alert-danger alert-dismissible fade show mx-auto" role="alert" style="width: 1080px; margin-top: 20px;">' . 
            'Invalid quantity entered, hence the request is under processing. ' . 
            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';

        } 
        
    } catch(PDOException $e) {
        echo "Failed: " . $e->getMessage();
    }
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

   <title>Consommation</title>
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
    width:800px;
    margin-left:280px;
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
h3{
       
       color: #060B32; /* Noir */
     margin-top:30px;
     margin-bottom: 20px;
     font-size: 36px; /* Taille de la police */
     text-align: center; /* Centrer le texte */
     text-transform: uppercase; /* Mettre en majuscules */
     text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3); /* Ombre portée */
     }
     .text{
        text-align: center;
        color:#000;
        font-weight:bold;
     }
     label{
        font-weight:bold;
     }
     </style>


</head>

<body>
<h3>Consumption of the month </h3>
<p class="text">Complete the form below to add information about your consommation</p>
   <div class="container1">
      <div class="text-center mb-4">
         
        
      </div>

      <div class="container d-flex justify-content-center">
      <form action="" method="post"  style="width:50vw; min-width:300px;" enctype="multipart/form-data">
    

    <div class="mb-3">
        <label class="form-label">Date:</label>
        <input type="date" class="form-control" name="date" placeholder="la date" id="date" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Quantity:</label>
        <input type="number" class="form-control" id="quantite" name="quantite" placeholder=" exemple :100,15 KWH" pattern="^\d+(\.\d{1,2})?$" min="0" required>
        <span id="quantiteError" style="color: red;"></span>
    </div>
    <div class="mb-3">
        <label class="form-label">image:</label>
        <input type="file" class="form-control" name="compteur" placeholder="entrer une image de compteur" required>
    </div>

    

    <div>
        <button type="submit" class="btn btn-success" name="submit">Save</button>
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
    document.getElementById('date').setAttribute('max', formattedDate);
</script>


</body>

</html>