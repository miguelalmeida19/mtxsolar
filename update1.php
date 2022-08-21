<?php
    // include mysql database configuration file
    include_once 'db.php';
    session_start();

    if (!empty($_POST['name'])) {

        $name = $_POST['name'];
        $id = $_SESSION['editId'];
        $query = "
        update client
        set name='$name'
        where id=$id
        ";
        $run = mysqli_query($conn, $query);
    }

    if (!empty($_POST['file'])) {
        $file = $_POST['file'];
        $id = $_SESSION['editId'];

        $query = "
            delete from records
            where ClientId=$id;
        ";

        $run = mysqli_query($conn, $query);

        if ($run){
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

            // Parse data from CSV file line by line
            // Parse data from CSV file line by line
            while (($getData = fgetcsv($csvFile, 100000, ";")) !== FALSE) {
                // Get row data
                $date = $getData[0];

                $solar = $getData[1];

                $eolic = $getData[2];

                $run4 = mysqli_query($conn, "INSERT INTO records (RecordDate, solar, eolic, ClientId) VALUES ('$date','$solar','$eolic','$id')");
            }
            fclose($csvFile);
        }
    }

?>
    <script type="application/javascript">
        window.location = "home.php"
    </script>
<?php
?>