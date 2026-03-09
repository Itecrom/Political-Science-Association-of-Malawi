<?php
// includes/footer.php
?>
<footer class="bg-secondary">
  <div class="py-100 border-bottom" style="border-color: green !important">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <div class="mb-5 mb-md-0 text-center text-md-left">
            <img class="mb-30" src="images/logo-footer.png" alt="logo">
            <p class="text-white mb-30">We have diverse membership of academics and professionals in political science and related fields, committed to advancing governance and development in Malawi.</p>
            <ul class="list-inline mb-0">
              <li class="list-inline-item"><a class="social-icon-outline" href="#"><i class="ti-facebook"></i></a></li>
              <li class="list-inline-item"><a class="social-icon-outline" href="#"><i class="ti-twitter-alt"></i></a></li>
              <li class="list-inline-item"><a class="social-icon-outline" href="#"><i class="ti-vimeo-alt"></i></a></li>
              <li class="list-inline-item"><a class="social-icon-outline" href="#"><i class="ti-linkedin"></i></a></li>
            </ul>
          </div>
        </div>
        <div class="col-lg-2 col-md-4 col-6">
          <h4 class="text-white mb-4">What we do</h4>
          <ul class="footer-links">
            <li><a href="#">Research</a></li>
            <li><a href="about.html">Publications</a></li>
            <li><a href="contact.html">Trainings</a></li>
            <li><a href="/">Academics</a></li>
            <li><a href="#">Political News</a></li>
          </ul>
        </div>
        <div class="col-lg-2 col-md-4 col-6">
          <h4 class="text-white mb-4">Quick Links</h4>
          <ul class="footer-links">
            <li><a href="#">Our History</a></li>
            <li><a href="/">About Us</a></li>
            <li><a href="contact.html">Contact Us</a></li>
            <li><a href="/">Service</a></li>
            <li><a href="#">Privacy Policy</a></li>
          </ul>
        </div>
        <div class="col-lg-3 offset-lg-1">
          <div class="mt-5 mt-lg-0 text-center text-md-left">
            <h4 class="mb-4 text-white">Subscribe Us</h4>
            <p class="text-white mb-4">Receive our Newsletters, Opportunities, Events and latest news </p>
            <form action="#" class="position-relative">
              <input type="text" class="form-control subscribe" name="subscribe" id="Subscribe" placeholder="Enter Your Email">
              <button class="btn-subscribe" type="submit" value="send">
                <i class="ti-arrow-right"></i>
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
<div class="pt-4 pb-3 position-relative">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 col-md-5"><p class="text-white text-center text-md-left mb-0"><span class="text-primary">Malawi PSA</span> &copy; <?= date('Y'); ?> All Rights Reserved</p></div>
        <div class="col-lg-6 col-md-7">
          <ul class="list-inline text-center text-md-right mb-0">
            <li class="list-inline-item mx-lg-3 my-lg-0 mx-2 my-2"><a class="font-secondary text-white" href="#">Register</a></li>
            <li class="list-inline-item mx-lg-3 my-lg-0 mx-2 my-2"><a class="font-secondary text-white" href="#">Legal</a></li>
            <li class="list-inline-item mx-lg-3 my-lg-0 mx-2 my-2"><a class="font-secondary text-white" href="faqs.php">Faq</a></li>
            <li class="list-inline-item ml-lg-3 my-lg-0 ml-2 my-2 ml-0"><a class="font-secondary text-white" href="#">Terms &amp; Conditions</a></li>
          </ul>
        </div>
      </div>
    </div>
    <button class="back-to-top"><i class="ti-angle-up"></i></button>
  </div>
</footer>

<!-- Core JS libraries (order matters) -->
<script src="plugins/jQuery/jquery.min.js"></script>
<script src="plugins/bootstrap/bootstrap.min.js"></script>
<script src="plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
<script src="plugins/slick/slick.min.js"></script>
<script src="plugins/filterizr/jquery.filterizr.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_KEY"></script>
<script src="plugins/google-map/gmap.js"></script>
<script src="plugins/syotimer/jquery.syotimer.js"></script>
<script src="plugins/aos/aos.js"></script>
<script src="plugins/swiper/swiper.min.js"></script>
<script src="js/script.js"></script>

<!-- Hero slider activation -->
<script>
(function ($) {
  $(document).ready(function () {
    if ($.fn.slick && $('.hero-slider-2').length) {
      $('.hero-slider-2').slick({
        autoplay      : true,
        autoplaySpeed : 4500,
        speed         : 900,
        fade          : true,
        cssEase       : 'ease-in-out',
        arrows        : true,
        prevArrow     : '<button type="button" class="slick-prev"><i class="ti-angle-left"></i></button>',
        nextArrow     : '<button type="button" class="slick-next"><i class="ti-angle-right"></i></button>',
        dots          : true,
        pauseOnHover  : false,
        adaptiveHeight: true
      });
    }
  });
})(jQuery);
</script>

</body>
</html>
