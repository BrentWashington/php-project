<?php
include 'functions.php';

$title = "PHP and HTML";

session_start();

include 'header.php';

// Get session values
$name = $_SESSION['name'];
$color = $_SESSION['color'];
$email = $_SESSION['email'];
$password = $_SESSION['password'];
$verifyPassword = $_SESSION['verify_password'];
$instrument = $_SESSION['instrument'];
$animals = $_SESSION['animals'];
$firstAnimal = $_SESSION['first_animal'];
$secondAnimal = $_SESSION['second_animal'];
$urbanAreas = $_SESSION['urban_areas'];
$firstUrbanArea = $_SESSION['first_urban_area'];
$secondUrbanArea = $_SESSION['second_urban_area'];
$thirdUrbanArea = $_SESSION['third_urban_area'];
$activity = $_SESSION['activity'];

echo <<<EOD
Little $name $color come play your $instrument.<br>
The $firstAnimal in the $firstUrbanArea, the $secondAnimal in the $secondUrbanArea.<br>
Where is the $name who looks after the $firstAnimal?<br>
They're out in the $thirdUrbanArea playing $activity.
EOD;

// Display an array of the POST contents
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

include 'footer.php';
