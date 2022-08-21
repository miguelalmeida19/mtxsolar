<?php
    session_start();
    $id = $_GET['clientId'];
    $name = $_GET['clientName'];
    $_SESSION['clientName'] = $name;
    $_SESSION['clientId'] = $id;
?>
    <script type="application/javascript">
        window.location = "home.php"
    </script>
<?php
?>