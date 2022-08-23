<?php
    // include mysql database configuration file
    include_once 'db.php';

    if (!empty($_POST['name'])) {

        $name = $_POST['name'];
        $username = mb_strtolower($_POST['name']);
        $password = mb_strtolower($_POST['name']) . '123';
        $file = $_POST['file'];

        $query = "insert into user(username, password) VALUES ('$username','$password')";

        $run = mysqli_query($conn, $query);

        if ($run) {
            $query1 = "select id from user where username='$username'";

            $run1 = mysqli_query($conn, $query1);

            if ($run1) {
                while ($row = mysqli_fetch_array($run1)) {
                    $userId = $row['id'];

                    $query2 = "insert into client(name, UserId) VALUES ('$name','$userId')";

                    $run2 = mysqli_query($conn, $query2);
                    if ($run2) {

                        $fileMimes = array(
                            'text/x-comma-separated-values',
                            'text/comma-separated-values',
                            'application/octet-stream',
                            'application/vnd.ms-excel',
                            'application/x-csv',
                            'text/x-csv',
                            'text/csv',
                            'application/csv',
                            'application/excel',
                            'application/vnd.msexcel',
                            'text/plain'
                        );

                        // Open uploaded CSV file with read-only mode
                        $csvFile = fopen($file, 'r');

                        // Skip the first line
                        fgetcsv($csvFile);

                        $query3 = "select id from client where UserId='$userId'";

                        $run3 = mysqli_query($conn, $query3);
                        $cliId = "";

                        if ($run3) {
                            while ($row = mysqli_fetch_array($run3)) {
                                $cliId = $row['id'];
                            }
                        }


                        // Parse data from CSV file line by line
                        // Parse data from CSV file line by line
                        try{
                            while (($getData = fgetcsv($csvFile, 100000,";")) !== FALSE) {
                                // Get row data

                                if (strlen($getData[0])>0){
                                    $date = $getData[0];
                                    $solar = rtrim(sprintf('%f', $getData[1]), "0");
                                    $eolic=str_replace(' ', '', $getData[2]);
                                    $solar=str_replace(' ', '', $solar);
                                    $run4 = mysqli_query($conn, "INSERT INTO records (RecordDate, solar, eolic, ClientId) VALUES ('$date','$solar','$eolic','$cliId')");

                                }
                            }
                        }catch (Exception $e){}
                        fclose($csvFile);

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