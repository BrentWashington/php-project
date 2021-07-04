<?php
$shipping = 2.99;
$downloadPrice = 9.99;
$cdPrice = 12.99;
$heading = "<h2>Cost by Quantity</h2>";
$pageTitle = 'PHP Basic Language Skills';
include 'header.php';

$download = true;

if ($download) {
    $heading .= "<h2>- Downloads</h2>";
    echo $heading;
    // Calculates the total for downloads
    $i = 1;
    while ($i < 6) {
        $total = $i * $downloadPrice;
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
        $total = ($i * $cdPrice) + $shipping;
        echo "Quantity: " . $i . "Total: " . (($i * $cdPrice) + $shipping);
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
        $total = $i * $downloadPrice;
        echo "Quantity: " . $i . " | " . "Total: " . $total;
        echo "<br>";
    }
} else {
    $heading .= "<h2>- CDs</h2>";
    echo $heading;
    // Calculates the total for CDs
    for ($i=1; $i < 5; $i++) { 
        $total = ($i * $cdPrice) + $shipping;
        echo "Quantity: " . $i . " | " . "Total: " . $total;
        echo "<br>";
    }
}

include '../footer.php';
?>