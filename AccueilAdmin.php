<?php
include('menuAdmin.php');
require('ConnectionDB.php');


// Vérifier si l'utilisateur est connecté


// Récupérer les informations de l'utilisateur connecté
$email = $_SESSION['email'];
$password = $_SESSION['password'];

$sql = "SELECT id_client, AVG(quantite) AS moyenne_consommation FROM consomation GROUP BY id_client";
$stmt = $conn->prepare($sql);

// Exécution de la requête
$stmt->execute();

// Initialisation du tableau pour stocker les données
$data = array();

// Récupération des résultats
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $idClient = $row['id_client'];
    $moyenneConsommation = $row['moyenne_consommation'];

    // Stocker les données dans le tableau associatif
    $data[$idClient] = $moyenneConsommation;

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <title>Home</title>
  <style>
    .statistics {
      color: #ffffff; /* Blanc pour le texte */
      padding: 10px;
      border-radius: 10px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2); /* Ombre légère */
      width: 280px; /* Largeur maximale */
      height: 150px;
      text-align: center;
      margin-top: 20px; /* Marge en haut */
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .orange {
      background-color: #FFA500; /* Orange */
    }

    .blue {
      background-color: #060B32; /* Bleu foncé */
    }

    .red {
      background-color: #AA1720; /* Rouge */
    }

    .green {
      background-color: #113206; /* Orange */
    }

    .bleu-ciel {
      background-color: #1B66F8; /* Bleu foncé */
    }

    .or {
      background-color: #808080; /* Rouge */
    }

    .statistics:hover {
      transform: scale(1.05); /* Augmentation de l'échelle au survol */
      box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.5); /* Ombre plus prononcée */
    }

    .icon {
      width: 40px;
      height: 40px;
    }

    h2{
      font-size:16px;
    }
    .number{
      color:#000;
      font-weight:bold;
      font-size: 32px;
    }

    /* Ajoutez un style pour le conteneur */
    .container {
      display: flex;
      justify-content: space-between;
      gap: 20px; /* Espacement entre les cartes */
      padding: 20px; /* Espacement intérieur */
    }
    .search-container {
  margin-top: 20px; /* Espace en haut */
  margin-bottom: 20px; /* Espace en bas */
  position: relative; /* Position relative pour que le bouton puisse être positionné par rapport à ce conteneur */
  text-align: center; /* Centrer le contenu */

}

#searchInput {
  width: 500px; /* Largeur de la barre de recherche augmentée */
  padding: 12px; /* Espace à l'intérieur de la barre de recherche */
  border: none; /* Suppression de la bordure */
  border-radius: 25px; /* Coins arrondis de la barre de recherche */
  font-size: 16px; /* Taille de la police */
  background-color: #303030; /* Couleur de fond de la barre de recherche */
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Ombre légère pour ajouter de la profondeur */
  outline: none; /* Supprimer le contour */
  margin-left: 20px; /* Ajouter de l'espace à gauche */
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

  .hidden {
  display: none;
}
#mytable{
  display: none;
}
.search-image {
  position: absolute;
  right: 450px; /* Positionnement à droite de l'input */
  top: 50%;
  transform: translateY(-50%);
  width: 20px; /* Taille de l'image */
  height: 20px;
}
.chart-container {
    margin-left: 100px;
    margin-bottom:20px; /* Ajoute un espace à gauche */
    background-color: rgb(48,48,48); /* Couleur d'arrière-plan */
    padding: 20px; /* Ajoute un remplissage pour l'espace intérieur */
    border-radius: 10px; /* Ajoute une bordure arrondie */
    width:200px;
    float: left;
    
  }
  .chart-container:hover {
    background-color: rgb(68, 68, 68); /* Changement de couleur au survol */
    transition: background-color 0.3s; /* Ajoute une transition en douceur */
}

.cont{
  display: flex; /* Utilisation de flexbox pour aligner les divs côte à côte */
 
}
    
  </style>
</head>
<body>


<div class="container">
    <div class="statistics orange">
      <div>
        <h2>Number of complaints processed</h2>
      </div>
      <div>
        <img src="images/timbre.png" alt="Icône orange" class="icon">
         <?php 
         try {
          
      
          // Requête SQL pour compter le nombre de réclamations non traitées
          $sql = "SELECT COUNT(*) AS total FROM reclamation WHERE etat = 'traite'";
          $stmt = $conn->prepare($sql);
          $stmt->execute();
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
          $complaints_processed = $result['total'];
      } catch (PDOException $e) {
          echo "Erreur de connexion à la base de données : " . $e->getMessage();
      }
         
         
         ?>
        <span class="number"><?php echo $complaints_processed; ?></span>
      </div>
    </div>
    <div class="statistics blue">
      <div>
        <h2>Number of complaints not processed</h2>
      </div>
      <div>
        <img src="images/fermer.png" alt="Icône bleue" class="icon">
        <?php 
         try {
          
      
          // Requête SQL pour compter le nombre de réclamations non traitées
          $sql = "SELECT COUNT(*) AS total FROM reclamation WHERE etat = 'non traite'";
          $stmt = $conn->prepare($sql);
          $stmt->execute();
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
          $complaints_not_processed = $result['total'];
      } catch (PDOException $e) {
          echo "Erreur de connexion à la base de données : " . $e->getMessage();
      }
         
         
         ?>

        <span class="number"><?php echo $complaints_not_processed; ?></span>
      </div>
    </div>
    <div class="statistics red">
      <div>
        <h2>sum of price</h2>
      </div>
      <div>
        <img src="images/facture.png" alt="Icône rouge" class="icon">
        <?php
        try {
          
      
          // Requête SQL pour compter le nombre de réclamations non traitées
          $sql = "SELECT SUM(prix_TTC) AS somme FROM facture";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Récupération de la moyenne de consommation
   
    $somme = number_format($result['somme'],2);
      } catch (PDOException $e) {
          echo "Erreur de connexion à la base de données : " . $e->getMessage();
      }
      ?>

<span class="number"><?php echo $somme; ?></span>
      </div>
    </div>
</div>
<br><br>
<div class="container">
    <div class="statistics bleu-ciel">
      <div>
        <h2>Number of clients</h2>
      </div>
      <div>
        <img src="images/client.png" alt="Icône orange" class="icon">
         <?php 
         try {
          
      
          // Requête SQL pour compter le nombre de réclamations non traitées
          $sql = "SELECT COUNT(*) AS total FROM client";
          $stmt = $conn->prepare($sql);
          $stmt->execute();
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
          $number = $result['total'];
      } catch (PDOException $e) {
          echo "Erreur de connexion à la base de données : " . $e->getMessage();
      }
         
         
         ?>
        <span class="number"><?php echo $number; ?></span>
      </div>
    </div>
    <div class="statistics green">
      <div>
        <h2>Average of consumption</h2>
      </div>
      <div>
        <img src="images/consom.png" alt="Icône bleue" class="icon">
        <?php 
         try {
          
      
          // Requête SQL pour compter le nombre de réclamations non traitées
          $sql = "SELECT AVG(quantite) AS moyenne_consommation FROM consomation";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Récupération de la moyenne de consommation
    $moyenne_consommation = number_format($result['moyenne_consommation'], 2);
      } catch (PDOException $e) {
          echo "Erreur de connexion à la base de données : " . $e->getMessage();
      }
         
         
         ?>

        <span class="number"><?php echo  $moyenne_consommation; ?></span>
      </div>
    </div>
    <div class="statistics or">
      <div>
        <h2>Anomaly's Number </h2>
      </div>
      <div>
        <img src="images/detection.png" alt="Icône rouge" class="icon">
        <?php 
         try {
          
          // Requête SQL pour compter le nombre de réclamations non traitées
          $sql = "SELECT COUNT(*) AS total FROM consomation WHERE etat = 'en attente'";
          $stmt = $conn->prepare($sql);
          $stmt->execute();
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
          $anomalies = $result['total'];
      } catch (PDOException $e) {
          echo "Erreur de connexion à la base de données : " . $e->getMessage();
      }
     ?>
        <span class="number"><?php echo $anomalies; ?></span>
      </div>
    </div>
</div>
<br><br>
<div class="cont">
<div >
<canvas class="chart-container" id="myChart" width="500" height="400"></canvas>
 </div>
 <div class="ch" style="width: 500px; height: 500px;">
<canvas class="chart-container" id="myChart1" width="500" height="400"></canvas>
 </div>
  </div>
<script>
    // Récupération des données à partir de PHP
    var complaintsProcessed = <?php echo $complaints_processed; ?>;
    var complaintsNotProcessed = <?php echo $complaints_not_processed; ?>;

    // Création du diagramme
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Processed', 'Not Processed'],
            
            datasets: [{
                label: 'Number of Complaints',
                data: [complaintsProcessed, complaintsNotProcessed],
                backgroundColor: [
                    'rgba(255, 140, 0, 1)',
                    'rgba(34, 66, 1241, 1)'
                ],
                borderColor: [
                    'rgba(255, 140, 0, 1)',
                    'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: false, // Désactiver la réponse au changement de taille
            maintainAspectRatio: false, // Conserver l'aspect ratio
            plugins: {
                legend: {
                    display: true, // Afficher la légende
                    position: 'top', // Position de la légende
                    labels: {
                        font: {
                            size: 14 // Taille de la police de la légende
                        },
                        color: 'white'
                    }
                },
                title: {
                    display: true, // Afficher le titre
                    text: 'Complaints Overview', // Texte du titre
                    font: {
                        size: 18 // Taille de la police du titre

                    },
                    color: 'white'
                }
            },
            scales: {
                x: {
                    display: true, // Afficher l'axe X
                    grid: {
                        display: false // Masquer les lignes de la grille sur l'axe X
                    }
                },
                y: {
                    display: true, // Afficher l'axe Y
                    grid: {
                        display: false // Masquer les lignes de la grille sur l'axe Y
                    },
                    beginAtZero: true // Commencer l'axe Y à zéro
                }
            },
            barThickness: 50, // Largeur des barres
            categorySpacing: 1, // Espacement entre les groupes de barres
            borderWidth: 1
        }
    });
</script>
<script>
    // Récupération des données à partir de PHP
    var clients = <?php echo $idClient; ?>;
    var consom = <?php echo $moyenneConsommation; ?>;

    // Création du diagramme circulaire
    var ctx = document.getElementById('myChart1').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'doughnut', // Changer le type de graphe en camembert
        data: {
            labels: ['clients', 'average consumption'],
            datasets: [{
                label: 'Number of Complaints',
                data: [clients, consom],
                backgroundColor: [
                    'rgba(255, 255, 255, 1)', // Couleur orange
                    'rgba(34, 66, 124, 1)' // Couleur bleue
                ],
                borderColor: [
                    'rgba(00, 56, 1B, 1)',
                    'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: false, // Désactiver la réponse au changement de taille
            maintainAspectRatio: false, // Conserver l'aspect ratio
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        font: {
                            size: 14
                        },
                        color: 'white'
                    }
                },
                title: {
                    display: true,
                    text: 'Average customer consumption',
                    font: {
                        size: 18
                    },
                    color: 'white'
                }
            }
        }
    });
</script>
</body>
</html>

