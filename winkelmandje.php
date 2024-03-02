<?php
include 'db-conn.php';
include 'header.php';
?>
<style>
body {
    font-family: Arial, sans-serif;
            color: green;
}
    </style>
<body>
    <?php

// Functie om pizza-informatie op te halen uit de database op basis van de pizza ID
function getPizzaInfo($pizzaId)
{
    // Hier kun je je eigen code toevoegen om verbinding te maken met de database en de juiste gegevens op te halen

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "pizza ala";

    try {
        // Maak verbinding met de database met behulp van PDO
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        // Stel de error modus in op Exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Bereid de SQL-query voor
        $stmt = $conn->prepare("SELECT * FROM pizza WHERE id = :pizzaId");
        $stmt->bindParam(':pizzaId', $pizzaId);

        // Voer de query uit
        $stmt->execute();

        // Haal de resultaten op
        $pizza = $stmt->fetch(PDO::FETCH_ASSOC);

        // Sluit de databaseverbinding
        $conn = null;

        return $pizza;
    } catch (PDOException $e) {
        die("Verbinding mislukt: " . $e->getMessage());
    }
}

// Bereken de totale prijs van het winkelmandje
function berekenWinkelmandjePrijs($cart)
{
    $totalePrijs = 0.00;
    $count = 0; // Houd het aantal pizza's bij

    foreach ($cart as $pizzaId => $sizes) {
        foreach ($sizes as $size => $quantity) {
            $count++; // Verhoog het aantal pizza's met 1

            $pizza = getPizzaInfo($pizzaId);

            if ($pizza) {
                $prijs = ($size == "small") ? $pizza["price_small"] : $pizza["price_large"];

                // Controleer of het aantal pizza's groter is dan 1 en oneven is (elke tweede pizza krijgt 50% korting)
                if ($count > 1 && $count % 2 == 0) {
                    $prijs *= 0.5; // Pas 50% korting toe
                }

                $totalePrijs += $prijs * $quantity;
            }
        }
    }

    return number_format($totalePrijs, 2); // Formateer de totale prijs met twee decimalen
}

// Rest van je code...


// Voeg de prijsberekening toe aan de code


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $size = $_POST["size"]; // Het geselecteerde formaat (small of large)
    $quantity = $_POST["quantity"];
    $pizzaId = $_POST["pizza_id"];

    // Controleer of het winkelmandje al bestaat in de sessie
    if (!isset($_SESSION["cart"])) {
        $_SESSION["cart"] = array();
    }

    // Controleer of de pizza al in het winkelmandje zit
    if (isset($_SESSION["cart"][$pizzaId][$size])) {
        // Als de pizza al in het winkelmandje zit, voeg de nieuwe hoeveelheid toe aan de bestaande hoeveelheid
        $_SESSION["cart"][$pizzaId][$size] += $quantity;
    } else {
        // Als de pizza nog niet in het winkelmandje zit, voeg een nieuw item toe aan het winkelmandje
        $_SESSION["cart"][$pizzaId][$size] = $quantity;
    }

    echo '<h1 style="font-size: 13px; margin-left: 20px; margin-top: 10px;">Je pizza is toegevoegt aan je winkelmand.</h1>';
    echo "<br>";
    echo "<br>";
}

// Winkelmandje weergeven
if (empty($_SESSION["cart"])) {
    echo '<h1 style="font-size: 13px; margin-left: 20px; margin-top: 10px;">Je winkelmandje is leeg.</h1>';
} else {
    // Winkelmandje bevat items
    foreach ($_SESSION["cart"] as $pizzaId => $sizes) {
        foreach ($sizes as $size => $quantity) {
            // Haal pizza-informatie op uit de database op basis van de pizza ID
            $pizza = getPizzaInfo($pizzaId);

            if ($pizza) {
                echo '<h1 style="font-size: 13px; margin-left: 20px; margin-top: 10px; color: olivegreen;">';
                echo "Pizza ID: " . $pizza["id"] . "<br>";
                echo "Naam: " . $pizza["name"] . "<br>";
                echo "Formaat: " . $size . "<br>";
                echo "Aantal: " . $quantity . "<br>";
                echo "Prijs per stuk: " . (($size == "small") ? $pizza["price_small"] : $pizza["price_large"]) . "<br>";
                echo "Subtotaal: " . (($size == "small") ? $pizza["price_small"] : $pizza["price_large"]) * $quantity . "<br>";
                echo "<br>";
                echo "</h1>";
                
            }
        }
    }

    // Bereken de totale prijs van het winkelmandje
    $totalePrijs = berekenWinkelmandjePrijs($_SESSION["cart"]);
    echo '<h1 style="font-size: 13px; margin-left: 20px; margin-top: 10px; color: olivegreen;">';
echo "Totale prijs: " . $totalePrijs . "<br>";
echo "</h1>";


    // Knop om winkelwagen te legen
    echo '<form action="winkelmandje-legen.php" method="POST">';
    echo '<input type="submit" name="empty_cart" value="Winkelwagen legen">';
    echo '</form>';

    echo '<form action="checkout.php" method="POST">';
    echo '<input type="hidden" name="cart" value="' . htmlentities(json_encode($_SESSION["cart"])) . '">';
    echo '<input type="hidden" name="totale_prijs" value="' . $totalePrijs . '">';
    echo '<input type="submit" name="checkout" value="Checkout">';
    echo '</form>';
}
?>
</body>

