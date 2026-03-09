<?php
// partials/service-and-facts.php
?>
<!-- ===================== SERVICES ===================== -->
<section class="section">
  <div class="container">
    <div class="row">

      <!-- Intro text -->
      <div class="col-lg-6 align-self-center mb-5 mb-lg-0" data-aos="fade-right">
        <h5 class="section-title-sm">Who we are</h5>
        <h2 class="section-title section-title-border-half">
          The Malawi Political Science Association (PSA)
        </h2>
        <p class="mb-4">
          We are a registered entity with a diverse membership of academics and professionals in various
          fields. According to Article&nbsp;4(1) of the PSA Constitution, the Association is non‑partisan
          and does not commit its members to positions not immediately concerned with its purpose.
        </p>
        <a href="about.php" class="btn btn-primary">Explore More</a>
      </div>

      <!-- Service cards -->
      <div class="col-lg-6" data-aos="fade-left">
        <div class="row">
          <!-- Premium -->
          <div class="col-sm-6 mb-4">
            <div class="card border-0 shadow-sm text-center py-5 h-100">
              <i class="ti-medall h2 text-primary mb-3"></i>
              <h5 class="mb-0">Premium Members</h5>
            </div>
          </div>
          <!-- Associate -->
          <div class="col-sm-6 mb-4">
            <div class="card border-0 shadow-sm text-center py-5 h-100">
              <i class="ti-medall-alt h2 text-primary mb-3"></i>
              <h5 class="mb-0">Associate Members</h5>
            </div>
          </div>
          <!-- Honorary -->
          <div class="col-sm-6 mb-4 mb-sm-0">
            <div class="card border-0 shadow-sm text-center py-5 h-100">
              <i class="ti-star h2 text-primary mb-3"></i>
              <h5 class="mb-0">Honorary Members</h5>
            </div>
          </div>
          <!-- Institutional -->
          <div class="col-sm-6">
            <div class="card border-0 shadow-sm text-center py-5 h-100">
              <i class="ti-user h2 text-primary mb-3"></i>
              <h5 class="mb-0">Institutional Members</h5>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===================== FUN FACTS ===================== -->
<section class="fun-facts overlay-dark section-sm" style="background-image:url(images/background/cta.jpg);">
  <div class="container">
    <div class="row text-center text-sm-left">

      <div class="col-lg-3 col-sm-6 mb-4 mb-lg-0" data-aos="zoom-in" data-aos-delay="100">
        <i class="round-icon ti-briefcase mb-3"></i>
        <h2 class="count text-white mb-0" data-count="56">0</h2>
        <p class="text-white mb-0">Current Members</p>
      </div>

      <div class="col-lg-3 col-sm-6 mb-4 mb-lg-0" data-aos="zoom-in" data-aos-delay="200">
        <i class="round-icon ti-book mb-3"></i>
        <h2 class="count text-white mb-0" data-count="30">0</h2>
        <p class="text-white mb-0">Books Published</p>
      </div>

      <div class="col-lg-3 col-sm-6 mb-4 mb-lg-0" data-aos="zoom-in" data-aos-delay="300">
        <i class="round-icon ti-search mb-3"></i>
        <h2 class="count text-white mb-0" data-count="90">0</h2>
        <p class="text-white mb-0">Research Conducted</p>
      </div>

      <div class="col-lg-3 col-sm-6" data-aos="zoom-in" data-aos-delay="400">
        <i class="round-icon ti-cup mb-3"></i>
        <h2 class="count text-white mb-0" data-count="15">0</h2>
        <p class="text-white mb-0">Awards Won</p>
      </div>

    </div>
  </div>
</section>

<!-- Counter animation (optional) -->
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const counters = document.querySelectorAll('.count');
    counters.forEach(counter => {
      const target = +counter.getAttribute('data-count');
      const speed  = 40; // lower is faster
      const updateCount = () => {
        const displayed = +counter.innerText;
        if (displayed < target) {
          counter.innerText = displayed + 1;
          setTimeout(updateCount, speed);
        }
      };
      updateCount();
    });
  });
</script>
