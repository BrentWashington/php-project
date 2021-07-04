<?php
include 'login-status.php';

$shipping = 2.99;
$downloadPrice = 9.99;
$cdPrice = 12.99;
$heading = "<h2>Cost by Quantity</h2>";
$title = 'Invoice';
include 'header.php';
include 'functions.php';

$download = true;

if ($download) {
    $heading .= "<h2>- Downloads</h2>";
    echo $heading;
    // Calculates the total for downloads
    $i = 1;
    while ($i < 6) {
        $total = priceCalc($downloadPrice, $i);
        echo "Quantity: " . $i . " | " . "Total: " . $total;
        echo "<br>";
        $i++;
    }
} else {
    $heading .= "<h2>- CDs</h2>";
    echo $heading;
    // Calculates the total for CDs
    $i = 1;
    while ($i < 6) {
        $total = priceCalc($cdPrice, $i) + $shipping;
        echo "Quantity: " . $i . "Total: " . $total;
        echo "<br>";
        $i++;
    }
}

$heading = "<h2>Cost by Quantity</h2>";
$download = false;

if ($download == true) {
    $heading .= "<h2>- Downloads</h2>";
    echo $heading;
    // Calculates the total for downloads
    for ($i=1; $i < 5; $i++) { 
        $total = priceCalc($downloadPrice, $i);
        echo "Quantity: " . $i . " | " . "Total: " . $total;
        echo "<br>";
    }
} else {
    $heading .= "<h2>- CDs</h2>";
    echo $heading;
    // Calculates the total for CDs
    for ($i=1; $i < 5; $i++) { 
        $total = priceCalc($cdPrice, $i) + $shipping;
        echo "Quantity: " . $i . " | " . "Total: " . $total;
        echo "<br>";
    }
}

$musicHeading = "<h2>Artists and Albums</h2>";

$music = array(
    "Nightwish" => "Escapist", 
    "King Crimson" => "21st Century Schizoid Man", 
    "Earth, Wind & Fire" => "September", 
    "Sex Pistols" => "God Save the Queen",
    "Queen" => "Don't Stop Me Now",
    "The Notorious B.I.G." => "Hypnotize",
    "Nightwish" => "Ghost Love Score",
    "The Rolling Stones" => "Paint It, Black",
    "Post Malone" => "Candy Paint",
    "Nightwish" => "The Siren"
);

// Adds another element to music array
$music["The Beatles"] = "The White Album";

echo($musicHeading);

// Displays each artist and album/song
foreach ($music as $artist => $album) {
    echo "Artist: $artist | Album: $album<br>";
}

include 'footer.php';
?>