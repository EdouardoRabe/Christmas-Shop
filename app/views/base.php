<?php $racine=""; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Christmas Shop</title>
    <link rel="shortcut icon" href="icons/icon-1.png" type="image/x-icon">
    <!-- Font Awoseme -->
    <script src="assets/js/accueil.js" crossorigin="anonymous"></script>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- Custom Css -->
    <link rel="stylesheet" href="assets/css/accueil.css">
    <link rel="stylesheet" href="assets/css/depot.css">
    
</head>

<body>
    <?php include($page.'.php')?>


    <footer id="contact" class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top container">
        <div class="col-md-4 d-flex align-items-center">
            <a href="/" class="mb-3 me-2 mb-md-0 text-muted text-decoration-none lh-1">
                <svg class="bi" width="30" height="24">
                    <use xlink:href="#bootstrap"></use>
                </svg>
            </a>
            <span class="mb-3 mb-md-0 text-muted">© 2025 Christmas Shop, EDOUARDO ETU003285, MICKAELLA ETU003276</span>
        </div>

        <ul class="nav col-md-4 justify-content-end list-unstyled d-flex font">
            <li class="ms-3"><a class="text-muted" href="#"><i class="fa-brands fa-twitter"></i></a></li>
            <li class="ms-3"><a class="text-muted" href="#"><i class="fa-brands fa-facebook"></i></a></li>
            <li class="ms-3"><a class="text-muted" href="#"><i class="fa-brands fa-github"></i></a></li>
        </ul>
    </footer>
    <script src="assets/js/bundle.min.js"></script>
    <script src="assets/js/ajax.js"></script>
</body>

</html>