
    <?php
    include 'db-conn.php';
    
    if (isset($_POST['update-info'])) {
        // Verkrijg de ingediende formuliergegevens
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price_small = $_POST['price_small'];
        $price_large = $_POST['price_large'];
    
        // Voorbereiden en uitvoeren van de update-query
        $stmt = $conn->prepare('UPDATE pizza SET name = ?, description = ?, price_small = ?, price_large = ? WHERE id = ?');
        $stmt->execute([$name, $description, $price_small, $price_large, $id]);
    
        // Doorverwijzen naar een andere pagina of een succesbericht weergeven
        echo 'succes';
        header("Location: admin.php");
        exit();
    }
    ?>
    





