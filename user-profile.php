
<?php include 'header.php';?>
<?php include 'db-conn.php';?>
<style>
    body {
      background-color: #688e47;
    }
</style>
<body>
<div class="profile-title">
        <?php 
      if(isset($_SESSION['myname']))
{
  echo "Hi, " . $_SESSION['myname'];
}
        ?>
        <br>
      </div>
    

      <div class="square">
        
      <h3 style="color: white;">previous orders</h3>
      <?php

  ?>

        <br>
        <table class="table table-striped-columns">
        <thead>
			<tr>
				<th>ordernummer</th>
				<th>id</th>
				<th>size</th>
        <th>aantal</th>
        <th>bestel-datum</th>
        <th>totale-prijs</th>
			</tr>
		</thead>
        <tbody>      <?php


// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['myname'])) {
    echo "Gebruiker is niet ingelogd.";
    exit;
}

// Haal de gebruikersnaam uit de sessie
$username = $_SESSION['myname']; // Vervang "myname" door de daadwerkelijke sessievariabele waarin de gebruikersnaam is opgeslagen

// Voer een query uit om de winkelwageninformatie van de gebruiker op te halen
$stmt = $conn->prepare("SELECT * FROM winkelwagen WHERE name = :username ORDER BY order_date DESC");

$stmt->bindParam(':username', $username);
$stmt->execute();

// Haal de resultaten op
$winkelwagenItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (count($winkelwagenItems) > 0) {
  foreach ($winkelwagenItems as $item){?>
        <tr>
      <td><?php echo $item['order_number'] . "<br>";?></td>
			<td><?php echo $item['pizza_id'] . "<br>";?></td>
			<td><?php echo $item['size'] . "<br>";?></td>
      <td><?php echo $item['quantity'] . "<br>";?></td>
<td><?php echo $item['order_date'] . "<br>";?></td>
<td><?php echo $item['total_price'] . "<br>";?></td>
	   </tr>
     <?php }

} else {
    echo "Er zijn geen winkelwagenitems gevonden.";
}
?>

</tbody>
</table>
</div>
</body>
<?php include 'footer.html'; ?>


