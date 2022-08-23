<!DOCTYPE html>
<html lang="en">

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

        <?php
            // Start the session
            session_start();
            include_once 'db.php';
            include_once 'power.php';

            $injection = $_POST['injection'];
            $priority = $_POST['priority'];

            $query1 = "select RecordDate, Solar, Eolic from records where ClientId={$_SESSION['clientId']}";
            $run1 = mysqli_query($conn, $query1);
            $dates = [];
            $solar = [];
            $eolic = [];
            $totalProduction = [];
            $injectedPower = [];
            $surplus = [];
            $solarSurplus = [];
            $eolicSurplus = [];
            $surplusPerc = [];
            $solarSurplusPerc = [];
            $eolicSurplusPerc = [];


            if ($run1) {
                while ($row = mysqli_fetch_array($run1)) {
                    $dates[] = "'{$row['RecordDate']}'";
                    $solar[] = round($row['Solar'],2);
                    $eolic[] = round($row['Eolic'],2);

                    $power = new Power();
                    $power->solar = round($row['Solar'],2);
                    $power->eolic = round($row['Eolic'],2);
                    $power->pontoInjeccao = round($injection,2);

                    $mode = 0;
                    if ($priority == 'Solar') {
                        $mode = 1;
                    } else {
                        $mode = 2;
                    }

                    $power->modo = $mode;

                    $totalProduction[] = round($power->Total(),2);
                    $injectedPower[] = round($power->PotenciaI(),2);
                    $surplus[] = round($power->Excedente(),2) ;
                    $solarSurplus[] = round($power->Excedentesolar(),2);
                    $eolicSurplus[] = round($power->Excedenteeolic(),2);
                    $surplusPerc[] = round($power->Excedenteper(),2);
                    $solarSurplusPerc[] = round($power->Excedentepersolar(),2);
                    $eolicSurplusPerc[] = round($power->Excedentepereolic(),2);

                }

                $dates = implode(',', $dates);
                $solar = implode(',', $solar);
                $eolic = implode(',', $eolic);
                $totalProduction = implode(',', $totalProduction);
                $injectedPower = implode(',', $injectedPower);
                $surplus = implode(',', $surplus);
                $solarSurplus = implode(',', $solarSurplus);
                $eolicSurplus = implode(',', $eolicSurplus);
                $surplusPerc = implode(',', $surplusPerc);
                $solarSurplusPerc = implode(',', $solarSurplusPerc);
                $eolicSurplusPerc = implode(',', $eolicSurplusPerc);
            }
        ?>

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
                        <li class="breadcrumb-item"><a href="graphs.php">Graphs</a></li>
                        <li class="breadcrumb-item active">Chart</li>
                    </ol>
                </nav>
            </div><!-- End Page Title -->

            <section class="section dashboard">
                <div class="row">

                    <div class="col-lg-6" style="min-width: 90%;">
                        <div class="card" style="width: 100%;">
                            <div class="card-body" style="width: 100%;">
                                <h5 class="card-title">Chart</h5>

                                <!-- Line Chart -->
                                <div id="lineChart"></div>

                                <script>
                                    document.addEventListener("DOMContentLoaded", () => {
                                        const chart = new ApexCharts(document.querySelector("#lineChart"), {
                                            series: [
                                                {
                                                    name: "Solar",
                                                    data: [
                                                        <?=
                                                            $solar
                                                            ?>
                                                    ]
                                                },
                                                {
                                                    name: "Eolic",
                                                    data: [
                                                        <?=
                                                            $eolic
                                                            ?>
                                                    ]
                                                },
                                                {
                                                    name: "Total Production",
                                                    data: [
                                                        <?=
                                                            $totalProduction
                                                            ?>
                                                    ]
                                                },
                                                {
                                                    name: "Injected Power",
                                                    data: [
                                                        <?=
                                                            $injectedPower
                                                            ?>
                                                    ]
                                                },
                                                {
                                                    name: "Total Surplus",
                                                    data: [
                                                        <?=
                                                            $surplus
                                                            ?>
                                                    ]
                                                },
                                                {
                                                    name: "Solar Surplus",
                                                    data: [
                                                        <?=
                                                            $solarSurplus
                                                            ?>
                                                    ]
                                                },
                                                {
                                                    name: "Eolic Surplus",
                                                    data: [
                                                        <?=
                                                            $eolicSurplus
                                                            ?>
                                                    ]
                                                },
                                                {
                                                    name: "Surplus Percentage",
                                                    data: [
                                                        <?=
                                                            $surplusPerc
                                                            ?>
                                                    ]
                                                },
                                                {
                                                    name: "Solar Surplus Percentage",
                                                    data: [
                                                        <?=
                                                            $solarSurplusPerc
                                                            ?>
                                                    ]
                                                },
                                                {
                                                    name: "Eolic Surplus Percentage",
                                                    data: [
                                                        <?=
                                                            $eolicSurplusPerc
                                                            ?>
                                                    ]
                                                },
                                            ],
                                            chart: {
                                                type: 'line',
                                                zoom: {
                                                    enabled: true
                                                },
                                                toolbar: {
                                                    export: {
                                                        csv: {
                                                            filename: 'chart',
                                                            columnDelimiter: ';',
                                                            headerCategory: 'category',
                                                            headerValue: 'value',
                                                            dateFormatter(timestamp) {
                                                                let dat = new Date(timestamp);
                                                                let hours = dat.toISOString().split('T')[1].split('.')[0];
                                                                return dat.toISOString().split('T')[0] + ' ' + hours.split(':')[0] + ':' + hours.split(':')[1]
                                                            }
                                                        }
                                                    }
                                                }
                                            },
                                            dataLabels: {
                                                enabled: false
                                            },
                                            stroke: {
                                                curve: 'smooth'
                                            },
                                            grid: {
                                                row: {
                                                    colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                                                    opacity: 0.5
                                                },
                                            },
                                            colors: ["#F3B415", "#F27036", "#663F59", "#6A6E94", "#4E88B4", "#00A7C6", "#18D8D8", '#A9D794',
                                                '#46AF78', '#A93F55', '#8C5E58', '#2176FF', '#33A1FD', '#7A918D', '#BAFF29'
                                            ],
                                            xaxis: {
                                                type: 'datetime',
                                                categories: [
                                                    <?=
                                                        $dates
                                                        ?>
                                                ],
                                            },
                                            yaxis: {
                                                type: 'numeric'
                                            }
                                        });

                                        chart.render();
                                        /*
                                        chart.hideSeries("Total Production");
                                        chart.hideSeries("Injected Power");
                                        chart.hideSeries("Total Surplus");
                                        chart.hideSeries("Solar Surplus");
                                        chart.hideSeries("Eolic Surplus");
                                        chart.hideSeries("Surplus Percentage");
                                        chart.hideSeries("Solar Surplus Percentage");
                                        chart.hideSeries("Eolic Surplus Percentage");
                                         */
                                    });


                                </script>
                                <!-- End Line Chart -->

                            </div>
                        </div>
                    </div>
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