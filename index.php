<?php
    // Start the session
    session_start();
?>
    <html lang="en">
        <head>
            <title>Login</title>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <link type="image/png" href="assets/img/favicon.png" rel="icon">

            <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

            <link rel="stylesheet"
                  href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

            <link rel="stylesheet" href="css/style.css">

        </head>
        <body>
            <section class="ftco-section">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-7 col-lg-5">
                            <div class="wrap">
                                <div class="img" style="background-image: url(images/banner.jpg);"></div>
                                <div class="login-wrap p-4 p-md-5">
                                    <div class="d-flex">
                                        <div class="w-100">
                                            <h3 class="mb-4">Sign In</h3>
                                        </div>
                                    </div>
                                    <form method="POST" action="#" class="signin-form">
                                        <div class="form-group mt-3">
                                            <input name="username" type="text" class="form-control" required>
                                            <label class="form-control-placeholder" for="username">Username</label>
                                        </div>
                                        <div class="form-group">
                                            <input name="password" id="password-field" type="password"
                                                   class="form-control" required>
                                            <label class="form-control-placeholder" for="password">Password</label>
                                            <span toggle="#password-field"
                                                  class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                        </div>
                                        <div class="form-group">
                                            <button name="submit" type="submit"
                                                    class="form-control btn btn-primary rounded submit px-3">
                                                Sign In
                                            </button>
                                        </div>
                                        <div class="form-group d-md-flex">
                                            <div class="w-50 text-left">
                                                <label class="checkbox-wrap checkbox-primary mb-0">Remember Me
                                                    <input type="checkbox" checked>
                                                    <span class="checkmark"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <script src="js/jquery.min.js"></script>
            <script src="js/popper.js"></script>
            <script src="js/bootstrap.min.js"></script>
            <script src="js/main.js"></script>

        </body>
    </html>

<?php
    // include mysql database configuration file
    include_once 'db.php';

    $_SESSION['clientName'] = null;
    $_SESSION['clientId'] = null;

    if (isset($_POST['username'])) {
        $uname = $_POST['username'];
        $password = $_POST['password'];

        $_SESSION["username"] = $uname;

        $sql = "select * from user where username='" . $uname . "'AND password='" . $password . "' limit 1";
        $sql1 = "SELECT * FROM client";

        try {
            $result = mysqli_query($conn, $sql);
            $result1 = mysqli_query($conn, $sql1);

            $num_rows = mysqli_num_rows($result);
            $num_rows1 = mysqli_num_rows($result1);

            $_SESSION["clients"]=$num_rows1;

            if ($num_rows == 1) {
                if (strcmp($uname,"admin")===0) {
                    $_SESSION["role"] = "admin";
                }
                else if (strcmp($uname,"manager")===0) {
                    $_SESSION["role"] = "manager";
                }
                else {
                    $_SESSION["role"] = "client";
                }
                echo "<br>" . "You Have Successfully Logged In";
                ?>
                <script type="application/javascript">
                    window.location = "home.php"
                </script>
                <?php
            } else {
                echo "<br>" . "You Have Entered Incorrect Password";
            }
        } catch (Exception $e) {
            echo $e->getMessage();

            echo "<br>" . "You Have Entered Incorrect Password";
        }
    }
?>