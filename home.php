<?php
    // Start the session
    session_start();
?>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">

        <title>Dashboard</title>
        <meta content="" name="description">
        <meta content="" name="keywords">

        <!-- Favicons -->
        <link href="assets/img/favicon.png" rel="icon">
        <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

        <!-- Google Fonts -->
        <link href="https://fonts.gstatic.com" rel="preconnect">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
              rel="stylesheet">

        <!-- Vendor CSS Files -->
        <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
        <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
        <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
        <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
        <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
        <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

        <link href="assets/css/style.css" rel="stylesheet">

    </head>

    <body>
        <!-- ======= Header ======= -->
        <header id="header" class="header fixed-top d-flex align-items-center">

            <div class="d-flex align-items-center justify-content-between">
                <a href="home.php" class="logo d-flex align-items-center">
                    <img src="assets/img/logo.png" alt="">
                    <span class="d-none d-lg-block">MTX SOLAR</span>
                </a>
                <i class="bi bi-list toggle-sidebar-btn"></i>
            </div><!-- End Logo -->

            <nav class="header-nav ms-auto">
                <ul class="d-flex align-items-center">

                    <li class="nav-item dropdown pe-3">

                        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                           data-bs-toggle="dropdown">
                            <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
                            <span class="d-none d-md-block dropdown-toggle ps-2">
                                <?php
                                    echo $_SESSION["username"]
                                ?>
                            </span>
                        </a><!-- End Profile Iamge Icon -->

                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                            <li class="dropdown-header">
                                <h6>
                                    <?php
                                        echo $_SESSION["username"]
                                    ?>
                                </h6>
                                <span>
                                    <?php
                                        echo mb_strtoupper($_SESSION["role"])
                                    ?>
                                </span>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="index.php">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Sign Out</span>
                                </a>
                            </li>

                        </ul><!-- End Profile Dropdown Items -->
                    </li><!-- End Profile Nav -->

                </ul>
            </nav><!-- End Icons Navigation -->

        </header><!-- End Header -->

        <!-- ======= Sidebar ======= -->
        <aside id="sidebar" class="sidebar">

            <ul class="sidebar-nav" id="sidebar-nav">

                <li class="nav-item">
                    <a class="nav-link " href="home.php">
                        <i class="bi bi-grid"></i>
                        <span>Dashboard</span>
                    </a>
                </li><!-- End Dashboard Nav -->

                <li class="nav-item">
                    <a class="nav-link collapsed" href="graphs.php">
                        <i class="bi bi-bar-chart"></i><span>Graphs</span>
                    </a>
                </li><!-- End Graphs -->

                <li class="nav-item">
                    <a class="nav-link collapsed" href="production-control.php">
                        <i class="bi bi-layout-text-window-reverse"></i><span>Production Control</span>
                    </a>
                </li><!-- End Production Control -->

            </ul>

        </aside><!-- End Sidebar-->

        <main id="main" class="main">

            <div class="pagetitle">
                <h1>Dashboard</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </nav>
            </div><!-- End Page Title -->

            <section class="section dashboard">
                <div class="row">

                    <!-- Sales Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Records <span>| Total Number</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-receipt"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>
                                            <?php
                                                // include mysql database configuration file
                                                include_once 'db.php';

                                                $sql = "select * from records";
                                                $result1 = mysqli_query($conn, $sql);
                                                $num_rows1 = mysqli_num_rows($result1);

                                                echo $num_rows1;
                                            ?>
                                        </h6>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Records Card -->

                    <!-- Selected Client Card -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card revenue-card">
                            <div class="card-body">
                                <h5 class="card-title">Selected Customer</h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>
                                            <?php
                                                if (isset($_SESSION["clientName"])){
                                                    echo "<h6>{$_SESSION['clientName']}</h6>";
                                                }else {
                                                    echo '<h6>No customer selected</h6>';
                                                }
                                            ?>
                                        </h6>
                                        <span class="text-muted small pt-2 ps-1">Select one of the clients below</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Selected Client Card -->

                    <!-- Customers Card -->
                    <div class="col-xxl-4 col-xl-12">

                        <div class="card info-card customers-card">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"></a>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Customers <span>| Now</span></h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>
                                            <?php
                                                // include mysql database configuration file
                                                include_once 'db.php';

                                                $sql = "select * from client";
                                                $result1 = mysqli_query($conn, $sql);
                                                $num_rows1 = mysqli_num_rows($result1);

                                                echo $num_rows1;
                                            ?>
                                        </h6>
                                        <span class="text-muted small pt-2 ps-1">This number is </span><span
                                                class="text-danger small pt-1 fw-bold">always updated</span>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div><!-- End Customers Card -->

                    <!-- Customers List -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Customers List</h5>
                            <button data-bs-toggle='modal' data-bs-target='#verticalycentered' type="button"
                                    class="btn btn-primary"><i class="bi bi-plus-circle me-1"></i>Add Customer
                            </button>
                            <br>
                            <br>
                            <!-- Dark Table -->

                            <?php

                                // include mysql database configuration file
                                include_once 'db.php';

                                $sql = "select * from client";
                                $result = mysqli_query($conn, $sql);

                                echo "
                                <form method='GET'>
                                <table class='table table-dark'>
                                <thead>
                                <tr>
                                    <th scope='col'>Client ID</th>
                                    <th scope='col'>Name</th>
                                    <th scope='col'>User ID</th>
                                    <th scope='col'>Operations</th>
                                </tr>
                                </thead>
                                <tbody>
                                </form>
                                ";

                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "
                                        <tr>
                                            <th scope='row'>{$row['id']}</th>
                                            <td>{$row['name']}</td>
                                            <td>{$row['UserId']}</td>
                                            <td>
                                            <a href='update.php?clientId={$row['id']}&clientName={$row['name']}' type='button' class='btn btn-info'><i class='bi bi-pen-fill me-1'></i>Update Customer</a>
                                            <a href='delete.php?deleteid={$row['id']}&userid={$row['UserId']}' type='button' class='btn btn-danger'><i class='bi bi-person-dash-fill me-1'></i>Remove Customer</a>
                                            <a href='select.php?clientId={$row['id']}&clientName={$row['name']}' type='button' class='btn btn-primary'><i class='bi bi-mouse-fill me-1'></i>Select</a>
                                            </td>
                                        </tr>
                                    ";
                                }
                                echo "
                                </tbody>
                                </table>";
                            ?>

                            <div class="modal fade" id="verticalycentered" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <form action="insert.php" method="POST">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Add Customer</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row mb-3">
                                                    <label for="inputText" class="col-sm-2 col-form-label">Name</label>
                                                    <div class="col-sm-10">
                                                        <input name="name" type="text" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="inputNumber" class="col-sm-2 col-form-label">File
                                                        Upload</label>
                                                    <div class="col-sm-10">
                                                        <input name="file" class="form-control" type="file"
                                                               accept=".csv" id="formFile" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="form-group">
                                                    <button name="submit" type="submit"
                                                            class="form-control btn btn-primary rounded submit px-3">
                                                        Confirm
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- End Dark Table -->

                        </div>
                    </div>
                    <!-- End Customers List -->

                </div>
            </section>

        </main><!-- End #main -->

        <!-- ======= Footer ======= -->
        <footer id="footer" class="footer">
            <div class="copyright">
                &copy; Copyright <strong><span>Bernardo Ferreira</span></strong>. All Rights Reserved
            </div>
        </footer><!-- End Footer -->

        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
                    class="bi bi-arrow-up-short"></i></a>

        <!-- Vendor JS Files -->
        <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
        <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/vendor/chart.js/chart.min.js"></script>
        <script src="assets/vendor/echarts/echarts.min.js"></script>
        <script src="assets/vendor/quill/quill.min.js"></script>
        <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
        <script src="assets/vendor/tinymce/tinymce.min.js"></script>
        <script src="assets/vendor/php-email-form/validate.js"></script>

        <!-- Template Main JS File -->
        <script src="assets/js/main.js"></script>

    </body>

</html>