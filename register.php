<?php
session_start();
include('server/connection.php');

  //if user had already registred , then take user to account page
if(isset($_SESSION['logged_in'])){

  header('location: account.php');
  exit;
}

 if(isset($_POST['register'])){

          $name = $_POST['name'];
          $email = $_POST['email'];
          $password = $_POST['password'];
          $confirmPassword = $_POST['confirmPassword'];

    //if password dont match
       if ( $password !== $confirmPassword){
          header('location: register.php?error=passwords dont match');
    

    //if password less then 6 charact
       }else if(strlen($password) < 6){
          header('location: register.php?error=password must be at least 6 charachters');


    //if there is no error  
       }else{
          //check whether there is a user with this email or not 
                $stmt1 = $conn->prepare("SELECT count(*) FROM users WHERE user_email=?");
                $stmt1->bind_param("s",$email);
                $stmt1->execute();
                $stmt1->bind_result($num_rows);
                $stmt1->store_result();
                $stmt1->fetch();

          //if there is a user already registred with this email
          if($num_rows != 0){
                header('location: register.php?error=user with this email already exists');

          //if no user registred with this email before
          }else{

                //create a new user
                $stmt = $conn->prepare("INSERT INTO users (user_name,user_email,user_password) 
                                VALUES (?,?,?)");

                $stmt->bind_param("sss",$name,$email,md5($password));


                //if account was created successfully
                if($stmt->execute()){
                    $user_id = $stmt->insert_id;
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['user_email'] = $email;
                    $_SESSION['user_name'] = $name;
                    $_SESSION['logged_in'] = true;
                    header('location: account.php?register_success=You registered successfully');

                //if account could not registred
                }else{
                    header('location : register.php?error=could not create an account at the moment');
                }

          }


  }



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
    
    <!-- Register-->

    <section class="my-5 py-5">
        <div class="container text-center mt-3 pt-5">
            <h2 class="form-weight-bold">Register</h2>
            <hr style="background-color: #fb774b;"  class="mx-auto" >
        </div>
        <div class="mx-auto container"> 
            <form method="POST" action="register.php" id="register-form">
              <p style ="color: red"><?php if(isset($_GET['error'])) { echo $_GET['error'];} ?></p>
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" class="form-control" id="register-name" name="name" placeholder="Name" required>
                </div>
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="text" class="form-control" id="register-email" name="email" placeholder="email" required>
                </div>
                <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" class="form-control" id="register-password" name="password" placeholder="password" required>
                </div>
                <div class="form-group">
                    <label for="">Confirm Password</label>
                    <input type="password" class="form-control" id="register-confirm-password" name="confirmPassword" placeholder="Confirm Password" required>
                </div>
                <div class="form-group">
                    <input type="submit" name="register" class="btn" id="register-btn" value="Register">
                </div>
                <div class="form-group">
                    <a id="login-url" class="btn" href="/login.php">Do you have an account ? Login</a>
                </div>
            </form>
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


</body>
</html>
