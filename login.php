<?php
//include 'db-conn.php';
include "access.php";

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



    
    $arr['email'] = $_POST['email'];
    $arr['password'] = hash('sha1', $_POST['password']);
    
    $query = "select * from users where email = :email && password = :password limit 1";
               $stm = $DB->prepare($query);
               if ($stm)
    {
       
       $check = $stm->execute($arr);
        if ($check){
      $data = $stm->fetchAll(PDO::FETCH_ASSOC);
      if(is_array($data) && count($data) > 0)
      {
        $_SESSION['myid'] = $data[0]['userid'];
        $_SESSION['myname'] = $data[0]['name'];
        $_SESSION['myrank'] = $data[0]['rank'];
        $_SESSION['rank'] = "user";

       }else{
        $error = "wrong username or password";
     }
    }
       if ($error == "")
       {
        header("location: homepage.php");
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
    <title>Login</title>
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
    <script src="https://kit.fontawesome.com/3aef4a74c1.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="logo-inlog">
        <img src="images/logo.png" height="40px" width="95px">
    </div>

    <div class="container">
        <div class="sign-up">
            <h4>Login</h4>
        </div>
        <br>
        <form method="post">
            <div class="form-group">
                <i class="fa-regular fa-envelope"></i> <label for="email">Email :</label><br>
                <input type="text" id="email" name="email" placeholder="e-mail" required class="form-control" style="color: black;"><br><br>
            </div>
            <div class="form-group">
                <i class="fa-solid fa-lock"></i> <label for="password">Password :</label><br>
                <input type="password" id="password" name="password" placeholder="password" required class="form-control" style="color: black;"><br><br>
            </div>
            <input type="submit" value="Login" class="btn btn-primary"> <a href="sign-up.php" class="btn btn-primary">Don't have an account</a>
        </form>
    </div>

    <?php 
    include 'footer.html'
    ?>
</body>
</html>



