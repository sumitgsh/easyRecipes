<?php require_once("./includes/initialize.php"); ?>
<?php	
    $session->logout();
    session_destroy();
    redirect_to("index.php");
?>
