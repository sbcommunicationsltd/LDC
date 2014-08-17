<?php
session_start();

// if the user is logged in, unset the session
if (isset($_SESSION['admin_is_logged_in'])) {
	//logged in, destroy session and start again.
    unset($_SESSION['admin_is_logged_in']);
	unset($_SESSION['admin2_is_logged_in']);
	unset($_SESSION['countlog']);
	unset($_SESSION['countlog2']);
}

// now that the user is logged out,
// go to login page
header('Location: login.php');
?>
