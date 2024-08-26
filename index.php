<?php
include('includes/header.php');
?>

    <!-- Carousel Start -->
    <div class="container-fluid mb-3">
        <div class="row px-xl-5">
            <div class="col-lg-8">
                <div id="header-carousel" class="carousel slide carousel-fade mb-30 mb-lg-0" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#header-carousel" data-slide-to="0" class="active"></li>
                        <li data-target="#header-carousel" data-slide-to="1"></li>
                        <li data-target="#header-carousel" data-slide-to="2"></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item position-relative active" style="height: 430px;">
                            <img class="position-absolute w-100 h-100" src="img/carousal1.jpg" style="object-fit: cover;">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">Fresh Plants</h1>
                                    <p class="mx-md-5 px-5 animate__animated animate__bounceIn">Fresh plants are lush and vibrant, with dewy leaves and tender shoots, creating a thriving, green landscape</p>
                                    <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp" href="shop.php">Shop Now</a>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item position-relative" style="height: 430px;">
                            <img class="position-absolute w-100 h-100" src="img/carousal2.jpg" style="object-fit: cover;">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">Alive with growth
                                    </h1>
                                    <p class="mx-md-5 px-5 animate__animated animate__bounceIn">Amid the garden's vibrant colors, each fresh plant is alive with growth, thriving and radiating lush, green energy</p>
                                    <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp" href="shop.php">Shop Now</a>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item position-relative" style="height: 430px;">
                            <img class="position-absolute w-100 h-100" src="img/carousal3.jpg" style="object-fit: cover;">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown">Freshly planted</h1>
                                    <p class="mx-md-5 px-5 animate__animated animate__bounceIn">Freshly planted seedlings are bursting with energy, their vibrant green leaves reaching toward the sun in healthy growth.</p>
                                    <a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp" href="#">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="product-offer mb-30" style="height: 200px;">
                    <img class="img-fluid" src="img/ofpic1.jpg" alt="">
                    <div class="offer-text">
                        <h6 class="text-white text-uppercase">Buy now !</h6>
                        <h3 class="text-white mb-3">Go Green</h3>
                        <a href="shop.php" class="btn btn-primary">Shop Now</a>
                    </div>
                </div>
                <div class="product-offer mb-30" style="height: 200px;">
                    <img class="img-fluid" src="img/ofpic2.jpg" alt="">
                    <div class="offer-text">
                        <h6 class="text-white text-uppercase">Buy now !</h6>
                        <h3 class="text-white mb-3">Green Plants</h3>
                        <a href="" class="btn btn-primary">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Carousel End -->


    <!-- Featured Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5 pb-3">
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Quality Product</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
                    <h5 class="font-weight-semi-bold m-0">Free Shipping</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa-duotone fa-solid fa-handshake text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">100% Trusted</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">24/7 Support</h5>
                </div>
            </div>
        </div>
    </div>
    <!-- Featured End -->


    <!-- Categories Start -->
    <div class="container-fluid pt-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Categories</span></h2>
        <div class="row px-xl-5 pb-3">

            <!-- Fetching Categories Query Starts -->

            <?php
            $catquery=$pdo->prepare('SELECT * FROM categories WHERE status = 1');
            $catquery->execute();

            $cdata=$catquery->fetchAll(PDO::FETCH_ASSOC);

            foreach($cdata as $catdata){
                ?>
            <div class="col-lg-6 col-md-4 col-sm-6 pb-1">
                <a class="text-decoration-none" href="">
                    <div class="cat-item d-flex align-items-center mb-4">
                        <div class="overflow-hidden" style="width: 100px; height: 100px;">
                            <img class="img-fluid" src="Dashboard/img/categoryimages/<?php echo $catdata['image']?>" 
                            style="width: 100%; height: 100%; object-fit: cover; alt="">
                        </div>
                        <div class="flex-fill pl-3">
                            <h5><?php echo $catdata['name']?></h5>
                            <small>
                                <a href="subcatsee.php?cid=<?php echo $catdata['category_id']?>">
                                    <!-- <i class="fa-solid fa-arrow-right fa-2x"></i> -->
                                     <button class="btn btn-dark"><i class="fa-solid fa-eye"></i></button>
                                </a>
                            </small>
                        </div>
                    </div>
                </a>
            </div>

                <?php
            }

            ?>
            <!-- Fetching Categories Query Ends -->
           
        </div>
    </div>
    <!-- Categories End -->



    <!-- Offer Start -->
    <div class="container-fluid pt-5 pb-3">
        <div class="row px-xl-5">
            <div class="col-md-6">
                <div class="product-offer mb-30" style="height: 300px;">
                    <img class="img-fluid" src="img/ofpic1.jpg" alt="">
                    <div class="offer-text">
                        <h6 class="text-white text-uppercase">Buy Now !</h6>
                        <h3 class="text-white mb-3">Go Green</h3>
                        <a href="shop.php" class="btn btn-success">Shop Now</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="product-offer mb-30" style="height: 300px;">
                    <img class="img-fluid" src="img/ofpic2.jpg" alt="">
                    <div class="offer-text">
                        <h6 class="text-white text-uppercase">Buy Now !</h6>
                        <h3 class="text-white mb-3">Green Plants</h3>
                        <a href="" class="btn btn-success">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Offer End -->



    <?php
    include('includes/footer.php');
    ?>