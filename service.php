<?php
    session_start();
    $id = $_GET['clientId'];
    $name = $_GET['name'];
    $_SESSION['editName'] = $name;
    $_SESSION['editId'] = $id;
?>
    <script type="application/javascript">
        window.location = "home.php"
    </script>
<?php
?>