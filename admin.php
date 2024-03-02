
<?php
//email : admin@gmail.com
// password : admin
include 'db-conn.php';
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
    <div class="sidebar">
        <a href="homepage.php"><img src="images/logo.png" height="35px" width="85px"></a>
        <a href="add-pizza.php">add pizza</a>
    </div>
    <div class="admin-name">
    <?php 
    if(isset($_SESSION['myname'])) {
        echo $_SESSION['myname'];
    }
    ?>
    </div>
    </div>
    <div class="log-in">
    <h4>welcome to the admin page</h4>
  </div><br>
    <div class="square-admin"><br>
        <h4>update your pizza</h4>
<br>
        <table class="table table-striped-columns">
            <thead>
                <tr>
                    <th>id</th>
                    <th>name</th>
                    <th>description</th>
                    <th>small price</th>
                    <th>large price</th>
                    <th>image</th>
                    <th>button</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $stmt = $conn->query("SELECT * FROM pizza");
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!$results) {
                echo "no records found";
            }

            foreach($results as $row) {
            ?>
                <tr>
                    <td><?php echo $row["id"]; ?></td>
                    <td><?php echo $row["name"]; ?></td>
                    <td><?php echo $row["description"]; ?></td>
                    <td><?php echo $row["price_small"]; ?></td>
                    <td><?php echo $row["price_large"]; ?></td>
                    <td><?php echo $row["image"]; ?></td>
                    <td>
                        <a class='btn btn-success' href='./update-pizza.php?id=<?php echo $row['id']; ?>'>Update</a>
                    </td>
                </tr>
            <?php
            } 
            ?>
            </tbody>
        </table>
    </div>
</body>
<?php 
include 'footer.html'
?>
</html>


