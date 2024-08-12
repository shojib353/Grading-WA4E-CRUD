<?php
require_once "pdo.php";

    session_start();
?>
<html>
<head>
<title>Shahoriar Shojib</title>
</head>
<body style="font-family: sans-serif;">
<h1>Welcome to the Profile</h1>
<?php
    if ( isset($_SESSION["success"]) ) {
        echo('<p style="color:green">'.htmlentities($_SESSION["success"])."</p>\n");
        unset($_SESSION["success"]);
    }
    if ( isset($_SESSION["error"]) ) {
        echo('<p style="color:red">'.htmlentities($_SESSION["error"])."</p>\n");
        unset($_SESSION["error"]);
    }  

    // Check if we are logged in!
    if (!isset($_SESSION["name"]) ) { ?>
        <a href="login.php">Please log In</a>
     <?php } else { ?>
         <form method="post">
         <a href="add.php">Add New Entry</a><br>
         <a href="logout.php">Logout</a>
         </form>
     <?php }

    $stmt = $pdo->query("SELECT * FROM Profile");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($rows) > 0) {
        echo '<table border="1">'."\n";

        echo "<tr><td>";
        echo "<b>Name</b>";
        echo("</td><td>");
        echo "<b>Headline</b>";
        echo("</td><td>");
        echo "<b>Action</b>";
        echo("</td></tr>\n");

        foreach ( $rows as $row ) {
            $name =  $row['first_name'] . " " . $row['last_name'];

            echo "<tr><td>";
            echo('<a href="view.php?profile_id='.$row["profile_id"].'">'.$name.'</a>');
            echo("</td><td>");
            echo($row['headline']);
            echo("</td><td>\n");
            echo('<a href="edit.php?profile_id='.$row["profile_id"].'">Edit</a> / <a href="delete.php?profile_id='.$row["profile_id"].'">Delete</a>');
            echo("</td></tr>\n");
        }
    }
 ?>
</body>
</html>
