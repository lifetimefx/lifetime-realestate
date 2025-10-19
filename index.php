<?php 
session_start();
require_once 'config/database.php';
require_once 'classes/User.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>lifetime - Real estate</title>
    <link rel="stylesheet" href="assets/css/style.css" />
    <link
      href="https://fonts.googleapis.com/css?family=Nunito:200,300,regular,500,600,700,800,900,200italic,300italic,italic,500italic,600italic,700italic,800italic,900italic"
      rel="stylesheet"
    />

    <link rel="stylesheet" href="assets/css/media.css" />

    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
    />
  </head>
  <body>
    <header>
      <nav>
        <div class="logo">LIFETIME</div>

        <ul>
          <li><a href="#home">Home</a></li>
          <li><a href="#about">About</a></li>
          <li><a href="">Features</a></li>
          <li><a href="">Pricing</a></li>
          <li><a href="">Categories</a></li>
        </ul>

        <div class="buttons">
          <a href="">Login</a>
            <a href="<?php $user = new User();
            $user->logout(); echo BASE_URL . '/login.php';
            ?>">Logout</a>
          <a href="">Register</a>
        </div>

        <div class="menutoggler">
          <i class="fa fa-bars"></i>
        </div>
      </nav>
    </header>

    <section id="home">
      <div class="col">
        <h1>Find Your Dream Home with Confidence at LIFETIME Real Estate</h1>

        <h3>
          Discover the perfect property with our trusted real estate experts.
          Browse homes, apartments, and land for sale or rent — all in one
          place.
        </h3>

        <div class="homebutton">
          <a href="">See features</a>
          <a href="">Pricing</a>
        </div>
      </div>
      <div class="col"></div>
    </section>

    <section id="about">
        <div class="col">

        </div>
        <div class="col">
            <h1>About us</h1>
            <p>
                Welcome to [Your Company Name], your trusted partner in real estate. We are dedicated to helping individuals, families, and investors find the perfect property that matches their goals and lifestyle.
            </p>

            <p>
                With years of industry experience, we combine expert market knowledge with personalized service to make every property journey smooth and rewarding. Whether you’re buying, selling, or investing, our team is committed to guiding you every step of the way — with transparency, professionalism, and care.
            </p>

            <p>
                At [Your Company Name], we don’t just sell properties — we help you find a place to call home and build lasting value for the future.
            </p>

            <div class="media">
                <a href="https://wa.me/+2348101274164" target="_blank"><i class="fab fa-whatsapp"></i></a>
                <a href=""><i class="fab fa-facebook"></i></a>
                <a href=""><i class="fab fa-instagram"></i></a>

                 <a href=""><i class="fab fa-telegram"></i></a>

                  <a href=""><i class="fab fa-tiktok"></i></a>

                   <a href=""><i class="fab fa-x"></i></a>
               
            </div>
        </div>
    </section>

    <section id="pricing">
        <div class="col">
            <div class="priceimage">

            </div>
            <p>
                $500
            </p>
            <div class="details">
                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Est, harum perspiciatis cum quasi voluptas aliquam ducimus, aspernatur, expedita a nam libero itaque! Nisi ea id illum totam. Est, ipsa quos.
            </div>
            <div class="buttons">
                <a href="">View</a>
                <a href=""><i class="fa fa-heart"></i></a>
            </div>
        </div>
        <div class="col"></div>
        <div class="col"></div>
    </section>
  </body>
</html>
