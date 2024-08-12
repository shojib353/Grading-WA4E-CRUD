<?php
require_once "pdo.php";

session_start();
if (!isset($_SESSION["name"]) ) {
    die('Not logged in');
}

// Demand a GET parameter
if ( ! isset($_GET['profile_id']) || strlen($_GET['profile_id']) < 1  ) {
    die('ID parameter missing');
}

if ( isset($_POST['save']) ) {
    if (strlen($_POST['first_name']) < 1 || strlen($_POST['last_name']) < 1 || strlen($_POST['email']) < 1 || strlen($_POST['headline']) < 1 || strlen($_POST['summary']) < 1) {
        $_SESSION["error"] = "All fields are required";
        header("Location: edit.php?profile_id=".$_GET['profile_id']);
        return;
    }
    else {
        $stmt = $pdo->prepare('UPDATE profile SET
        first_name=:fn, last_name=:ln, email=:em, headline=:hd, summary=:su
        WHERE profile_id = :id');

        $stmt->execute(array(
        ':fn' => htmlentities($_POST['first_name']),
        ':ln' => htmlentities($_POST['last_name']),
        ':em' => htmlentities($_POST['email']),
        ':hd' => htmlentities($_POST['headline']),
        ':su' => htmlentities($_POST['summary']),
        ':id' => htmlentities($_GET['profile_id']))
        );

        $_SESSION['success'] = "Record edited";
        header("Location: index.php");
        return;
    }
}

$profile_id = htmlentities($_GET['profile_id']);
$stmt = $pdo->query("SELECT * FROM Profile WHERE profile_id = $profile_id");
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$first_name = false;
$last_name = false;
$email = false;
$headline = false;
$summary = false;

if ( $row === FALSE ) {
    die('ACCESS DENIED');
} else {
    if ($row['user_id'] != $_SESSION["user_id"]) {
        die('ACCESS DENIED');
    } else {
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $email = $row['email'];
        $headline = $row['headline'];
        $summary = $row['summary'];
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
<input type="text" name="first_name" size="40" value=<?php echo $first_name ?> id="id1" />
<p>Last Name</p>
<input type="text" name="last_name" size="40" value=<?php echo $last_name ?> id="id2" />
<p>Email</p>
<input type="text" name="email" size="40" value=<?php echo $email ?> id="id3" />
<p>Headline</p>
<input type="text" name="headline" size="40" value=<?php echo $headline ?> id="id4" />
<p>Summary</p>
<input type="text" name="summary" size="40" value=<?php echo $summary ?> id="id5" />
<input type="submit" name="save" value="Save" onclick="return doValidate();">
<a href="index.php">Cancel</a></p>
</form>
</body>
