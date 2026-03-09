<?php
// partials/client-logos.php
?>
<section class="bg-primary py-4">
  <div class="container">
    <div class="client-logo-slider swiper clientSwiper">
      <div class="swiper-wrapper">
        <div class="swiper-slide text-center py-2"><img src="images/clients/client-1.png" alt="Client 1" style="max-height: 50px;"></div>
        <div class="swiper-slide text-center py-2"><img src="images/clients/client-2.png" alt="Client 2" style="max-height: 50px;"></div>
        <div class="swiper-slide text-center py-2"><img src="images/clients/client-3.png" alt="Client 3" style="max-height: 50px;"></div>
        <div class="swiper-slide text-center py-2"><img src="images/clients/client-4.png" alt="Client 4" style="max-height: 50px;"></div>
        <div class="swiper-slide text-center py-2"><img src="images/clients/client-5.png" alt="Client 5" style="max-height: 50px;"></div>
      </div>
    </div>
  </div>
</section>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    if (document.querySelector('.clientSwiper')) {
      new Swiper('.clientSwiper', {
        loop: true,
        slidesPerView: 2,
        spaceBetween: 30,
        breakpoints: {
          576: { slidesPerView: 3 },
          768: { slidesPerView: 4 },
          992: { slidesPerView: 5 }
        },
        autoplay: {
          delay: 2500,
          disableOnInteraction: false
        }
      });
    }
  });
</script>
