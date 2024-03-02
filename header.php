<?php session_start();
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
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary" style="background-color: green;">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"><img src="images/logo.png" height="40px" width="95px"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="welcomepage.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="homepage.php">Pizza's</a>
        </li>
        <li class="nav-item"><a class="nav-link" href="user-profile.php"><?php if(isset($_SESSION['myname'])) {echo $_SESSION['myname'];}?></a></li>
            </a></li>
            <li class="nav-item">
          <a class="nav-link" href="log-out.php">Log-out</a>
        </li>
          </ul>
        </li>
      </ul>
    </div>
    <div class="navbar-nav ml-auto">
      <a class="nav-link" href="winkelmandje.php"><i class="fas fa-shopping-cart"></i> Shopping Cart</a>
    </div>
  </div>
</nav>






