<?php
include 'header.php';
include 'db-conn.php';
?>

<style>
    body {
        background-color: #688e47;
    }

    .background-color {
        background-color: #688e47;
        padding: 20px;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }

    .pizza-card {
  
        background-color: #ffffff;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
  border-style: solid;
  height: auto;
  width: 15rem;
  padding: 10px;
margin-left: 1.85rem;
margin-right: 1rem;
margin-top: 2rem;
margin-bottom: 2rem;
display: grid inline-grid;
float : left;

    }

    .pizza-card .card-img-top {
    height: 100%;
    object-fit: contain;
    border-radius: 8px 8px 0 0;
}

    .pizza-card .card-body {
        padding: 10px;
        
    }

    .pizza-card .card-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 5px;
        color: green;
    }

    .pizza-card .card-text {
        color: green;
    }

    .pizza-card .list-group-item {
        color: green;
    }

    .pizza-card .card-body input[type="number"] {
        width: 60px;
        padding: 5px;
        margin-bottom: 10px; /* Voeg deze regel toe */
    }

    .pizza-card .card-body input[type="submit"] {
        background-color: green;
    color: white;
    border: none;
    padding: 6px 10px; /* Pas de padding aan naar wens */
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px; /* Pas de lettergrootte aan naar wens */
    margin-top: 10px; /* Voeg deze regel toe */
    }

    .pizza-card .card-body input[type="submit"]:hover {
        background-color: darkgreen;
    }
</style>

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
            <div class="pizza-card">
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
                        <input type="radio" name="size" value="large"> 18cm <?php echo $row["price_large"]; ?>
                    </li>
                </ul>
                <div class="card-body">
                    <input type="number" name="quantity" value="1" min="1">
                    <input type="hidden" name="pizza_id" value="<?php echo $row["id"]; ?>">
                    <input type="submit" value="Toevoegen aan winkelmandje">
                </div>
            </div>
        </form>
    <?php } ?>
</div>

<?php include 'footer.html'; ?>
