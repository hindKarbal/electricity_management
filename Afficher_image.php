/*
    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        // Récupérer l'image de la base de données
        $sql = "SELECT compteur FROM consomation WHERE id_client = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    
        // Fetch the image data
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $imageData = $row['compteur'];
    
        // Convertir les données binaires en une chaîne base64
        $imageBase64 = base64_encode($imageData);
    
        // Afficher l'image
        echo '<img src="data:image/jpeg;base64,'.$imageBase64.'" />';
    } catch(PDOException $e) {
        echo "Failed: " . $e->getMessage();
    }
    
    */