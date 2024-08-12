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

if ( isset($_POST['delete']) ) {
    $stmt = $pdo->prepare('DELETE FROM Profile WHERE profile_id = :id');

    $stmt->execute(array(
    ':id' => htmlentities($_GET['profile_id']))
    );

    $_SESSION['success'] = "Record deleted";
    header("Location: index.php");
    return;
}
?>
<html>
<head>
<title>Shahoriar Shojib</title>
</head>
<body style="font-family: sans-serif;">
<form method="post">
<input type="submit" name="delete" value="Delete">
<a href="index.php">Cancel</a></p>
</form>
</body>
