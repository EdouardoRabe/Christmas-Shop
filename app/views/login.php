<?php
  $racine="";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous"
    ></script> -->
    <link rel="stylesheet" href="assets/css/style.css" />
    <title>Sign in & Sign up Form</title>
  </head>
  <body>
    <div class="container">
      <?= $form?>

      <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
          <h3>New here?</h3>
          <p>
            Welcome to our platform! Join us today and enjoy access to exclusive gifts and personalized recommendations 
          </p>

            <button class="btn transparent" id="sign-up-btn">
              Sign up
            </button>
          </div>
          <img src="assets/img/4.png" class="image" alt="" />
        </div>
        <div class="panel right-panel">
          <div class="content">
          <h3>One of us?</h3>
          <p>
            Welcome back! Log in to explore new offers, manage your gifts, and continue creating unforgettable memories with us. 
            We're excited to have you here!
          </p>

            <button class="btn transparent" id="sign-in-btn">
              Sign in
            </button>
          </div>
          <img src="assets/img/3.png" class="image" alt="" />
        </div>
      </div>
    </div>

    <script src="assets/js/app.js"></script>
  </body>
</html>
