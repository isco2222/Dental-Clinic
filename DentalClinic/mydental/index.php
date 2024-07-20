
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dental Clinic CINS 5103</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- bootstrap cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/css/bootstrap.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.home.css">
   <link rel="" href=""/>

</head>
<body>

<!-- header section starts  -->

<header class="header fixed-top">

   <div class="container">

      <div class="row align-items-center justify-content-between">

         <a href="#home" class="" style="color: #244844;"><h1><b>DentalClinic</b></h1></a>

         <nav class="nav">
            <b><a href="#home">home</a>
            <a href="#about">about</a>
            <a href="#services">services</a>
            <a href="#contact">contact</a>	
         </nav>
	

         <a href="admin.php" class="link-btn">Admin</a>

         <div id="menu-btn" class="fas fa-bars"></div>

      </div>

   </div>

</header>

<!-- header section ends -->

<!-- home section starts  -->

<section class="home" id="home">

   <div class="container">

      <div class="row min-vh-100 align-items-center">
         <div class="content text-left text-mid-left">
            <b><h3>Bringing Confidence to Every Smile.</h3></b>
            <p>Dedicated to enhancing smiles with compassion and care. Committed to dental excellence through advanced technology. Serving our community with integrity and respect.</p>
         </div>
      </div>

   </div>

</section>

<!-- home section ends -->

<!-- about section starts  -->

<section class="about" id="about">

   <div class="container">

      <div class="row align-items-center">

         <div class="col-md-6 image">
            <img src="images/about-img.jpg" class="w-100 mb-5 mb-md-0" alt="">
         </div>

         <div class="col-md-6 content">
            <span>about us</span>
            <h3>A Healthy Smile Starts with Us!</h3>
            <p> Our dedicated team of professionals is committed to providing personalized care, advanced treatments, and a warm, welcoming environment. Trust us to be your partners in achieving optimal oral health.</p>
            

         </div>

      </div>

   </div>

</section>

<!-- about section ends -->

<!-- services section starts  -->

<section class="services" id="services">

   <h1 class="heading">our services</h1>

   <div class="box-container container">

      <div class="box">
         <img src="images/icon-1.svg" alt="">
         <h3>Alignment specialist</h3>
      </div>

      <div class="box">
         <img src="images/icon-2.svg" alt="">
         <h3>Cosmetic dentistry</h3>
      </div>

      <div class="box">
         <img src="images/icon-3.svg" alt="">
         <h3>Oral hygiene experts</h3>
      </div>

      <div class="box">
         <img src="images/icon-4.svg" alt="">
         <h3>Root canal specialist</h3>
      </div>

      <div class="box">
         <img src="images/icon-5.svg" alt="">
         <h3>Live dental advisory</h3>
      </div>

      <div class="box">
         <img src="images/icon-6.svg" alt="">
         <h3>More</h3>
      </div>

   </div>

</section>

<!-- services section ends -->

<!-- process section starts  -->

<section class="process">

   <h1 class="heading">work process</h1>

   <div class="box-container container">

      <div class="box">
         <img src="images/process-1.png" alt="">
         <h3>Cosmetic Dentistry</h3>
         <p>Cosmetic dentistry includes teeth whitening, dental implants, dental crowns, and teeth shaping.</p>
      </div>

      <div class="box">
         <img src="images/process-2.png" alt="">
         <h3>Pediatric Dentistry</h3>
         <p>Padiatric dentistry include stainless steel crowns, tooth-colored fillings, dental cleanings, and cavities.</p>
      </div>

      <div class="box">
         <img src="images/process-3.png" alt="">
         <h3>Dental Implants</h3>
         <p>Dental implants are artificial tooth roots that are surgically placed into the jawbone.</p>
      </div>

   </div>

</section>

<!-- process section ends -->


   
<!-- footer section starts  -->
<section class="contact" id="contact">
<section class="footer">

   <div class="box-container container">

      <div class="box">
         <i class="fas fa-phone"></i>
         <h3>phone number</h3>
         <p>979-456-7890</p>

      </div>

      <div class="box">
         <i class="fas fa-map-marker-alt"></i>
         <h3>our address</h3>
         <p>Houston, Texas - 77308</p>
      </div>

      <div class="box">
         <i class="fas fa-clock"></i>
         <h3>opening hours</h3>
         <p>09:00am to 07:00pm</p>
      </div>

      <div class="box">
         <i class="fas fa-envelope"></i>
         <h3>email address</h3>
         <p>dclinic@gmail.com</p>

      </div>

   </div>

   <div class="credit"> &copy; <?php echo date('Y'); ?> <span>DentalClinic</span> All Reserved Rights </div>

</section>
</section>

<!-- footer section ends -->



<!-- custom js file link  -->
<script src="js/script1.js"></script>

</body>
</html>

<?php

$conn = mysqli_connect('localhost','root','','dentalclinic') or die('connection failed');

?>
