<?php

include('server/connection.php');

if(isset($_POST['order_details_btn']) && isset($_POST['order_id'])){

    $order_id = $_POST['order_id'];
    $order_status = $_POST['order_status'];

    $stmt = $conn-> prepare("SELECT * FROM order_items WHERE order_id =?");

    $stmt->bind_param('i',$order_id);

    $stmt->execute();
  
    $order_details = $stmt->get_result();
}else{

    header('location: account.php');
    exit;
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
    




        <!-- Order Details-->

        <section id="orders" class="orders container my-5 py-3">
        <div class="container mt-5">
          <h2 class="font-weight-bold text-center">Order details</h2>
          <hr class="mx-auto" style="background-color: #fb774b;">
        </div>

        <table class="mt-5 pt-5 mx-auto">
          <tr>
              <th>Product </th>
              <th>Price</th>
              <th>Quantity</th>
          </tr>


          <?php while ($row = $order_details->fetch_assoc() ){ ?>

                    <tr>
                        <td>
                            <div class="product-info">
                                <img src="/assets/imgs/<?php echo $row['product_image']; ?>" alt="">  
                                <div>
                                    <p class="mt-3"><?php echo $row['product_name']; ?></p>
                                </div>
                            </div>
                            
                        </td>

                        <td>
                        <span>$ <?php echo $row['product_price']; ?></span>
                        </td>

                        <td>
                        <span><?php echo $row['product_quantity']; ?></span>
                        </td>
          
                    </tr>

          <?php } ?>

        </table>

                <?php if($order_status =="not paid"){  ?>

                    <form style="float: right;" action="">

                        <input class="btn btn-primary" type="submit" value="Pay Now" name="">

                    </form>

                <?php } ?>


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


</body>
</html>