<?php include 'db-conn.php';
include 'access.php';
access('ADMIN');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/3aef4a74c1.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<style>
body {
        background-color: #688e47;
}
    </style>
<body>

<?php
if (isset($_GET['id'])) {
    $stmt = $conn->prepare('SELECT * FROM pizza WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $results = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
    <div class="admin-name">
    <?php 
    if(isset($_SESSION['myname'])) {
        echo $_SESSION['myname'];
    }
    ?>
    </div>
    <div class="log-in">
    <h4></h4>
  </div><br>
  <div class="square-admin">
    <div class="square">
        <h2>Add Your Pizza</h2>
<form action="update-db.php" method="post" enctype="multipart/form-data">
    <?php if (isset($results)) { ?>
        <div class="form-group">
            <label for="id">ID:</label>
            <input type="text" name="id" class="form-control" value="<?php echo $results['id']; ?>" readonly>
        </div>
        <br>
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" class="form-control" value="<?php echo $results['name']; ?>">
        </div>
        <br>
        <div class="form-group">
            <label for="description">Description:</label>
            <input type="text" name="description" class="form-control" value="<?php echo $results['description']; ?>">
        </div>
        <br>
        <div class="form-group">
            <label for="price_small">Price (Small):</label>
            <input type="text" name="price_small" class="form-control" value="<?php echo $results['price_small']; ?>">
        </div>
        <br>
        <div class="form-group">
            <label for="price_large">Price (Large):</label>
            <input type="text" name="price_large" class="form-control" value="<?php echo $results['price_large']; ?>">
        </div>
        <br>
        <button class="btn btn-primary btn-edit" type="submit" name="update-info">Save</button>
    <?php } else { ?>
        <p>No results found.</p>
    <?php } ?>
</form>
    </div>
    </div>
    </body>
    <?php 
include 'footer.html'
?>
</html>






