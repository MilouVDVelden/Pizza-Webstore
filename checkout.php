<?php
include 'db-conn.php';
include 'header.php';?>
<style>
body {
    font-family: Arial, sans-serif;
            color: green;
}
    </style>
<body>
<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["cart"])) {
    $cart = json_decode($_POST["cart"], true); // De gecodeerde winkelwageninformatie decoderen
    $totalePrijs = $_POST["totale_prijs"]; // De totale prijs uit het formulier halen

    // Haal de naam uit de sessie
    $name = $_SESSION['myname']; // Vervang "myname" door de daadwerkelijke sessievariabele waarin de naam is opgeslagen

    // Haal de huidige datum en tijd op
    $datetime = date("Y-m-d H:i:s");

    $orderNumber = uniqid();

    // Loop door de winkelwagen en voeg elke pizza toe aan de database samen met de naam, datum/tijd en totale prijs
    foreach ($cart as $pizzaId => $sizes) {
        foreach ($sizes as $size => $quantity) {
            // Voeg de pizza-informatie, naam, datum/tijd en totale prijs toe aan de database
            $stmt = $conn->prepare("INSERT INTO winkelwagen (pizza_id, size, quantity, name, order_date, total_price, order_number) VALUES (:pizzaId, :size, :quantity, :name, :datetime, :total_price, :order_number)");
            $stmt->bindParam(':pizzaId', $pizzaId);
            $stmt->bindParam(':size', $size);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':datetime', $datetime);
            $stmt->bindParam(':total_price', $totalePrijs);
            $stmt->bindParam(':order_number', $orderNumber);
            $stmt->execute();
        }
    }
    echo '<h1 style="font-size: 13px; margin-left: 20px; margin-top: 10px; color: olivegreen;">';
    echo "dank u wel voor uw bestelling";
    echo "</h1>";
    // Sessie legen
    unset($_SESSION['cart']);
} else {
    echo "Er is geen winkelwageninformatie ontvangen.";
}
?>

<a href="homepage.php" class="btn btn-primary" style="font-size: 13px; margin-left: 20px; margin-top: 10px;">terug</a>

</body>



