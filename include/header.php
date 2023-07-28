<?php 
    session_start();
    require_once ('require/config.php');

?>
<!doctype html>
<html lang="en">

<head>
    <title>Mobile Store</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Jquery Library -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!--Bootstrap Icons  -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&family=Open+Sans:wght@300;400;500;600;700;800&family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap');
        body{
            font-family: 'Lato', sans-serif;
            font-family: 'Open Sans', sans-serif;
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php?page=index"><span>Mobile Shop</span></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <?php
                    // Get the current page from the URL parameter "page"
                    $current_page = isset($_GET['page']) ? $_GET['page'] : '';

                ?>
                    <ul class="navbar-nav  ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($current_page === 'index') ? 'active' : ''; ?>" aria-current="page" href="index.php?page=index">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($current_page === 'products') ? 'active' : ''; ?>" href="products.php?page=products">Products</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link <?php echo ($current_page === 'category') ? 'active' : ''; ?> dropdown-toggle" href="category.php?page=category" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Categories
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="mobiles.php">Mobiles</a></li>
                                <li><a class="dropdown-item" href="computers.php">Computers</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="android_tvs.php">Android Tvs</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo ($current_page === 'cart') ? 'active' : ''; ?>" href="cart.php?page=cart"><i class="bi bi-cart3"></i><span id="cart-item" class="badge rounded-pill bg-danger"></span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main>