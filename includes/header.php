<?php
// includes/header.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once __DIR__ . '/meta.php'; ?>

    <!-- Adsense -->
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4801370358631853" crossorigin="anonymous"></script>

    <!-- Core Styles -->
    <link rel="stylesheet" href="/plugins/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="/plugins/magnific-popup/magnific-popup.css">
    <link rel="stylesheet" href="/plugins/slick/slick.css">
    <link rel="stylesheet" href="/plugins/slick/slick-theme.css">
    <link rel="stylesheet" href="/plugins/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="/plugins/animate/animate.css">
    <link rel="stylesheet" href="/plugins/aos/aos.css">
    <link rel="stylesheet" href="/plugins/swiper/swiper.min.css">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>

<header>
    <!-- top header -->
    <div class="top-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ul class="list-inline text-lg-right text-center mb-0">
                        <li class="list-inline-item"><a href="mailto:psamalawi@gmail.com"><i class="ti-email"></i></a></li>
                        <li class="list-inline-item"><a href="callto:+265888558560"><i class="ti-mobile"></i></a></li>
                        <li class="list-inline-item"><a href="https://www.facebook.com/"><i class="ti-facebook"></i></a></li>
                        <li class="list-inline-item"><a href="https://www.instagram.com/"><i class="ti-instagram"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- navigation bar -->
    <div class="navigation">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="/home.php"><img src="<?= $base ?>/images/logo.png" alt="PSA logo"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item"><a class="nav-link" href="/home.php">Home</a></li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">About Us</a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="/about.php">About PSA</a>
                                <a class="dropdown-item" href="/psa-history.php">History of PSA</a>
                                <a class="dropdown-item" href="/conststa.php">Constitution &amp; Mission</a>
                                <a class="dropdown-item" href="/team.php">Organisation Structure</a>
                                <a class="dropdown-item" href="/afpart.php">Affiliates &amp; Partners</a>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Membership</a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="/members.php">PSA Members</a>
                                <a class="dropdown-item" href="/membership.php">Become a Member</a>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">News &amp; Events</a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="/psa-news.php">News</a>
                                <a class="dropdown-item" href="/psa-events.php">Events</a>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Research</a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="/research.php">Overview</a>
                                <a class="dropdown-item" href="/consultancy.php">Consultancy</a>
                                <a class="dropdown-item" href="/training.php">Training</a>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Publications</a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="/books.php">Books</a>
                                <a class="dropdown-item" href="/policy-papers.php">Policy Papers</a>
                                <a class="dropdown-item" href="/journal-articles.php">Journal Articles</a>
                            </div>
                        </li>

                        <li class="nav-item"><a class="nav-link" href="/contact.php">Contacts</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</header>
