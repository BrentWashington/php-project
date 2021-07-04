<?php
include 'login-status.php';

$title = "My Profile";

include 'functions.php';

include 'config.php';

include 'header.php';

// Reset form errors
$firstNameError = NULL;
$lastNameError = NULL;
$emailError = NULL;
$passwordError = NULL;
$verifyPasswordError = NULL;
$ProfilePictureError = NULL;

// Reset validation flags
$isValid = false;
$beingEdited = false;
$update = false;
$profileUpdated = false;
$updateSuccessful = false;

// Check whether of not a connection to the database has been established
if (!$dbConnection) {
    echo "MySQL Connection Error: " . mysqli_connect_error();
}

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

if (isset($_GET['edit'])) {
    $beingEdited = true;
}

if (isset($_POST['update'])) {
    $update = true;
}

// Check if the user wants to delete their profile
if (isset($_POST['delete'])) {
    $memberID = $_POST['memberID'];
    // Redirect to delete confirmation page 
    header("Location: https://2learnweb.brookhavencollege.edu/TrevorNoah/php/delete-verify.php?memberID=$memberID");
    exit;
}

// Check if the form has been updated
if ($update == true) {
    $memberID = $_POST['memberID'];
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

    // Assume data integrity
    $isValid = true;

    // Get the values from the form

    $firstName = trim($_POST['first_name']);
    // Capitalize the name
    $firstName = ucwords($firstName);
    $firstName = htmlspecialchars($firstName);
    if (empty($firstName)) {
        $firstNameError = "<span class='error'>Please enter your first name</span>";
        $isValid = false;
    }

    $lastName = trim($_POST['last_name']);
    // Capitalize the name
    $lastName = ucwords($lastName);
    $lastName = htmlspecialchars($lastName);
    if (empty($lastName)) {
        $lastNameError = "<span class='error'>Please enter your last name</span>";
        $isValid = false;
    }

    $email = trim($_POST['email']);
    $email = htmlspecialchars($email);
    // Check for empty or invalid email input
    if (empty($email) || !preg_match('/[-\w.]+@([A-z0-9][-A-z0-9]+\.)+[A-z]{2,4}/', $email)) {
        $emailError = "<span class='error'>Please enter a valid email</span>";
        $isValid = false;
    }

    $password = trim($_POST['password']);
    // Check for empty or invalid password input
    if (empty($password)) {
        $passwordError = "<span class='error'>Please enter a password</span>";
        $isValid = false;
    } elseif (!preg_match('/(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/', $password)) {
        $passwordError = "<span class='error'>Must contain at least one number and 
        one uppercase and lowercase letter, and at least 8 or more characters</span>";
        $isValid = false;
    }

    $verifyPassword = trim($_POST['verify_password']);
    // Compare the entered passwords
    if (strcmp($password, $verifyPassword) != 0) {
        $verifyPasswordError = "<span class='error'>Passwords must match</span>";
        $isValid = false;
    }

    // Check that the files are gif, jpg, or png files and the file size is under 100 KB
    $fileType = pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION);
    if (!(($fileType == "gif") or ($fileType == "jpg") or ($fileType == "png")) and $_FILES['profile_pic']['size'] < 100000) {
        $ProfilePictureError = "<span class='error'>Please choose a valid file</span>";
        $isValid = false;
    } else if (file_exists("uploads/" . $_FILES['profile_pic']['name'])) {
        $ProfilePictureError = "<span class='error'>File already exists</span>";
        $isValid = false;
    }
}

// Executes if the submitted form is valid
if ($isValid == true) {
    $username = strtolower($firstName[0] . $lastName);

    // Check the profile picture for errors and display the error code if there is one
    if ($_FILES['profile_pic']['error'] > 0) {
        echo "Error Code: " . $_FILES['profile_pic']['error'] . "<br>";
    } else {
        // Move the file to a permanent location
        move_uploaded_file($_FILES['profile_pic']['tmp_name'], "uploads/" . $_FILES['profile_pic']['name']);
    }

    // Sanitize the form data for database update
    $firstName = mysqli_escape_string($dbConnection, $firstName);
    $lastName = mysqli_escape_string($dbConnection, $lastName);
    $username = mysqli_escape_string($dbConnection, $username);
    $email = mysqli_escape_string($dbConnection, $email);
    $password = mysqli_escape_string($dbConnection, $password);
    $profilePicture = mysqli_escape_string($dbConnection, $_FILES['profile_pic']['name']);

    // Encrypt the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Query statement for updating the form data into the database table
    $updateQuery =
        "UPDATE membership SET 
            firstname = '$firstName', 
            lastname = '$lastName', 
            username = '$username',
            email = '$email',
            password = '$hashedPassword',
            image = '$profilePicture'
            WHERE memberID = $memberID;";
    // Update the form data into the database
    $updateResult = mysqli_query($dbConnection, $updateQuery);
    // Throw an arrow if the query fails
    if (!$updateResult) {
        die(mysqli_error($dbConnection));
    } else {
        // Get the number of affected table rows
        $row_count = mysqli_affected_rows($dbConnection);
        if ($row_count == 1) {
            // Retrieve the ID of the last record
            $memberID = mysqli_insert_id($dbConnection);
            $updateSuccessful = true;
            $profileUpdated = true;
        } else {
            $updateSuccessful = false;
            echo "Unable to update information";
        }
    }

    // Query and display the data if the update was successful
    if ($updateSuccessful == true) {
        // Query statement for selecting all the fields in the last record
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
            $profilePicture = $row['image'];

            echo "<span class='error'>Update failed</span>";

            // Display the profile
            displayData($profilePicture, $firstName, $lastName, $email, $username);
        } else {
            displayData($profilePicture, $firstName, $lastName, $email, $username);
        }
    }
}

if ($beingEdited == false && $update == false) {
    displayData($profilePicture, $firstName, $lastName, $email, $username);
    echo <<<EOD
<form action="profile.php" method="get">
    <input type="hidden" name="memberID" value="$memberID">
    <input type="submit" name="edit" value="Edit" class="btn btn-primary">
</form>
EOD;
} else if ($profileUpdated == false) {
    echo <<<EOD
<form method="post" action="profile.php" enctype="multipart/form-data">
    <p>
        <label for="first_name"><b>First Name</b></label><br>
        <input type="text" name="first_name" id="first_name" value="$firstName">&nbsp$firstNameError
    </p>

    <p>
        <label for="last_name"><b>Last Name</b></label><br>
        <input type="text" name="last_name" id="last_name" value="$lastName">&nbsp$lastNameError
    </p>

    <p>
        <label for="email"><b>Email</b></label><br>
        <input type="text" name="email" id="email" value="$email">&nbsp$emailError
    </p>

    <p>
        <label for="password"><b>Password</b></label><br>
        <input type="password" name="password" id="password">&nbsp$passwordError
    </p>

    <p>
        <label for="verify_password"><b>Verify Password</b></label><br>
        <input type="password" name="verify_password" id="verify_password">&nbsp$verifyPasswordError
    </p>

    <p>
        <input type="hidden" name="MAX_FILE_SIZE" value="100000"> <!-- File size limited to 100 KB -->
        <label for="profile_picture"><b>Profile Picture</b></label><br>
        <input type="file" name="profile_pic" id="profile_pic"><br>
        $ProfilePictureError
    </p>

    <input type="hidden" name="memberID" value="$memberID">
    <input type="submit" name="update" value="Update" class="btn btn-primary">
    <input type="submit" name="delete" value="Delete" class="btn btn-primary">
</form>
EOD;
}

include 'footer.php';
