<?php
require_once "pdo.php";

    session_start();
    $salt = 'XyZzy12*_';

    if ( isset($_POST["email"]) && isset($_POST["pass"]) ) {
        if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 ) {
            $_SESSION['error'] = "Email and password are required";
            header("Location: login.php");
            return;
        }
        else if (!str_contains($_POST['email'], '@')) {
            $_SESSION['error'] = "Email must have an at-sign (@)";
            header("Location: login.php");
            return;
        }
        else {
            $check = hash('md5', $salt.$_POST['pass']);
            $stmt = $pdo->prepare('SELECT user_id, name FROM users
            WHERE email = :em AND password = :pw');
            $stmt->execute(array( ':em' => $_POST['email'], ':pw' => $check));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ( $row === FALSE ) {
                $_SESSION["error"] = "Incorrect password.";
                error_log("Login fail ".$_POST['who']." $check");
                header( 'Location: login.php' ) ;
                return;
            } else {
                unset($_SESSION["email"]);  // Logout current user
                $_SESSION["name"] = $_POST["email"];
                $_SESSION["user_id"] = $row["user_id"];
                $_SESSION["success"] = "Logged in.";
                error_log("Login success ".$_POST['who']);
                header( 'Location: index.php' ) ;
                return;
            }
        }
    }
?>
<html>
<script>
    function doValidate() {
        console.log('Validating...');
        try {
            pw = document.getElementById('id_1723').value;
            console.log("Validating pw="+pw);
            if (pw == null || pw == "") {
                alert("Both fields must be filled out");
                return false;
            }
            email = document.getElementById('id_1722').value;
            console.log("Validating email="+email);
            if (email == null || email == "") {
                alert("Both fields must be filled out");
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
<h1>Please Log In</h1>
<?php
    if ( isset($_SESSION["error"]) ) {
        echo('<p style="color:red">'.$_SESSION["error"]."</p>\n");
        unset($_SESSION["error"]);
    }
?>
<form method="post">
<p>User Name <input type="text" name="email" id="id_1722"><br/></p>
<p>Password <input type="text" name="pass" id="id_1723"><br/></p>
<p><input type="submit" onclick="return doValidate();" value="Log In">
<a href="index.php">Cancel</a></p>
</form>
</body>