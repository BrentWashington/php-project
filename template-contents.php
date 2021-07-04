<?php
$title = "Page Template Title";
$minutes = 15;
// Header
include 'header.php';

echo <<<EOD
<p>I stared at my screen for about $minutes minutes wondering what to write.</p>
<p>I just gave up and wrote this.<p>
EOD;

// Footer
include 'footer.php';
?>