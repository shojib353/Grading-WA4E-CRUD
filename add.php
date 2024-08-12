<?php
require_once "pdo.php";

session_start();
if (!isset($_SESSION["name"]) ) {
    die('Not logged in');
}



if ( isset($_POST['add']) ) {
    if (strlen($_POST['first_name']) < 1 || strlen($_POST['last_name']) < 1 || strlen($_POST['email']) < 1 || strlen($_POST['headline']) < 1 || strlen($_POST['summary']) < 1) {
        $_SESSION["error"] = "All fields are required";
        header("Location: add.php");
        return;
    }
    else {
        $stmt = $pdo->prepare('INSERT INTO Profile
        (user_id, first_name, last_name, email, headline, summary)
        VALUES ( :uid, :fn, :ln, :em, :he, :su)');
    $stmt->execute(array(
        ':uid' => $_SESSION['user_id'],
        ':fn' => $_POST['first_name'],
        ':ln' => $_POST['last_name'],
        ':em' => $_POST['email'],
        ':he' => $_POST['headline'],
        ':su' => $_POST['summary'])
    );

        $_SESSION['success'] = "Record Added";
        header("Location: index.php");
        return;
    }
}



?>
<html>
<script>
    function doValidate() {
        try {
            first = document.getElementById('id1').value;
            if (first == null || first == "") {
                alert("All fields are required");
                return false;
            }
            last = document.getElementById('id2').value;
            if (last == null || last == "") {
                alert("All fields are required");
                return false;
            }
            email = document.getElementById('id3').value;
            if (email == null || email == "") {
                alert("All fields are required");
                return false;
            } else if (!email.includes("@")) {
                alert("Email address must contain @");
                return false;
            }
            headline = document.getElementById('id4').value;
            if (headline == null || headline == "") {
                alert("All fields are required");
                return false;
            }
            summary = document.getElementById('id5').value;
            if (summary == null || summary == "") {
                alert("All fields are required");
                return false;
            }
        return true;
        } catch(e) {
            return false;
        }
        return false;
    }
</script>
<head>
<title>Shahoriar Shojib</title>
</head>
<body style="font-family: sans-serif;">
<?php
    if ( isset($_SESSION["error"]) ) {
        echo('<p style="color:red">'.$_SESSION["error"]."</p>\n");
        unset($_SESSION["error"]);
    }
?>
<form method="post">
<p>First Name</p>
<input type="text" name="first_name" size="40"/>
<p>Last Name</p>
<input type="text" name="last_name" size="40"/>
<p>Email</p>
<input type="text" name="email" size="40" />
<p>Headline</p>
<input type="text" name="headline" size="40"/>
<p>Summary</p>
<input type="text" name="summary" size="40" /><br>
<input type="submit" name="add" value="add" onclick="doValidate();">
<a href="index.php">Cancel</a></p>
</form>
</body>
