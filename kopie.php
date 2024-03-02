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

    echo "Pizza is toegevoegd aan het winkelmandje.";
}

// Winkelmandje weergeven
if (empty($_SESSION["cart"])) {
    echo "Je winkelmandje is leeg.";
} else {
    // Winkelmandje bevat items
    foreach ($_SESSION["cart"] as $pizzaId => $sizes) {
        foreach ($sizes as $size => $quantity) {
            // Hier kun je de gegevens van elke pizza ophalen uit de database op basis van de pizza ID en het formaat
            // en ze weergeven in een tabel, lijst of op een andere gewenste manier

            // Voorbeeld:
            echo "Pizza ID: " . $pizzaId . "<br>";
            echo "Formaat: " . $size . "<br>";
            echo "Aantal: " . $quantity . "<br>";

            // Voeg hier eventueel andere informatie toe, zoals de naam, prijs, etc.
            echo "<br>";
        }
    }

    // Knop om winkelwagen te legen
    echo '<form action="winkelmandje-legen.php" method="POST">';
    echo '<input type="submit" name="empty_cart" value="Winkelwagen legen">';
    echo '</form>';
}
?>





<div class="background-color">
<?php
$stmt = $conn->query("SELECT * FROM pizza");
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (!$results) {
    echo "No records found";
}

foreach ($results as $row) { ?>
<form action="winkelmandje.php" method="POST">
    <!-- Pizza-kaart inhoud -->


    <div class="pizza-card" style="width: 16rem;">
        <img src="<?php echo $row["image"]; ?>" class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title"><?php echo $row["name"]; ?></h5>
            <p class="card-text"><?php echo $row["description"]; ?></p>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <input type="radio" name="size" value="small" checked> 13cm <?php echo $row["price_small"]; ?>
            </li>
            <li class="list-group-item">
                <input type="radio" name="size" value="large" checked> 18cm <?php echo $row["price_large"]; ?>
            </li>
        </ul>
        <div class="card-body">
        <input type="number" name="quantity" value="1" min="1">
        <input type="hidden" name="pizza_id" value="<?php echo $row["id"]; ?>">

        <input type="submit" value="Toevoegen aan winkelmandje">

            </form>
        </div>
    </div>
<?php } ?>
<?php include 'footer.html';?>





<?php
include 'db-conn.php';
include 'header.php';
?>

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

                // Controleer of het aantal pizza's oneven is (elke tweede pizza krijgt 50% korting)
                if ($count % 2 == 0) {
                    $prijs *= 0.5; // Pas 50% korting toe
                }

                $totalePrijs += $prijs * $quantity;
            }
        }
    }

    return number_format($totalePrijs, 2); // Formateer de totale prijs met twee decimalen
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Controleer of het winkelmandje al bestaat in de sessie
    if (!isset($_SESSION["cart"])) {
        $_SESSION["cart"] = array();
    }

    // Verwerk het formulier alleen als het winkelmandje niet leeg is
    if (!empty($_SESSION["cart"])) {
        // Verkrijg de ingevoerde gegevens van de klant
        $name = $_POST["name"];
        $email = $_POST["email"];
        $city = $_POST["city"];
        $zip = $_POST["zip"];
        // Voeg hier eventueel andere velden toe die je wilt verzamelen

        // Voer verdere validatie uit op de ingevoerde gegevens indien nodig
        // ...

        // Verwerk de bestelling en stuur de gegevens naar de database of een ander verwerkingssysteem
        // ...

        // Toon een bevestigingsbericht of stuur de klant door naar een bedankpagina
        echo "Bedankt voor uw bestelling, " . $name . "! We zullen zo snel mogelijk contact met u opnemen.";

        // Leeg het winkelmandje en de sessie na een succesvolle bestelling
        $_SESSION["cart"] = array();
        session_destroy(); // Optioneel, afhankelijk van je sessiebeheer

        // Stop de verdere uitvoering van de pagina
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout - Pizza Ala</title>
</head>
<body>
    <h1>Checkout</h1>

    <?php if (!empty($_SESSION["cart"])): ?>
        <h2>Uw bestelling:</h2>

        <table>
            <tr>
                <th>Pizza ID</th>
                <th>Naam</th>
                <th>Formaat</th>
                <th>Aantal</th>
                <th>Prijs per stuk</th>
                <th>Subtotaal</th>
            </tr>

            <?php foreach ($_SESSION["cart"] as $pizzaId => $sizes): ?>
                <?php foreach ($sizes as $size => $quantity): ?>
                    <?php $pizza = getPizzaInfo($pizzaId); ?>
                    <?php if ($pizza): ?>
                        <tr>
                            <td><?php echo $pizza["id"]; ?></td>
                            <td><?php echo $pizza["name"]; ?></td>
                            <td><?php echo $size; ?></td>
                            <td><?php echo $quantity; ?></td>
                            <td><?php echo ($size == "small") ? $pizza["price_small"] : $pizza["price_large"]; ?></td>
                            <td><?php echo (($size == "small") ? $pizza["price_small"] : $pizza["price_large"]) * $quantity; ?></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </table>

        <h3>Totale prijs: <?php echo berekenWinkelmandjePrijs($_SESSION["cart"]); ?></h3>

        <h2>Voer uw gegevens in:</h2>

        <form action="checkout.php" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="text" id="email" name="email" required>

            <label for="city">City:</label>
            <input type="text" id="city" name="city" required>

            <label for="zip">Zip:</label>
            <input type="text" id="zip" name="zip" required>

            <!-- Voeg hier eventueel andere velden toe die je wilt verzamelen -->

            <input type="submit" value="Bestellen">
        </form>
    <?php else: ?>
        <p>Je winkelmandje is leeg. Voeg eerst items toe voordat je kunt bestellen.</p>
    <?php endif; ?>
</body>
</html>


