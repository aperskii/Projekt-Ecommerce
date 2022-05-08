<?php

session_start();
include('server/connection.php');

if(!isset($_SESSION['logged_in'])){
    header('location: login.php');
    exit;
}

if(isset($_GET['logout'])){
  if(isset($_SESSION['logged_in'])){
    unset($_SESSION['logged_in']);
    unset($_SESSION['user_email']);
    unset($_SESSION['user_name']);

    header('location: login.php');
    exit; 
  }
}


if(isset($_POST['change_password'])){

  $password = $_POST['password'];
  $confirmPassword = $_POST['confirmPassword'];
  $user_email = $_SESSION['user_email'];

        //if password dont match
        if ( $password !== $confirmPassword){
          header('location: account.php?error=passwords dont match');


        //if password less then 6 charact
        }else if(strlen($password) < 6){
          header('location: account.php?error=password must be at least 6 charachters');
        }else{
            
          $stmt = $conn->prepare('UPDATE users SET user_password = ? WHERE user_email = ?');

          $stmt->bind_param('ss',md5($password),$user_email);

          if($stmt->execute()){
            header('location: account.php?message=password had been updated successfully');
          }else{
            header('location: account.php?error=could not update password');
          }

          }

}


//get orders 

if(isset($_SESSION['logged_in'])){

  $user_id = $_SESSION['user_id'];

  $stmt = $conn-> prepare("SELECT * FROM orders WHERE user_id=?");

  $stmt->bind_param('i',$user_id);
  
  $stmt->execute();
  
  $orders = $stmt->get_result();


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
    
    <!-- Account-->

    <section class="my-5 py-5">
        <div class="row container mx-auto">
            <div class="text-center mt-3 pt-5 col-lg-6 col-md-12 col-sm-12">
            <p class="text-center" style ="color: green"><?php if(isset($_GET['register_success'])) { echo $_GET['register_success'];} ?></p>
            <p class="text-center" style ="color: green"><?php if(isset($_GET['login_success'])) { echo $_GET['login_success'];} ?></p>
                <h3 class="font-weight-bold">Account info</h3>
                <hr style="background-color: #fb774b;"  class="mx-auto" >
                <div class="account-info">
                    <p>Name : <span><?php if(isset($_SESSION['user_name'])){ echo $_SESSION['user_name'];} ?></span></p>
                    <p>Email : <span><?php if(isset($_SESSION['user_email'])){ echo $_SESSION['user_email']; } ?></span></p>
                    <p><a href="#orders" id="order-btn">Your orders</a></p>
                    <p><a href="account.php?logout=1" id="logout-btn">Logout</a></p>
                </div>
            </div>

            <div class="col-lg-6 col-md-12 col-sm-12">
                <form method="POST" action="account.php" id="account-form">
                <p class="text-center" style ="color: red"><?php if(isset($_GET['error'])) { echo $_GET['error'];} ?></p>
                <p class="text-center" style ="color: green"><?php if(isset($_GET['message'])) { echo $_GET['message'];} ?></p>
                    <h3>Change Password</h3>
                    <hr style="background-color: #fb774b;"  class="mx-auto" >
                    <div class="form-group">
                        <label for="">Password</label>
                        <input type="password" class="form-control" name="password" id="account-password" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <label for="">Confirm Password</label>
                        <input type="password" class="form-control" name="confirmPassword" id="account-password-confirm" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="change_password" value="Change Password" class="btn" id="change-pass-btn">
                    </div>
                </form>
            </div>
        </div>
    </section>


    
    <!-- Orders-->

    <section id="orders" class="orders container my-5 py-3">
        <div class="container mt-2">
          <h2 class="font-weight-bold text-center">Your Orders</h2>
          <hr class="mx-auto" style="background-color: #fb774b;">
        </div>

        <table class="mt-5 pt-5">
          <tr>
              <th>Order id</th>
              <th>Order Cost</th>
              <th>Order Status</th>
              <th>Order Date</th>
              <th>Order Details</th>
          </tr>


          <?php while ($row = $orders->fetch_assoc() ){ ?>


          <tr>
              <td>
              <!--   <div class="product-info">
                      <img src="/assets/imgs/featured7.jpeg" alt="">  
                    <div>
                        <p class="mt-3"><?php echo $row['order_id']; ?></p>
                    </div>
                </div>
                -->  
                <span><?php echo $row['order_id']; ?></span>
              </td>

              <td>

              <span>$ <?php echo $row['order_cost']; ?></span>
              </td>

              <td>

              <span><?php echo $row['order_status']; ?></span>

              </td>

              <td>
              <span><?php echo $row['order_date']; ?></span>
              </td>

              <td>
              <form method="POST" action="order_details.php">
                  <input type="hidden" name="order_status" value="<?php echo $row['order_status']; ?>">
                  <input type="hidden" value="<?php echo $row['order_id']; ?>" name="order_id">
                  <input name="order_details_btn" class="btn order_details-btn" type="submit" value="Details">
              </form>
              </td>

          </tr>

          <?php } ?>

        </table>

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
