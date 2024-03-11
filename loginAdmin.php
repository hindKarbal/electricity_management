<?php
require("ConnectionDB.php");

// Démarrer une session
session_start();

// Vérifier si une session est active
if (session_status() == PHP_SESSION_ACTIVE) {
    // Destruction de la session existante
    session_destroy();
}

if (isset($_POST['username'], $_POST['password'])) {

    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $uname = validate($_POST['username']);
    $pass = validate($_POST['password']);

    if (empty($uname)) {
        echo "Username is required";
        exit();
    } else if (empty($pass)) {
        echo "Password is required";
        exit();
    } else {
        // Vérifier si c'est un admin
        $sql = "SELECT * FROM admin WHERE email=:uname AND password=:pass";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':uname', $uname);
        $stmt->bindParam(':pass', $pass);
        $stmt->execute();
        $admin_row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifier si c'est un client
        $sql = "SELECT * FROM client WHERE email=:uname ";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':uname', $uname);

        $stmt->execute();
        $client_row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin_row) {
            // Démarrer une nouvelle session pour l'admin
            session_start();
            $_SESSION['user_type'] = 'admin';
            $_SESSION['email'] = $admin_row['email'];
            $_SESSION['password'] = $admin_row['password'];
            $_SESSION['nom'] = $admin_row['nom'];
            $_SESSION['prenom'] = $admin_row['prenom'];
            header("Location: AccueilAdmin.php");
            exit();
           
        } elseif ($client_row) {
            // Récupérer le mot de passe hashé de la base de données
            $hashed_password = $client_row['password'];

            if (password_verify($pass, $hashed_password)) {
                // Démarrer une nouvelle session pour le client
                session_start();
                $_SESSION['user_type'] = 'client';
                $_SESSION['id'] = $client_row['id'];
                $_SESSION['email'] = $client_row['email'];
                $_SESSION['nom'] = $client_row['nom'];
                $_SESSION['prenom'] = $client_row['prenom'];
                $_SESSION['Tel'] = $client_row['Tel'];
                $_SESSION['CIN'] = $client_row['CIN'];
                $_SESSION['date'] = $client_row['date'];
                $_SESSION['gender'] = $client_row['gender'];
                $_SESSION['adresse'] = $client_row['adresse'];
                $_SESSION['prefix'] = $client_row['prefix'];
                header("Location: AcceuilClient.php");
                exit();
            } else {
                header("Location: loginAd.php?error=1");
                exit();
            }
        } else {
            header("Location: loginAd.php?error=1");
            exit();
        }
    }



} else {
    echo "Form not submitted";
    exit();
}
?>