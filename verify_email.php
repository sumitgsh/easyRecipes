

<!DOCTYPE html>
<html>
	<head>
	<title>User Email Verification</title>
	</head>
<body>

<?php
require_once("./includes/initialize.php");

if (isset($_GET['token'])) {
	$conn=$database->open_connection();
    $token = $_GET['token'];
    $sql = "SELECT * FROM users WHERE token='$token' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $query = "UPDATE users SET verified=1 WHERE token='$token'";

        if (mysqli_query($conn, $query)) {
            $msg = "Your email address has been verified successfully";
            // header('location: login.php');
            exit(0);
        }
    } else {
        $msg="User not found!";
    }
} else {
		$msg="No token provided!";
}
?>
<p><?php echo $msg; ?></p>
</body>
</html>



