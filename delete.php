<?php
    include_once 'db.php';

    try {
        if (isset($_GET['deleteid'])){
            $id=$_GET['deleteid'];
            $userId=$_GET['userid'];
            $query = "delete from records where ClientId=$id";
            $run = mysqli_query($conn, $query);
            if ($run) {
                $query1 = "delete from client where id=$id";
                $run1 = mysqli_query($conn, $query1);
                if ($run1){
                    $query2 = "delete from user where id=$userId";
                    $run2 = mysqli_query($conn, $query2);
                    if ($run2){
                        ?>
                        <script type="application/javascript">
                            window.location = "home.php"
                        </script>
                        <?php
                    }
                }
            }
        }

    }catch (Exception $e) {
        echo $e->getMessage();

        echo "<br>" . "You Have Entered Incorrect Password";
    }

