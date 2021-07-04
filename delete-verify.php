<?php
include 'login-status.php';

$title = "Delete Profile";

include 'functions.php';

include 'config.php';

include 'header.php';

// Get the ID of the record
$memberID = $_GET['memberID'];
$selectQuery = "SELECT * FROM membership WHERE memberID = '$memberID';";
// Retrieve all the data from the record
$selectResult = mysqli_query($dbConnection, $selectQuery);
// Throw an error if the query fails
if (!$selectResult) die(mysqli_error($dbConnection));
// Get and assign the values from the current table record
if ($row = mysqli_fetch_assoc($selectResult)) {
    $firstName = $row['firstname'];
    $lastName = $row['lastname'];
    $username = $row['username'];
    $email = $row['email'];
    $password = $row['password'];
    $profilePicture = $row['image'];
}

$fullName = $firstName . " " . $lastName;

if (isset($_POST['delete'])) {
    // Delete the image from the server
    unlink("/TrevorNoah/php/uploads" . $profilePicture);
    // Delete the account from the database
    $memberID = $_POST['memberID'];
    $deleteQuery = "DELETE FROM membership WHERE memberID = '$memberID' LIMIT 1;";
    $result = mysqli_query($dbConnection, $deleteQuery);
    if (!$result) {
        die(mysqli_error($dbConnection));
    } else {
        $row_count = mysqli_affected_rows($dbConnection);
        if ($row_count == 1) {
            echo "Account deleted";

            // Redirect back to home page
            header("Location: https://2learnweb.brookhavencollege.edu/TrevorNoah/php/index.php");
            exit;
        } else {
            echo "Failed to delete account";
        }
    }
} else {
    // Show the profile
    displayData($profilePicture, $firstName, $lastName, $email, $username);

    // Warning message and verify button for deletion
    echo "Are you sure you want to delete this account? This action cannot be undone.";
    echo <<<EOD
<form action="delete-verify.php" method="post">
	<input type="hidden" name="memberID" value="$memberID">
	<input type="submit" name="delete" value="Yes. Delete this account" class="btn btn-primary">
</form>
EOD;
}

include 'footer.php';
