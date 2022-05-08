<?php 

include('server/connection.php');

if(isset($_GET['product_id'])){

  $product_id = $_GET['product_id'];

  $stmt = $conn-> prepare("SELECT * FROM products WHERE product_id = ?");
  
  $stmt->bind_param("i",$product_id);

  $stmt->execute();
  
  $product = $stmt->get_result();
  
}

else{
  header('location: index.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>
<body>

    <!-- NAVBAR-->

    <nav class="navbar navbar-expand-lg navbar-light bg-white py-4 fixed-top">
      <div class="container">
          <img class="logo" src="/assets/imgs/logo.jpeg" alt="">
          <h2 class="brand">Store</h2>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse nav-buttons" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">

            <li class="nav-item">
              <a class="nav-link" href="index.html">Home</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="shop.html">Shop</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="https://www.berqiqch.com">Blog</a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="contact.html">Contact Us</a>
            </li>

            <li class="nav-item">
              <a href="cart.html"><i class="fas fa-shopping-bag"></i></a>
              <a href="account.html"><i class="fas fa-user"></i></a>
            </li>

          </ul>
        </div>
      </div>
    </nav>

    <!-- Single Product-->

    <section class="container single-product my-5 pt-5">
        <div class="row mt-5">

        <?php while ($row = $product -> fetch_assoc()){ ?>

            <div class="col-lg-5 col-md-6 col-sm-12">
                <img class="img-fluid w-100 pb-1" src="/assets/imgs/<?php echo $row['product_image']; ?>" id="mainImg" alt="">
                <div class="small-img-group" id="imgGroup">
                    <div class="small-img-col">
                        <img src="/assets/imgs/<?php echo $row['product_image']; ?>" width="100%" class="small-img" alt="">
                    </div>
                    <div class="small-img-col">
                        <img src="/assets/imgs/<?php echo $row['product_image2']; ?>" width="100%" class="small-img" alt="">
                    </div>
                    <div class="small-img-col">
                        <img src="/assets/imgs/<?php echo $row['product_image3']; ?>" width="100%" class="small-img" alt="">
                    </div>
                    <div class="small-img-col">
                        <img src="/assets/imgs/<?php echo $row['product_image4']; ?>" width="100%" class="small-img" alt="">
                    </div>
                </div>
            </div>


            <div class="col-lg-6 col-md-12 col-12">
                <h6><?php echo $row['product_category']; ?></h6>
                <h3 class="py-4"><?php echo $row['product_name']; ?></h3>
                <h2>$ <?php echo $row['product_price']; ?></h2>

          <form method="POST" action="cart.php">

            <input type="hidden" name="product_id" value = "<?php echo $row['product_id']; ?>"/>
            <input type="hidden" name="product_image" value = "<?php echo $row['product_image']; ?>"/>
            <input type="hidden" name="product_name" value="<?php echo $row['product_name']; ?>">
            <input type="hidden" name="product_price" value="<?php echo $row['product_price']; ?>">
            <input type="number" value="1" name="product_quantity">
            <button class="buy-btn" type="submit" name="add_to_cart">Add To Card</button>

          </form>

                <h4 class="mt-5 mb-5">Product details</h4>
                <span>
                <?php echo $row['product_description']; ?>
                </span>
            </div>
            <?php } ?>

        </div>

    </section>


              <!-- Realated products -->
              <section id="related-products" class="my-5 pb-5">
                <div class="container text-center mt-5 py-5 ">
                  <h3>Related Products</h3>
                  <hr class="mx-auto">
                </div>
                <div class="row mx-auto container-fluid">
                  <div class="product text-center col-lg-3 col-md-4 col-sm-12">
                    <img class="img-fluid mb-3" src="assets/imgs/featured1.jpeg" alt="">
                    <div class="star">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                    </div>
                    <h5 class="p-name">Sports Shoes</h5>
                    <h4 class="p-price">$199.8</h4>
                    <button class="buy-btn">Buy Now</button>
                  </div>
  
                  <div class="product text-center col-lg-3 col-md-4 col-sm-12">
                    <img class="img-fluid mb-3" src="assets/imgs/featured2.jpeg" alt="">
                    <div class="star">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                    </div>
                    <h5 class="p-name">Sports Shoes</h5>
                    <h4 class="p-price">$199.8</h4>
                    <button class="buy-btn">Buy Now</button>
                  </div>
  
                  <div class="product text-center col-lg-3 col-md-4 col-sm-12">
                    <img class="img-fluid mb-3" src="assets/imgs/featured3.jpeg" alt="">
                    <div class="star">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                    </div>
                    <h5 class="p-name">Sports Shoes</h5>
                    <h4 class="p-price">$199.8</h4>
                    <button class="buy-btn">Buy Now</button>
                  </div>
  
                  <div class="product text-center col-lg-3 col-md-4 col-sm-12">
                    <img class="img-fluid mb-3" src="assets/imgs/featured4.jpeg" alt="">
                    <div class="star">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                    </div>
                    <h5 class="p-name">Sports Shoes</h5>
                    <h4 class="p-price">$199.8</h4>
                    <button class="buy-btn">Buy Now</button>
                  </div>
  
                </div>
  
              </section>








    <!-- Footer -->

    <footer class="mt-5 py-5">
        <div class="row container mx-auto pt-5">
              <div class="footer-one col-lg-3 col-md-6 col-md-12">
                  <img class="logo" src="/assets/imgs/logo.jpeg" alt="">
                  <p class="pt-3">We provite the best products for the most affordable prices</p>
              </div>

            <div class="footer-one col-lg-3 col-md-6 col-md-12">
              <h5 class="pb-2">Featured</h5>
              <ul class="text-uppercase">
                <li><a href="#">Men</a></li>
                <li><a href="#">Women</a></li>
                <li><a href="#">Boys</a></li>
                <li><a href="#">Girls</a></li>
                <li><a href="#">New Arrivals</a></li>
                <li><a href="#">clothes</a></li>
              </ul>
            </div>

            <div class="footer-one col-lg-3 col-md-6 col-md-12">
              <h5 class="pb-2">Contact Us</h5>
              <div>
                <h6 class="text-uppercase">Address</h6>
                <p>1233 Street Name,City</p>
              </div>

              <div>
                <h6 class="text-uppercase">Phone</h6>
                <p>+123467980</p>
              </div>

              <div>
                <h6 class="text-uppercase">Email</h6>
                <p>info@email.com</p>
              </div>
            </div>

          <div class="footer-one col-lg-3 col-md-6 col-md-12">
              <h5 class="pb-2">Instagram</h5>
              <div class="row">
                <img src="/assets/imgs/featured1.jpeg" alt="" class="img-fluid w-25 h-100 m-2">
                <img src="/assets/imgs/featured2.jpeg" alt="" class="img-fluid w-25 h-100 m-2">
                <img src="/assets/imgs/watch2.jpeg" alt="" class="img-fluid w-25 h-100 m-2">
                <img src="/assets/imgs/shoes2.jpeg" alt="" class="img-fluid w-25 h-100 m-2">
                <img src="/assets/imgs/shoes1.jpeg" alt="" class="img-fluid w-25 h-100 m-2">
              </div>
          </div>

        </div>

        <div class="copyright mt-5">
          <div class="row container mx-auto">
            <div class="col-lg-4 col-md-5 col-sm-12 mb-4">
              <img src="/assets/imgs/payment.jpeg" alt="">
            </div>
            <div class="col-lg-4 col-md-5 col-sm-12 mb-4 text-nowrap mb-2">
              <p>E-Commerce @ 2022 All Right Reserved</p>
            </div>
            <div class="col-lg-4 col-md-5 col-sm-12 mb-4">
              <a href="#"><i class="fab fa-facebook"></i></a>
              <a href="#"><i class="fab fa-instagram"></i></a>
              <a href="#"><i class="fab fa-twitter"></i></a>
            </div>
          </div>

        </div>

      
    </footer>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

  <script>
     var mainImg = document.getElementById("mainImg");
     var smallImg = document.getElementsByClassName("small-img");

     for( let i=0 ; i<4 ; i++){
     smallImg[i].onclick = function()
        {
         mainImg.src = smallImg[i].src;
        }
    }
  </script>

</body>
</html>