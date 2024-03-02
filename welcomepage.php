<?php include 'header.php';?>


<div class="background-image">

<div class="mainscreen"><br>
<br>
      <style>
  g {
    color: white;
    font-size: 44px;
  }
</style>

        <br><b style=font-size:44px;>welcome</b><g>
<?php 
if(isset($_SESSION['myname']))
{
echo $_SESSION['myname'];
}
  ?>
        </g><br>
        <a style=font-size:37px;>To pizzaria corleone calzone</a>
        <br><a style=font-size:35px;><b>The best</b> pizza's you order here.</a>
        </div>

        <div class="locatie"><i class="fa-solid fa-location-dot"></i> <a style=font-size:20px;>locations</div>
  <div class="locatie">utrecht</div>
  <div class="locatie">rotterdam</div>
  <div class="locatie">gouda</div>

  <div class="deal"><a style=font-size:24px;>deal of the day</a><a style=font-size:14px;><br><b>50% off the second pizza</b>
</div>

</div>
<?php
include 'footer.html'; ?>