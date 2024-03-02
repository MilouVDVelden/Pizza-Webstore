<?php
include 'db-conn.php';
include 'access.php';
access('ADMIN');?>
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
<body>
<style>
body {
        background-color: #688e47;
}
    </style>
    <div class="sidebar">
        <a href="welcomepage.php"><img src="images/logo.png" height="35px" width="90px"></a>
        <a href="admin.php">update pizza</a>
    </div>
    <div class="admin-name">
    <?php 
if(isset($_SESSION['myname']))
{
echo $_SESSION['myname'];
}
  ?>
    </div>
    </div>
    <div class="log-in">
    <h4></h4>
  </div><br>
  <div class="square-admin">
    <div class="square">
        <h2>Add Your Pizza</h2>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Pizza Name</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Enter name" required>
            </div>
            <br>
            <div class="form-group">
                <label for="description">Pizza Description</label>
                <textarea name="description" id="description" class="form-control" placeholder="Enter description" required></textarea>
            </div>
            <br>
            <div class="form-group">
                <label for="image">Pizza Image</label>
                <input type="file" name="fileToUploadImage" id="image" accept=".jpg, .jpeg, .png" class="form-control-file" required>
            </div>
            <br>
            <div class="form-group">
                <label for="price_small">Price (Small)</label>
                <input type="text" name="price_small" id="price_small" class="form-control" placeholder="Enter small price" required>
            </div>
            <br>
            <div class="form-group">
                <label for="price_large">Price (Large)</label>
                <input type="text" name="price_large" id="price_large" class="form-control" placeholder="Enter large price" required>
            </div>
            <br>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>



</div>
</body>
<?php 
include 'footer.html'
?>
</html>