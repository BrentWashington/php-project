<?php
include 'login-status.php';

$title = "Home";
include 'header.php';

// Display the logout message if the user signed out
if (isset($_GET['message'])) {
    $logoutMessage = $_GET['message'];
    echo '<div class="alert alert-info" role="alert">' . $logoutMessage . '</div>';
}

// Determines the name to display the welcome message
if (isset($_COOKIE['firstname'])) {
    $firstName = $_COOKIE['firstname'];
} else {
    $firstName = "Guest";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-4">Hello, <?php echo $firstName; ?>!</h1>
            <p class="lead">
                I am currently a college student working toward my Associates of Applied Science degree. I have
                many hobbies that I enjoy doing during my free time.
            </p>
        </div>
    </div>
</body>

</html>

<?php
include 'footer.php';
?>