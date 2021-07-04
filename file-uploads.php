<?php
include 'functions.php';

include 'header.php';

$title = "PHP and HTML";

// Reset form contents for a new form
$username = NULL;
$firstName = NULL;
$lastName = NULL;
$email = NULL;
$password = NULL;
$verifyPassword = NULL;

// Reset form errors
$firstNameError = NULL;
$lastNameError = NULL;
$emailError = NULL;
$passwordError = NULL;
$verifyPasswordError = NULL;
$ProfilePictureError = NULL;

// Set the validation flag to false to load the form
$isValid = false;

// Check if the form has been submitted
if (isset($_POST['submit'])) {
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
    if (empty($password)) {
        $passwordError = "<span class='error'>Please enter a password</span>";
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

// Display the values on the page if the form is valid
if ($isValid) {
    $username = strtolower($firstName[0] . $lastName);
    $fullName = $firstName . " " . $lastName;

    // Open the membership file for appending content
    $membershipFile = fopen("membership.txt", "a") or die("Unable to open file.");
    // User data to be appended to the membership file
    $membershipFormat = $fullName . "," . $email . "," . $password . "," . $username . ",";
    // Write the data to the membership file
    fwrite($membershipFile, $membershipFormat);
    // Close the file
    fclose($membershipFile);

    // Check the profile picture for errors and display the error code if there is one
    if ($_FILES['profile_pic']['error'] > 0) {
        echo "Error Code: " . $_FILES['profile_pic']['error'] . "<br>";
    } else {
        // Move the file to a permanent location
        move_uploaded_file($_FILES['profile_pic']['tmp_name'], "uploads/" . $_FILES['profile_pic']['name']);
    }

    // Display the form contents
    echo "<br><br>";
    echo '<img src="' . "uploads/" . $_FILES['profile_pic']['name'] . '" alt="Profile Picture">' . "<br>";
    echo "Name: " . $fullName . "<br>";
    echo "Email: " . $email . "<br>";
    echo "Password: " . $password . "<br>";
    echo "Username: " . $username . "<br>";
    echo "<br>";

    $poem = "poem.txt";
    // Open the poem file for reading content
    $poemFile = fopen($poem, "r") or die("Unable to open file.");
    // Display the file's contents
    echo nl2br(fread($poemFile, filesize($poem)));
    // Close the file
    $poemFile = fclose($poemFile);
} else {
    echo <<<EOD
<form method="post" action="file-uploads.php" enctype="multipart/form-data">
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
        <input type="text" name="password" id="password" value="$password">&nbsp$passwordError
    </p>

    <p>
        <label for="verify_password"><b>Verify Password</b></label><br>
        <input type="text" name="verify_password" id="verify_password" value="$verifyPassword">&nbsp$verifyPasswordError
    </p>

    <p>
        <input type="hidden" name="MAX_FILE_SIZE" value="100000"> <!-- File size limited to 100 KB -->
        <label for="profile_picture"><b>Profile Picture</b></label><br>
        <input type="file" name="profile_pic" id="profile_pic"><br>
        $ProfilePictureError
    </p>

    <input type="submit" name="submit" value="Submit">
</form>
EOD;
}

include 'footer.php';
