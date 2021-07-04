<?php
include 'functions.php';

$title = "PHP and HTML";

include 'header.php';

// Checks if the form has been submitted
if (isset($_POST['submit'])) {
    // Gets the data
    $name = $_POST['name'];
    $color = $_POST['color'];
    $instrument = $_POST['instrument'];
    $animals = $_POST['animal'];
    $urbanAreas = $_POST['urban_area'];
    $activity = $_POST['activity'];

    // Gets the selected animals from the check boxes
    foreach ($animals as $key => $value) {
        if ($firstAnimal == "") {
            $firstAnimal = $value;
        } else {
            $secondAnimal = $value;
        }
    }

    // Gets the selected areas from the check boxes
    foreach ($urbanAreas as $key => $value) {
        if ($firstUrbanArea == "") {
            $firstUrbanArea = $value;
        } elseif ($secondUrbanArea == "") {
            $secondUrbanArea = $value;
        } else {
            $thirdUrbanArea = $value;
        }
    }

    // Displays the data
    echo "Welcome <i>$name!</i>";
    echo "<br>";
    echo "Your favorite color is <i>$color</i>.";
    echo "<br>";
    echo "Your favorite musical instrument is <i>$instrument</i>.";
    echo "<br>";
    echo "Your favorite animals are <i>$firstAnimal</i> and <i>$secondAnimal</i>.";
    echo "<br>";
    echo "Your favorite places are the <i>$firstUrbanArea</i>, the <i>$secondUrbanArea</i>, and the <i>$thirdUrbanArea</i>.";
    echo "<br>";
    echo "Your favorite activity is <i>$activity</i>.";

    // Displays a debugging statement
    echo "<pre>";
    print_r($name);
    echo "<br>";
    print_r($color);
    echo "<br>";
    print_r($instrument);
    echo "<br>";
    print_r($animals);
    print_r($urbanAreas);
    print_r($activity);
    echo "</pre>";
} else {
    echo <<<EOD
    <form method="post" action="my-form.php" style="margin: 15px;">

        <p>
            <label for="name"><b>Name</b></label><br>
            <input type="text" name="name" id="name">
        </p>

        <p>
            <label for="color"><b>Favorite Color</b></label><br>
            <input type="text" name="color" id="color">
        </p>

        <p>
            <fieldset>
                <legend><h3>Musical Instruments</h3></legend>
                <!-- Guitar -->
                <input type="radio" name="instrument" id="guitar" value="guitar">
                <label for="guitar">Guitar</label>
                <!-- Drums -->
                <input type="radio" name="instrument" id="drums" value="drums">
                <label for="drums">Drums</label>
                <!-- Piano -->
                <input type="radio" name="instrument" id="piano" value="piano">
                <label for="piano">Piano</label>
                <!-- Violin -->
                <input type="radio" name="instrument" id="violin" value="violin">
                <label for="violin">Violin</label>
            </fieldset>
        </p>

        <p>
            <fieldset>
                <legend><h3>Favorite Animals <small class="text-muted">(Select two)</small></h3></legend>
                <!-- Dog -->
                <input type="checkbox" name="animal[]" id="animal_1" value="dogs">
                <label>Dog</label><br>
                <!-- Cat -->
                <input type="checkbox" name="animal[]" id="animal_2" value="cats">
                <label>Cat</label><br>
                <!-- Wolf -->
                <input type="checkbox" name="animal[]" id="animal_3" value="wolves">
                <label>Wolf</label><br>
                <!-- Lion -->
                <input type="checkbox" name="animal[]" id="animal_4" value="lions">
                <label>Lion</label><br>
            </fieldset>
        </p>

        <p>
            <fieldset>
                <legend><h3>Favorite Urban Areas <small class="text-muted">(Select three)</small></h3></legend>
                <!-- Reunion Tower -->
                <input type="checkbox" name="urban_area[]" id="urban_area_1" value="Reunion Tower">
                <label>Reunion Tower</label><br>
                <!-- Dallas County Courthouse -->
                <input type="checkbox" name="urban_area[]" id="urban_area_2" value="Dallas County Courthouse">
                <label>Dallas County Courthouse</label><br>
                <!-- Fountain Place -->
                <input type="checkbox" name="urban_area[]" id="urban_area_3" value="Fountain Place">
                <label>Fountain Place</label><br>
                <!-- Chase Tower -->
                <input type="checkbox" name="urban_area[]" id="urban_area_4" value="Chase Tower">
                <label>Chase Tower</label><br>
                <!-- Renaissance Tower -->
                <input type="checkbox" name="urban_area[]" id="urban_area_5" value="Renaissance Tower">
                <label>Renaissance Tower</label><br>
            </fieldset>
        </p>

        <p>
            <label for="activity">Favorite Activity:</label>
            <select name="activity" id="activity">
                <option value="basketball">Basketball</option>
                <option value="football">Football</option>
                <option value="baseball">Baseball</option>
                <option value="tennis">Tennis</option>
                <option value="Golf">Golf</option>
            </select>
        </p>


        <input type="submit" name="submit" value="Submit">
    </form>
EOD;
}

include 'footer.php';
