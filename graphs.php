<!DOCTYPE html>
<html lang="en">

    <?php
        // Start the session
        session_start();
    ?>


    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">

        <title>Graphs</title>
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
                            <img src="assets/img/profile.png" alt="Profile" class="rounded-circle">
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
                    <a class="nav-link collapsed" href="home.php">
                        <i class="bi bi-grid"></i>
                        <span>Dashboard</span>
                    </a>
                </li><!-- End Dashboard Nav -->

                <li class="nav-item">
                    <a class="nav-link" href="graphs.php">
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
                <h1>Graphs</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                        <li class="breadcrumb-item active">Graphs</li>
                    </ol>
                </nav>
            </div><!-- End Page Title -->

            <section class="section dashboard">
                <div class="row">
                    <?php
                        if (isset($_SESSION['clientId'])) {
                            echo '<!-- Default Card -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Some parameters</h5>
                            <form action="chart.php" method="POST">
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Priority</label>
                                    <div class="col-sm-10">
                                        <select name="priority" class="form-select" aria-label="Default select example" required>
                                            <option selected value="Solar">Solar</option>
                                            <option value="Eolic">Eolic</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputNumber" class="col-sm-2 col-form-label">Injection point</label>
                                    <div class="col-sm-10">
                                        <input name="injection" step="0.01" type="number" class="form-control" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Display Graph</label>
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-primary">Confirm</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div><!-- End Default Card -->';
                        } else {
                            echo '<div class="col-xxl-4 col-md-6">
                        <div class="card info-card revenue-card">
                            <div class="card-body">
                                <h5 class="card-title">No Customer Selected</h5>

                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>
                                        No customer selected
                                        </h6>
                                        <a href="home.php" class="text-muted small pt-2 ps-1">Select one of the customer first</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!-- End Selected Client Card -->';
                        }
                    ?>
                </div>
            </section>

        </main><!-- End #main -->

        <!-- ======= Footer ======= -->
        <footer id="footer" class="footer">
            <div class="copyright">
                &copy; Copyright <strong><span>Mtx Solar</span></strong>. All Rights Reserved
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