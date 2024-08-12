<?php 
require_once "pdo.php";

session_start();

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
    
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $email = $row['email'];
        $headline = $row['headline'];
        $summary = $row['summary'];
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shahoriar Shojib</title>
</head>
<body>

 <h1>Profile information</h1>
<p>First Name:<?php echo $first_name ?></p>
<p></p><br>
<p>Last Name:<?php echo $last_name ?></p>
<p></p><br>
<p>Email:<?php echo $email ?></p>
<p></p><br>
<p>Headline:<?php echo $headline ?></p>
<p></p><br>
<p>Summary:<?php echo $summary ?></p>
<p></p><br>
<a href="index.php">done</a></p>

    
</body>
</html>