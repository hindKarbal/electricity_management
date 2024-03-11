<?php
include('menu.php');
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="style.css">
<title>Acceuil</title>

</head>
<body>

<section class="section section1">
  <div>
    <h1><span>E</span>lectricity<span>P</span>rovider</h1>
    <p>Electricity Provide is here to streamline your life, making it easier and more convenient for you</p> 
    <a href="#section2" id="btn">Learn More</a>
  </div>
</section>

<section class="section section2" id="section2">
  <h2>About</h2>
  <div style="overflow: hidden;">
    <div class="image-container" style="border-radius: 20px; float: left; margin-right: 20px;">
      <img src="images/elec.jpg" alt="Image 2" style="border-radius: 20px; width: 400px;">
    </div>
    <hr><hr>
    <div class="text-container">
    <div class="text-box">
    <p id="p"><span>E</span>lectricity <span>P</span>rovider Solutions is a leading electricity provider agency committed to delivering reliable and sustainable energy solutions to its clients. Our experienced team is dedicated to providing consistent and high-quality electrical supply while focusing on energy efficiency and renewable resources. With our dedication to innovation and sustainability, PowerPro Solutions is your trusted partner in meeting all your electricity needs, whether for households, businesses, or industries</p>
    </div>
</div>

  </div>
</section>

<section class="section section3" id="section3">
  <h2>Login</h2>
  <div class="card" style="width: 550px; background-color: #060B32; border-radius: 10px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3); padding: 20px; color: white; font-family: Arial, sans-serif;">
    <div style="display: flex; align-items: center;">
        <img src="images/mot-de-passe.png" alt="Admin Image" style="width: 250px; height: 200px; border-radius: 5px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5); margin-right: 20px;">
        <p style="flex-grow: 1; align-self: center; font-size: 20px;">Click here to login</p>
    </div>
   
    <a href="loginAd.php" class="btn" style="display: block; margin-top: 20px; background-color: 	#ED7F10; color: white; text-decoration: none; text-align: center; padding: 10px 20px; border-radius: 5px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5); transition: all 0.3s ease;">Login</a>
</div>
</section>



</body>
</html>
<?php include('footer.php'); ?>

