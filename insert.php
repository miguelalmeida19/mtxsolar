<?php
    $host = "localhost";
    $user = "root";
    $password = "";
    $db = "mtxsolar";

    $con = mysqli_connect($host, $user, $password);
    mysqli_set_charset($con, "utf8mb4");
    mysqli_select_db($con, $db);

    if (!empty($_POST['name'])) {

        $name = $_POST['name'];
        $username = mb_strtolower($_POST['name']);
        $password = mb_strtolower($_POST['name']) . '123';
        $file = $_POST['file'];

        $query = "insert into user(username, password) VALUES ('$username','$password')";

        $run = mysqli_query($con, $query);

        if ($run) {
            $query1 = "select id from user where username='$username'";

            $run1 = mysqli_query($con, $query1);

            if ($run1) {
                while ($row = mysqli_fetch_array($run1)) {
                    $userId = $row['id'];

                    $query2 = "insert into client(name, UserId) VALUES ('$name','$userId')";

                    $run2 = mysqli_query($con, $query2);
                    if ($run2) {
                        ?>
                        <script type="application/javascript">
                            window.location = "home.php"
                        </script>
                        <?php
                    }
                }
            }
        }
    }
?>