<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>

<?php
// includes/header.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once __DIR__ . '/meta.php'; ?>

  <meta charset="utf-8">
  <title>Malawi Political Science Association</title>

  
  <!-- mobile responsive meta -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  
  <!-- Bootstrap -->
  <link rel="stylesheet" href="plugins/bootstrap/bootstrap.min.css">
  <!-- magnific popup -->
  <link rel="stylesheet" href="plugins/magnific-popup/magnific-popup.css">
  <!-- Slick Carousel -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
  <link rel="stylesheet" href="plugins/slick/slick.css">
  <link rel="stylesheet" href="plugins/slick/slick-theme.css">
  <!-- themify icon -->
  <link rel="stylesheet" href="plugins/themify-icons/themify-icons.css">
  <!-- animate -->
  <link rel="stylesheet" href="plugins/animate/animate.css">
  <!-- Aos -->
  <link rel="stylesheet" href="plugins/aos/aos.css">
  <!-- swiper -->
  <link rel="stylesheet" href="plugins/swiper/swiper.min.css">
  <!-- Stylesheets -->
  <link href="css/style.css" rel="stylesheet">

  <!--Favicon-->
  <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
  <link rel="icon" href="images/favicon.png" type="image/x-icon">
  
 </head>

<body>
  
<header>
    <!-- top header -->
    <div class="top-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ul class="list-inline text-lg-right text-center">
                        <li class="list-inline-item">
                            <a href="mailto:psamalawi@gmail.com"><i class="ti-email"></i></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="callto:+265 (0) 888 558 560">
                                <span class="ml-2"><i class="ti-mobile"></i></span>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="www.facebook.com/">
                                <span class="ml-2"><i class="ti-facebook"></i></span>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="www.instagram.com/">
                                <span class="ml-2"><i class="ti-instagram"></i></span>
                            </a>
                        </li>                       
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- nav bar -->
    <div class="navigation">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="home.php">
                    <img src="images/logo.png" alt="PSA logo">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">

                        <li class="nav-item dropdown">
                            <a class="nav-link" href="index.php" role="" data-toggle="" aria-haspopup="true"
                                aria-expanded="false">
                                Home
                            </a>
                  
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                About Us
                            </a>
                            <div class="dropdown-menu" >
                                <a class="dropdown-item" href="about.php">About PSA</a>
                                <a class="dropdown-item" href="psa-history.php">History of PSA</a>
                                <a class="dropdown-item" href="conststa.php">Constitution and <br> Mission Statement</a>
                                <a class="dropdown-item" href="team.php">Organisation <br> Structure</a>
                                <a class="dropdown-item" href="afpart.php">Affiliates <br> and Partners</a>                    
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                PSA Membership
                            </a>
                            <div class="dropdown-menu" >
                                <a class="dropdown-item" href="members.php">PSA Members</a>
                                <a class="dropdown-item" href="membership.php">Become a Member</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="psa-news.php" role="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                News & Events
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                              Research  
                            </a>
                            <div class="dropdown-menu" >
                                <a class="dropdown-item" href="">Overview</a>
                                <a class="dropdown-item" href="">Research</a>
                                <a class="dropdown-item" href="">Consultancy</a>
                                <a class="dropdown-item" href="">Training</a>                              
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="" role="button" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                Publications
                            </a>
                            <div class="dropdown-menu" >
                                <a class="dropdown-item" href="journal.php">Journal Articles</a>
                                <a class="dropdown-item" href="">Books</a>
                                <a class="dropdown-item" href="">Policy Papers</a>                          
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.php">Contacts</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</header>
