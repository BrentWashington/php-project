<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        nav {
            margin-bottom: 15px;
        }

        a:hover {
            color: red;
        }

        .error {
            color: red;
        }

        header {
            margin: 25px;
            text-align: center;
        }

        body {
            margin: 15px;
            background-color: #D6EAF8;
        }

        #calendar_form {
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <header>
        <h1>Intro to PHP Programming | Brent Washington</h1>
    </header>

    <nav>
        <ul class="nav nav-tabs justify-content-center">
            <li><a class="nav-item nav-link" href="index.php">Home</a></li>
            <li><a class="nav-item nav-link" href="invoice.php">Invoice</a></li>
            <li><a class="nav-item nav-link" href="calendar.php">Calendar</a></li>
            <li><a class="nav-item nav-link" href="register.php">Register</a></li>
            <li><a class="nav-item nav-link" href="profile.php">Profile</a></li>
            <li><a class="nav-item nav-link" href="blog.php">Blog</a></li>
        </ul>
    </nav>