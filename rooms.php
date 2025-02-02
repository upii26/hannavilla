<?php
include("process/config.php");



$query = "SELECT * FROM rooms";
$result = mysqli_query($conn, $query);


if ($result && mysqli_num_rows($result) > 0) {
	
	$rooms = mysqli_fetch_all($result, MYSQLI_ASSOC);
	
}

include "navbar.php"
?>

<style>
    .search {
  position: absolute;
  margin: auto;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  width: 80px;
  height: 80px;
  background: crimson;
  border-radius: 50%;
  transition: all 0.5s ease;

  z-index: 4;
  box-shadow: 0 0 25px 0 rgba(0, 0, 0, 0.4);

  &:hover {
    cursor: pointer;
    box-shadow: 0 0 40px rgba(255, 0, 0, 0.6);
  }

  &::before {
    content: "";
    position: absolute;
    margin: auto;
    top: 22px;
    right: 0;
    bottom: 0;
    left: 22px;
    width: 12px;
    height: 2px;
    background: white;
    transform: rotate(45deg);
    transition: all 0.5s ease;
  }

  &::after {
    content: "";
    position: absolute;
    margin: auto;
    top: -5px;
    right: 0;
    bottom: 0;
    left: -5px;
    width: 25px;
    height: 25px;
    border-radius: 50%;
    border: 2px solid white;
    transition: all 0.5s ease;
  }
}

input {
  font-family: "Inconsolata", monospace;
  width: 50px;
  height: 50px;
  outline: none;
  border: none;
  background: crimson;
  color: white;
  text-shadow: 0 0 10px crimson;
  padding: 0 80px 0 20px;
  border-radius: 30px;
  box-shadow: 0 0 25px 0 crimson, 0 20px 25px 0 rgba(0, 0, 0, 0.2);
  transition: all 0.5s ease;
  opacity: 0;
  z-index: 5;
  font-weight: bolder;
  letter-spacing: 0.1em;

  &:hover {
    cursor: pointer;
  }

  &:focus {
    width: 300px;
    opacity: 1;
    cursor: text;
    transition: width 0.5s ease;
  }

  &:focus ~ .search {
    right: -250px;
    background: #80011f;
    z-index: 6;

    &::before {
      top: 0;
      left: 0;
      width: 25px;
    }

    &::after {
      top: 0;
      left: 0;
      width: 25px;
      height: 2px;
      border: none;
      background: white;
      border-radius: 0%;
      transform: rotate(-45deg);
    }
  }

  &::placeholder {
    color: white;
    opacity: 0.5;
    font-weight: bolder;
  }
}

</style>

<div class="hero-wrap" style="background-image: url('images/1783.jpg');">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text d-flex align-itemd-end justify-content-center">
            <div class="col-md-9 ftco-animate text-center d-flex align-items-end justify-content-center">
                <div class="text">
                    <p class="breadcrumbs mb-2"><span class="mr-2"><a href="index.html">Home</a></span>
                        <span>About</span>
                    </p>
                    <h1 class="mb-4 bread">Rooms</h1>
                </div>
            </div>
        </div>
    </div>
</div>


<section class="ftco-section bg-light">
    <div class="container">
        <div class="row mb-4">
            <div class="col justify-content-end d-flex">
                <div class="search-container">
                    <input type="text" placeholder="Search..." id="searchInput">
                    <div class="search"></div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-lg-12">
                <div class="row">
                    <?php
                    foreach ($rooms as $room) {
                        $images = explode(",", $room['image']); 
                    ?>
                    <div class="col-sm col-md-6 col-lg-4 ftco-animate">
                        <div class="room">
                            <!-- Bootstrap Carousel -->
                            <div id="roomCarousel<?php echo $room['id_rooms']; ?>" class="carousel slide"
                                data-bs-ride="carousel" data-bs-interval="3000">
                                <div class="carousel-inner">
                                    <?php foreach ($images as $index => $image) { ?>
                                    <div class="carousel-item <?php if ($index === 0) echo 'active'; ?>">
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
                            </div>

                            <!-- Detail rooms -->
                            <div class="text p-3 text-center">
                                <h3 class="mb-3"><a
                                        href="rooms-single.php?id=<?php echo $room['id_rooms']; ?>"><?php echo $room['name']; ?></a>
                                </h3>
                                <p><span
                                        class="price mr-2">Rp.<?php echo number_format($room['price'], 2, ',', '.'); ?></span>
                                    <span class="per">per night</span>
                                </p>
                                <ul class="list">
                                    <li><span>Max:</span> <?php echo $room['person']; ?> Persons</li>
                                    <li><span>Size:</span> <?php echo $room['size']; ?></li>
                                    <li><span>Bed:</span> <?php echo $room['bed']; ?></li>
                                </ul>
                                <hr>
                            </div>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>


</body>
<?php include "footer.php" ?>

<script>
    
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const searchButton = document.querySelector('.search');

    searchButton.addEventListener('click', function() {
        if (searchInput.style.opacity === '0') {
            searchInput.style.opacity = '1';
            searchInput.style.width = '300px'; // Perluas input saat di-klik
            searchInput.focus();
        } else {
            searchInput.style.opacity = '0';
            searchInput.style.width = '50px'; // Kembalikan ke ukuran awal
            searchInput.value = ''; // Kosongkan input
        }
    });

    searchInput.addEventListener('blur', function() {
        if (searchInput.value === '') {
            searchInput.style.opacity = '0';
            searchInput.style.width = '50px'; // Kembalikan ke ukuran awal
        }
    });
});
// Event listener for dynamic search filter
searchInput.addEventListener("input", function () {
    const searchQuery = this.value.toLowerCase();
    const rooms = document.querySelectorAll(".room");

    rooms.forEach((room) => {
        const roomName = room.querySelector("h3 a").innerText.toLowerCase();
        const roomPrice = room.querySelector(".price").innerText.toLowerCase();
        const roomPerson = room.querySelector("ul.list li:nth-child(1)").innerText.toLowerCase();
        const roomSize = room.querySelector("ul.list li:nth-child(2)").innerText.toLowerCase();
        const roomBed = room.querySelector("ul.list li:nth-child(3)").innerText.toLowerCase();

        if (
            roomName.includes(searchQuery) ||
            roomPrice.includes(searchQuery) ||
            roomPerson.includes(searchQuery) ||
            roomSize.includes(searchQuery) ||
            roomBed.includes(searchQuery)
        ) {
            room.parentElement.style.display = "block";
        } else {
            room.parentElement.style.display = "none";
        }
    });
});
</script>

</html>