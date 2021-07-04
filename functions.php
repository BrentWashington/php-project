<?php
// Calculates the price with discounts
function priceCalc($price, $quantity) {
    $discounts = array(0, 0, 0.05, 0.1, 0.2, 0.25);
    if ($quantity > 5) {
        $quantity = 5;
    }

    $discountPercent = $discounts[$quantity];
    // Calculates the new price after the discount is taken out
    $discountPrice = $price - ($price * $discountPercent);
    $total = $discountPrice * $quantity;

    return number_format($total, 2);
}

/* SQL */

// Displays the profile in the database
function displayData($profilePicture, $firstName, $lastName, $email, $username) {
    echo "<br><br>";
    echo '<img src="' . "uploads/" . $profilePicture . '" alt="Profile Picture">' . "<br>";
    echo "Name: " . "$firstName $lastName" . "<br>";
    echo "Email: " . $email . "<br>";
    echo "Username: " . $username . "<br>";
}