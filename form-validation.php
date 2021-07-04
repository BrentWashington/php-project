<?php
session_start();

include 'functions.php';

$title = "PHP and HTML";

// Set the sticky fields to null for a new form
$name = NULL;
$color = NULL;
$email = NULL;
$password = NULL;
$verifyPassword = NULL;
$instrument = NULL;
$animals = NULL;
$urbanAreas = NULL;
$activity = NULL;

$guitarChecked = NULL;
$drumsChecked = NULL;
$pianoChecked = NULL;
$violinChecked = NULL;

$dogsChecked = NULL;
$catsChecked = NULL;
$wolvesChecked = NULL;
$lionsChecked = NULL;

$area1Checked = NULL;
$area2Checked = NULL;
$area3Checked = NULL;
$area4Checked = NULL;
$area5Checked = NULL;

$basketballSelected = NULL;
$footballSelected = NULL;
$baseballSelected = NULL;
$tennisSelected = NULL;
$golfSelected = NULL;

// Set the error messages to null
$nameError = NULL;
$colorError = NULL;
$emailError = NULL;
$passwordError = NULL;
$verifyPasswordError = NULL;
$instrumentError = NULL;
$animalsError = NULL;
$urbanAreasError = NULL;
$activityError = NULL;

// Set the validation flag to false to load the form
$isValid = false;

// Check if the form has been submitted
if (isset($_POST['submit'])) {
    // Assume data integrity
    $isValid = true;

    // Get the values from the form

    $name = htmlspecialchars($_POST['name']);
    // Capitalize each name
    $name = ucwords($name);
    $name = trim($name);
    if (empty($name)) {
        $nameError = "<span class='error'>Please enter a name</span>";
        $isValid = false;
    }

    $color = htmlspecialchars($_POST['color']);
    $color = trim($color);
    if (empty($color)) {
        $colorError = "<span class='error'>Please enter a color</span>";
        $isValid = false;
    }

    $email = htmlspecialchars($_POST['email']);
    $email = trim($email);
    // Check for empty or invalid email input
    if (empty($email) || !preg_match('/[-\w.]+@([A-z0-9][-A-z0-9]+\.)+[A-z]{2,4}/', $email)) {
        $emailError = "<span class='error'>Please enter a valid email</span>";
        $isValid = false;
    }

    $password = htmlspecialchars($_POST['password']);
    $password = trim($password);
    if (empty($password)) {
        $passwordError = "<span class='error'>Please enter a password</span>";
        $isValid = false;
    }

    $verifyPassword = htmlspecialchars($_POST['verify_password']);
    $verifyPassword = trim($verifyPassword);
    // Compare the entered passwords
    if (strcmp($password, $verifyPassword) != 0) {
        $verifyPasswordError = "<span class='error'>Passwords must match</span>";
        $isValid = false;
    }

    // Check if an instrument has been selected
    if (isset($_POST['instrument'])) {
        $instrument = $_POST['instrument'];
        // Check the instrument for the sticky field
        switch ($instrument) {
            case 'guitar':
                $guitarChecked = "checked";
                break;
            case 'drums':
                $drumsChecked = "checked";
                break;
            case 'piano':
                $pianoChecked = "checked";
                break;
            default:
                $violinChecked = "checked";
                break;
        }
    } else {
        $instrumentError = "<span class='error'>Please select an instrument</span>";
        $isValid = false;
    }

    // Check if an animal has been selected
    if (isset($_POST['animal'])) {
        $animals = $_POST['animal'];
        foreach ($animals as $key => $value) {
            // Get the checked boxes for the sticky field
            switch ($value) {
                case 'dogs':
                    $dogsChecked = "checked";
                    break;
                case 'cats':
                    $catsChecked = "checked";
                    break;
                case 'wolves':
                    $wolvesChecked = "checked";
                    break;
                case 'lions':
                    $lionsChecked = "checked";
                    break;
                default:
                    // Do nothing
                    break;
            }

            // Get the selected animals from the check boxes
            if ($firstAnimal == "") {
                $firstAnimal = $value;
            } else {
                $secondAnimal = $value;
            }
        }

        // Ensure that only two checkboxes are selected
        $checkedAnimals = 0;
        $checkedAnimals = count($animals);
        if ($checkedAnimals != 2) {
            $animalsError = "<span class='error'>Please select two animals</span>";
            $isValid = false;
        }
    } else {
        $animalsError = "<span class='error'>Please select two animals</span>";
        $isValid = false;
    }

    // Check if an urban area has been selected
    if (isset($_POST['urban_area'])) {
        $urbanAreas = $_POST['urban_area'];
        foreach ($urbanAreas as $key => $value) {
            // Get the checked boxes for the sticky field
            switch ($value) {
                case 'Reunion Tower':
                    $area1Checked = "checked";
                    break;
                case 'Dallas County Courthouse':
                    $area2Checked = "checked";
                    break;
                case 'Fountain Place':
                    $area3Checked = "checked";
                    break;
                case 'Chase Tower':
                    $area4Checked = "checked";
                    break;
                case 'Renaissance Tower':
                    $area4Checked = "checked";
                    break;
                default:
                    // Do nothing
                    break;
            }
            // Get the selected areas from the check boxes
            if ($firstUrbanArea == "") {
                $firstUrbanArea = $value;
            } elseif ($secondUrbanArea == "") {
                $secondUrbanArea = $value;
            } else {
                $thirdUrbanArea = $value;
            }
        }

        // Ensure that only three checkboxes are selected
        $checkedAreas = 0;
        $checkedAreas = count($urbanAreas);
        if ($checkedAreas != 3) {
            $urbanAreasError = "<span class='error'>Please select three urban areas</span>";
            $isValid = false;
        }
    } else {
        $urbanAreasError = "<span class='error'>Please select three urban areas</span>";
        $isValid = false;
    }

    // Get the selected activity
    $activity = $_POST['activity'];
    if ($activity == 'select') {
        $activityError = "<span class='error'>Please select an activity</span>";
        $isValid = false;
    } else {
        // Check the activity for the sticky field
        switch ($activity) {
            case 'basketball':
                $basketballSelected = "selected";
                break;
            case 'football':
                $footballSelected = "selected";
                break;
            case 'baseball':
                $baseballSelected = "selected";
                break;
            case 'tennis':
                $tennisSelected = "selected";
                break;
            case 'golf':
                $golfSelected = "selected";
                break;
            default:
                // Do nothing
                break;
        }
    }
}

// Display the values on the page if the form is valid
if ($isValid) {
    // Assign session variables to POST values
    $_SESSION['name'] = $name;
    $_SESSION['color'] = $color;
    $_SESSION['email'] = $email;
    $_SESSION['password'] = $password;
    $_SESSION['verify_password'] = $verifyPassword;
    $_SESSION['instrument'] = $instrument;
    $_SESSION['animals'] = $animals;
    $_SESSION['first_animal'] = $firstAnimal;
    $_SESSION['second_animal'] = $secondAnimal;
    $_SESSION['urban_areas'] = $urbanAreas;
    $_SESSION['first_urban_area'] = $firstUrbanArea;
    $_SESSION['second_urban_area'] = $secondUrbanArea;
    $_SESSION['third_urban_area'] = $thirdUrbanArea;
    $_SESSION['activity'] = $activity;
    // Redirect to the results page
    header("Location: form-results.php");
    exit();
} else {
    include 'header.php';
    echo <<<EOD
    <form method="post" action="form-validation.php" style="margin: 15px;">

        <p>
            <label for="name"><b>Name</b></label><br>
            <input type="text" name="name" id="name" value="$name">&nbsp$nameError
        </p>

        <p>
            <label for="color"><b>Favorite Color</b></label><br>
            <input type="text" name="color" id="color" value="$color">&nbsp$colorError
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
            <fieldset>
                <legend><h3>Musical Instruments</h3></legend>
                <!-- Guitar -->
                <input type="radio" name="instrument" id="guitar" value="guitar" $guitarChecked>
                <label for="guitar">Guitar</label>
                <!-- Drums -->
                <input type="radio" name="instrument" id="drums" value="drums" $drumsChecked>
                <label for="drums">Drums</label>
                <!-- Piano -->
                <input type="radio" name="instrument" id="piano" value="piano" $pianoChecked>
                <label for="piano">Piano</label>
                <!-- Violin -->
                <input type="radio" name="instrument" id="violin" value="violin" $violinChecked>
                <label for="violin">Violin</label>
            </fieldset>
            $instrumentError
        </p>

        <p>
            <fieldset>
                <legend><h3>Favorite Animals <small class="text-muted">(Select two)</small></h3></legend>
                <!-- Dog -->
                <input type="checkbox" name="animal[1]" id="animal_1" value="dogs" $dogsChecked>
                <label for="animal_1">Dog</label><br>
                <!-- Cat -->
                <input type="checkbox" name="animal[2]" id="animal_2" value="cats" $catsChecked>
                <label for="animal_2">Cat</label><br>
                <!-- Wolf -->
                <input type="checkbox" name="animal[3]" id="animal_3" value="wolves" $wolvesChecked>
                <label for="animal_3">Wolf</label><br>
                <!-- Lion -->
                <input type="checkbox" name="animal[4]" id="animal_4" value="lions" $lionsChecked>
                <label for="animal_4">Lion</label><br>
            </fieldset>
            $animalsError
        </p>

        <p>
            <fieldset>
                <legend><h3>Favorite Urban Areas <small class="text-muted">(Select three)</small></h3></legend>
                <!-- Reunion Tower -->
                <input type="checkbox" name="urban_area[1]" id="urban_area_1" value="Reunion Tower" $area1Checked>
                <label for="urban_area_1">Reunion Tower</label><br>
                <!-- Dallas County Courthouse -->
                <input type="checkbox" name="urban_area[2]" id="urban_area_2" value="Dallas County Courthouse" $area2Checked>
                <label for="urban_area_2">Dallas County Courthouse</label><br>
                <!-- Fountain Place -->
                <input type="checkbox" name="urban_area[3]" id="urban_area_3" value="Fountain Place" $area3Checked>
                <label for="urban_area_3">Fountain Place</label><br>
                <!-- Chase Tower -->
                <input type="checkbox" name="urban_area[4]" id="urban_area_4" value="Chase Tower" $area4Checked>
                <label for="urban_area_4">Chase Tower</label><br>
                <!-- Renaissance Tower -->
                <input type="checkbox" name="urban_area[5]" id="urban_area_5" value="Renaissance Tower" $area5Checked>
                <label for="urban_area_5">Renaissance Tower</label><br>
            </fieldset>
            $urbanAreasError
        </p>

        <p>
            <label for="activity">Favorite Activity:</label>
            <select name="activity" id="activity">
                <option value="select">--select--</option>
                <option value="basketball" $basketballSelected>Basketball</option>
                <option value="football" $footballSelected>Football</option>
                <option value="baseball" $baseballSelected>Baseball</option>
                <option value="tennis" $tennisSelected>Tennis</option>
                <option value="golf" $golfSelected>Golf</option>
            </select>
            &nbsp$activityError
        </p>


        <input type="submit" name="submit" value="Submit">
    </form>
EOD;
}

include 'footer.php';
