<?php
include 'login-status.php';

$title = "Blog";

include 'functions.php';

include 'config.php';

include 'header.php';

if (!$dbConnection) {
    echo "MySQL Connection Error: " . mysqli_connect_error();
}

// Reset variables
$title = $content = NULL;
$newTitle = $newContent = NULL;
$editedTitle = $editedContent = NULL;
$invalidTitleError = $invalidContentError = NULL;
$isValid = false;

$where = 1;
$stmt = $dbConnection->stmt_init();
if ($stmt->prepare("SELECT postID, title, content FROM blog_post WHERE ?")) {
    $stmt->bind_param("i", $where);
    $stmt->execute();
    $stmt->bind_result($postID, $title, $content);
    $stmt->store_result();
    $classList_row_cnt = $stmt->num_rows();

    // Check that at least one record exists
    if ($classList_row_cnt > 0) {
        $selectPost = <<<EOD
        <ul>\n
EOD;
        // Loop through to result to build the list
        while ($stmt->fetch()) {
            $selectPost .= <<<EOD
            <li><a href="blog.php?postID=$postID">$title</a></li>\n
EOD;
        }

        $selectPost .= <<<EOD
        </ul>\n
EOD;
    } else {
        $selectPost = "<p>No blog posts found.</p>";
    }

    $stmt->free_result();
    $stmt->close();
} else {
    $selectPost = "<p>The system is down right now. Please try again later.</p>";
}

if (!isset($_POST['edit']) && !isset($_GET['postID']) && !isset($_POST['create'])) {
    // Display the blog list
    echo '<h1>Blog List</h1>';
    echo $selectPost;

    if (isset($_SESSION['memberID'])) {
        // Display the "create new post" button
        echo <<<EOD
        <form action="blog.php" method="post">
            <input type="submit" name="create" value="Create New Post" class="btn btn-primary">
        </form>
EOD;
    } else {
        echo 'Want to create a new post? <a href="login.php">Log in</a>.';
    }
}

if (isset($_GET['postID'])) {
    $postID = $_GET['postID'];

    // Store the blog post ID in a session variable
    $_SESSION['postID'] = $postID;

    // Assign the the title and content variables to the data associated with the post ID
    $stmt = $dbConnection->stmt_init();
    if ($stmt->prepare("SELECT title, content FROM blog_post WHERE postID = ?")) {
        $stmt->bind_param("i", $postID);
        $stmt->execute();
        $stmt->bind_result($title, $content);
        $stmt->fetch();
        $stmt->close();
    }

    // View existing post
    echo <<<EOD
    <p>
    <h1>$title</h1>
    </p>

    <p>
        $content
    </p>
EOD;

    // Display the buttons depending on login status
    if (isset($_SESSION['memberID'])) {
        echo <<<EOD
        <form action="blog.php" method="post">
            <p>
                <input type="submit" name="edit" value="Edit" class="btn btn-success">
            </p>
            <input type="submit" name="delete" value="Delete" class="btn btn-danger">
        </form>
        <form action="blog.php" method="post">
            <input type="submit" name="show_blog_list" value="Blog List" class="btn btn-primary">
        </form>
EOD;
    } else {
        echo <<<EOD
        <form action="blog.php" method="post">
            <input type="submit" name="show_blog_list" value="Blog List" class="btn btn-primary">
        </form>
EOD;
    }
}

if (isset($_POST['delete'])) {
    $postID = $_SESSION['postID'];

    // Delete the existing post from the database
    $stmt = $dbConnection->stmt_init();
    if ($stmt->prepare("DELETE FROM blog_post WHERE postID = ?")) {
        $stmt->bind_param("i", $postID);
        $stmt->execute();
        $stmt->close();
    }

    header("Refresh:0");
    exit;
}

if (isset($_POST['cancel']) || isset($_POST['show_blog_list'])) {
    // Go back to the blog list
    header("Refresh:0");
    exit;
}

if (isset($_POST['save'])) {
    // Validate and insert the new blog post record into the database

    $isValid = true;

    if (empty($_POST['blog_title'])) {
        $invalidTitleError = "<span class='error'>Please enter a title</span>";
        $isValid = false;
    } else {
        $newTitle = trim($_POST['blog_title']);
        $newTitle = htmlspecialchars($newTitle);
    }

    if (empty($_POST['blog_content'])) {
        $invalidContentError = "<span class='error'>Please enter some content</span>";
        $isValid = false;
    } else {
        $newContent = trim($_POST['blog_content']);
        $newContent = htmlspecialchars($newContent);
    }

    if ($isValid == true) {
        // Insert the data into the database
        $stmt = $dbConnection->stmt_init();
        if ($stmt->prepare("INSERT INTO blog_post (title, content, authorID) VALUES (?, ?, ?)")) {
            $stmt->bind_param("ssi", $newTitle, $newContent, $_SESSION['memberID']);
            $stmt->execute();
            $stmt->close();
        }

        // Retrieve the new blog post ID
        $stmt = $dbConnection->stmt_init();
        if ($stmt->prepare("SELECT postID FROM blog_post WHERE title = ? AND content = ?")) {
            $stmt->bind_param("ss", $newTitle, $newContent);
            $stmt->execute();
            $stmt->bind_result($postID);
            $stmt->fetch();
            $stmt->close();
        }

        // Display the new post
        header("Location: blog.php?postID=$postID");
        exit;
    }
}

if (isset($_POST['update'])) {
    // Validate and update the existing blog post

    $isValid = true;

    if (empty($_POST['blog_title'])) {
        $invalidTitleError = "<span class='error'>Please enter a title</span>";
        $isValid = false;
    } else {
        $editedTitle = trim($_POST['blog_title']);
        $editedTitle = htmlspecialchars($editedTitle);
    }

    if (empty($_POST['blog_content'])) {
        $invalidContentError = "<span class='error'>Please enter some content</span>";
        $isValid = false;
    } else {
        $editedContent = trim($_POST['blog_content']);
        $editedContent = htmlspecialchars($editedContent);
    }

    if ($isValid == true) {
        // Update the data in the database
        $stmt = $dbConnection->stmt_init();
        if ($stmt->prepare("UPDATE blog_post SET title = ?, content = ? WHERE postID = ?")) {
            $stmt->bind_param("ssi", $editedTitle, $editedContent, $_SESSION['postID']);
            $stmt->execute();
            $stmt->close();
        }

        // Retrieve the blog post ID
        $stmt = $dbConnection->stmt_init();
        if ($stmt->prepare("SELECT postID FROM blog_post WHERE title = ? AND content = ?")) {
            $stmt->bind_param("ss", $editedTitle, $editedContent);
            $stmt->execute();
            $stmt->bind_result($postID);
            $stmt->fetch();
            $stmt->close();
        }

        // Display the updated post
        header("Location: blog.php?postID=$postID");
        exit;
    }
}

if (isset($_POST['edit'])) {
    $postID = $_SESSION['postID'];

    // Assign the the title and content variables to the data associated with the post ID
    $stmt = $dbConnection->stmt_init();
    if ($stmt->prepare("SELECT title, content FROM blog_post WHERE postID = ?")) {
        $stmt->bind_param("i", $postID);
        $stmt->execute();
        $stmt->bind_result($title, $content);
        $stmt->fetch();
        $stmt->close();
    }

    // Display edit form
    echo <<<EOD
    <h1>Edit</h1>

    <form action="blog.php" method="post">
    <p>
        <label for="title">Title</label><br>
        <input type="text" id="title" name="blog_title" value="$title" size="77">&nbsp$invalidTitleError
    </p>

    <p>
        <label for="content">Content</label><br>
        <textarea id="content" name="blog_content" rows="5" cols="80">$content</textarea>&nbsp$invalidContentError
    </p>

    <input type="hidden" name="edit" value="edit">

    <p>
        <input type="submit" name="update" value="Update" class="btn btn-success">
    </p>

    <p>
        <input type="submit" name="save" value="Save New Post" class="btn btn-success">
    </p>

    <p>
        <input type="submit" name="cancel" value="Cancel" class="btn btn-danger">
    </p>
    </form>
EOD;
}

if (isset($_POST['create'])) {
    // Load a blank form for a new blog post
    echo <<<EOD
    <h1>New Post</h1>
    
    <form action="blog.php" method="post">
        <p>
            <label for="title">Title</label><br>
            <input type="text" id="title" name="blog_title" value="$newTitle" size="77">&nbsp$invalidTitleError
        </p>
        <p>
            <label for="content">Content</label><br>
            <textarea id="content" name="blog_content" rows="5" cols="80">$newContent</textarea>&nbsp$invalidContentError
        </p>

        <input type="hidden" name="create" value="create">

        <p>
            <input type="submit" name="save" value="Save New Post" class="btn btn-success">
        </p>
        <p>
            <input type="submit" name="cancel" value="Cancel" class="btn btn-danger">
        </p>
    </form>
EOD;
}

include 'footer.php';
