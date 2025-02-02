<?php
include "process/config.php";
$query = "SELECT * FROM rooms";
$result = mysqli_query($conn, $query);


if ($result && mysqli_num_rows($result) > 0) {

    $rooms = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
include "navbar.php"
?>

<body>
    
 <!-- Owl Carousel Section -->
<section class="home-slider owl-carousel">
    <!-- Slide 1 -->
    <div class="slider-item" style="background-image:url(images/31098.jpg);">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text align-items-center justify-content-center">
                <div class="col-md-12 ftco-animate text-center">
                    <div class="text mb-5 pb-3">
                        <h1 class="mb-3">Welcome To HANNA</h1>
                        <h2>Hotels &amp; Resorts</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Slide 2 -->
    <div class="slider-item" style="background-image:url(images/4908.jpg);">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text align-items-center justify-content-center">
                <div class="col-md-12 ftco-animate text-center">
                    <div class="text mb-5 pb-3">
                        <h1 class="mb-3">Enjoy With HANNA </h1>
                        <h2>Join With Us</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>





<style>
    
</style>

    <section class="ftco-section ftc-no-pb ftc-no-pt">
        <div class="container">
            <div class="row">
                <div class="col-md-5 p-md-5 img img-2 d-flex justify-content-center align-items-center"
                    style="background-image: url(images/5080.jpg);">
                    <a href="https://vimeo.com/45830194"
                        class="icon popup-vimeo d-flex justify-content-center align-items-center">
                        <span class="icon-play"></span>
                    </a>
                </div>
                <div class="col-md-7 py-5 wrap-about pb-md-5 ftco-animate">
                    <div class="heading-section heading-section-wo-line pt-md-5 pl-md-5 mb-5">
                        <div class="ml-md-0">
                            <span class="subheading">Welcome to HANNA VILLA</span>
                            <h2 class="mb-4">Welcome To Our Hotel</h2>
                        </div>
                    </div>
                    <div class="pb-md-5">
                        <p>Welcome to the HANNA Villa, where comfort meets elegance in the heart of paradise. From the
                            moment you arrive, you’ll be embraced by the warm ambiance and inviting charm that define
                            our resort. Here, every detail has been carefully crafted to create a peaceful retreat where
                            guests can unwind and immerse themselves in a luxurious escape.</p>

                        <p>Discover spaces that blend modern design with tropical beauty, allowing you to enjoy the best
                            of both worlds. Whether you’re seeking relaxation by the pool, gourmet dining, or an
                            adventure into the surrounding landscapes, the HANNA Villa is your gateway to unforgettable
                            experiences and cherished memories.
                            We invite you to explore, unwind, and indulge in the tranquility that awaits. Welcome to a
                            place where every stay is a special occasion.
                        </p>
                        <ul class="ftco-social d-flex">
                            <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                            <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                            <li class="ftco-animate"><a href="#"><span class="icon-google-plus"></span></a></li>
                            <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section">
        <div class="container">
            <div class="row d-flex">
                <div class="col-md-3 d-flex align-self-stretch ftco-animate">
                    <div class="media block-6 services py-4 d-block text-center">
                        <div class="d-flex justify-content-center">
                            <div class="icon d-flex align-items-center justify-content-center">
                                <span class="flaticon-reception-bell"></span>
                            </div>
                        </div>
                        <div class="media-body p-2 mt-2">
                            <h3 class="heading mb-3">25/7 Front Desk</h3>
                            <p>is always ready to assist you, ensuring a comfortable stay at HANNA Villa.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-flex align-self-stretch ftco-animate">
                    <div class="media block-6 services py-4 d-block text-center">
                        <div class="d-flex justify-content-center">
                            <div class="icon d-flex align-items-center justify-content-center">
                                <span class="flaticon-serving-dish"></span>
                            </div>
                        </div>
                        <div class="media-body p-2 mt-2">
                            <h3 class="heading mb-3">Restaurant Bar</h3>
                            <p>Enjoy exquisite dishes and refreshing drinks at our cozy Restaurant Bar.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-flex align-sel Searchf-stretch ftco-animate">
                    <div class="media block-6 services py-4 d-block text-center">
                        <div class="d-flex justify-content-center">
                            <div class="icon d-flex align-items-center justify-content-center">
                                <span class="flaticon-car"></span>
                            </div>
                        </div>
                        <div class="media-body p-2 mt-2">
                            <h3 class="heading mb-3">Transfer Services</h3>
                            <p>ensure convenient and seamless transportation to and from HANNA Villa.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 d-flex align-self-stretch ftco-animate">
                    <div class="media block-6 services py-4 d-block text-center">
                        <div class="d-flex justify-content-center">
                            <div class="icon d-flex align-items-center justify-content-center">
                                <span class="flaticon-spa"></span>
                            </div>
                        </div>
                        <div class="media-body p-2 mt-2">
                            <h3 class="heading mb-3">Spa Suites</h3>
                            <p>where relaxation and luxury come together for a rejuvenating experience.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section bg-light">
        <div class="container">
            <div class="row justify-content-center mb-5 pb-3">
                <div class="col-md-7 heading-section text-center ftco-animate">
                    <h2 class="mb-4">Our Rooms</h2>
                </div>
            </div>
            <div class="row">
                <?php
                foreach ($rooms as $room) {
                    $images = explode(",", $room['image']);
                ?>
                <div class="col-sm col-md-6 col-lg-4 ftco-animate">
                    <div class="room">
                        <!-- Bootstrap Carousel -->
                        <div id="carousel-<?php echo $room['id_rooms']; ?>" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <?php foreach ($images as $index => $image) { ?>
                                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                    <a href="rooms-single.php?id=<?php echo $room['id_rooms']; ?>"
                                        class="img d-flex justify-content-center align-items-center"
                                        style="background-image: url('<?php echo 'assets/uploads/' . basename($image); ?>');">
                                        <div class="icon d-flex justify-content-center align-items-center">
                                            <span class="icon-search2"></span>
                                        </div>
                                    </a>
                                </div>
                                <?php } ?>
                            </div>
                            <!-- Carousel Controls -->
                            <a class="carousel-control-prev" href="#carousel-<?php echo $room['id_rooms']; ?>"
                                role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carousel-<?php echo $room['id_rooms']; ?>"
                                role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                        <div class="text p-3 text-center">
                            <h3 class="mb-3"><a
                                    href="rooms-single.php?id=<?php echo $room['id_rooms']; ?>"><?php echo $room['name']; ?></a>
                            </h3>
                            <p><span
                                    class="price mr-2">Rp.<?php echo number_format($room['price'], 2, ',', '.'); ?></span>
                                <span class="per">per night</span>
                            </p>
                            <hr>
                            <p class="pt-1"><a href="rooms-single.php?id=<?php echo $room['id_rooms']; ?>"
                                    class="btn-custom">View Room Details <span class="icon-long-arrow-right"></span></a>
                            </p>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>


    <section class="ftco-section ftco-counter img" id="section-counter" style="background-image: url(images/bg_1.jpg);">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-3 d-flex justify-content-center counter-wrap ftco-animate">
                            <div class="block-18 text-center">
                                <div class="text">
                                    <strong class="number" data-number="500">0</strong>
                                    <span>Happy Guests</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 d-flex justify-content-center counter-wrap ftco-animate">
                            <div class="block-18 text-center">
                                <div class="text">
                                    <strong class="number" data-number="6">0</strong>
                                    <span>Rooms</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 d-flex justify-content-center counter-wrap ftco-animate">
                            <div class="block-18 text-center">
                                <div class="text">
                                    <strong class="number" data-number="10">0</strong>
                                    <span>Staffs</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 d-flex justify-content-center counter-wrap ftco-animate">
                            <div class="block-18 text-center">
                                <div class="text">
                                    <strong class="number" data-number="10">0</strong>
                                    <span>Destination</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="ftco-section testimony-section bg-light">
        <div class="container">
            <div class="row">
                <div class="col ftco-animate">
                    <div class="row ftco-animate">
                        <div class="col-md-6">
                            <div class="item">
                                <div class="testimony-wrap py-4 pb-5">
                                    <div class="user-img mb-4"
                                        style="background-image: url(images/Founder\ &\ Architect.jpg)">
                                        <span class="quote d-flex align-items-center justify-content-center">
                                            <i class="icon-quote-left"></i>
                                        </span>
                                    </div>
                                    <div class="text">
                                        <p class="name text-center">Yohan</p>
                                        <p class="position text-dark text-center">Founder & Architect</p>
                                        <p class="mb-4" style="text-align: justify;">Yohan's vision for HANNA Villa
                                            started with a deep love for
                                            architecture and a desire to create a unique sanctuary in Bali. With years
                                            of experience as an architect and designer, Yohan envisioned a space that
                                            would capture both the natural beauty of the island and a sense of luxurious
                                            comfort. His designs are rooted in harmony with the surroundings, blending
                                            modern aesthetics with traditional Balinese elements to create a warm,
                                            inviting space for every guest. For Yohan, HANNA Villa is more than just a
                                            place to stay; it’s an experience crafted with care, elegance, and an
                                            attention to detail that makes every corner feel special.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="item">
                                <div class="testimony-wrap py-4 pb-5">
                                    <div class="user-img mb-4"
                                        style="background-image: url(images/Founder\ &\ Interior\ Designer.jpg)">
                                        <span class="quote d-flex align-items-center justify-content-center">
                                            <i class="icon-quote-left"></i>
                                        </span>
                                    </div>
                                    <div class="text">
                                        <p class="name text-center">HANNA</p>
                                        <p class="position text-dark text-center">Founder & Interior Designer</p>
                                        <p class="mb-4" style="text-align: justify;">HANNA brings Yohan's architectural
                                            vision to life through her
                                            expertise in interior design and management. Her passion lies in creating a
                                            space where guests feel instantly at home. From selecting locally crafted
                                            furniture to choosing the color palettes that bring a serene vibe to each
                                            room, Anna’s touch is evident in every detail. In addition to her design
                                            role, HANNA manages the daily operations of HANNA Villa, ensuring that every
                                            guest’s experience is smooth, personalized, and memorable. Her dedication to
                                            creating a welcoming and stylish environment is the heartbeat of HANNA
                                            Villa, turning it into a beloved escape for travelers.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
<script>
    $(document).ready(function(){
        $(".home-slider").owlCarousel({
            items: 1,               // Only 1 item per slide
            loop: true,             // Loop the carousel
            autoplay: true,         // Auto slide
            autoplayTimeout: 5000,  // Time between each slide in milliseconds (5 seconds)
            autoplayHoverPause: true, // Pause autoplay when hovering over the carousel
            nav: false,             // Disable next/previous navigation buttons
            dots: true,             // Enable dots navigation
        });
    });
</script>
<?php include "footer.php" ?>

</html>