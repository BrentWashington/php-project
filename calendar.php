<?php
include 'login-status.php';

$title = "Calendar";

include 'header.php';

// Set the default time zone
date_default_timezone_set("America/Chicago");

// Check if a custom time and date has been submitted
if (isset($_POST['change'])) {
    // Get the date and time from the form
    $customDate = strtotime($_POST['date']);
    $formattedDate = date("F d, Y", $customDate);
    $customTime = strtotime($_POST['time']);

    // Display the date from the form
    echo $formattedDate . "<br>";
    // Display the time from the form
    echo date("g:i A", $customTime) . "<br>";

    // Invoke the time of day method
    timeOfDay($customTime);
    echo "<br>";

    // Invoke the semester method
    getSemester($formattedDate);
    echo "<br>";

    // Invoke the christmas method
    getChristmasDay($formattedDate);
} else {
    // Get the current date and time and format them
    $date = date("F d, Y");
    $time = date("g:i A");
    // Display the current date
    echo $date . "<br>";
    // Display the current time
    echo $time . "<br>";

    // Invoke the time of day method
    timeOfDay($time);
    echo "<br>";

    // Invoke the semester method
    getSemester($date);
    echo "<br>";

    // Invoke the christmas method
    getChristmasDay($date);
}

// Form to change the date and time
echo <<<EOD
<form action="calendar.php" method="post" id="calendar_form">
    <fieldset>
        <legend>Change Date & Time</legend>
        <!-- Date -->
        <label for="date">
            <h6>Date: </h6>
        </label>
        <input type="date" name="date" id="date"><br>
        <!-- Time -->
        <label for="time">
            <h6>Time: </h6>
        </label>
        <input type="time" name="time" id="time"><br>
        <!-- Submit -->
        <input type="submit" name="change" value="Change" class="btn btn-primary">
    </fieldset>
</form>
EOD;

/**
 * Displays a message according to the time of day
 */
function timeOfDay($time)
{
    echo "<br>";

    // Sets the time in 24-hour format
    $time = date("H", $time);
    if ($time < 12) {
        echo '<img src="images/morning.svg" alt="Morning icon" />';
        echo " ";
        echo "Good morning!"; // Display the morning message before 1200 hours
    } elseif ($time >= 12 && $time < 17) {
        echo '<img src="images/afternoon.svg" alt="Afternoon icon" />';
        echo " ";
        echo "Good afternoon!"; // Display the afternoon message between 1200 and 1700 hours
    } elseif ($time >= 17 && $time < 19) {
        echo '<img src="images/evening.svg" alt="Evening icon" />';
        echo " ";
        echo "Good evening!"; // Display the evening message between 1700 and 1900 hours
    } elseif ($time >= 19) {
        echo '<img src="images/night.svg" alt="Night icon" />';
        echo " ";
        echo "Good night!"; // Display the night message after 1900 hours
    }
}

/**
 * Displays the semester at Brookhaven according to the date
 */
function getSemester($date)
{
    echo "<br>";

    $date = strtotime($date);
    // Check the date among the semester/month ranges
    if (date("n", $date) >= 1 && date("n", $date) <= 5) {
        echo '<img src="images/spring.svg" alt="Spring icon" />';
        echo " ";
        echo "It's spring at Brookhaven College!";
    } elseif (date("n", $date) >= 6 && date("n", $date) <= 7) {
        echo '<img src="images/summer.svg" alt="Summer icon" />';
        echo " ";
        echo "It's summer at Brookhaven College!";
    } elseif (date("n", $date) >= 8 && date("n", $date) <= 11) {
        echo '<img src="images/fall.svg" alt="Fall icon" />';
        echo " ";
        echo "It's fall at Brookhaven College!";
    } elseif (date("n", $date) == 12) {
        echo '<img src="images/winter.svg" alt="Winter icon" />';
        echo " ";
        echo "It's winter at Brookhaven College!";
    }
}

/**
 * Finds out whether or not the current day is Christmas (if not, then how many days until)
 */
function getChristmasDay($date)
{
    $date = strtotime($date);
    // $christmasDay = mktime(0, 0, 0, 12, 25);
    $christmasDay = strtotime("December 25");
    echo "<br>";
    echo '<img src="images/christmas-tree.svg" alt="Christmas icon" />';
    echo " ";
    if ($date == $christmasDay) {
        echo "Merry Christmas!";
    } else if ($date < $christmasDay) {
        // Calculate and display the remaining days until Christmas
        $remainingDays = floor(($christmasDay - $date) / 86400);
        if ($remainingDays != 1) {
            echo "Christmas arrives in: <strong>$remainingDays</strong> days";
        } else {
            echo "Christmas arrives in: <strong>$remainingDays</strong> day";
        }
    } else {
        // Calculate the remaining days until next year's Christmas
        $christmasDay = strtotime("December 25 +1 year");
        $remainingDays = floor(($christmasDay - $date) / 86400);
        if ($remainingDays != 1) {
            echo "Christmas arrives in: <strong>$remainingDays</strong> days";
        } else {
            echo "Christmas arrives in: <strong>$remainingDays</strong> day";
        }
    }
}

include 'footer.php';
