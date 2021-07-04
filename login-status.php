<?php
session_start();

// Check whether or not the user is logged in
if (isset($_SESSION['memberID'])) {
    echo <<<EOD
    <form action="login-status.php" method="post">
        <input type="hidden" name="memberID" value="$memberID">
        <input type="submit" name="logout" value="Log Out" class="btn btn-primary">
    </form>
EOD;
} else {
    echo <<<EOD
    <a href="login.php">
        <input type="button" value="Log In" class="btn btn-primary">
    </a>
EOD;
}

// Log out the user by destroying all the session variables
if (isset($_POST['logout'])) {
    $message = "You are logged out";
    foreach ($_SESSION as $key => $value) {
        unset($_SESSION[$key]);
    }

    session_destroy();
    header("Location: index.php?message=$message");
    exit;
}
