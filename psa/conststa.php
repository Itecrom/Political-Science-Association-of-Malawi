<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include 'includes/header.php';
?>


<!-- Search Form -->
<div class="search-form">
    <a href="#" class="close" id="searchClose">
        <i class="ti-close"></i>
    </a>
    <div class="container">
        <form action="#" class="row">
            <div class="col-lg-10 mx-auto">
                <h3>Search Here</h3>
                <div class="input-wrapper">
                    <input type="text" class="form-control" name="search" id="search" placeholder="Enter Keywords..." required>
                    <button>
                        <i class="ti-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- /navigation --> 

<section class="page-title overlay" style="background-image: url(images/background/page-title.jpg);">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="text-white font-weight-bold">PSA Constitution</h2>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- project single -->
<section class="section">
    <div class="container">
        <div class="row">
            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4801370358631853"
     crossorigin="anonymous"></script>
<ins class="adsbygoogle"
     style="display:block"
     data-ad-format="autorelaxed"
     data-ad-client="ca-pub-4801370358631853"
     data-ad-slot="1195692593"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
            <aside class="col-lg-4 order-lg-2 order-1">
                <!-- overview -->
                <div class="p-4 rounded border mb-50">
                    <h4 class="text-color mb-20">Mission Statement</h4>
                    <p>It shall be the purpose of this Association to contribute to political and socio-economic 
                    development of Malawi through promoting the study of Political Science, research, advocacy and policy dialogue.</p>
                </div>
                <!-- case study -->
                <div class="rounded bg-gray border py-3 px-4 mb-50">
                    <i class="d-inline-block mr-1 text-dark ti-files" style="font-size: 20px;"></i>
                    <h4 class="mb-1 d-inline-block">PSA-Mw Constitution</h4>
                    <a class="font-secondary text-color d-block ml-4" href="downloads/PSA Constitution.pdf">Download</a>
                </div>
                <!-- Consultation -->
                <div class="mb-50">
                    <h5 class="mb-20">Become a Member</h5>
                    <form action="memberreg.php" class="row">
                        <div class="col-12">
                            <input type="text" class="form-control" name="name" id="name" placeholder="Name" required>
                        </div>
                        <div class="col-12">
                            <input type="email" class="form-control" name="email" id="email" placeholder="Email Address"
                                required>
                        </div>
                        <div class="col-12">
                            <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject"
                                required>
                        </div>
                        <div class="col-12">
                            <textarea name="question" id="question" class="form-control p-2" placeholder="Your Question Here..."
                                style="height: 150px;"></textarea>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit" value="send">Submit Request</button>
                        </div>
                    </form>
                </div>
            </aside>
            <!-- project content -->
            <div class="col-lg-8 order-lg-1 order-2">
                <img class="img-fluid w-100 mb-60" src="images/project/project-single.jpg" alt="Constitution">
                <div class="tab-content" id="myTabContent">
                    <!-- tab 1 -->
                    <div class="tab-pane fade show active" id="challanges" role="tabpanel" aria-labelledby="challanges-tab">
                        <p>Realizing the importance of political science in the political socio-economic development of the 
                        country, we the trustees of the Association do hereby adopt this constitution setting objectives 
                    and regulations of administration of the said Association whose purpose shall be the promotion of 
                the study of political science, research, advocacy and policy dialogue.</p>
                        <div class="tab-content-item">
                            <h6>The Association is nonpartisan. </h6>
                            <p>It will not support political parties or candidates. It will 
                            not take positions nor commit its members to particular political positions not 
                        immediately concerned with its purpose. </p>
                        </div>
                        <div class="tab-content-item">
                            <h6>The Association shall have the power of</h6>
                            <p>Adopting resolutions or taking such other actions as it deems appropriate in support of academic freedom, and other freedoms by and within the Association and the political profession when in its judgment such freedoms have been clearly violated or threatened </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<?php include 'includes/footer.php'; ?>

</body>
</html>