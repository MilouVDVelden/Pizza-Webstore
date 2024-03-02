<?php 
//include 'db-conn.php';
$error = "";
function create_userid()
{
    $length =rand(4,19);
    $number = "";
    for ($i=0; $i <$length; $i++) {
        # code . . .
        $new_rand = rand(0,9);

        $number = $number . $new_rand;
    }
    return $number;
}

if ($_SERVER['REQUEST_METHOD']== "POST")
{
    if(!$DB = new PDO("mysql:host=localhost;dbname=pizza ALA","root",""))
    {
        die("could not connect to the database");
    } 


    $arr['userid'] = create_userid();
    $condition = true;
    while ($condition)
    {
               $query = "select id from users where userid = :userid limit 1";
               $stm = $DB->prepare($query);
               if ($stm)
    {
       $check = $stm-> execute($arr);
        if ($check){
      $data = $stm->fetchAll(PDO::FETCH_ASSOC);
      if(is_array($data) && count($data) > 0)
      {
        $arr['userid'] = create_userid(); 
        continue;
       }
     }
    }
    $condition = false;
}
    $arr['name'] = $_POST['name'];
    $arr['lastname'] = $_POST['lastname'];
    $arr['email'] = $_POST['email'];
    $arr['city'] = $_POST['city'];
    $arr['zip'] = $_POST['zip'];
    $arr['password'] = hash('sha1', $_POST['password']);
    $arr['rank'] = "user";
    
    
    $query = "insert into users (userid,name,lastname,email,city,zip,password,rank) values (:userid,:name, :lastname, :email,:city, :zip, :password,:rank)";
               $stm = $DB->prepare($query);
               if ($stm)
    {
       $check = $stm->execute($arr);
       if (!$check)
       {
        $error = "could not save to database";
       }
       if ($error == "")
       {
        header("location: login.php");
        die;
       }
    }
}
?>

<?php
if ($error !== "")
{
    echo "<br><span style='color:red'>$error</span><br><br>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <style>
        body {
            background-image: url("https://wallpaper.dog/large/10701850.jpg");
    background-repeat: no-repeat;
    background-size: cover;
    height: 800px;
    margin: 0%;
        }
        .container {
            width: 400px;
            margin-top: 4rem;
            background-color: rgba(255, 255, 255, 0.2);
            padding: 20px;
            border-radius: 5px;
            color: white;
            border: 2px solid white;
            backdrop-filter: blur(8px);
            height: auto;
        }
        .form-group {
            margin-bottom: 10px;
        }
    </style>

</head>
<body>
    <div class="logo-inlog">
        <img src="images/logo.png" height="40px" width="95px">
    </div>

    <div class="container">
        <div class="sign-up">
            <h4>sign-up</h4>
        </div>
        <br>
        <form action="" method="POST">
    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" class="form-control" required placeholder="Enter your name" style="color: black;">
    </div>

    <div class="form-group">
        <label for="lastname">Last Name:</label>
        <input type="text" id="lastname" name="lastname" class="form-control" required placeholder="Enter your last name" style="color: black;">
    </div>

    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" class="form-control" required placeholder="Enter your email" style="color: black;">
    </div>

    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" class="form-control" required placeholder="Enter your password" style="color: black;">
    </div>

    <div class="form-group">
        <label for="city">City:</label>
        <input type="text" id="city" name="city" class="form-control" required placeholder="Enter your city" style="color: black;">
    </div>

    <div class="form-group">
        <label for="zip">ZIP Code:</label>
        <input type="text" id="zip" name="zip" class="form-control" required placeholder="Enter your ZIP code" style="color: black;">
    </div>

    <button type="submit" class="btn btn-primary">Sign Up</button>
    <button type="button" class="btn btn-primary" onclick="window.location.href='login.php'">Log In</button>
</form>
    </div>

    <?php
    include 'footer.html'
    ?>
</body>
</html>




