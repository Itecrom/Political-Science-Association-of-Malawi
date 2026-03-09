<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'includes/header.php';
?>

<section class="page-title overlay" style="background-image: url(images/background/page-title.jpg);">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="text-white font-weight-bold">Contact Us</h2>
            </div>
        </div>
    </div>
</section>

<!-- contact -->
<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 offset-lg-1 col-md-5">
                <h2 class="section-title">Contact Us</h2>
                <ul class="pl-0">
                    <!-- contact items -->
                    <li class="d-flex mb-30">
                        <i class="round-icon mr-3 ti-mobile"></i>
                        <div class="align-self-center font-primary">
                            <p>+265 (0) 888 558 560
							<br>+265 (0) 995 623 818
                            <br>+265 (0) 998 377 653</p>
                        </div>
                    </li>
                    <li class="d-flex mb-30">
                        <i class="round-icon mr-3 ti-email"></i>
                        <div class="align-self-center font-primary">
                            <p>Political Science Association,
                            <br>P.O. BOX 624, Zomba, Malawi. 
                            <br><b><u></b>info@psamalawi.org</p></u>
                        </div>
                    </li>
                    <li class="d-flex mb-30">
                        <i class="round-icon mr-3 ti-map-alt"></i>
                        <div class="align-self-center font-primary">
                            <p>Good Vision Camp Street, ZA 61/54 
							<br>before EGPAF, after LEAD offices.
                            <br>Mulunguzi, Zomba</p>
                        </div>
                    </li>	
                </ul>
            </div>
            <!-- form -->
            <div class="col-lg-6">
                <div class="p-5 rounded box-shadow">
                    <form action='' method="post" class="row">
                        <div class="col-12">
                            <h4>Send us a message</h4>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" name="name" id="name" class="form-control" placeholder="Full Name" required>
                        </div>
                        <div class="col-lg-6">
                            <input type="text" name="name" id="subject" class="form-control" placeholder="Message Title" required>
                        </div>
                        <div class="col-12">
                            <input type="email" class="form-control" name="email" id="email" placeholder="Email Address" required>
                        </div>
                        <div class="col-12">
                            <input type="phone" name="phone" id="phone" class="form-control" placeholder="Phone Number" required>
                        </div>
                        <div class="col-12">
                            <textarea class="form-control p-2" name="message" id="message" placeholder="Your Message Here..." required style="height: 150px;"></textarea>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit" value="send">Submit Now</button>
                        </div>						
                    </form>
                </div>
            </div>
        </div>
    </div>

</section>

<section class="map">
    <!-- Google Map -->
<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15387.794089832845!2d35.3338225!3d-15.379274!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x50548cf077fcebbc!2sMalawi%20Political%20Science%20Association!5e0!3m2!1sen!2smw!4v1652115303013!5m2!1sen!2smw" width="100%" height="400" style="upper-border: red 4px";" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</section>


<?php include 'includes/footer.php'; ?>

</body>
</html>