<?php
include 'functions.php';

$title = 'PHP Basic Language Skills';
include 'header.php';

$music = array(
    'The Beatles' =>  array(
        'A Hard Day\'s Night' => 1964,
        'Help!' => 1965,
        'Rubber Soul' => 1965,
        'Abbey Road' => 1969
    ),
    'Led Zeppelin' => array(
        'Led Zeppelin IV' => 1971
    ),
    'Rolling Stones' => array(
        'Let It Bleed' => 1969,
        'Sticky Fingers' => 1971
    ),
    'The Who' => array(
        'Tommy' => 1969,
        'Quadrophenia' => 1973,
        'The Who by Numbers' => 1975
    )
);

// Gets and displays release date for The Who's "Tommy"
$tommyReleaseDate = $music['The Who']['Tommy'];
echo "<br>Release Date for Tommy: {$tommyReleaseDate}<br>";

// Displays the artists and their albums
foreach ($music as $artistsArray => $artist) {
    echo "<br><u>{$artistsArray}:</u><br>";
    foreach ($artist as $album => $releaseDate) {
        // Lists the albums and release dates of The Who
        if ($artistsArray == 'The Who') {
            echo "{$album} ({$releaseDate})<br>";
        } else {
            echo "{$album}<br>";
        }
    }
}

// Displays albums released after 1970
echo '<br><u>Albums released after 1970:</u><br>';
foreach ($music as $artistsArray => $artist) {
    foreach ($artist as $album => $releaseDate) {
        if ($releaseDate > 1970) {
            echo "{$album} ({$releaseDate}) by {$artistsArray}<br>";
        }
    }
}

include 'footer.php';