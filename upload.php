<?php
include 'db-conn.php';
?>
<?php
if (isset($_POST['submit'])) {
    // Verbinding maken met de database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "pizza ALA";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $name = $_POST['name'];
        $description = $_POST['description'];
        $price_small = $_POST['price_small'];
        $price_large = $_POST['price_large'];

        $targetDirectory = "uploads/";
        $targetFile = $targetDirectory . basename($_FILES["fileToUploadImage"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Controleer of er een bestand is geüpload
        if (empty($_FILES["fileToUploadImage"]["tmp_name"])) {
            echo "Er is geen bestand geüpload.";
            $uploadOk = 0;
        } else {
            // Controleer of het bestand een afbeelding is
            $check = getimagesize($_FILES["fileToUploadImage"]["tmp_name"]);
            if ($check === false) {
                echo "Het bestand is geen afbeelding.";
                $uploadOk = 0;
            }
        }

        // Controleer de bestandsgrootte
        if ($_FILES["fileToUploadImage"]["size"] > 500000) {
            echo "Het bestand is te groot.";
            $uploadOk = 0;
        }

        // Als alles in orde is, upload het bestand en sla het op in de database
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["fileToUploadImage"]["tmp_name"], $targetFile)) {
                // Query om de afbeelding in de database op te slaan
                $query = "INSERT INTO pizza (name, description, image, price_small, price_large) VALUES (:name, :description, :image, :price_small, :price_large)";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':image', $targetFile);
                $stmt->bindParam(':price_small', $price_small);
                $stmt->bindParam(':price_large', $price_large);
                $stmt->execute();

                echo "Afbeelding succesvol opgeslagen!";
            } else {
                echo "Er is een fout opgetreden bij het uploaden van het bestand.";
            }
        }
    } catch (PDOException $e) {
        echo "Fout bij verbinden met de database: " . $e->getMessage();
    }
}
header("Location: admin.php");
?>


