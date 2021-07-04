<?php
session_start();

$title = "Log In";

include 'functions.php';

include 'config.php';

include 'header.php';

$hashedPassword = NULL;

$usernameError = NULL;
$passwordError = NULL;
$noRecordError = NULL;
$isValid = false;


if (isset($_POST['login'])) {
    $isValid = true;

    $username = trim($_POST['username']);
    $username = htmlspecialchars($username);
    if (empty($username)) {
        $usernameError = "<span class='error'>Please enter your username</span>";
        $isValid = false;
    }

    $password = trim($_POST['password']);
    $password = htmlspecialchars($password);
    if (empty($password)) {
        $passwordError = "<span class='error'>Please enter your password</span>";
        $isValid = false;
    }

    if ($isValid == true) {
        $stmt = $dbConnection->stmt_init();
        if ($stmt->prepare("SELECT password FROM membership WHERE username = ?")) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->bind_result($hashedPassword);
            $stmt->fetch();
            $stmt->close();
        }

        // Check if the entered password matches the stored one
        if (password_verify($password, $hashedPassword)) {
            // Query the database for username and membership values
            $query = "SELECT username FROM membership WHERE username = '$username' AND password = '$hashedPassword';";
            $result = mysqli_query($dbConnection, $query);
            if (!$result) die(mysqli_error($dbConnection));

            // Get and assign the matching record values
            if ($row = mysqli_fetch_assoc($result)) {
                // Assign username and password record values to session variables
                $_SESSION['username'] = $row['username'];

                $username = $_SESSION['username'];

                // Retrieve the member ID and first name of the current record
                $selectQuery = "SELECT * FROM membership WHERE username = '$username' AND password = '$hashedPassword';";
                $selectResult = mysqli_query($dbConnection, $selectQuery);
                // Throw an error if the query fails
                if (!$selectResult) die(mysqli_error($dbConnection));
                // Assign the ID and first name record value to a session variables
                if ($row = mysqli_fetch_assoc($selectResult)) {
                    $_SESSION['memberID'] = $row['memberID'];
                    $_SESSION['firstname'] = $row['firstname'];
                    $_SESSION['lastname'] = $row['lastname'];
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['image'] = $row['image'];
                }

                // Create a cookie to store the user's first name for 30 days
                setcookie('firstname', $_SESSION['firstname'], time() + 60 * 60 * 24 * 30);

                // Redirect back to the home page
                header("Location: index.php");
                exit;
            } else {
                echo '<div class="alert alert-danger" role="alert">No account found in the system.</div>';
            }
        } else {
            echo '<div class="alert alert-danger" role="alert">No account found in the system.
            New users must register before gaining access to the site. 
            If you forgot your login, please use the Password Recover tool.</div>';
        }
    }
}

echo <<<EOD
<form action="login.php" method="post">
    <p>
        <label for="username"><b>Username</b></label><br>
        <input type="text" name="username" id="username">&nbsp$usernameError
    </p>

    <p>
        <label for="password"><b>Password</b></label><br>
        <input type="password" name="password" id="password">&nbsp$passwordError
    </p>

    <input type="submit" name="login" value="Log In" class="btn btn-primary">
</form>
EOD;

include 'footer.php';
